<?php

class portal extends api
{

    function __construct()
    {
        parent::__construct();
    }

    public function resumen()
    {
        $resultado["total"] = 0;
        $resultado["pendientes"] = 0;
        $resultado["emisiones"] = 0;
        $resultado["vencimientos"] = 0;
        $emitida = array("Emitido", "En trámite");
        $pagina = 1;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        do {
            $cotizaciones = $this->searchRecordsByCriteria("Deals", $criterio, $pagina, 200);
            if ($cotizaciones) {
                $pagina++;
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
            } else {
                $pagina = 0;
            }
        } while ($pagina > 0);
        return $resultado;
    }

    public function obtener_url()
    {
        $resultado = array();
        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);
        foreach ($url as $campo => $valor) {
            if ($campo >= 2) {
                $resultado[] = $valor;
            }
        }
        return $resultado;
    }
}
