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
        "redirect_uri" => "install.php",
        "token_persistence_path" => "zcrm-php-sdk"
    );

    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }

    public function searchRecordsByCriteria($modulo, $criterio, $num_pag = 1, $cantidad = 200)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
        $param_map = array("page" => $num_pag, "per_page" => $cantidad);

        try {
            $response = $moduleIns->searchRecordsByCriteria($criterio, $param_map);
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

            return array();
        }
    }

    public function getRecords($modulo, $num_pag = 1, $cantidad = 200)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
        $param_map = array("page" => $num_pag, "per_page" => $cantidad);

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

            return array();
        }
    }

    public function getRecord($modulo, $id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
        try {
            $response = $moduleIns->getRecord($id);
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

            return null;
        }
    }

    public function createRecords($modulo, $registro, $plan_id = null, $prima = null)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
        $records = array();
        $record = ZCRMRecord::getInstance($modulo, null);

        foreach ($registro as $campo => $valor) {
            $record->setFieldValue($campo, $valor);
        }

        if (!empty($plan_id)) {
            $lineItem = ZCRMInventoryLineItem::getInstance(null);
            $lineItem->setListPrice($prima);
            $taxInstance1 = ZCRMTax::getInstance("ITBIS 16");
            $taxInstance1->setPercentage(16);
            $lineItem->addLineTax($taxInstance1);
            $lineItem->setProduct(ZCRMRecord::getInstance("Products", $plan_id));
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

    public function getAttachments($modulo, $id, $num_pag = 1, $cantidad = 200)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
        $param_map = array("page" => $num_pag, "per_page" => $cantidad);

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

            return array();
        }
    }

    public function downloadAttachment($modulo, $id, $adjunto_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
        $fileResponseIns = $record->downloadAttachment($adjunto_id);

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

    public function downloadPhoto($modulo, $id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
        $fileResponseIns = $record->downloadPhoto();

        /*
          echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
          echo "<br>";
          echo "File Name:" . $fileResponseIns->getFileName();
          echo "<br>";
         */

        $filePath = "public/img";
        $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);

        return $filePath . "/" . $fileResponseIns->getFileName();
    }

    public function update($modulo, $id, $registro)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);

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

    public function uploadAttachment($modulo, $id, $ruta)
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
}
