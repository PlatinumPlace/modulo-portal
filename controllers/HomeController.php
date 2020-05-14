<?php

class HomeController
{

    public function index()
    {
        $zoho_api = new zoho_api;

        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        $cotizaciones = $zoho_api->searchRecordsByCriteria("Deals", $criterio);

        $resultado["total"] = 0;
        $resultado["pendientes"] = 0;
        $resultado["emisiones"] = 0;
        $resultado["vencimientos"] = 0;
        $emitida = array("Emitido", "En trámite");

        if ($cotizaciones) {
            foreach ($cotizaciones as $cotizacion) {

                if ($cotizacion->getFieldValue("Stage") != "Abandonado") {
                    $resultado["total"] += 1;
                }

                if ($cotizacion->getFieldValue("Stage") == "Cotizando") {
                    $resultado["pendientes"] += 1;
                }

                if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

                    if (date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                        $resultado["emisiones"] += 1;
                        $resultado["aseguradoras"][] = $cotizacion->getFieldValue('Aseguradora')->getLookupLabel();
                    }

                    if (date("Y-m", strtotime($cotizacion->getFieldValue("Closing_Date"))) == date('Y-m')) {
                        $resultado["vencimientos"] += 1;
                    }
                }
            }
        }

        $aseguradoras =  array_count_values($resultado["aseguradoras"]);

        require_once("views/template/header.php");
        require_once("views/home/index.php");
        require_once("views/template/footer.php");
    }

    public function error()
    {
        require_once("views/template/header.php");
        require_once("views/home/error.php");
        require_once("views/template/footer.php");
    }

    public function cargando($nueva_url)
    {
        $url = explode("-", $nueva_url);
        $controlador = $url[0];
        $funcion = $url[1];
        $id = $url[2];

        require_once("views/template/header.php");
        require_once("views/home/cargando.php");
        require_once("views/template/footer.php");
    }
}
