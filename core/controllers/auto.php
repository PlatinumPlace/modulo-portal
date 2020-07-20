<?php
class auto
{
    public function detalles()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $num_pagina = (isset($url[1]) and is_numeric($url[1])) ? $url[1] : 1;
        $alerta = (isset($url[1]) and !is_numeric($url[1])) ? $url[1] : null;
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $home = new home;
            $home->error();
            exit();
        }

        require_once "core/views/layout/header_main.php";
        require_once "core/views/auto/index.php";
        require_once "core/views/layout/footer_main.php";
    }

    public function adjuntar()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $home = new home;
            $home->error();
            exit();
        }

        if (!empty($_FILES["documentos"]['name'][0])) {
            $ruta = "public/tmp";
            if (!is_dir($ruta)) {
                mkdir($ruta, 0755, true);
            }

            foreach ($_FILES["documentos"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                    $name = basename($_FILES["documentos"]["name"][$key]);
                    move_uploaded_file($tmp_name, "$ruta/$name");
                    $api->adjuntar_archivo("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId(), "$ruta/$name");
                    unlink("$ruta/$name");
                }
            }

            header("Location:" . constant("url") . "auto/detalles/" . $id . "/Documentos Adjuntados.");
            exit();
        }


        require_once "core/views/layout/header_main.php";
        require_once "core/views/auto/adjuntar.php";
        require_once "core/views/layout/footer_main.php";
    }

    public function descargar()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $home = new home;
            $home->error();
            exit();
        }

        require_once "core/views/auto/descargar.php";
    }

    public function emitir()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $alerta = (isset($url[1]) and !is_numeric($url[1])) ? $url[1] : null;
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $home = new home;
            $home->error();
            exit();
        }

        require_once "core/views/layout/header_main.php";
        require_once "core/views/auto/emitir.php";
        require_once "core/views/layout/footer_main.php";
    }
}
