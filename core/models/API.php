<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

include "././api/config.php";

class API
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

    public function searchRecordsByCriteria($module_name, &$record_model, $criteria, $Product_details = false)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $param_map = array("page" => 1, "per_page" => 100);
        $results = array();
        $cont1 = 0;
        $cont2 = 0;
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {

                foreach ($record_model as $propertie => $propertie_value) {
                    $results[$cont1]['id'] = $record->getEntityId();
                    $results[$cont1][$propertie] = $record->getFieldValue($propertie);
                }

                if ($Product_details == true) {
                    $lineItems = $record->getLineItems();

                    foreach ($lineItems as $lineItem) {
                        $results[$cont1]['Product_details'][$cont2] = array(
                                'Product_id' => $lineItem->getProduct()->getEntityId(),
                                'ListPrice' => $lineItem->getListPrice(),
                                'Total' => $lineItem->getNetTotal(),
                                'Tax' => $lineItem->getTaxAmount()
                        );
                        $cont2++;
                    }
                }

                $cont1++;
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
