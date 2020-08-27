<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

function calcular_prima_auto($contrato, $tipo_vehiculo)
{
    $tasa_valor = 0;
    $criterio = "Contrato:equals:" . $contrato->getEntityId();

    $tasas = lista_filtrada_registros("Tasas", $criterio);
    foreach ($tasas as $tasa) {
        if (in_array($tipo_vehiculo, $tasa->getFieldValue('Grupo_de_veh_culo')) and $tasa->getFieldValue('A_o') == $_POST["fabricacion"]) {
            $tasa_valor = $tasa->getFieldValue('Valor');
        }
    }

    $recargos = lista_filtrada_registros("Recargos", $criterio);
    foreach ($recargos as $recargo) {
        if ((in_array($tipo_vehiculo, $recargo->getFieldValue('Grupo_de_veh_culo')) and $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"]) and (($_POST["fabricacion"] > $recargo->getFieldValue('Desde') and $_POST["fabricacion"] < $recargo->getFieldValue('Hasta')) or $_POST["fabricacion"] < $recargo->getFieldValue('Hasta') or $_POST["fabricacion"] > $recargo->getFieldValue('Desde'))) {
            $recargo_valor = $recargo->getFieldValue('Porcentaje');
        }
    }

    if (!empty($recargo_valor)) {
        $tasa_valor = $tasa_valor + (($tasa_valor * $recargo_valor) / 100);
    }

    $prima = $_POST["valor"] * $tasa_valor / 100;

    if ($prima < $contrato->getFieldValue('Prima_M_nima')) {
        $prima = $contrato->getFieldValue('Prima_M_nima');
    }

    return $prima;
}

function verificar_restringido_auto($prima, $aseguradora, $marca, $modelo)
{
    if (!empty($marca->getFieldValue('Restringido_en')) and in_array($aseguradora, $marca->getFieldValue('Restringido_en'))) {
        return 0;
    } elseif (!empty($modelo->getFieldValue('Restringido_en')) and in_array($aseguradora, $modelo->getFieldValue('Restringido_en'))) {
        return 0;
    } else {
        return $prima;
    }
}

function crear_cotizacion_auto($planes, $tipo_vehiculo)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
    $records = array();
    $record = ZCRMRecord::getInstance("Quotes", null);

    $record->setFieldValue("Subject", "Plan " . $_POST["facturacion"] . " " . $_POST["tipo_plan"]);
    $record->setFieldValue("Account_Name", $_SESSION["usuario"]['empresa_id']);
    $record->setFieldValue("Contact_Name", $_SESSION["usuario"]['id']);
    $record->setFieldValue("Quote_Stage", "Cotizando");
    $record->setFieldValue("Valid_Till", date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days")));
    $record->setFieldValue("Fecha_emisi_n", date("Y-m-d"));
    $record->setFieldValue("Tipo_P_liza", "Declarativa");
    $record->setFieldValue("Plan", $_POST["tipo_plan"]);
    $record->setFieldValue("Valor_Asegurado", $_POST["valor"]);
    $record->setFieldValue("RNC_C_dula", $_POST["rnc_cedula"]);
    $record->setFieldValue("Nombre", $_POST["nombre"]);
    $record->setFieldValue("Marca", $_POST["marca"]);
    $record->setFieldValue("Modelo", $_POST["modelo"]);
    $record->setFieldValue("A_o_Fabricaci_n", $_POST["fabricacion"]);
    $record->setFieldValue("Tipo_Veh_culo", $tipo_vehiculo);

    foreach ($planes as $plan) {
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
        /*
         echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
         echo "<br>";
         echo "Status:" . $responseIns->getStatus();
         echo "<br>";
         echo "Message:" . $responseIns->getMessage();
         echo "<br>";
         echo "Code:" . $responseIns->getCode();
         echo "<br>";
         echo "Details:" . json_encode($responseIns->getDetails());
         echo "<br>";
         */
        $details = json_decode(json_encode($responseIns->getDetails()), true);
    }

    return $details["id"];
}

function emitir_cotizacion_auto($id, $prima_neta, $contrato_id, $nuevo_trato_id, $aseguradora)
{
    $record = ZCRMRestClient::getInstance()->getRecordInstance("Quotes", $id);

    $record->setFieldValue("Quote_Stage", "Emitida");
    $record->setFieldValue("Fecha_emisi_n", date("Y-m-d"));
    $record->setFieldValue("Valid_Till", date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")));
    $record->setFieldValue("RNC_C_dula", $_POST["rnc_cedula"]);
    $record->setFieldValue("Nombre", $_POST["nombre"]);
    $record->setFieldValue("Fecha_Nacimiento", $_POST["fecha_nacimiento"]);
    $record->setFieldValue("Deal_Name", $nuevo_trato_id);
    $record->setFieldValue("Aseguradora", $aseguradora);

    $lineItem = ZCRMInventoryLineItem::getInstance($_POST["aseguradora"]);
    $lineItem->setDescription($contrato_id);
    $lineItem->setListPrice($prima_neta);

    $taxInstance1 = ZCRMTax::getInstance("ITBIS 16");
    $taxInstance1->setPercentage(16);
    $lineItem->addLineTax($taxInstance1);
    $lineItem->setQuantity(1);
    $record->addLineItem($lineItem);

    $responseIns = $record->update();

    /*
      echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
      echo "<br>";
      echo "Status:" . $responseIns->getStatus();
      echo "<br>";
      echo "Message:" . $responseIns->getMessage();
      echo "<br>";
      echo "Code:" . $responseIns->getCode();
      echo "<br>";
      echo "Details:" . json_encode($responseIns->getDetails());
      echo "<br>";
     */
}
