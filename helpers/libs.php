<?php

use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
use zcrmsdk\crm\crud\ZCRMTax;

function verificar_sesion($usuarios)
{
    if (!isset($_SESSION["usuario"])) {
        $usuarios->iniciar_sesion();
        exit();
    } else {
        if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
            $usuarios->cerrar_sesion();
        }
    }

    $_SESSION["usuario"]["tiempo_activo"] = time();
}

function buscar_pagina($portal)
{
    if (isset($_GET["page"])) {
        if ($_GET["page"] == "cerrar_sesion") {
            $portal->cerrar_sesion();
        }

        if (method_exists($portal, $_GET["page"])) {
            $portal->{$_GET["page"]}();
        } else {
            $portal->error();
        }
    } else {
        $portal->inicio();
    }
}

function validar_usuario()
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contacts");
    $criteria = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
    $param_map = array("page" => 1, "per_page" => 200);

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
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }
}

function resumen_cotizaciones()
{
    $num_pag = 1;
    $result["total"] = 0;
    $result["emisiones"] = 0;
    $result["vencimientos"] = 0;
    $result["aseguradoras"] = array();

    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
    $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

    do {
        $param_map = array("page" => $num_pag, "per_page" => 200);

        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            $num_pag++;

            foreach ($records as $record) {
                $result["total"] += 1;

                if (
                    $record->getFieldValue("Deal_Name") != null
                    and
                    date("Y-m", strtotime($record->getFieldValue("Fecha_emisi_n"))) == date('Y-m')
                ) {
                    $result["emisiones"] += 1;
                    $result["aseguradoras"][] = $record->getFieldValue('Aseguradora')->getLookupLabel();
                }

                if (
                    $record->getFieldValue("Deal_Name") != null
                    and
                    date("Y-m", strtotime($record->getFieldValue("Valid_Till"))) == date('Y-m')
                ) {
                    $result["vencimientos"] += 1;
                }
            }
        } catch (ZCRMException $ex) {
            // echo $ex->getMessage();
            // echo "<br>";
            // echo $ex->getExceptionCode();
            // echo "<br>";
            // echo $ex->getFile();
            // echo "<br>";

            $num_pag = 0;
        }
    } while ($num_pag > 1);

    return $result;
}

function buscar_cotizacion($num_pag)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");

    if ($_POST) {
        $criteria = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
    } else {
        $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
    }

    $param_map = array("page" => $num_pag, "per_page" => 15);
    $records = array();

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();
    } catch (ZCRMException $ex) {
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }

    return $records;
}

function filtro_contratos()
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contratos");
    $param_map = array("page" => 1,  "per_page" => 200);
    $criteria = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
    $result = array();

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();

        foreach ($records as $record) {
            if ($record->getFieldValue('Tipo') == "Auto") {
                $result["auto"] = true;
            } elseif ($record->getFieldValue('Tipo') == "Vida") {
                $result["vida"] = true;
            } elseif ($record->getFieldValue('Tipo') == "Incendio") {
                $result["incendio"] = true;
            }
        }
    } catch (ZCRMException $ex) {
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }

    return $result;
}

function lista_aseguradoras()
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contratos");
    $criteria = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
    $param_map = array("page" => 1,  "per_page" => 200);
    $aseguradoras = array();

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();

        foreach ($records as $record) {
            $aseguradoras[$record->getEntityId()] = $record->getFieldValue('Aseguradora')->getLookupLabel();
        }
    } catch (ZCRMException $ex) {
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }

    return $aseguradoras;
}

function detalles_registro($modulo, $id)
{
    $record = null;
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);

    try {
        $response = $moduleIns->getRecord($id);
        $record = $response->getData();
    } catch (ZCRMException $ex) {
        //echo $ex->getMessage();
        //echo "<br>";
        //echo $ex->getExceptionCode();
        //echo "<br>";
        //echo $ex->getFile();
        //echo "<br>";
    }

    return $record;
}

