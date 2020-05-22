<?php

class HomeController
{

    public function index()
    {

        $usuario = json_decode($_COOKIE["usuario"], true);
        $api = new api;

        $criterio = "Contact_Name:equals:" . $usuario['id'];
        $cotizaciones = $api->searchRecordsByCriteria("Deals", $criterio);

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

        require_once("core/views/template/header.php");
        require_once("core/views/home/index.php");
        require_once("core/views/template/footer.php");
    }

    public function error()
    {
        require_once("core/views/template/header.php");
        require_once("core/views/home/error.php");
        require_once("core/views/template/footer.php");
    }

    public function redirect($peticion = null)
    {
        if (empty($peticion)) {
            $this->error();
            exit;
        } else {
            $url = explode('-', $peticion);
            $controlador = $url[0];
            $funcion = $url[1];
            $datos = $url[2];
        }

        require_once("core/views/template/header.php");
        require_once("core/views/home/reedirigir.php");
        require_once("core/views/template/footer.php");
    }
}
