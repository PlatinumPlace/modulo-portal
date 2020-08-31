<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

function calcular_prima_vida($prima, $contrato_id)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Tasas");
    $criteria = "Contrato:equals:" . $contrato_id;
    $param_map = array("page" => 1, "per_page" => 200);
    $tasa_deudor = 0;
    $tasa_codeudor = 0;
    $tasa_vida = 0;
    $tasa_desempleo = 0;

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();

        foreach ($records as $record) {
            switch ($record->getFieldValue('Tipo')) {
                case 'Deudor':
                    $tasa_deudor = $record->getFieldValue('Valor');
                    break;

                case 'Codeudor':
                    $tasa_codeudor = $record->getFieldValue('Valor');
                    break;

                case 'Vida':
                    $tasa_vida = $record->getFieldValue('Valor');
                    break;

                case 'Desempleo':
                    $tasa_desempleo = $record->getFieldValue('Valor');
                    break;
            }
        }
    } catch (ZCRMException $ex) {
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }

    if (!empty($_POST["desempleo"]) and !empty($_POST["cuota"])) {
        $prima = $_POST["valor"] / 1000 * ($tasa_vida / 100);
        $prima +=  $_POST["cuota"] / 1000 * $tasa_desempleo;
    } else {
        if (!empty($_POST["fecha_codeudor"])) {
            $prima = $_POST["valor"] / 1000 * (($tasa_codeudor - $tasa_deudor) / 100);
        } else {
            $prima = $_POST["valor"] / 1000 * ($tasa_deudor / 100);
        }
    }

    return $prima;
}

