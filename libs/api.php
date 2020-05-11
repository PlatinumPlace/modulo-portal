<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

class api
{

    public $config = array(
        "client_id" => "",
        "client_secret" => "",
        "currentUserEmail" => "",
        "token_persistence_path" => "api"
    );

    public function __construct()
    {
        $this->config["redirect_uri"] = constant("url") . "helpers/instalar_zoho_api.php";
        ZCRMRestClient::initialize($this->config);
    }

    public function crear_registro($nombre_modulo, array $nuevo_registro)
    {

        $modulo = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        $registros = array();
        $registro = ZCRMRecord::getInstance($nombre_modulo, null);

        foreach ($nuevo_registro as $campo => $valor) {
            $registros->setFieldValue($campo, $valor);
        }

        array_push($registros, $registro);
        $resultados = $modulo->createRecords($registros);

        foreach ($resultados->getEntityResponses() as $resultado) {

            echo "HTTP Status Code:" . $resultado->getHttpStatusCode();
            echo "<br/>";
            echo "Status:" . $resultado->getStatus();
            echo "<br/>";
            echo "Message:" . $resultado->getMessage();
            echo "<br/>";
            echo "Code:" . $resultado->getCode();
            echo "<br/>";
            echo "Details:" . json_encode($resultado->getDetails());

            $respuesta = json_decode(json_encode($resultado->getDetails()), true);
        }

        return $respuesta['id'];
    }

    public function obtener_registro($nombre_modulo, $registro_id)
    {

        $modulo = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        $registro = null;

        try {

            $resultado = $modulo->getRecord($registro_id);
            $registro = $resultado->getData();
        } catch (ZCRMException $ex) {

            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
        }

        return $registro;
    }

    public function obtener_registros($nombre_modulo)
    {

        $modulo = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        $registros = null;

        try {

            $respuesta = $modulo->getRecords();
            $registros = $respuesta->getData();
        } catch (ZCRMException $ex) {

            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
        }

        return $registros;
    }

    public function buscar_registro_por_criterio($nombre_modulo, $criterio)
    {

        $modulo = ZCRMRestClient::getInstance()->getModuleInstance($nombre_modulo);
        $registros = null;

        try {

            $respuesta = $modulo->searchRecordsByCriteria($criterio);
            $registros = $respuesta->getData();
        } catch (ZCRMException $ex) {

            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
        }

        return $registros;
    }

    public function modificar_registro($nombre_modulo, array $cambios_registro, $registro_id)
    {

        $registro = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $registro_id);

        foreach ($cambios_registro as $campo => $valor) {
            $registro->setFieldValue($campo, $valor);
        }

        $respuesta = $registro->update();

        echo "HTTP Status Code:" . $respuesta->getHttpStatusCode();
        echo "<br/>";
        echo "Status:" . $respuesta->getStatus();
        echo "<br/>";
        echo "Message:" . $respuesta->getMessage();
        echo "<br/>";
        echo "Code:" . $respuesta->getCode();
        echo "<br/>";
        echo "Details:" . json_encode($respuesta->getDetails());
    }

    public function descargar_foto($nombre_modulo, $registro_id, $ruta)
    {

        $registro = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $registro_id);

        $respuesta_archivo = $registro->downloadPhoto();

        $fp = fopen($ruta . $respuesta_archivo->getFileName(), "w");

        $ruta_temporal = $respuesta_archivo->getFileContent();

        fputs($fp, $ruta_temporal);

        fclose($fp);

        $respuesta = $ruta . $respuesta_archivo->getFileName();

        return $respuesta;
    }

    public function subir_archivos($nombre_modulo, $registro_id, $ruta)
    {

        $registro = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $registro_id);
        $respuesta = $registro->uploadAttachment($ruta);

        echo "HTTP Status Code:" . $respuesta->getHttpStatusCode();
        echo "<br/>";
        echo "Status:" . $respuesta->getStatus();
        echo "<br/>";
        echo "Message:" . $respuesta->getMessage();
        echo "<br/>";
        echo "Code:" . $respuesta->getCode();
        echo "<br/>";
        echo "Details:" . $respuesta->getDetails()['id'];
    }

    public function obtener_archivos($nombre_modulo, $registro_id)
    {

        $registro = ZCRMRestClient::getInstance()->getRecordInstance($nombre_modulo, $registro_id);

        try {

            $respuesta = $registro->getAttachments();
            $archivos = $respuesta->getData();
        } catch (ZCRMException $ex) {

            echo $ex->getMessage();
            echo "<br/>";
            echo $ex->getExceptionCode();
            echo "<br/>";
            echo $ex->getFile();
        }

        return $archivos;
    }
}
