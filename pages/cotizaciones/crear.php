<?php

$api = new api;

$marcas =  $api->getRecords("Marcas");
sort($marcas);

if (isset($_POST['crear_auto'])) {

    $nueva_cotizacion["Stage"] = "Cotizando";
    $nueva_cotizacion["Type"] = "Auto";
    $nueva_cotizacion["Lead_Source"] = "Portal GNB";
    $nueva_cotizacion["Deal_Name"] = "Cotización";
    $nueva_cotizacion["Contact_Name"] =  $_SESSION["usuario"]['id'];
    $nueva_cotizacion["Tipo_de_poliza"] = $_POST["Tipo_de_poliza"];
    $nueva_cotizacion["Plan"] = $_POST["Plan"];
    $nueva_cotizacion["Marca"] = $_POST["Marca"];
    $nueva_cotizacion["Modelo"] = $_POST["Modelo"];

    $modelo = $api->getRecord("Modelos", $_POST['Modelo']);

    $nueva_cotizacion["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
    $nueva_cotizacion["Valor_Asegurado"] = $_POST["Valor_Asegurado"];
    $nueva_cotizacion["A_o_de_Fabricacion"] = $_POST["A_o_de_Fabricacion"];
    $nueva_cotizacion["Chasis"] = (isset($_POST["Chasis"])) ? $_POST["Chasis"] : null;
    $nueva_cotizacion["Color"] = (isset($_POST["Color"])) ? $_POST["Color"] : null;
    $nueva_cotizacion["Uso"] = (isset($_POST["Uso"])) ? $_POST["Uso"] : null;
    $nueva_cotizacion["Placa"] = (isset($_POST["Placa"])) ? $_POST["Placa"] : null;
    $nueva_cotizacion["Es_nuevo"] = (isset($_POST["Es_nuevo"])) ? true : false;

    $oferta_id = $api->createRecord("Deals", $nueva_cotizacion);

    $nueva_url = array("auto", "detalles", $oferta_id);
    header("Location:" . constant("url") . "portal/redirigir/" . json_encode($nueva_url));
    exit;
}

require_once("pages/cotizaciones/crear_vista.php");
