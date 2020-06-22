<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

class api
{
    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "currentUserEmail" => "",
        "redirect_uri" => "api/install.php",
        "token_persistence_path" => "api"
    );

    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }

    public function searchRecordsByCriteria($module_api_name, $criteria, $page, $per_page)
    {
        $records = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array("page" => $page, "per_page" => $per_page);
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
            */
        }
        return $records;
    }

    public function createRecord($module_api_name, array $record_values)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $records = array();
        $record = ZCRMRecord::getInstance($module_api_name, null);
        foreach ($record_values as $field => $value) {
            $record->setFieldValue($field, $value);
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
            */
            $details = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $details;
    }

    public function getRecord($module_api_name, $record_id)
    {
        $record = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        try {
            $response = $moduleIns->getRecord($record_id);
            $record = $response->getData();
        } catch (ZCRMException $ex) {
            /*
            echo $ex->getMessage();
            echo "<br>";
            echo $ex->getExceptionCode();
            echo "<br>";
            echo $ex->getFile();
            */
        }
        return $record;
    }

    public function getRecords($module_api_name, $page, $per_page)
    {
        $records = null;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array("page" => $page, "per_page" => $per_page);
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
            */
        }
        return $records;
    }

    public function updateRecord($module_api_name, $record_id, array $record_values)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        foreach ($record_values as $field => $value) {
            $record->setFieldValue($field, $value);
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
        */
    }

    public function downloadPhoto($module_api_name, $record_id, $filePath)
    {
        if (!is_dir($filePath)) {
            mkdir($filePath, 0755, true);
        }
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $fileResponseIns = $record->downloadPhoto();
        /*
        echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        echo "File Name:" . $fileResponseIns->getFileName();
        */
        $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
        return $filePath . "/" . $fileResponseIns->getFileName();
    }

    public function uploadAttachment($module_api_name, $record_id, $filePath)
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
        */
    }

    public function getAttachments($module_api_name, $record_id, $page, $per_page)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $param_map = array("page" => $page, "per_page" => $per_page);
        $attachments=null;
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
            */
        }
        return $attachments;
    }
}
