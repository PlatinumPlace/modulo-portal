<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class quoteAPI
{
    public function getRecordByCriteria($dealid)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
        $criteria = "Deal_Name:equals:" . $dealid;
        $param_map = array("page" => 1, "per_page" => 1);
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();
        $cont = 0;
        try {
            foreach ($records as $record) {
                $lineItems = $record->getLineItems();
                foreach ($lineItems as $lineItem) {
                    $result[$cont]['ListPrice'] = $lineItem->getListPrice();
                    $result[$cont]['Total'] = $lineItem->getNetTotal();
                    $result[$cont]['Tax'] = $lineItem->getTaxAmount();
                    $result[$cont]['id_product'] = $lineItem->getProduct()->getEntityId();
                    $cont++;
                }
            }
            return $result;
        } catch (ZCRMException $ex) {
            echo $ex->getMessage(); // To get ZCRMException error message
            echo $ex->getExceptionCode(); // To get ZCRMException error code
            echo $ex->getFile(); // To get the file name that throws the Exception
        }
    }
}