function exportar_cotizaciones_csv()
{
    $titulo = "Reporte " . ucfirst($_POST["estado_cotizacion"]) . " " . $_POST["tipo_cotizacion"];
    $contenido_csv = array(
        array($_SESSION["usuario"]['empresa_nombre']),
        array($titulo),
        array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
        array("Vendedor:", $_SESSION["usuario"]['nombre']),
        array("")
    );

    switch ($_POST["tipo_cotizacion"]) {
        case 'auto':
            switch ($_POST["estado_cotizacion"]) {
                case 'pendientes':
                    $contenido_csv[] = array(
                        "Emision",
                        "Vigencia",
                        "Deudor",
                        "RNC/Cédula",
                        "Marca",
                        "Modelo",
                        "Tipo",
                        "Año",
                        "Valor Aseguradora",
                        "Prima",
                        "Aseguradora"
                    );
                    break;

                case 'emitidas':
                    $contenido_csv[] = array(
                        "Emision",
                        "Vigencia",
                        "Póliza",
                        "Deudor",
                        "RNC/Cédula",
                        "Marca",
                        "Modelo",
                        "Tipo",
                        "Año",
                        "Chasis",
                        "Valor Aseguradora",
                        "Prima",
                        "Comisión",
                        "Aseguradora"
                    );
                    break;
            }
            break;
    }

    $prima_sumatoria = 0;
    $valor_sumatoria = 0;
    $comision_sumatoria = 0;
    $num_pag = 1;

    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Quotes");
    $criteria = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

    do {
        $param_map = array("page" => $num_pag, "per_page" => 200);

        try {
            $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
            $records = $response->getData();
            $num_pag++;

            foreach ($records as $record) {

                $planes = $record->getLineItems();

                foreach ($planes as $plan) {

                    if (
                        $plan->getNetTotal() > 0
                        and
                        date("Y-m-d", strtotime($record->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"]
                        and
                        date("Y-m-d", strtotime($record->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"]
                        and
                        empty($_POST["contrato_id"])
                        or
                        $_POST["contrato_id"] == $plan->getDescription()
                    ) {

                        switch ($_POST["tipo_cotizacion"]) {

                            case 'auto':

                                if (
                                    $_POST["estado_cotizacion"] == "pendientes"
                                    and
                                    $record->getFieldValue('Deal_Name') == null
                                ) {
                                    $plan_detalles = detalles_registro("Products", $plan->getProduct()->getEntityId());
                                    $prima_sumatoria += $plan->getNetTotal();
                                    $valor_sumatoria += $record->getFieldValue('Valor_Asegurado');
                                    $contenido_csv[] = array(
                                        date("Y-m-d", strtotime($record->getFieldValue("Fecha_emisi_n"))),
                                        date("Y-m-d", strtotime($record->getFieldValue("Valid_Till"))),
                                        $record->getFieldValue('Nombre'),
                                        $record->getFieldValue('RNC_C_dula'),
                                        $record->getFieldValue('Marca')->getLookupLabel(),
                                        $record->getFieldValue('Modelo')->getLookupLabel(),
                                        $record->getFieldValue('Tipo_Veh_culo'),
                                        $record->getFieldValue('A_o_Fabricaci_n'),
                                        number_format($record->getFieldValue('Valor_Asegurado'), 2),
                                        number_format($plan->getNetTotal(), 2),
                                        $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel()
                                    );
                                } elseif (
                                    $_POST["estado_cotizacion"] == "emitidas"
                                    and
                                    $record->getFieldValue('Deal_Name') != null
                                ) {
                                    $trato = detalles_registro("Deals", $record->getFieldValue('Deal_Name')->getEntityId());
                                    $prima_sumatoria += $plan->getNetTotal();
                                    $valor_sumatoria += $record->getFieldValue('Valor_Asegurado');
                                    $comision_sumatoria += $trato->getFieldValue('Comisi_n_Socio');
                                    $contenido_csv[] = array(
                                        date("Y-m-d", strtotime($record->getFieldValue("Fecha_emisi_n"))),
                                        date("Y-m-d", strtotime($record->getFieldValue("Valid_Till"))),
                                        $trato->getFieldValue('P_liza')->getLookupLabel(),
                                        $trato->getFieldValue('Contact_Name')->getLookupLabel(),
                                        $record->getFieldValue('RNC_C_dula'),
                                        $record->getFieldValue('Marca')->getLookupLabel(),
                                        $record->getFieldValue('Modelo')->getLookupLabel(),
                                        $record->getFieldValue('Tipo_Veh_culo'),
                                        $record->getFieldValue('A_o_Fabricaci_n'),
                                        $trato->getFieldValue('Bien')->getLookupLabel(),
                                        number_format($record->getFieldValue('Valor_Asegurado'), 2),
                                        number_format($plan->getNetTotal(), 2),
                                        number_format($trato->getFieldValue('Comisi_n_Socio'), 2),
                                        $record->getFieldValue('Aseguradora')->getLookupLabel()
                                    );
                                }

                                break;
                        }
                    }
                }
            }
        } catch (ZCRMException $ex) {
            // echo $ex->getMessage();
            // echo "<br>";
            // echo $ex->getExceptionCode();
            // echo "<br>";
            // echo $ex->getFile();
            // echo "<br>";

            $num_pag = 0;
        }
    } while ($num_pag > 1);

    $contenido_csv[] = array("");
    $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2));
    $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2));
    if ($_POST["estado_cotizacion"] == "emitidas") {
        $contenido_csv[] = array("Total Comisiones:", number_format($comision_sumatoria, 2));
    }

    if ($valor_sumatoria > 0) {
        if (!is_dir("public/path")) {
            mkdir("public/path", 0755, true);
        }

        $ruta_csv = "public/path/" . $titulo . ".csv";
        $fp = fopen($ruta_csv, 'w');
        foreach ($contenido_csv as $campos) {
            fputcsv($fp, $campos);
        }
        fclose($fp);

        $fileName = basename($ruta_csv);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: ');
        header('Content-Length: ' . filesize($ruta_csv));
        readfile($ruta_csv);
        unlink($ruta_csv);
        exit();
    } else {
        header("Location:" . constant("url") . "?page=reportes&alert=No se encontraton resultados");
    }
}

