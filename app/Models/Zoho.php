<?php
namespace App\Models;

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;
use zcrmsdk\oauth\ZohoOAuth;

class Zoho
{
    public function __construct()
    {
        ZCRMRestClient::initialize([
            "client_id" => "1000.7FJQ4A2KDH9S2IJWDYL13HATQFMA2H",
            "client_secret" => "c3f1d0589803f294a7c5b27e3968ae1658927da9d7",
            "currentUserEmail" => "tecnologia@gruponobe.com",
            "redirect_uri" => url("/"),
            "token_persistence_path" => public_path()
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

        $filePath = public_path("img");
        $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");
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
}
