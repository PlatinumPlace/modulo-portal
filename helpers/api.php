<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

class api
{
    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "redirect_uri" => "",
        "currentUserEmail" => "",
        "token_persistence_path" => "api"
    );

    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }

    public function searchRecordsByCriteria($module_name, $criteria)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $records = null;
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria);
            $records = $response->getData();
        } catch (ZCRMException $ex) {
            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
        }
        return $records;
    }

    public function createRecord($module_name, array $record_model)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $records = array();
        $record = ZCRMRecord::getInstance($module_name, null);
        foreach ($record_model as $propertie => $propertie_value) {
            $record->setFieldValue($propertie, $propertie_value);
        }
        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
            echo "<br/>";
            echo "Status:" . $responseIns->getStatus();
            echo "<br/>";
            echo "Message:" . $responseIns->getMessage();
            echo "<br/>";
            echo "Code:" . $responseIns->getCode();
            echo "<br/>";
            echo "Details:" . json_encode($responseIns->getDetails());
            $result = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $result;
    }

    public function getRecord($module_name, $record_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $record = null;
        try {
            $response = $moduleIns->getRecord($record_id);
            $record = $response->getData();
        } catch (ZCRMException $ex) {
            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
        }
        return $record;
    }

    public function updateRecord($module_name, array $record_model, $record_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_name, $record_id);
        foreach ($record_model as $propertie => $propertie_value) {
            $record->setFieldValue($propertie, $propertie_value);
        }
        $responseIns = $record->update();
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
        echo "<br/>";
        echo "Status:" . $responseIns->getStatus();
        echo "<br/>";
        echo "Message:" . $responseIns->getMessage();
        echo "<br/>";
        echo "Code:" . $responseIns->getCode();
        echo "<br/>";
        echo "Details:" . json_encode($responseIns->getDetails());
        return json_decode(json_encode($responseIns->getDetails()), true);
    }

    public function downloadPhoto($module_name, $record_id, $filePath)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_name, $record_id);
        $fileResponseIns = $record->downloadPhoto();
        $fp = fopen($filePath . $fileResponseIns->getFileName(), "w");
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
        $result = $filePath . $fileResponseIns->getFileName();
        return $result;
    }

    public function getRecords($module_name)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $records = null;
        try {
            $response = $moduleIns->getRecords();
            $records = $response->getData();
        } catch (ZCRMException $ex) {
            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
        }
        return $records;
    }

    public function uploadAttachment($module_name, $record_id, $filePath)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_name, $record_id);
        $responseIns = $record->uploadAttachment($filePath);
        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
        echo "<br/>";
        echo "Status:" . $responseIns->getStatus();
        echo "<br/>";
        echo "Message:" . $responseIns->getMessage();
        echo "<br/>";
        echo "Code:" . $responseIns->getCode();
        echo "<br/>";
        echo "Details:" . $responseIns->getDetails()['id'];
    }
}
