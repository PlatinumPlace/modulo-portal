<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

class ZohoAPI
{

    public function createRecord($module_name, &$record_model)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $records = array();
        $record = ZCRMRecord::getInstance($module_name, null);

        $record_properties = get_object_vars($record_model);

        foreach ($record_properties as $propertie => $propertie_value) {
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
            echo "<br/>";
            $Details = json_decode(json_encode($responseIns->getDetails()), true);
            $result = $Details['id'];
        }

        return $result;
    }

    public function getMyRecords($module_name, $contact_id, $page = 1, $per_page = 100)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $criteria = "Contact_Name:equals:" . $contact_id;
        $param_map = array("page" => $page, "per_page" => $per_page);
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();
        $cont = 0;
        try {
            foreach ($records as $record) {
                $result[$cont]['id'] = $record->getEntityId();
                $result[$cont]['Stage'] = $record->getFieldValue("Stage");
                $result[$cont]['Closing_Date'] = $record->getFieldValue("Closing_Date");
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
        return $result;
    }

    public function getRecord($module_name, $record_id)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_name);
        $response = $moduleIns->getRecord($record_id);
        $record = $response->getData();
        $result = array();
        try {

            $result['Plan'] = $record->getFieldValue("Plan");
            $result['Nombre_del_asegurado'] = $record->getFieldValue("Nombre_del_asegurado");
            $result['Direcci_n_del_asegurado'] = $record->getFieldValue("Direcci_n_del_asegurado");
            $result['A_o_de_Fabricacion'] = $record->getFieldValue("A_o_de_Fabricacion");
            $result['Chasis'] = $record->getFieldValue("Chasis");
            $result['Color'] = $record->getFieldValue("Color");
            $result['Email_del_asegurado'] = $record->getFieldValue("Email_del_asegurado");
            $result['Marca'] = $record->getFieldValue("Marca");
            $result['Modelo'] = $record->getFieldValue("Modelo");
            $result['Placa'] = $record->getFieldValue("Placa");
            $result['Type'] = $record->getFieldValue("Type");
            $result['RNC_Cedula_del_asegurado'] = $record->getFieldValue("RNC_Cedula_del_asegurado");
            $result['Telefono_del_asegurado'] = $record->getFieldValue("Telefono_del_asegurado");
            $result['Tipo_de_poliza'] = $record->getFieldValue("Tipo_de_poliza");
            $result['Tipo_de_vehiculo'] = $record->getFieldValue("Tipo_de_vehiculo");
            $result['Valor_Asegurado'] = $record->getFieldValue("Valor_Asegurado");
            $result['Es_nuevo'] = $record->getFieldValue("Es_nuevo");
            $result['Stage'] = $record->getFieldValue("Stage");

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

    public function updateRecord($module_name, $record_id,&$record_model)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_name, $record_id);
        $record->setFieldValue("Aseguradora", $record_model->Aseguradora);
        $record->setFieldValue("Stage", $record_model->Stage);
        $responseIns = $record->update();
    }
}
