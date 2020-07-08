<?php

use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class usuario extends zoho_api
{
    function __construct()
    {
        parent::__construct();
    }

    public function validar_usuario()
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contacts");
        $criteria = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
        $param_map = array("page" => 1, "per_page" => 1);
        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            foreach ($records as $record) {
                if ($record->getFieldValue("Estado") == true) {
                    $_SESSION["usuario"]['id'] = $record->getEntityId();
                    $_SESSION["usuario"]['nombre'] = $record->getFieldValue("First_Name") . " " . $record->getFieldValue("Last_Name");
                    $_SESSION["usuario"]['empresa_id'] = $record->getFieldValue("Account_Name")->getEntityId();
                    $_SESSION["usuario"]['empresa_nombre'] = $record->getFieldValue("Account_Name")->getLookupLabel();
                    $_SESSION["usuario"]['tiempo_activo'] = time();
                }
            }
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
}
