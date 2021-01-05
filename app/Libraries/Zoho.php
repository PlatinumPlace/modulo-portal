<?php

namespace App\Libraries;

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;
use zcrmsdk\oauth\ZohoOAuth;

class Zoho
{
    function __construct()
    {
        ZCRMRestClient::initialize([
            "client_id" => "",
            "client_secret" => "",
            "currentUserEmail" => "",
            "redirect_uri" => site_url(),
            "token_persistence_path" => "token"
        ]);
    }

    public function generateTokens($grant_token)
    {
        $oAuthClient = ZohoOAuth::getClientInstance();
        $oAuthClient->generateAccessToken($grant_token);
    }

    public function searchRecordsByCriteria($module_api_name, $criteria, $page, $per_page)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array("page" => $page, "per_page" => $per_page);
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            return $response->getData();
        } catch (ZCRMException $ex) {
            //echo $ex->getMessage();
            //echo "<br>";
            //echo $ex->getExceptionCode();
            //echo "<br>";
            //echo $ex->getFile();
            //echo "<br>";
            return array();
        }
    }

    public function getRecords($module_api_name)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array("page" => 1, "per_page" => 200);
        try {
            $response = $moduleIns->getRecords($param_map);
            return $response->getData();
        } catch (ZCRMException $ex) {
            //echo $ex->getMessage();
            //echo "<br>";
            //echo $ex->getExceptionCode();
            //echo "<br>";
            //echo $ex->getFile();
            //echo "<br>";
            return array();
        }
    }

    public function getRecord($module_api_name, $record_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        try {
            $response = $moduleIns->getRecord($record_id);
            return $response->getData();
        } catch (ZCRMException $ex) {
            //echo $ex->getMessage();
            //echo "<br>";
            //echo $ex->getExceptionCode();
            //echo "<br>";
            //echo $ex->getFile();
            //echo "<br>";
        }
    }

    public function downloadPhoto($module_api_name, $record_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $fileResponseIns = $record->downloadPhoto();
        //echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        //echo "<br>";
        //echo "File Name:" . $fileResponseIns->getFileName();
        //echo "<br>";
        $fp = fopen("img/" . $fileResponseIns->getFileName(), "w");
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
        return $fileResponseIns->getFileName();
    }

    public function createRecords($module_api_name, $registro, $productos = array())
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $records = array();
        $record = ZCRMRecord::getInstance($module_api_name, null);
        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        foreach ($productos as $producto) {
            $lineItem = ZCRMInventoryLineItem::getInstance(null);
            $lineItem->setDescription($producto["descripcion"]);
            $lineItem->setListPrice($producto["precio"]);
            $taxInstance1 = ZCRMTax::getInstance("ITBIS 16");
            $taxInstance1->setPercentage(16);
            $taxInstance1->setValue(50);
            $lineItem->addLineTax($taxInstance1);
            $lineItem->setProduct(ZCRMRecord::getInstance("Products", $producto["id"]));
            $lineItem->setQuantity(1);
            $record->addLineItem($lineItem);
        }
        array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        foreach ($responseIn->getEntityResponses() as $responseIns) {
            //echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
            //echo "<br>";
            //echo "Status:" . $responseIns->getStatus();
            //echo "<br>";
            //echo "Message:" . $responseIns->getMessage();
            //echo "<br>";
            //echo "Code:" . $responseIns->getCode();
            //echo "<br>";
            //echo "Details:" . json_encode($responseIns->getDetails());
            //echo "<br>";
            $details = json_decode(json_encode($responseIns->getDetails()), true);
        }
        return $details["id"];
    }

    public function update($module_api_name, $record_id, $registro)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }
        $responseIns = $record->update();
        //echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
        //echo "<br>";
        //echo "Status:" . $responseIns->getStatus();
        //echo "<br>";
        //echo "Message:" . $responseIns->getMessage();
        //echo "<br>";
        //echo "Code:" . $responseIns->getCode();
        //echo "<br>";
        //echo "Details:" . json_encode($responseIns->getDetails());
        //echo "<br>";
    }

    public function uploadAttachment($module_api_name, $record_id, $path)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $responseIns = $record->uploadAttachment($path);
        //echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
        //echo "<br>";
        //echo "Status:" . $responseIns->getStatus();
        //echo "<br>";
        //echo "Message:" . $responseIns->getMessage();
        //echo "<br>";
        //echo "Code:" . $responseIns->getCode();
        //echo "<br>";
        //echo "Details:" . $responseIns->getDetails()['id'];
        //echo "<br>";
    }

    public function getAttachments($module_api_name, $record_id, $page, $per_page)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $param_map = array("page" => $page, "per_page" => $per_page);
        try {
            $responseIns = $record->getAttachments($param_map);
            return $responseIns->getData();
        } catch (ZCRMException $ex) {
            //echo $ex->getMessage();
            //echo "<br>";
            //echo $ex->getExceptionCode();
            //echo "<br>";
            //echo $ex->getFile();
            //echo "<br>";
            return array();
        }
    }

    public function downloadAttachment($module_api_name, $record_id, $attachment_id, $filePath)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $fileResponseIns = $record->downloadAttachment($attachment_id);
        $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");
        //echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        //echo "<br>";
        //echo "File Name:" . $fileResponseIns->getFileName();
        //echo "<br>";
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
        return $filePath . "/" . $fileResponseIns->getFileName();
    }
}
