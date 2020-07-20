<?php
class home
{
    public function error()
    {
        require_once "core/views/error.php";
    }

    public function index()
    {
        $api = new api;

        $total = 0;
        $pendientes = 0;
        $emisiones = 0;
        $vencimientos = 0;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

        $num_pagina = 1;
        do {
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 200);
            if (!empty($cotizaciones)) {
                $num_pagina++;

                foreach ($cotizaciones as $cotizacion) {
                    $total += 1;

                    if ($cotizacion->getFieldValue("Quote_Stage") == "Negociación") {
                        $pendientes += 1;
                    } elseif ($cotizacion->getFieldValue("Quote_Stage") == "Cerrada ganada") {
                        if (date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                            $emisiones += 1;

                            $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                            $aseguradoras[] = $trato->getFieldValue('Aseguradora')->getLookupLabel();
                        }
                        if (date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m')) {
                            $vencimientos += 1;
                        }
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);

        require_once "core/views/layout/header_main.php";
        require_once "core/views/index.php";
        require_once "core/views/layout/footer_main.php";
    }
}
