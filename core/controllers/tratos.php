<?php
class tratos
{
    public function buscar()
    {
        $api = new api;

        $url = obtener_url();
        $filtro = (isset($url[0])) ? $url[0] : null;
        $num_pagina = (isset($url[1])) ? $url[1] : 1;

        if ($_POST) {
            $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
            $cotizaciones = $api->buscar_criterio("Deals", $criterio, $num_pagina, 15);
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $cotizaciones = $api->buscar_criterio("Deals", $criterio, $num_pagina, 15);
        }

        require_once "core/views/layout/header_main.php";
        require_once "core/views/tratos/buscar.php";
        require_once "core/views/layout/footer_main.php";
    }

    public function detalles_auto()
    {

        require_once "core/views/layout/header_main.php";
        require_once "core/views/tratos/detalles_auto.php";
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
        require_once "core/views/tratos/adjuntar.php";
        require_once "core/views/layout/footer_main.php";
    }

    public function descargar_autp()
    {
        # code...
    }
}
