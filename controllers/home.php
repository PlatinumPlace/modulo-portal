<?php

class home
{
    public function error()
    {
        require_once "views/error.php";
    }

    public function index()
    {
        $api = new api;

        $cotizaciones_total = 0;
        $cotizaciones_pendientes = 0;
        $tratos_emitidos = 0;
        $tratos_venciendo = 0;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

        $num_pagina = 1;
        do {
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 200);
            if (!empty($cotizaciones)) {
                $num_pagina++;

                foreach ($cotizaciones as $cotizacion) {
                    $cotizaciones_total += 1;

                    if (
                        date('Y-m') >= date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))
                        and
                        date('Y-m') <= date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till")))
                        and
                        $cotizacion->getFieldValue("Deal_Name") == null
                    ) {
                        $cotizaciones_pendientes += 1;
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);


        $num_pagina = 1;
        do {
            $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 200);
            if (!empty($tratos)) {
                $num_pagina++;

                foreach ($tratos as $trato) {
                    if ($trato->getFieldValue('Stage') != "Cotizando") {
                        if (date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                            $tratos_emitidos += 1;
                            $aseguradoras[] = $trato->getFieldValue('Aseguradora')->getLookupLabel();
                        }

                        if (date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')) {
                            $tratos_venciendo += 1;
                        }
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);

        require_once "views/layout/header_main.php";
        require_once "views/index.php";
        require_once "views/layout/footer_main.php";
    }
}
