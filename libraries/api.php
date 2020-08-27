<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

function lista_filtrada_registros($modulo, $criteria, $num_pagina = 1, $cantidad = 200)
{
    $records = array();
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
    $param_map = array("page" => $num_pagina, "per_page" => $cantidad);

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();
    } catch (ZCRMException $ex) {
        /*
        echo $ex->getMessage();
        echo "<br>";
        echo $ex->getExceptionCode();
        echo "<br>";
        echo $ex->getFile();
        echo "<br>";
        */
    }

    return $records;
}

function detalles_registro($modulo, $id)
{
    $record = null;
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);

    try {
        $response = $moduleIns->getRecord($id);
        $record = $response->getData();
    } catch (ZCRMException $ex) {
        /*
          echo $ex->getMessage();
          echo "<br>";
          echo $ex->getExceptionCode();
          echo "<br>";
          echo $ex->getFile();
          echo "<br>";
        */
    }

    return $record;
}

function lista_registros($modulo, $num_pagina = 1, $cantidad = 200)
{
    $records = array();
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
    $param_map = array("page" => $num_pagina, "per_page" => $cantidad);

    try {
        $response = $moduleIns->getRecords($param_map);
        $records = $response->getData();
    } catch (ZCRMException $ex) {
        /*
          echo $ex->getMessage();
         echo "<br>";
          echo $ex->getExceptionCode();
          echo "<br>";
          echo $ex->getFile();
          echo "<br>";
         */
    }

    return $records;
}

function lista_adjuntos($modulo, $id)
{
    $attachments = array();
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $param_map = array("page" => "1", "per_page" => "200");

    try {
        $responseIns = $record->getAttachments($param_map);
        $attachments = $responseIns->getData();
    } catch (ZCRMException $ex) {
        /*
          echo $ex->getMessage();
         echo "<br>";
          echo $ex->getExceptionCode();
          echo "<br>";
          echo $ex->getFile();
          echo "<br>";
         */
    }
    
    return $attachments;
}

function descargar_adjunto($modulo, $id, $id_adjunto)
{
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $fileResponseIns = $record->downloadAttachment($id_adjunto);

    $filePath = "public/path";
    if (!is_dir($filePath)) {
        mkdir($filePath, 0755, true);
    }

    $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");
    /*
      echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
      echo "<br>";
      echo "File Name:" . $fileResponseIns->getFileName();
      echo "<br>";
     */

    $stream = $fileResponseIns->getFileContent();
    fputs($fp, $stream);
    fclose($fp);

    return $filePath . "/" . $fileResponseIns->getFileName();
}

function obtener_imagen_registro($modulo, $id)
{
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $fileResponseIns = $record->downloadPhoto();

    /*
    echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
    echo "<br>";
    echo "File Name:" . $fileResponseIns->getFileName();
    echo "<br>";
    */

    $filePath = "public/path";
    if (!is_dir($filePath)) {
        mkdir($filePath, 0755, true);
    }

    $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");
    $stream = $fileResponseIns->getFileContent();
    fputs($fp, $stream);
    fclose($fp);
    return $filePath . "/" . $fileResponseIns->getFileName();
}

function crear_registro($modulo, $registro)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
    $records = array();
    $record = ZCRMRecord::getInstance($modulo, null);

    foreach ($registro as $campo => $valor) {
        $record->setFieldValue($campo, $valor);
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

function adjuntar_registro($modulo, $id, $ruta)
{
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $responseIns = $record->uploadAttachment($ruta);
    /*
      echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
     echo "<br>";
      echo "Status:" . $responseIns->getStatus();
     echo "<br>";
      echo "Message:" . $responseIns->getMessage();
      echo "<br>";
     echo "Code:" . $responseIns->getCode();
     echo "<br>";
      echo "Details:" . $responseIns->getDetails()['id'];
     echo "<br>";
     */
}
