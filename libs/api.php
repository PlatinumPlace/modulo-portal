<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

class Api
{
    // array con los parametros de zoho app
    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "redirect_uri" => "",
        "currentUserEmail" => "",
        "token_persistence_path" => "api"
    );
    // inicializa las clases del api
    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }
    // buscar los registros segun un criterio y el nombre del modulo en el crm
    // retorna varios registros con las propiedades de la clase del api .....
    // que se recorren con un foreach
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
    // crea un nuevo registro en el crm usando el nombre del modulo y un array
    // recorre el array en un foreach con las propiedades del array,para esto debe tener 
    // los mismos nombres que los campos del modulo
    // retorna el id del nuevo registro
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
        return $result['id'];
    }
    // retorna un objeto , segun el nombre del modulo y el id
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
    // modifica un registro existente,usando el nombre del modulo,el id y un array con los valores
    // asignados en espacios con el nombre de los campos del modulo en el crm
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
    }
    // descarga la imagen de perfil de un registro del crm, tomando el nombre del modulo,
    // el id y la ubicacion donde se guardan las imagenes
    // retornando la ubicacion de la imagen y su nombre con la extension
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
    // retorna todos los registros de un modulo, tomando el nombre del modulo
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
    // adjunta un archivo a un registro del crm,tomando el nombre del modulo,el id del registro y la ubicacion
    // temporal en el servidor
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