function crear_cotizacion_vida()
{
    $edad_deudor = calcular_edad($_POST["fecha_nacimiento"]);
    $edad_codeudor = (!empty($_POST["fecha_codeudor"])) ?  calcular_edad($_POST["fecha_codeudor"]) : null;
    $lista_contratos = lista_contratos("Vida");

    foreach ($lista_contratos as $contrato) {

        $plan = seleccionar_plan($contrato->getFieldValue('Aseguradora')->getEntityId());
        $prima = calcular_prima_vida(0, $contrato->getEntityId());

        $planes_seleccionados[] = array(
            "id" => $plan->getEntityId(),
            "prima" => $prima,
            "descripcion" => $contrato->getEntityId()
        );
    }

    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
    $records = array();
    $record = ZCRMRecord::getInstance("Quotes", null);

    if (!empty($_POST["desempleo"])) {
        $titulo = "Vida/Desempleo";
        $desempleo = true;
    } else {
        $titulo = "Vida";
        $desempleo = false;
    }

    $record->setFieldValue("Subject", "Plan " . $titulo);
    $record->setFieldValue("Account_Name", $_SESSION["usuario"]['empresa_id']);
    $record->setFieldValue("Contact_Name", $_SESSION["usuario"]['id']);
    $record->setFieldValue("Quote_Stage", "Cotizando");
    $record->setFieldValue("Valid_Till", date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days")));
    $record->setFieldValue("Fecha_emisi_n", date("Y-m-d"));
    $record->setFieldValue("Tipo_P_liza", "Declarativa");
    $record->setFieldValue("Plan", "Vida");
    $record->setFieldValue("Valor_Asegurado", $_POST["valor"]);
    $record->setFieldValue("RNC_C_dula", $_POST["rnc_cedula"]);
    $record->setFieldValue("Nombre", $_POST["nombre"]);
    $record->setFieldValue("Fecha_Nacimiento_Codeudor", $_POST["fecha_codeudor"]);
    $record->setFieldValue("Plazo", $_POST["plazo"]);
    $record->setFieldValue("Fecha_Nacimiento", $_POST["fecha_nacimiento"]);
    $record->setFieldValue("Cuota_Men", $_POST["cuota"]);
    $record->setFieldValue("Desempleo", $desempleo);

    foreach ($planes_seleccionados as $plan) {
        $lineItem = ZCRMInventoryLineItem::getInstance(null);
        $lineItem->setDescription($plan["descripcion"]);
        $lineItem->setListPrice($plan["prima"]);
        $taxInstance1 = ZCRMTax::getInstance("ITBIS 16");
        $taxInstance1->setPercentage(16);
        $lineItem->addLineTax($taxInstance1);
        $lineItem->setProduct(ZCRMRecord::getInstance("Products", $plan["id"]));
        $lineItem->setQuantity(1);
        $record->addLineItem($lineItem);
    }

    array_push($records, $record);
    $responseIn = $moduleIns->createRecords($records);
    foreach ($responseIn->getEntityResponses() as $responseIns) {
        // echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
        // echo "<br>";
        // echo "Status:" . $responseIns->getStatus();
        // echo "<br>";
        // echo "Message:" . $responseIns->getMessage();
        // echo "<br>";
        // echo "Code:" . $responseIns->getCode();
        // echo "<br>";
        // echo "Details:" . json_encode($responseIns->getDetails());
        // echo "<br>";
        $details = json_decode(json_encode($responseIns->getDetails()), true);
    }

    header("Location:" . constant("url") . "?page=detalles&id=" . $details["id"]);
    exit();
}

function emitir_cotizacion_vida($cotizacion)
{
    $planes = $cotizacion->getLineItems();
    foreach ($planes as $plan) {
        if ($plan->getId() == $_POST["plan_id"]) {
            $prima_total = $plan->getNetTotal();
            $prima_neta = $plan->getListPrice();
            $contrato_id = $plan->getDescription();
        }
    }

    $contrato = detalles_registro("Contratos", $contrato_id);
    $poliza = $contrato->getFieldValue('No_P_liza');
    $comision_nobe = $prima_total * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
    $comision_aseguradora = $prima_total * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
    $comision_socio = $prima_total * $contrato->getFieldValue('Comisi_n_Socio') / 100;
    $contrato_id = $contrato->getEntityId();

    $cliente_nuevo["Vendor_Name"] = $contrato->getFieldValue("Aseguradora")->getEntityId();
    $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
    $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $cliente_nuevo["Mailing_Street"] = $_POST["direccion"];
    $cliente_nuevo["First_Name"] = $_POST["nombre"];
    $cliente_nuevo["Last_Name"] = $_POST["apellido"];
    $cliente_nuevo["Mobile"] = $_POST["telefono"];
    $cliente_nuevo["Phone"] = $_POST["tel_residencia"];
    $cliente_nuevo["Tel_Trabajo"] = $_POST["tel_trabajo"];
    $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
    $cliente_nuevo["Email"] = $_POST["correo"];
    $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
    $cliente_nuevo["Tipo"] = "Cliente";
    $cliente_nuevo_id = crear_registro("Contacts", $cliente_nuevo);

    $poliza_nueva["Name"] = $poliza;
    $poliza_nueva["Estado"] = true;
    $poliza_nueva["Plan"] = $cotizacion->getFieldValue('Subject');
    $poliza_nueva["Aseguradora"] = $contrato->getFieldValue("Aseguradora")->getEntityId();
    $poliza_nueva["Prima"] = round($prima_total, 2);
    $poliza_nueva["Deudor"] = $cliente_nuevo_id;
    $poliza_nueva["Ramo"] = str_replace("Plan", "", $cotizacion->getFieldValue('Subject'));
    $poliza_nueva["Socio"] = $_SESSION["usuario"]['empresa_id'];
    $poliza_nueva["Tipo"] = "Declarativa";
    $poliza_nueva["Valor_Aseguradora"] = $cotizacion->getFieldValue('Valor_Asegurado');
    $poliza_nueva["Vigencia_desde"] = date("Y-m-d");
    $poliza_nueva["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
    $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
    $poliza_nueva["Nombre_Codeudor"] = $_POST["nombre_codeudor"];
    $poliza_nueva["Direcci_n_Codeudor"] = $_POST["direccion_codeudor"];
    $poliza_nueva["Tel_Codeudor"] = $_POST["telefono_codeudor"];
    $poliza_nueva["Fecha_Nacimiento_Codeudor"] = $_POST["fecha_nacimiento_codeudor"];
    $poliza_nueva_id = crear_registro("P_lizas", $poliza_nueva);

    $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
    $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
    $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $nuevo_trato["Stage"] = "En trámite";
    $nuevo_trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
    $nuevo_trato["Type"] = "Auto";
    $nuevo_trato["P_liza"] = $poliza_nueva_id;
    $nuevo_trato["Cliente"] = $cliente_nuevo_id;
    $nuevo_trato["Contrato"] = $contrato_id;
    $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
    $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
    $nuevo_trato["Amount"] = round($comision_nobe, 2);
    $nuevo_trato["Lead_Source"] = "Portal";
    $nuevo_trato_id = crear_registro("Deals", $nuevo_trato);

    $record = ZCRMRestClient::getInstance()->getRecordInstance("Quotes", $cotizacion->getEntityId());

    $record->setFieldValue("Quote_Stage", "Emitida");
    $record->setFieldValue("Fecha_emisi_n", date("Y-m-d"));
    $record->setFieldValue("Valid_Till", date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")));
    $record->setFieldValue("RNC_C_dula", $_POST["rnc_cedula"]);
    $record->setFieldValue("Nombre", $_POST["nombre"]);
    $record->setFieldValue("Fecha_Nacimiento", $_POST["fecha_nacimiento"]);
    $record->setFieldValue("Deal_Name", $nuevo_trato_id);
    $record->setFieldValue("Aseguradora", $contrato->getFieldValue("Aseguradora")->getEntityId());

    $lineItem = ZCRMInventoryLineItem::getInstance($_POST["plan_id"]);
    $lineItem->setDescription($contrato_id);
    $lineItem->setListPrice($prima_neta);

    $taxInstance1 = ZCRMTax::getInstance("ITBIS 16");
    $taxInstance1->setPercentage(16);
    $lineItem->addLineTax($taxInstance1);
    $lineItem->setQuantity(1);
    $record->addLineItem($lineItem);

    $responseIns = $record->update();

    // echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
    // echo "<br>";
    // echo "Status:" . $responseIns->getStatus();
    // echo "<br>";
    // echo "Message:" . $responseIns->getMessage();
    // echo "<br>";
    // echo "Code:" . $responseIns->getCode();
    // echo "<br>";
    // echo "Details:" . json_encode($responseIns->getDetails());
    // echo "<br>";

    $ruta = "public/path";
    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
    $name = basename($_FILES["cotizacion_firmada"]["name"]);
    move_uploaded_file($tmp_name, "$ruta/$name");
    adjuntar_registro("Deals", $nuevo_trato_id, "$ruta/$name");
    unlink("$ruta/$name");

    header("Location:" . constant("url") . "?page=detalles&id=" . $cotizacion->getEntityId() . "&alert=Póliza emitida, descargue para obtener el carnet");
    exit();
}