function lista_registros($modulo)
{
    $records = array();
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
    $param_map = array("page" => 1, "per_page" => 200);

    try {
        $response = $moduleIns->getRecords($param_map);
        $records = $response->getData();
    } catch (ZCRMException $ex) {
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }

    return $records;
}

function lista_contratos($tipo)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Contratos");
    $criteria = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:$tipo))";
    $param_map = array("page" => 1, "per_page" => 200);
    $records = array();

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();
    } catch (ZCRMException $ex) {
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }

    return $records;
}

function seleccionar_plan($aseguradora_id)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Products");
    $criteria = "Vendor_Name:equals:" . $aseguradora_id;
    $param_map = array("page" => 1, "per_page" => 200);
    $plan = null;

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();

        foreach ($records as $record) {
            if ($record->getFieldValue('Product_Category') == $_POST["tipo_plan"]) {
                $plan = $record;
            }
        }
    } catch (ZCRMException $ex) {
        // echo $ex->getMessage();
        // echo "<br>";
        // echo $ex->getExceptionCode();
        // echo "<br>";
        // echo $ex->getFile();
        // echo "<br>";
    }

    return $plan;
}

function lista_adjuntos($modulo, $id)
{
    $attachments = array();
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $param_map = array("page" => 1, "per_page" => 200);

    try {
        $responseIns = $record->getAttachments($param_map);
        $attachments = $responseIns->getData();
    } catch (ZCRMException $ex) {
        //echo $ex->getMessage();
        //echo "<br>";
        //echo $ex->getExceptionCode();
        //echo "<br>";
        //echo $ex->getFile();
        //echo "<br>";
    }

    return $attachments;
}

