<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class vendorAPI
{

    public function getRecords()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Vendors");
        $param_map=array("page"=>10,"per_page"=>10);
        $response = $moduleIns->getRecords($param_map);
        $records = $response->getData(); 
        
        try {
            foreach ($records as  $key => $record) {

                $result[$key]['id']= $record->getEntityId();;
                $result[$key]['Vendor_Name']= $record->getFieldValue("Vendor_Name");
               
            }
        } catch (ZCRMException $ex) {
            echo $ex->getMessage(); // To get ZCRMException error message
            echo $ex->getExceptionCode(); // To get ZCRMException error code
            echo $ex->getFile(); // To get the file name that throws the Exception
        }

        return $result;
    }
}
