<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

include "././zohoapi/config.php";

class ZohoAPI
{

    public function createRecord($module_name, &$record_model)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $records = array();
        $record = ZCRMRecord::getInstance($module_name, null);

        foreach ($record_model as $propertie => $propertie_value) {

            if ($propertie_value != null) {
                $record->setFieldValue($propertie, $propertie_value);
            }
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
            echo "<br/>";
            $Details = json_decode(json_encode($responseIns->getDetails()), true);
            $result = $Details['id'];
        }

        return $result;
    }

    public function searchRecordsByCriteria($module_name, &$record_model, $criteria, $Product = false)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $param_map = array("page" => 1, "per_page" => 100);
        $results = array();
        $cont = 0;
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {

                foreach ($record_model as $propertie => $propertie_value) {
                    $results[$cont]['id'] = $record->getEntityId();
                    $results[$cont][$propertie] = $record->getFieldValue($propertie);
                }

                if ($Product == true) {
                    $lineItems = $record->getLineItems();
                    foreach ($lineItems as $lineItem) {
                        $result[$cont]['ListPrice'] = $lineItem->getListPrice();
                        $result[$cont]['Total'] = $lineItem->getNetTotal();
                        $result[$cont]['Tax'] = $lineItem->getTaxAmount();
                        $result[$cont]['id_product'] = $lineItem->getProduct()->getEntityId();
                    }
                }
                $cont++;
            }
        } catch (ZCRMException $ex) {
            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
            echo "<br/>";
        }
        return $results;
    }

    public function getRecord($module_name, &$record_model, $record_id, $Vendor_Name = false)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $response = $moduleIns->getRecord($record_id);
        $record = $response->getData();
        $result = array();
        try {

            foreach ($record_model as $propertie => $propertie_value) {
                $result[$propertie] = $record->getFieldValue($propertie);

                if ($Vendor_Name == true) {
                    $result['Vendor_Name'] = $record->getFieldValue("Vendor_Name")->getLookupLabel();
                    $result['Vendor_Name_id'] = $record->getFieldValue("Vendor_Name")->getEntityId();
                }
            }
        } catch (ZCRMException $ex) {
            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
            echo "<br/>";
        }
        return $result;
    }

    public function updateRecord($module_name, &$record_model, $record_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_name, $record_id);

        foreach ($record_model as $propertie => $propertie_value) {

            if ($propertie_value != null) {
                $record->setFieldValue($propertie, $propertie_value);
            }
        }

        $trigger = array(); //triggers to include
        $lar_id = "lar_id"; //lead assignment rule id
        $responseIns = $record->update($trigger, $lar_id); // to update the record

        echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
        echo "<br/>";
        echo "Status:" . $responseIns->getStatus();
        echo "<br/>";
        echo "Message:" . $responseIns->getMessage();
        echo "<br/>";
        echo "Code:" . $responseIns->getCode();
        echo "<br/>";
        echo "Details:" . json_encode($responseIns->getDetails());
    }
}
