<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

class api
{
    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "currentUserEmail" => "",
        "redirect_uri" => "index.php",
        "token_persistence_path" => "zcrm_php_sdk"
    );

    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }

    function searchRecordsByCriteria($module_api_name, $criteria, $page = 1, $per_page = 200)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array("page" => $page, "per_page" => $per_page);
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            return $response->getData();
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
    }

    function getRecords($module_api_name, $page = 1, $per_page = 200)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array("page" => $page, "per_page" => $per_page);
        try {
            $response = $moduleIns->getRecords($param_map);
            return $response->getData();
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
    }

    function getRecord($module_api_name, $record_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        try {
            $response = $moduleIns->getRecord($record_id);
            return $response->getData();
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
    }

    function createRecords($module_api_name, $registro, $planes = array())
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $records = array();
        $record = ZCRMRecord::getInstance($module_api_name, null);

        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }

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

    function getAttachments($module_api_name, $record_id, $page = 1, $per_page = 200)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $param_map = array("page" => $page,  "per_page" => $per_page);
        try {
            $responseIns = $record->getAttachments($param_map);
            return $responseIns->getData();
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
    }

    function downloadAttachment($module_api_name, $record_id, $attachment_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $fileResponseIns = $record->downloadAttachment($attachment_id);

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

    function downloadPhoto($module_api_name, $record_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
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

    function uploadAttachment($module_api_name, $record_id, $filePath)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $responseIns = $record->uploadAttachment($filePath);
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

    function update($module_api_name, $record_id, $registro, $plan = array())
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);

        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }

        $lineItem = ZCRMInventoryLineItem::getInstance($plan["id"]);
        $lineItem->setDescription($plan["descripcion"]);
        $lineItem->setListPrice($plan["prima"]);
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
}
