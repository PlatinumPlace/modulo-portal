<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

class api extends config_api
{
    function __construct()
    {
        parent::__construct();
    }

    public function buscar_criterio($nombre_modulo, $criterio, $num_pagina, $cantidad_registros)
    {
        $record = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => $cantidad_registros
        );
        try {
            $response = $moduleIns->searchRecordsByCriteria($criterio, $param_map);
            $record =  $response->getData();
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

    public function detalles_registro($nombre_modulo, $id_registro)
    {
        $record = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        try {
            $response = $moduleIns->getRecord($id_registro);
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

    public function lista_registros($nombre_modulo, $num_pagina, $cantidad_registros)
    {
        $records = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => $cantidad_registros
        );
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

    public function crear_registro($nombre_modulo, $registro, $productos = null)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        $records = array();
        $record = ZCRMRecord::getInstance($nombre_modulo, null);

        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }

        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $lineItem = ZCRMInventoryLineItem::getInstance(null);

                $lineItem->setProduct(ZCRMRecord::getInstance("Products", $producto["id"]));
                $lineItem->setDescription($producto["descripcion"]);
                $lineItem->setQuantity($producto["cantidad"]);
                $lineItem->setListPrice($producto["prima"]);

                $taxInstance1 = ZCRMTax::getInstance($producto["impuesto"]);
                $taxInstance1->setPercentage($producto["impuesto_valor"]);
                $taxInstance1->setValue(50);
                $lineItem->addLineTax($taxInstance1);

                $record->addLineItem($lineItem);
            }
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

    public function adjuntar_archivo($nombre_modulo, $id_registro, $ruta)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $id_registro);
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

    public function lista_adjuntos($nombre_modulo, $id_registro, $num_pagina, $cantidad_registros)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $id_registro);
        $param_map = array(
            "page" => $num_pagina,
            "per_page" => $cantidad_registros
        );
        $attachments = null;
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

    public function obtener_imagen($nombre_modulo, $id_registro, $ruta)
    {
        if (!is_dir($ruta)) {
            mkdir($ruta, 0755, true);
        }
        $record = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $id_registro);
        $fileResponseIns = $record->downloadPhoto();
        /*
         echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
                       echo "<br>";
        echo "File Name:" . $fileResponseIns->getFileName();
                      echo "<br>";
         */
        $fp = fopen($ruta . "/" . $fileResponseIns->getFileName(), "w");
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
        return $ruta . "/" . $fileResponseIns->getFileName();
    }

    public function guardar_cambios_registro($nombre_modulo, $id_registro, $registro)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $id_registro);
        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
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
}
