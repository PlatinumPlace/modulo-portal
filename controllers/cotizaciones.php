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
        $filtro = (isset($url[2])) ? $url[2] : "todos";
        $num_pagina = (isset($url[3])) ? $url[3] : 1;

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
        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/crear.php";
        require_once "views/layout/footer_main.php";
    }

    function reporte()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[2])) ? $url[2] : null;

        if (isset($_POST["csv"])) {
            $titulo = "Reporte " . ucfirst($_POST["tipo"]) . " " . ucfirst($_POST["plan"]);

            $contenido_csv = array(
                array($_SESSION["usuario"]['empresa_nombre']),
                array($titulo),
                array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
                array("Vendedor:", $_SESSION["usuario"]['nombre']),
                array("")
            );

            switch ($_POST["tipo"]) {
                case 'pendientes':

                    if ($_POST["plan"] == "full" or $_POST["plan"] == "ley") {
                        $contenido_csv[] = array(
                            "Emision",
                            "Vigencia",
                            "Marca",
                            "Modelo",
                            "Tipo",
                            "Año",
                            "Uso",
                            "Condicion",
                            "Valor Aseguradora",
                            "Prima",
                            "Aseguradora"
                        );
                    }

                    break;
            }


            $prima_sumatoria = 0;
            $valor_sumatoria = 0;
            $comision_sumatorio = 0;

            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, 1, 200);
            if (!empty($cotizaciones)) {
                foreach ($cotizaciones as $cotizacion) {
                    if (
                        date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  >= $_POST["desde"]
                        and
                        date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  <= $_POST["hasta"]
                        and
                        $cotizacion->getFieldValue("Plan") == ucfirst($_POST["plan"])
                    ) {
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            switch ($_POST["tipo"]) {
                                case 'pendientes':

                                    if ($_POST["plan"] == "full" or $_POST["plan"] == "ley") {
                                        if ($plan->getNetTotal() > 0) {
                                            if (empty($_POST["aseguradora"])) {
                                                $prima_sumatoria += $plan->getNetTotal();
                                                $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');

                                                $contenido_csv[] = array(
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))),
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                                    $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Tipo_Veh_culo'),
                                                    $cotizacion->getFieldValue('A_o_Fabricaci_n'),
                                                    $cotizacion->getFieldValue('Uso_Veh_culo'),
                                                    ($cotizacion->getFieldValue('Veh_culo_Nuevo') == true) ? "Nuevo" : "Usado",
                                                    number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                                    number_format($plan->getNetTotal(), 2),
                                                    $plan->getDescription()
                                                );
                                            } elseif ($_POST["aseguradora"] == $plan->getDescription()) {
                                                $prima_sumatoria += $plan->getNetTotal();
                                                $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');

                                                $contenido_csv[] = array(
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))),
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                                    $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Tipo_Veh_culo'),
                                                    $cotizacion->getFieldValue('A_o_Fabricaci_n'),
                                                    $cotizacion->getFieldValue('Uso_Veh_culo'),
                                                    ($cotizacion->getFieldValue('Veh_culo_Nuevo') == true) ? "Nuevo" : "Usado",
                                                    number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                                    number_format($plan->getNetTotal(), 2),
                                                    $plan->getDescription()
                                                );
                                            }
                                        }
                                    }

                                    break;
                            }
                        }
                    }
                }
            } else {
                $alerta = "No existen resultados";
            }

            $contenido_csv[] = array("");
            $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2));
            $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2));

            $ruta_csv = "public/tmp/" . $titulo . ".csv";

            if (!is_dir("public/tmp")) {
                mkdir("public/tmp", 0755, true);
            }

            if ($valor_sumatoria > 0) {
                $fp = fopen($ruta_csv, 'w');
                foreach ($contenido_csv as $campos) {
                    fputcsv($fp, $campos);
                }
                fclose($fp);
            }

            $fileName = basename($ruta_csv);
            if (!empty($fileName) and file_exists($ruta_csv)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: ');
                header('Content-Length: ' . filesize($ruta_csv));
                readfile($ruta_csv);
                unlink($ruta_csv);
                exit;
            } else {
                $alerta = 'No se encontraton resultados';
            }
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/reporte.php";
        require_once "views/layout/footer_main.php";
    }
}
