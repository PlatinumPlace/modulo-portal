<?php

$api = new api;

$total = 0;
$pendientes = 0;
$emisiones = 0;
$vencimientos = 0;
$emitida = array("Emitido", "En trámite");

$pagina = 1;
$criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

do {

    $cotizaciones = $api->searchRecordsByCriteria("Deals", $criterio, $pagina, 200);

    if ($cotizaciones) {

        $pagina++;

        foreach ($cotizaciones as $cotizacion) {

            if ($cotizacion->getFieldValue("Stage") != "Abandonado") {
                $total += 1;
            }

            if ($cotizacion->getFieldValue("Stage") == "Cotizando") {
                $pendientes += 1;
            }

            if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

                if (date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                    $emisiones += 1;
                    $aseguradoras[] = $cotizacion->getFieldValue('Aseguradora')->getLookupLabel();
                }

                if (date("Y-m", strtotime($cotizacion->getFieldValue("Closing_Date"))) == date('Y-m')) {
                    $vencimientos += 1;
                }
            }
        }
    } else {
        $pagina = 0;
    }
} while ($pagina > 0);

if (!empty($aseguradoras)) {
    $aseguradoras =  array_count_values($aseguradoras);
}

require_once("pages/portal/pagina_principal_vista.php");
