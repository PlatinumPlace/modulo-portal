<?php

$api = new api;
$portal = new portal;

$url = $portal->obtener_url();
$oferta_id = $url[0];
$alerta  = (isset($url[1])) ? $url[1] : "";

$oferta = $api->getRecord("Deals", $oferta_id);
$criterio = "Deal_Name:equals:$oferta_id";
$cotizaciones =  $api->searchRecordsByCriteria("Quotes", $criterio, 1, 200);

if (
    empty($oferta)
    or
    empty($cotizaciones)
    or
    $oferta->getFieldValue("Stage") == "Abandonada"
    or
    $oferta->getFieldValue("Email") != null
) {
    header("Location:" . constant("url") . "cotizaciones/error");
    exit();
}

if ($_POST) {

    $cambios["Chasis"] = $_POST["Chasis"];
    $cambios["Color"] = $_POST["Color"];
    $cambios["Placa"] = $_POST["Placa"];

    if (!empty($_POST["mis_clientes"])) {

        $cliente_info = $api->getRecord("Contacts", $_POST["mis_clientes"]);

        $cambios["Direcci_n"] = $cliente_info->getFieldValue("Mailing_Street");
        $cambios["Nombre"] = $cliente_info->getFieldValue("First_Name");
        $cambios["Apellido"] = $cliente_info->getFieldValue("Last_Name");
        $cambios["RNC_Cedula"] = $cliente_info->getFieldValue("RNC_C_dula");
        $cambios["Telefono"] = $cliente_info->getFieldValue("Phone");
        $cambios["Tel_Residencia"] = $cliente_info->getFieldValue("Home_Phone");
        $cambios["Tel_Trabajo"] = $cliente_info->getFieldValue("Tel_Trabajo");
        $cambios["Fecha_de_Nacimiento"] = $cliente_info->getFieldValue("Date_of_Birth");
        $cambios["Email"] = $cliente_info->getFieldValue("Email");
    } else {
        $cambios["Direcci_n"] = $_POST["Direcci_n"];
        $cambios["Nombre"] = $_POST["Nombre"];
        $cambios["Apellido"] = $_POST["Apellido"];
        $cambios["RNC_Cedula"] = $_POST["RNC_Cedula"];
        $cambios["Telefono"] = (isset($_POST["Telefono"])) ? $_POST["Telefono"] : null;
        $cambios["Tel_Residencia"] = (isset($_POST["Tel_Residencia"])) ? $_POST["Tel_Residencia"] : null;
        $cambios["Tel_Trabajo"] = (isset($_POST["Tel_Trabajo"])) ? $_POST["Tel_Trabajo"] : null;
        $cambios["Fecha_de_Nacimiento"] = $_POST["Fecha_de_Nacimiento"];
        $cambios["Email"] = $_POST["Email"];
    }

    if (
        empty($cambios["RNC_Cedula"])
        or
        empty($cambios["Nombre"])
        or
        empty($cambios["Apellido"])
        or
        empty($cambios["Email"])
        or
        empty($cambios["Fecha_de_Nacimiento"])
    ) {
        $alerta = "Debes completar almenos el <b>nombre,RNC/Cedula,Email y fecha de nacimiento</b> para agregar un cliente.";
    } else {
        $api->updateRecord("Deals", $oferta_id, $cambios);

        $alerta = "Cliente agregado";
        header("Location:" . constant("url") . "auto/detalles/$oferta_id/$alerta");
        exit;
    }
}

require_once("pages/template/header_auto.php");
require_once("pages/auto/completar_vista.php");
