<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

function calcular_prima_vida($prima, $tasa_deudor, $tasa_codeudor)
{
    if (!empty($_POST["fecha_codeudor"])) {
        $prima = $_POST["valor"] / 1000 * (($tasa_codeudor - $tasa_deudor) / 100);
    } else {
        $prima = $_POST["valor"] / 1000 * ($tasa_deudor / 100);
    }
    return $prima;
}

function calcular_prima_vida_desempleo($prima, $tasa_vida, $tasa_desempleo)
{
    $prima = $_POST["valor"] / 1000 * ($tasa_vida / 100);
    $prima +=  $_POST["cuota"] / 1000 * $tasa_desempleo;
    return $prima;
}

function crear_cotizacion_vida($planes)
{
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

        $details = json_decode(json_encode($responseIns->getDetails()), true);
    }

    return $details["id"];
}
