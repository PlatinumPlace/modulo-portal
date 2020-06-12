<?php

$api = new api;
$portal = new portal;

$url = $portal->obtener_url();
$oferta_id = $url[0];
$alerta  = (isset($url[1])) ? $url[1] : "";

$oferta = $api->getRecord("Deals", $oferta_id);
$criterio = "Deal_Name:equals:$oferta_id";
$cotizaciones =  $api->searchRecordsByCriteria("Quotes", $criterio, 1, 200);

$emitida = array("Emitido", "En trámite");

if (
    empty($oferta)
    or
    empty($cotizaciones)
    or
    $oferta->getFieldValue("Stage") == "Abandonada"
) {
    header("Location:" . constant("url") . "portal/error");
    exit();
}

if ($_POST) {

    $ruta = "public/tmp";
    if (!is_dir($ruta)) {
        mkdir($ruta, 0755, true);
    }

    if (!empty($_FILES["cotizacion_firmada"]["name"])) {

        $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
        $permitido = array("pdf");

        if (in_array($extension, $permitido)) {

            $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
            $name = basename($_FILES["cotizacion_firmada"]["name"]);
            move_uploaded_file($tmp_name, "$ruta/$name");
            $api->uploadAttachment("Deals", $oferta_id, "$ruta/$name");
            unlink("$ruta/$name");
            $cambios["Aseguradora"] = $_POST["aseguradora_id"];
            $cambios["Stage"] = "En trámite";
            $cambios["Deal_Name"] = "Resumen";
            $api->updateRecord("Deals", $oferta_id, $cambios);

            $alerta = "Cotizacion emitida,descargue la previsualizacion para obtener el carnet. ";
        } else {
            $alerta = "Error al cargar documentos, solo se permiten archivos PDF.";
        }
    } else if (!empty($_FILES["documentos"]['name'][0])) {

        foreach ($_FILES["documentos"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                $name = basename($_FILES["documentos"]["name"][$key]);
                move_uploaded_file($tmp_name, "$ruta/$name");
                $api->uploadAttachment("Deals", $oferta_id, "$ruta/$name");
                unlink("$ruta/$name");
            }
        }

        $alerta =  "Documentos adjuntados";
    }

    $nueva_url = array("auto", "detalles", $oferta_id, $alerta);
    header("Location:" . constant("url") . "portal/redirigir/" . json_encode($nueva_url));
    exit;
}

require_once("pages/template/header_auto.php");
require_once("pages/auto/emitir_vista.php");
