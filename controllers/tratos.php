<?php

class tratos
{
    public function buscar()
    {
        $api = new api;

        $url = obtener_url();
        $filtro = (isset($url[0])) ? $url[0] : "todos";
        $num_pagina = (isset($url[1])) ? $url[1] : 1;

        if ($_POST) {
            $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
            $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 15);
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 15);
        }

        require_once "views/layout/header_main.php";
        require_once "views/tratos/buscar.php";
        require_once "views/layout/footer_main.php";
    }

    public function detalles_auto()
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

        $trato = $api->detalles_registro("Deals", $id);
        if (empty($trato)) {
            $home = new home;
            $home->error();
            exit();
        }

        $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue('P_liza')->getEntityId());
        if (empty($poliza)) {
            $home = new home;
            $home->error();
            exit();
        }

        $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());
        if (empty($bien)) {
            $home = new home;
            $home->error();
            exit();
        }

        $cliente = $api->detalles_registro("Clientes", $trato->getFieldValue('Cliente')->getEntityId());
        if (empty($cliente)) {
            $home = new home;
            $home->error();
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/tratos/detalles_auto.php";
        require_once "views/layout/footer_main.php";
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
        $trato = $api->detalles_registro("Deals", $id);

        if (empty($trato)) {
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
                    $api->adjuntar_archivo("Deals", $id, "$ruta/$name");
                    unlink("$ruta/$name");
                }
            }

            header("Location:" . constant("url") . "tratos/detalles_" . strtolower($trato->getFieldValue('Type')) . "/" . $id . "/Documentos Adjuntados.");
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/tratos/adjuntar.php";
        require_once "views/layout/footer_main.php";
    }

    public function descargar_auto()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $trato = $api->detalles_registro("Deals", $id);
        if (empty($trato)) {
            $home = new home;
            $home->error();
            exit();
        }

        $coberturas = $api->detalles_registro("Contratos", $trato->getFieldValue('Contrato')->getEntityId());
        if (empty($coberturas)) {
            $home = new home;
            $home->error();
            exit();
        }

        $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());
        if (empty($bien)) {
            $home = new home;
            $home->error();
            exit();
        }

        $cliente = $api->detalles_registro("Clientes", $trato->getFieldValue('Cliente')->getEntityId());
        if (empty($cliente)) {
            $home = new home;
            $home->error();
            exit();
        }

        $aseguradora = $api->detalles_registro("Vendors", $trato->getFieldValue('Aseguradora')->getEntityId());
        if (empty($aseguradora)) {
            $home = new home;
            $home->error();
            exit();
        }

        $imagen_aseguradora = $api->obtener_imagen("Vendors", $trato->getFieldValue('Aseguradora')->getEntityId(), "public/img");

        require_once "views/tratos/descargar_auto.php";
    }
}
