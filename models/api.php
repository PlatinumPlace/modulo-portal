<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

class api {

    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "currentUserEmail" => "",
        "redirect_uri" => "index.php",
        "token_persistence_path" => "zoho_sdk"
    );

    public function __construct() {
        ZCRMRestClient::initialize($this->configuration);
    }

    public function searchRecordsByCriteria($module_api_name, $criteria, $num_pag = 1, $cantidad = 200) {
        $records = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array(
            "page" => $num_pag,
            "per_page" => $cantidad
        );

        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
        } catch (ZCRMException $ex) {
            //echo $ex->getMessage();
            //echo "<br>";
            //echo $ex->getExceptionCode();
            //echo "<br>";
            //echo $ex->getFile();
            //echo "<br>";
        }

        return $records;
    }

    public function getRecord($module_api_name, $record_id) {
        $record = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);

        try {
            $response = $moduleIns->getRecord($record_id);
            $record = $response->getData();
        } catch (ZCRMException $ex) {
            // echo $ex->getMessage();
            // echo "<br>";
            // echo $ex->getExceptionCode();
            // echo "<br>";
            // echo $ex->getFile();
            // echo "<br>";
        }

        return $record;
    }

    public function getAttachments($module_api_name, $record_id, $num_pag = 1, $cantidad = 200) {
        $attachments = array();
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $param_map = array(
            "page" => $num_pag,
            "per_page" => $cantidad
        );

        try {
            $responseIns = $record->getAttachments($param_map);
            $attachments = $responseIns->getData();
        } catch (ZCRMException $ex) {
            // echo $ex->getMessage();
            // echo "<br>";
            // echo $ex->getExceptionCode();
            // echo "<br>";
            // echo $ex->getFile();
            // echo "<br>";
        }

        return $attachments;
    }

    public function downloadAttachment($module_api_name, $record_id, $attachment_id) {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $fileResponseIns = $record->downloadAttachment($attachment_id);

        $filePath = "public/path";
        if (!is_dir($filePath)) {
            mkdir($filePath, 0755, true);
        }

        $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");

        // echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        // echo "<br>";
        // echo "File Name:" . $fileResponseIns->getFileName();
        // echo "<br>";

        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);

        return $filePath . "/" . $fileResponseIns->getFileName();
    }

    public function downloadPhoto($module_api_name, $record_id) {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $fileResponseIns = $record->downloadPhoto();

        // echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        // echo "<br>";
        // echo "File Name:" . $fileResponseIns->getFileName();
        // echo "<br>";

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

    public function uploadAttachment($module_api_name, $record_id, $filePath) {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $responseIns = $record->uploadAttachment($filePath);
        // echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
        // echo "<br>";
        // echo "Status:" . $responseIns->getStatus();
        // echo "<br>";
        // echo "Message:" . $responseIns->getMessage();
        // echo "<br>";
        // echo "Code:" . $responseIns->getCode();
        // echo "<br>";
        // echo "Details:" . $responseIns->getDetails()['id'];
    }

    public function getRecords($module_api_name) {
        $records = array();
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);

        try {
            $response = $moduleIns->getRecords();
            $records = $response->getData();
        } catch (ZCRMException $ex) {
            // echo $ex->getMessage();
            // echo "<br>";
            // echo $ex->getExceptionCode();
            // echo "<br>";
            // echo $ex->getFile();
            // echo "<br>";
        }

        return $records;
    }

    public function createRecords($module_api_name, $registro, $planes = array()) {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $records = array();
        $record = ZCRMRecord::getInstance($module_api_name, null);

        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }

        foreach ($planes as $plan) {
            $lineItem = ZCRMInventoryLineItem::getInstance(null);

            $lineItem->setProduct(ZCRMRecord::getInstance("Products", $plan["id"]));
            $lineItem->setDescription($plan["descripcion"]);
            $lineItem->setQuantity($plan["cantidad"]);
            $lineItem->setListPrice($plan["prima"]);

            $taxInstance1 = ZCRMTax::getInstance($plan["impuesto"]);
            $taxInstance1->setPercentage($plan["impuesto_valor"]);
            $taxInstance1->setValue(50);
            $lineItem->addLineTax($taxInstance1);

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

        return $details["id"];
    }

    public function update($module_api_name, $record_id, $registro, $planes = null) {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);

        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }

        if (!empty($planes)) {
            foreach ($planes as $plan) {
                $lineItem = ZCRMInventoryLineItem::getInstance(null);

                $lineItem->setProduct(ZCRMRecord::getInstance("Products", $plan["id"]));
                $lineItem->setDescription($plan["descripcion"]);
                $lineItem->setQuantity($plan["cantidad"]);
                $lineItem->setListPrice($plan["prima"]);

                $taxInstance1 = ZCRMTax::getInstance($plan["impuesto"]);
                $taxInstance1->setPercentage($plan["impuesto_valor"]);
                $taxInstance1->setValue(50);
                $lineItem->addLineTax($taxInstance1);

                $record->addLineItem($lineItem);
            }
        }

        $responseIns = $record->update();

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
    }

}
