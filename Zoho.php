<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;
use zcrmsdk\oauth\ZohoOAuth;

//Cada método contiene mensajes de confirmación dados por el api.
//Glosario
//página: los módulos tiene 1 página cada 200 registros.
class Zoho
{
    //https://accounts.zoho.com/developerconsole
    //Requiere: id cliente, clave secreta, email del la cuenta de zoho, ruta al token.
    function __construct()
    {
        ZCRMRestClient::initialize([
            "client_id" => "",
            "client_secret" => "",
            "currentUserEmail" => "",
            "redirect_uri" => "",
            "token_persistence_path" => ""
        ]);
    }

    //https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html#Initialization
    //Requiere: token de actualización.
    //Retorna: nada.
    //Descripción: usa la clase del api para genera un token .txt.
    public function generateTokens($grant_token)
    {
        $oAuthClient = ZohoOAuth::getClientInstance();
        $oAuthClient->generateAccessToken($grant_token);
    }

    //https://www.zoho.com/crm/developer/docs/php-sdk/module-sample.html?src=search_record_criteria
    //Requiere: módulo,criterio, página del módulo, cantidad de registros.
    //Ejemplo de criterio: "Nombre:equals:$nombre".
    //Retorna: múltiples objetos ZCRMRecord.
    //Descripción: busca registros en un módulo según la cadena de criterio.
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/module-sample.html?src=records_list
    //Requiere: módulo, opcional = página del módulo, cantidad de registros.
    //Retorna: múltiples objetos ZCRMRecord.
    //Descripción: listado de registros.
    public function getRecords($module_api_name, $page = 1, $per_page = 200)
    {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($module_api_name);
        $param_map = array("page" => $page, "per_page" => $per_page);
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/module-sample.html?src=get_record
    //Requiere: módulo, id del registro.
    //Retorna: objeto ZCRMRecord.
    //Descripción: objeto con las propiedades del registro.
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/record-samples.html?src=download_photo
    //Requiere: módulo, id del registro.
    //Retorna: ruta del archivo.
    //Descripción: descarga la foto de perfil de un registro.
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/module-sample.html?src=create_records
    //Requiere: módulo, arreglo, donde los campos tenga el nombre de api de los campos del
    //módulo, arreglo con los siguientes campos: id del registro producto, descripción, precio.
    //Retorna: id del nuevo registro.
    //Descripción: crea un nuevo registro en un módulo, si contiene una tabla de productos: los
    //asigna según los valores id del arreglo y si contiene una descripción y precio también.
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/record-samples.html?src=update_record
    //Requiere: módulo, id de registro, arreglo, donde los campos tenga el nombre de api de los campos del
    //módulo.
    //Retorna: nada.
    //Descripción: modifica los valores de un registro.
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/record-samples.html?src=upload_attachments
    //Requiere: módulo, id de registro, ruta del archivo.
    //Retorna: nada.
    //Descripción: carga un archivo a un registro.
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/record-samples.html?src=get_attachments
    //Requiere: módulo, id del registro, pagina de los archivos cargados, cantidad de
    //los archivos cargados.
    //Retorna: múltiples objetos ZCRMRestClient asociados a un registro.
    //Descripción: listado de objetos que representan los archivos cargados a un registro.
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

    //https://www.zoho.com/crm/developer/docs/php-sdk/record-samples.html?src=download_attachments
    //Requiere: módulo, id del registro, id del archivo cargado al registro, ruta donde se
    //descarga el archivo.
    //Retorna: ruta del archivo.
    //Descripción: descarga un archivo, que esté cargado a un registro, a un ruta específica.
    public function downloadAttachment($module_api_name, $record_id, $attachment_id)
    {
        $record = ZCRMRestClient::getInstance()->getRecordInstance($module_api_name, $record_id);
        $fileResponseIns = $record->downloadAttachment($attachment_id);
        $fp = fopen("tmp/".$fileResponseIns->getFileName(), "w");
        //echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
        //echo "<br>";
        //echo "File Name:" . $fileResponseIns->getFileName();
        //echo "<br>";
        $stream = $fileResponseIns->getFileContent();
        fputs($fp, $stream);
        fclose($fp);
        return $fileResponseIns->getFileName();
    }
}
