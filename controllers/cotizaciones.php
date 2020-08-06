<?php

class cotizaciones
{
    public function inicio()
    {
        $api = new api;

        $cotizaciones_total = 0;
        $cotizaciones_pendientes = 0;
        $cotizaciones_emitidas = 0;
        $cotizaciones_vencidas = 0;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

        $num_pagina = 1;
        do {
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 200);
            if (!empty($cotizaciones)) {
                $num_pagina++;

                foreach ($cotizaciones as $cotizacion) {
                    $cotizaciones_total += 1;

                    if ($cotizacion->getFieldValue("Deal_Name") == null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                        $cotizaciones_pendientes += 1;
                    }

                    if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                        $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                        $cotizaciones_emitidas += 1;
                        $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue("P_liza")->getEntityId());
                        $aseguradoras[] = $poliza->getFieldValue('Aseguradora')->getLookupLabel();
                    }

                    if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m')) {
                        $cotizaciones_vencidas += 1;
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/index.php";
        require_once "views/layout/footer_main.php";
    }

    public function buscar()
    {
        $api = new api;
        $url = obtener_url();
        $filtro = (isset($url[0])) ? $url[0] : "todos";
        $num_pagina = (isset($url[1])) ? $url[1] : 1;

        if ($_POST) {
            $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 15);
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 15);
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/buscar.php";
        require_once "views/layout/footer_main.php";
    }

    public function crear()
    {
        $api = new api;
        $url = obtener_url();

        if ($_POST) {
            switch ($url[0]) {
                case 'auto':
                    crear_cotizacion_auto($api);
                    break;

                case 'vida':
                    crear_cotizacion_vida($api);
                    break;

                case 'desempleo':
                    crear_cotizacion_desempleo($api);
                    break;

                case 'auto':
                    crear_cotizacion_incendio($api);
                    break;
            }
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/crear.php";
        require_once "views/layout/footer_main.php";
    }

    public function detalles()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[1]) and !is_numeric($url[1])) ? $url[1] : null;
        $num_pagina = (isset($url[1]) and is_numeric($url[1])) ? $url[1] : 1;

        if (!isset($url[0])) {
            require_once "views/error.php";
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/detalles.php";
        require_once "views/layout/footer_main.php";
    }

    public function extracto_auto()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            require_once "views/error.php";
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
        $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue('P_liza')->getEntityId());
        $imagen_aseguradora = $api->obtener_imagen("Vendors", $poliza->getFieldValue('Aseguradora')->getEntityId(), "public/img");

        require_once "views/cotizaciones/extracto.php";
    }

    public function reporte()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[0])) ? $url[0] : null;

        if (isset($_POST["csv"])) {
            switch ($_POST["estado_cotizacion"]) {
                case 'pendientes':
                    $alerta = reporte_pendientes($api);
                    break;

                case 'emitidos':
                    $alerta = reporte_emitidos($api);
                    break;
            }
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/reporte.php";
        require_once "views/layout/footer_main.php";
    }

    public function descargar()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            require_once "views/error.php";
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        if ($cotizacion->getFieldValue("Deal_Name") != null) {
            $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());

            $coberturas = $api->detalles_registro("Contratos", $trato->getFieldValue('Contrato')->getEntityId());
            $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue('P_liza')->getEntityId());
            $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());
            $cliente = $api->detalles_registro("Contacts", $trato->getFieldValue('Contact_Name')->getEntityId());
            $aseguradora = $api->detalles_registro("Vendors", $poliza->getFieldValue('Aseguradora')->getEntityId());
            $imagen_aseguradora = $api->obtener_imagen("Vendors", $aseguradora->getEntityId(), "public/img");
        }

        require_once "views/cotizaciones/descargar.php";
    }

    public function emitir()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[0])) {
            require_once "views/error.php";
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        if (!empty($_FILES["cotizacion_firmada"]["name"])) {
            $alerta = emitir_auto($cotizacion, $api);
        }

        if (!empty($_FILES["documentos"]['name'][0])) {
            adjuntar_documentos_cotizacion($id, $cotizacion->getFieldValue("Deal_Name")->getEntityId(), $api);
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/emitir.php";
        require_once "views/layout/footer_main.php";
    }
}