function descargar_adjunto($modulo, $id, $id_adjunto)
{
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $fileResponseIns = $record->downloadAttachment($id_adjunto);

    $filePath = "public/path";
    if (!is_dir($filePath)) {
        mkdir($filePath, 0755, true);
    }

    $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");

    // echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
    // echo "<br>";
    // echo "File Name:" . $fileResponseIns->getFileName();
    // echo "<br>";

    $stream = $fileResponseIns->getFileContent();
    fputs($fp, $stream);
    fclose($fp);

    return $filePath . "/" . $fileResponseIns->getFileName();
}

function descargar_adjunto_contrato()
{
    $documento = descargar_adjunto("Contratos", $_GET["contract_id"], $_GET["attachment_id"]);
    $fileName = basename($documento);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: ');
    header('Content-Length: ' . filesize($documento));
    readfile($documento);
    unlink($documento);
    exit();
}

function obtener_imagen_registro($modulo, $id)
{
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $fileResponseIns = $record->downloadPhoto();

    // echo "HTTP Status Code:" . $fileResponseIns->getHttpStatusCode();
    // echo "<br>";
    // echo "File Name:" . $fileResponseIns->getFileName();
    // echo "<br>";

    $filePath = "public/path";
    if (!is_dir($filePath)) {
        mkdir($filePath, 0755, true);
    }

    $fp = fopen($filePath . "/" . $fileResponseIns->getFileName(), "w");
    $stream = $fileResponseIns->getFileContent();
    fputs($fp, $stream);
    fclose($fp);

    return $filePath . "/" . $fileResponseIns->getFileName();
}

function adjuntar_registro($modulo, $id, $ruta)
{
    $record = ZCRMRestClient::getInstance()->getRecordInstance($modulo, $id);
    $responseIns = $record->uploadAttachment($ruta);
    // echo "HTTP Status Code:" . $responseIns->getHttpStatusCode();
    // echo "<br>";
    // echo "Status:" . $responseIns->getStatus();
    // echo "<br>";
    // echo "Message:" . $responseIns->getMessage();
    // echo "<br>";
    // echo "Code:" . $responseIns->getCode();
    // echo "<br>";
    // echo "Details:" . $responseIns->getDetails()['id'];
    // echo "<br>";
}

function crear_registro($modulo, $registro)
{
    $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance($modulo);
    $records = array();
    $record = ZCRMRecord::getInstance($modulo, null);

    foreach ($registro as $campo => $valor) {
        $record->setFieldValue($campo, $valor);
    }

    array_push($records, $record);
    $responseIn = $moduleIns->createRecords($records);
    foreach ($responseIn->getEntityResponses() as $responseIns) {
        // echo "HTTP Status Code:" . $responseIn->getHttpStatusCode();
        // echo "<br>";
        // echo "Status:" . $responseIns->getStatus();
        // echo "<br>";
        // echo "Message:" . $responseIns->getMessage();
        // echo "<br>";
        // echo "Code:" . $responseIns->getCode();
        // echo "<br>";
        // echo "Details:" . json_encode($responseIns->getDetails());
        // echo "<br>";
        $details = json_decode(json_encode($responseIns->getDetails()), true);
    }

    return $details["id"];
}

function adjuntar_trato($cotizacion)
{
    $ruta = "public/path";
    if (!is_dir($ruta)) {
        mkdir($ruta, 0755, true);
    }

    foreach ($_FILES["documentos"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
            $name = basename($_FILES["documentos"]["name"][$key]);
            move_uploaded_file($tmp_name, "$ruta/$name");
            adjuntar_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId(), "$ruta/$name");
            unlink("$ruta/$name");
        }
    }

    header("Location:" . constant('url') . "?page=adjuntar&id=".$cotizacion->getEntityId()."&alert=Documentos Adjuntados");
    exit();
}

function calcular_edad($fecha)
{
    list ($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}