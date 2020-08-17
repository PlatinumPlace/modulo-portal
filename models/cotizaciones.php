<?php

class cotizaciones extends api {

    function resumen() {
        $result["cotizaciones_total"] = 0;
        $result["cotizaciones_pendientes"] = 0;
        $result["cotizaciones_emitidas"] = 0;
        $result["cotizaciones_vencidas"] = 0;
        $result["aseguradoras"] = array();

        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $num_pagina = 1;

        do {
            $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio, $num_pagina);
            if (!empty($cotizaciones)) {
                $num_pagina++;
                foreach ($cotizaciones as $cotizacion) {
                    $result["cotizaciones_total"] += 1;

                    if ($cotizacion->getFieldValue("Deal_Name") == null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                        $result["cotizaciones_pendientes"] += 1;
                    }

                    if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                        $result["cotizaciones_emitidas"] += 1;
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            $result["aseguradoras"][] = $plan->getDescription();
                        }
                    }

                    if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m')) {
                        $result["cotizaciones_vencidas"] += 1;
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);

        return $result;
    }

    function buscar($filtro, $num_pagina) {
        if ($_POST) {
            $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        }

        $result = $this->searchRecordsByCriteria("Quotes", $criterio, $num_pagina, 10);
        foreach ($result as $cotizacion) {
            if (empty($filtro) or $filtro == "todos" or ($filtro == "emisiones_mensuales" and $cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date("Y-m")) or ($filtro == "vencimientos_mensuales" and $cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date("Y-m"))) {

                if ($cotizacion->getFieldValue("Deal_Name") != null) {
                    echo '<tr class="table-success">';
                } elseif ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date("Y-m")) {
                    echo '<tr class="table-danger">';
                }

                echo "<td>" . $cotizacion->getFieldValue('Quote_Number') . "</td>";
                echo "<td>" . date("d-m-Y", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</td>";
                echo "<td>" . $cotizacion->getFieldValue('RNC_C_dula') . "</td>";
                echo "<td>" . $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') . "</td>";
                echo "<td>RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                echo "<td>" . $cotizacion->getFieldValue('Subject') . "</td>";
                echo "<td>";
                echo '<a href="' . constant("url") . 'detalles/' . $cotizacion->getEntityId() . '" title="Detalles"><i class="fas fa-info-circle"></i></a>';
                echo "&nbsp;";
                if ($cotizacion->getFieldValue("Deal_Name") == null) {
                    echo '<a href="' . constant("url") . 'emitir/' . $cotizacion->getEntityId() . '" title="Emitir"><i class="fas fa-user"></i></i></a>';
                } else {
                    echo '<a href="' . constant("url") . 'adjuntar/' . $cotizacion->getEntityId() . '" title="Adjuntar"><i class="fas fa-file-upload"></i></i></a>';
                }
                echo "&nbsp;";
                echo '<a href="' . constant("url") . 'descargar/' . $cotizacion->getEntityId() . '" title="Descargar"><i class="fas fa-file-download"></i></a>';
                echo "</td>";
                echo "</tr>";
            }
        }
    }

    function exportar_csv() {
        $titulo = "Reporte " . ucfirst($_POST["estado_cotizacion"]) . " " . $_POST["tipo_cotizacion"];
        $contenido_csv = array(
            array(
                $_SESSION["usuario"]['empresa_nombre']
            ),
            array(
                $titulo
            ),
            array(
                "Desde:",
                $_POST["desde"],
                "Hasta:",
                $_POST["hasta"]
            ),
            array(
                "Vendedor:",
                $_SESSION["usuario"]['nombre']
            ),
            array(
                ""
            )
        );

        switch ($_POST["tipo_cotizacion"]) {
            case 'Auto':
                switch ($_POST["estado_cotizacion"]) {
                    case 'pendientes':
                        $contenido_csv[] = array(
                            "Emision",
                            "Vigencia",
                            "Deudor",
                            "RNC/Cédula",
                            "Marca",
                            "Modelo",
                            "Tipo",
                            "Año",
                            "Valor Aseguradora",
                            "Prima",
                            "Aseguradora"
                        );
                        break;

                    case 'emitidas':
                        $contenido_csv[] = array(
                            "Emision",
                            "Vigencia",
                            "Póliza",
                            "Deudor",
                            "RNC/Cédula",
                            "Marca",
                            "Modelo",
                            "Tipo",
                            "Año",
                            "Chasis",
                            "Valor Aseguradora",
                            "Prima",
                            "Comisión",
                            "Aseguradora"
                        );
                        break;
                }
                break;
        }

        $prima_sumatoria = 0;
        $valor_sumatoria = 0;
        $comision_sumatoria = 0;
        $num_pag = 1;

        do {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio, $num_pag);
            if (!empty($cotizaciones)) {
                $num_pag++;
                foreach ($cotizaciones as $cotizacion) {
                    switch ($_POST["estado_cotizacion"]) {
                        case 'pendientes':
                            if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') == null) {
                                $planes = $cotizacion->getLineItems();
                                foreach ($planes as $plan) {
                                    if ($plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
                                        switch ($_POST["tipo_cotizacion"]) {
                                            case 'Auto':
                                                $prima_sumatoria += $plan->getNetTotal();
                                                $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');

                                                $contenido_csv[] = array(
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))),
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                                    $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido'),
                                                    $cotizacion->getFieldValue('RNC_C_dula'),
                                                    $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Tipo_Veh_culo'),
                                                    $cotizacion->getFieldValue('A_o_Fabricaci_n'),
                                                    number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                                    number_format($plan->getNetTotal(), 2),
                                                    $plan->getDescription()
                                                );
                                                break;
                                        }
                                    }
                                }
                            }
                            break;

                        case 'emitidas':
                            if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') != null) {
                                $planes = $cotizacion->getLineItems();
                                foreach ($planes as $plan) {
                                    if ($plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
                                        switch ($_POST["tipo_cotizacion"]) {
                                            case 'Auto':
                                                $trato = $this->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')
                                                                ->getEntityId());
                                                $prima_sumatoria += $plan->getNetTotal();
                                                $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');
                                                $comision_sumatoria += $trato->getFieldValue('Comisi_n_Socio');

                                                $contenido_csv[] = array(
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))),
                                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                                    $trato->getFieldValue('P_liza')->getLookupLabel(),
                                                    $trato->getFieldValue('Contact_Name')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('RNC_C_dula'),
                                                    $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                                    $cotizacion->getFieldValue('Tipo_Veh_culo'),
                                                    $cotizacion->getFieldValue('A_o_Fabricaci_n'),
                                                    $trato->getFieldValue('Bien')->getLookupLabel(),
                                                    number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                                    number_format($plan->getNetTotal(), 2),
                                                    number_format($trato->getFieldValue('Comisi_n_Socio'), 2),
                                                    $plan->getDescription()
                                                );
                                                break;
                                        }
                                    }
                                }
                            }
                            break;
                    }
                }
            } else {
                $num_pag = 0;
            }
        } while ($num_pag > 0);

        $contenido_csv[] = array(
            ""
        );
        $contenido_csv[] = array(
            "Total Primas:",
            number_format($prima_sumatoria, 2)
        );
        $contenido_csv[] = array(
            "Total Valores:",
            number_format($valor_sumatoria, 2)
        );
        if ($_POST["estado_cotizacion"] == "emitidas") {
            $contenido_csv[] = array(
                "Total Comisiones:",
                number_format($comision_sumatoria, 2)
            );
        }

        if ($valor_sumatoria > 0) {
            if (!is_dir("public/path")) {
                mkdir("public/path", 0755, true);
            }

            $ruta_csv = "public/path/" . $titulo . ".csv";
            $fp = fopen($ruta_csv, 'w');
            foreach ($contenido_csv as $campos) {
                fputcsv($fp, $campos);
            }
            fclose($fp);

            $fileName = basename($ruta_csv);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: ');
            header('Content-Length: ' . filesize($ruta_csv));
            readfile($ruta_csv);
            unlink($ruta_csv);
            exit();
        } else {
            return 'No se encontraton resultados';
        }
    }

    function exportar_pdf() {
        $result["prima_sumatoria"] = 0;
        $result["valor_sumatoria"] = 0;
        $result["comision_sumatoria"] = 0;
        $num_pag = 1;
        do {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio, $num_pag);
            if (!empty($cotizaciones)) {
                $num_pag++;
                foreach ($cotizaciones as $cotizacion) {
                    switch ($_POST["estado_cotizacion"]) {
                        case 'pendientes':
                            $planes = $cotizacion->getLineItems();
                            foreach ($planes as $plan) {
                                if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') == null and $plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
                                    switch ($_POST["tipo_cotizacion"]) {
                                        case 'Auto':
                                            $result["prima_sumatoria"] += $plan->getNetTotal();
                                            $result["valor_sumatoria"] += $cotizacion->getFieldValue('Valor_Asegurado');

                                            echo "<tr>";
                                            echo '<th scope="col">' . date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('Marca')->getLookupLabel() . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('Modelo')->getLookupLabel() . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('Tipo_Veh_culo') . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('A_o_Fabricaci_n') . "</th>";
                                            echo "<td>" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                            echo "<td>" . number_format($plan->getNetTotal(), 2) . "</th>";
                                            echo "<td>" . $plan->getDescription() . "</th>";
                                            echo "</tr>";
                                            break;
                                    }
                                }
                            }
                            break;

                        case 'emitidas':
                            $planes = $cotizacion->getLineItems();
                            foreach ($planes as $plan) {
                                if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') != null and $plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
                                    switch ($_POST["tipo_cotizacion"]) {
                                        case 'Auto':
                                            $trato = $this->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')
                                                            ->getEntityId());
                                            $result["prima_sumatoria"] += $plan->getNetTotal();
                                            $result["valor_sumatoria"] += $cotizacion->getFieldValue('Valor_Asegurado');
                                            $result["comision_sumatoria"] += $trato->getFieldValue('Comisi_n_Socio');

                                            echo "<tr>";
                                            echo '<th scope="col">' . date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</th>";
                                            echo "<td>" . $trato->getFieldValue('Contact_Name')->getLookupLabel() . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('Marca')->getLookupLabel() . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('Modelo')->getLookupLabel() . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('Tipo_Veh_culo') . "</th>";
                                            echo "<td>" . $cotizacion->getFieldValue('A_o_Fabricaci_n') . "</th>";
                                            echo "<td>" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                            echo "<td>" . number_format($plan->getNetTotal(), 2) . "</th>";
                                            echo "<td>" . number_format($trato->getFieldValue('Comisi_n_Socio'), 2) . "</th>";
                                            echo "<td>" . $plan->getDescription() . "</th>";
                                            echo "</tr>";
                                            break;
                                    }
                                }
                            }
                            break;
                    }
                }
            } else {
                $num_pag = 0;
            }
        } while ($num_pag > 0);

        if (empty($result["valor_sumatoria"])) {
            header("Location:" . constant("url") . "reportes/No existen resultados.");
            exit();
        }

        return $result;
    }

    function dispobible_crear() {
        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);
        $result = array();

        foreach ($contratos as $contrato) {
            if ($contrato->getFieldValue('Tipo') == "Auto") {
                $result["auto"] = true;
            } elseif ($contrato->getFieldValue('Tipo') == "Vida") {
                $result["vida"] = true;
            } elseif ($contrato->getFieldValue('Tipo') == "Incendio") {
                $result["incendio"] = true;
            }
        }

        return $result;
    }

}
