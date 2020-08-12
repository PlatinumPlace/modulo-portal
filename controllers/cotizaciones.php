<?php

class cotizaciones
{
    public function index()
    {
        $api = new api;
        $cotizaciones_total = 0;
        $cotizaciones_pendientes = 0;
        $cotizaciones_emitidas = 0;
        $cotizaciones_vencidas = 0;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $num_pagina = 1;

        do {
            $cotizaciones = $api->searchRecordsByCriteria("Quotes", $criterio, $num_pagina);

            if (!empty($cotizaciones)) {
                $num_pagina++;

                foreach ($cotizaciones as $cotizacion) {
                    $cotizaciones_total += 1;

                    if (
                        $cotizacion->getFieldValue("Deal_Name") == null
                        and
                        date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')
                    ) {
                        $cotizaciones_pendientes += 1;
                    }

                    if (
                        $cotizacion->getFieldValue("Deal_Name") != null
                        and
                        date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')
                    ) {
                        $cotizaciones_emitidas += 1;
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            $aseguradoras[] = $plan->getDescription();
                        }
                    }

                    if (
                        $cotizacion->getFieldValue("Deal_Name") != null
                        and
                        date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m')
                    ) {
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
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        }

        $result = $api->searchRecordsByCriteria("Quotes", $criterio, $num_pagina, 10);

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/buscar.php";
        require_once "views/layout/footer_main.php";
    }

    public function detalles()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[1]) and !is_numeric($url[1])) ? $url[1] : null;
        $num_pagina = (isset($url[1]) and is_numeric($url[1])) ? $url[1] : 1;
        $id = (isset($url[0])) ? $url[0] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            $alerta = "Cotización Vencida.";
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/detalles.php";
        require_once "views/layout/footer_main.php";
    }

    public function descargar()
    {
        $api = new api;
        $url = obtener_url();
        $id = (isset($url[0])) ? $url[0] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "cotizaciones/detalles/$id");
            exit();
        }

        if ($cotizacion->getFieldValue("Deal_Name") == null) {
            require_once "views/cotizaciones/descargar_pendiente.php";
        } else {
            $trato = $api->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
            $coberturas = $api->getRecord("Contratos", $trato->getFieldValue("Contrato")->getEntityId());
            $imagen_aseguradora = $api->downloadPhoto("Vendors", $coberturas->getFieldValue("Aseguradora")->getEntityId());

            switch ($cotizacion->getFieldValue("Tipo")) {
                case 'Auto':
                    $bien = $api->getRecord("Bienes", $trato->getFieldValue("Bien")->getEntityId());
                    $aseguradora = $api->getRecord("Vendors", $coberturas->getFieldValue("Aseguradora")->getEntityId());
                    break;

                case 'Vida':

                    break;
            }
            require_once "views/cotizaciones/descargar_emitido.php";
        }
    }

    public function documentos()
    {
        $api = new api;
        $url = obtener_url();
        $id = (isset($url[0])) ? $url[0] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue("Deal_Name") == null) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "cotizaciones/detalles/$id");
            exit();
        }

        $trato = $api->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
        $ajuntos = $api->getAttachments("Contratos", $trato->getFieldValue('Contrato')->getEntityId(), 1, 200);

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/documentos.php";
        require_once "views/layout/footer_main.php";
    }

    public function adjuntar()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[1]) and !is_numeric($url[1])) ? $url[1] : null;
        $num_pagina = (isset($url[1]) and is_numeric($url[1])) ? $url[1] : 1;
        $id = (isset($url[0])) ? $url[0] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue("Deal_Name") == null) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "cotizaciones/detalles/$id");
            exit();
        }

        $documentos_aduntos = $api->getAttachments("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId(), $num_pagina, 5);

        if ($_FILES) {
            $ruta_archivo = "public/path";
            if (!is_dir($ruta_archivo)) {
                mkdir($ruta_archivo, 0755, true);
            }

            foreach ($_FILES["documentos"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                    $name = basename($_FILES["documentos"]["name"][$key]);
                    move_uploaded_file($tmp_name, "$ruta_archivo/$name");
                    $api->uploadAttachment("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId(), "$ruta_archivo/$name");
                    unlink("$ruta_archivo/$name");
                }
            }

            $alerta = "Documentos Adjuntados";
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/adjuntar.php";
        require_once "views/layout/footer_main.php";
    }

    public function reporte()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[0])) ? $url[0] : null;

        if (isset($_POST["pdf"])) {
            $titulo = "Reporte Pendientes " . $_POST["tipo_cotizacion"];
            $prima_sumatoria = 0;
            $valor_sumatoria = 0;
            $comision_sumatoria = 0;
            $num_pag = 1;

            require_once "views/cotizaciones/descargar_reporte.php";
            exit();
        }

        if (isset($_POST["csv"])) {
            $titulo = "Reporte " . ucfirst($_POST["estado_cotizacion"]) . " " . $_POST["tipo_cotizacion"];
            $contenido_csv = array(
                array($_SESSION["usuario"]['empresa_nombre']),
                array($titulo),
                array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
                array("Vendedor:", $_SESSION["usuario"]['nombre']),
                array("")
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
                $cotizaciones = $api->searchRecordsByCriteria("Quotes", $criterio, $num_pag);
                if (!empty($cotizaciones)) {
                    $num_pag++;
                    foreach ($cotizaciones as $cotizacion) {
                        switch ($_POST["estado_cotizacion"]) {
                            case 'pendientes':
                                if (
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  >= $_POST["desde"]
                                    and
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  <= $_POST["hasta"]
                                    and
                                    $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"]
                                    and
                                    $cotizacion->getFieldValue('Deal_Name') == null
                                ) {
                                    $planes = $cotizacion->getLineItems();
                                    foreach ($planes as $plan) {
                                        if (
                                            $plan->getNetTotal() > 0
                                            and
                                            (empty($_POST["aseguradora"])
                                                or
                                                $_POST["aseguradora"] == $plan->getDescription())
                                        ) {
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
                                if (
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  >= $_POST["desde"]
                                    and
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  <= $_POST["hasta"]
                                    and
                                    $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"]
                                    and
                                    $cotizacion->getFieldValue('Deal_Name') != null
                                ) {
                                    $planes = $cotizacion->getLineItems();
                                    foreach ($planes as $plan) {
                                        if (
                                            $plan->getNetTotal() > 0
                                            and
                                            (empty($_POST["aseguradora"])
                                                or
                                                $_POST["aseguradora"] == $plan->getDescription())
                                        ) {
                                            switch ($_POST["tipo_cotizacion"]) {
                                                case 'Auto':
                                                    $trato = $api->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
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


            $contenido_csv[] = array("");
            $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2));
            $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2));
            if ($_POST["estado_cotizacion"] == "emitidas") {
                $contenido_csv[] = array("Total Comisiones:", number_format($comision_sumatoria, 2));
            }

            if ($valor_sumatoria > 0) {
                if (!is_dir("public/tmp")) {
                    mkdir("public/tmp", 0755, true);
                }

                $ruta_csv = "public/tmp/" . $titulo . ".csv";
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
                exit;
            } else {
                $alerta = 'No se encontraton resultados';
            }
        }


        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/reporte.php";
        require_once "views/layout/footer_main.php";
    }

    public function crear()
    {
        $api = new api;
        $url = obtener_url();
        $tipo = (isset($url[0])) ? $url[0] : null;

        if ($_POST) {
            switch ($tipo) {
                case 'auto':
                    $modelo = $api->getRecord("Modelos", $_POST["modelo"]);
                    $tipo_vehiculo = $modelo->getFieldValue("Tipo");
                    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
                    $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);

                    foreach ($contratos as $contrato) {
                        $prima = 0;
                        $plan_id = null;
                        $tasa_valor = 0;
                        $recargo_valor = 0;

                        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                        $planes = $api->searchRecordsByCriteria("Products", $criterio);
                        foreach ($planes as $plan) {
                            if ($plan->getFieldValue('Product_Category') == "Plan " . $_POST["tipo_plan"]) {
                                $plan_id = $plan->getEntityId();
                                $prima = $plan->getFieldValue('Unit_Price');
                            }
                        }

                        if ($prima == 0) {
                            $criterio = "Contrato:equals:" . $contrato->getEntityId();
                            $tasas = $api->searchRecordsByCriteria("Tasas", $criterio);
                            foreach ($tasas as $tasa) {
                                if (
                                    in_array($tipo_vehiculo, $tasa->getFieldValue('Grupo_de_veh_culo'))
                                    and
                                    $tasa->getFieldValue('A_o') == $_POST["fabricacion"]
                                ) {
                                    $tasa_valor = $tasa->getFieldValue('Valor');
                                }
                            }

                            $recargos = $api->searchRecordsByCriteria("Recargos", $criterio);
                            foreach ($recargos as $recargo) {
                                if (
                                    (in_array($tipo_vehiculo, $recargo->getFieldValue('Grupo_de_veh_culo'))
                                        and
                                        $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"])
                                    and
                                    (
                                        ($_POST["fabricacion"] < $recargo->getFieldValue('Desde')
                                            and
                                            $_POST["fabricacion"] > $recargo->getFieldValue('Hasta'))
                                        or
                                        $_POST["fabricacion"] > $recargo->getFieldValue('Hasta')
                                        or
                                        $_POST["fabricacion"] < $recargo->getFieldValue('Desde'))
                                ) {
                                    $recargo_valor = $recargo->getFieldValue('Porcentaje');
                                }
                            }

                            if ($recargo_valor > 0) {
                                $tasa_valor = $tasa_valor + (($tasa_valor * $recargo_valor) / 100);
                            }

                            $prima = $_POST["valor"] * $tasa_valor / 100;

                            if ($prima > 0 and $prima < $contrato->getFieldValue('Prima_M_nima')) {
                                $prima = $contrato->getFieldValue('Prima_M_nima');
                            }
                        }

                        if ($prima > 0 and $_POST["facturacion"] == "Mensual") {
                            $prima = $prima / 12;
                        }

                        $num_pag = 1;
                        do {
                            $criterio = "Contrato:equals:" . $contrato->getEntityId();
                            $retringidos = $api->searchRecordsByCriteria("Restringidos", $criterio, $num_pag);
                            if (!empty($retringidos)) {
                                $num_pag++;
                                foreach ($retringidos as $retringido) {
                                    if (
                                        (empty($retringido->getFieldValue('Modelo'))
                                            and
                                            $retringido->getFieldValue('Marca')->getEntityId() ==  $_POST["marca"])
                                        or
                                        (!empty($retringido->getFieldValue('Modelo'))
                                            and
                                            $retringido->getFieldValue('Modelo')->getEntityId() ==  $_POST["modelo"])
                                    ) {
                                        $prima = 0;
                                    }
                                }
                            } else {
                                $num_pag = 0;
                            }
                        } while ($num_pag > 0);

                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                    }

                    $cotizacion["Subject"] = "Plan " . $_POST["facturacion"] . " " . $_POST["tipo_plan"];
                    $cotizacion["Quote_Stage"] = "Cotizando";
                    $cotizacion["Tipo"] = "Auto";
                    $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
                    $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                    $cotizacion["Fecha_emisi_n"] = date("Y-m-d");
                    $cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
                    $cotizacion["Tipo_P_liza"] = "Declarativa";
                    $cotizacion["Plan"] = $_POST["tipo_plan"];
                    $cotizacion["Valor_Asegurado"] = $_POST["valor"];

                    $cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                    $cotizacion["Nombre"] = $_POST["nombre"];
                    $cotizacion["Apellido"] = $_POST["apellido"];
                    $cotizacion["Direcci_n"] = $_POST["direccion"];
                    $cotizacion["Tel_Celular"] = $_POST["telefono"];
                    $cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                    $cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                    $cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                    $cotizacion["Correo"] = $_POST["correo"];

                    $cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
                    $cotizacion["Marca"] = $_POST["marca"];
                    $cotizacion["Modelo"] = $_POST["modelo"];
                    $cotizacion["Uso_Veh_culo"] = $_POST["uso"];
                    $cotizacion["Estado_Veh_culo"] = (!empty($_POST["estado"])) ? true : false;
                    $cotizacion["Tipo_Veh_culo"] = $tipo_vehiculo;
                    $id = $api->createRecords("Quotes", $cotizacion, $plan_seleccionado);
                    header("Location:" . constant("url") . "cotizaciones/detalles/$id");
                    exit();
                    break;

                case 'vida':
                    $edad_deudor = calcular_edad($_POST["fecha_nacimiento"]);
                    $edad_codeudor = (!empty($_POST["fecha_codeudor"])) ?  calcular_edad($_POST["fecha_codeudor"]) : null;
                    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Vida))";
                    $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);

                    foreach ($contratos as $contrato) {
                        $prima = 0;

                        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                        $planes = $api->searchRecordsByCriteria("Products", $criterio);
                        foreach ($planes as $plan) {
                            if ($plan->getFieldValue('Product_Category') == "Plan Vida") {
                                $plan_id = $plan->getEntityId();
                            }
                        }

                        $criterio = "Contrato:equals:" . $contrato->getEntityId();
                        $tasas = $api->searchRecordsByCriteria("Tasas", $criterio);
                        foreach ($tasas as $tasa) {
                            if ($tasa->getFieldValue('Codeudor') == true) {
                                $tasa_codeudor = $tasa->getFieldValue('Valor');
                            } else {
                                $tasa_deudor = $tasa->getFieldValue('Valor');
                            }
                        }

                        $tasa_deudor = $tasa_deudor / 100;
                        $tasa_codeudor = $tasa_codeudor / 100;
                        $prima = $_POST["valor"] / 1000 * $tasa_deudor;

                        if (!empty($edad_codeudor)) {
                            $prima += $_POST["valor"] / 1000 * ($tasa_codeudor - $tasa_deudor);
                        }

                        if (
                            $edad_deudor > $contrato->getFieldValue('Edad_Max')
                            or
                            $edad_deudor < $contrato->getFieldValue('Edad_Min')
                            or
                            (!empty($edad_codeudor)
                                and
                                $edad_codeudor > $contrato->getFieldValue('Edad_Max')
                                or
                                $edad_codeudor < $contrato->getFieldValue('Edad_Min'))
                        ) {
                            $prima = 0;
                        }

                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                    }

                    $nueva_cotizacion["Subject"] = "Plan Vida";
                    $nueva_cotizacion["Fecha_Nacimiento_Codeudor"] = $_POST["fecha_codeudor"];
                    $nueva_cotizacion["Quote_Stage"] = "Cotizando";
                    $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
                    $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                    $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
                    $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
                    $nueva_cotizacion["Tipo_P_liza"] = "Declarativa";
                    $nueva_cotizacion["Plan"] = "Vida";
                    $nueva_cotizacion["Tipo"] = "Vida";
                    $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
                    $nueva_cotizacion["Plazo"] =  $_POST["plazo"];
                    $nueva_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                    $nueva_cotizacion["Nombre"] = $_POST["nombre"];
                    $nueva_cotizacion["Apellido"] = $_POST["apellido"];
                    $nueva_cotizacion["Direcci_n"] = $_POST["direccion"];
                    $nueva_cotizacion["Tel_Celular"] = $_POST["telefono"];
                    $nueva_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                    $nueva_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                    $nueva_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                    $nueva_cotizacion["Correo"] = $_POST["correo"];
                    $nuevo_cotizacion_id = $api->createRecords("Quotes", $nueva_cotizacion, $plan_seleccionado);
                    header("Location:" . constant("url") . "cotizaciones/detalles/$nuevo_cotizacion_id");
                    exit();
                    break;

                case 'desempleo':
                    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Desempleo))";
                    $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);

                    foreach ($contratos as $contrato) {
                        $prima = 0;

                        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                        $planes = $api->searchRecordsByCriteria("Products", $criterio);
                        foreach ($planes as $plan) {
                            if ($plan->getFieldValue('Product_Category') == "Plan Vida") {
                                $plan_id = $plan->getEntityId();
                            }
                        }

                        $criterio = "Contrato:equals:" . $contrato->getEntityId();
                        $tasas = $api->searchRecordsByCriteria("Tasas", $criterio);
                        foreach ($tasas as $tasa) {
                            if ($tasa->getFieldValue('Desempleo') == true) {
                                $tasa_deudor_desempleo = $tasa->getFieldValue('Valor');
                            } else {
                                $tasa_deudor = $tasa->getFieldValue('Valor');
                            }
                        }

                        $prima = $_POST["valor"] / 1000 * ($tasa_deudor / 100);
                        $prima += $_POST["cuota"] / 1000 * $tasa_deudor_desempleo;

                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                    }

                    $nueva_cotizacion["Subject"] = "Plan Vida/Desempleo";
                    $nueva_cotizacion["Quote_Stage"] = "Cotizando";
                    $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
                    $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                    $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
                    $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
                    $nueva_cotizacion["Tipo_P_liza"] = "Declarativa";
                    $nueva_cotizacion["Plan"] = "Vida/Desempleo";
                    $nueva_cotizacion["Tipo"] = "Desempleo";
                    $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
                    $nueva_cotizacion["Plazo"] =  $_POST["plazo"];
                    $nueva_cotizacion["Cuota_Men"] =  $_POST["cuota"];
                    $nueva_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                    $nueva_cotizacion["Nombre"] = $_POST["nombre"];
                    $nueva_cotizacion["Apellido"] = $_POST["apellido"];
                    $nueva_cotizacion["Direcci_n"] = $_POST["direccion"];
                    $nueva_cotizacion["Tel_Celular"] = $_POST["telefono"];
                    $nueva_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                    $nueva_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                    $nueva_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                    $nueva_cotizacion["Correo"] = $_POST["correo"];
                    $nuevo_cotizacion_id = $api->createRecords("Quotes", $nueva_cotizacion, $plan_seleccionado);
                    header("Location:" . constant("url") . "cotizaciones/detalles/$nuevo_cotizacion_id");
                    exit();
                    break;

                case 'incendio':
                    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Incendio))";
                    $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);

                    foreach ($contratos as $contrato) {
                        $prima = 0;

                        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                        $planes = $api->searchRecordsByCriteria("Products", $criterio);
                        foreach ($planes as $plan) {
                            if ($plan->getFieldValue('Product_Category') == "Plan Vida") {
                                $plan_id = $plan->getEntityId();
                            }
                        }

                        $criterio = "Contrato:equals:" . $contrato->getEntityId();
                        $tasas = $api->searchRecordsByCriteria("Tasas", $criterio);
                        foreach ($tasas as $tasa) {
                            $tasa_deudor = $tasa->getFieldValue('Valor');
                        }

                        $tasa_deudor = ($tasa_deudor / 100) / 100;
                        $prima = $_POST["valor"] * $tasa_deudor / 12;

                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                    }

                    $nueva_cotizacion["Subject"] = "Plan Incendio";
                    $nueva_cotizacion["Quote_Stage"] = "Cotizando";
                    $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
                    $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                    $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
                    $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
                    $nueva_cotizacion["Tipo_P_liza"] = "Declarativa";
                    $nueva_cotizacion["Plan"] = "Incendio";
                    $nueva_cotizacion["Tipo"] = "Incendio";
                    $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
                    $nueva_cotizacion["Plazo"] =  $_POST["plazo"];
                    $nueva_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                    $nueva_cotizacion["Nombre"] = $_POST["nombre"];
                    $nueva_cotizacion["Apellido"] = $_POST["apellido"];
                    $nueva_cotizacion["Direcci_n"] = $_POST["direccion"];
                    $nueva_cotizacion["Tel_Celular"] = $_POST["telefono"];
                    $nueva_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                    $nueva_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                    $nueva_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                    $nueva_cotizacion["Correo"] = $_POST["correo"];
                    $nueva_cotizacion["Riesgo"] = $_POST["riesgo"];
                    $nuevo_cotizacion_id = $api->createRecords("Quotes", $nueva_cotizacion, $plan_seleccionado);
                    header("Location:" . constant("url") . "cotizaciones/detalles/$nuevo_cotizacion_id");
                    exit();
                    break;
            }
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/crear.php";
        require_once "views/layout/footer_main.php";
    }

    public function emitir()
    {
        $api = new api;
        $url = obtener_url();
        $alerta = (isset($url[1]) and !is_numeric($url[1])) ? $url[1] : null;
        $id = (isset($url[0])) ? $url[0] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue("Deal_Name") != null) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "cotizaciones/detalles/$id");
            exit();
        }

        if (!empty($_FILES["cotizacion_firmada"]["name"])) {
            $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
            $permitido = array("pdf");
            if (!in_array($extension, $permitido)) {
                $alerta = "Para emitir solo se admiten documentos PDF";
            } else {

                switch ($cotizacion->getFieldValue('Tipo')) {
                    case 'Auto':
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            if ($plan->getDescription() == $_POST["aseguradora"]) {
                                $plan_id = $plan->getProduct()->getEntityId();
                                $prima = $plan->getNetTotal();
                                $prima_neta = $plan->getListPrice();
                                $isc = $plan->getTaxAmount();
                            }
                        }

                        $plan_detalles = $api->getRecord("Products", $plan_id);
                        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                        $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
                        foreach ($contratos as $contrato) {
                            if ($contrato->getFieldValue("Aseguradora")->getEntityId() == $plan_detalles->getFieldValue("Vendor_Name")->getEntityId()) {
                                $poliza = $contrato->getFieldValue('No_P_liza');
                                $comision_nobe = $prima * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                                $comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                                $comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                                $contrato_id = $contrato->getEntityId();
                            }
                        }

                        $cliente_nuevo["Vendor_Name"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
                        $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $cliente_nuevo["Mailing_Street"] = $_POST["direccion"];
                        $cliente_nuevo["First_Name"] = $_POST["nombre"];
                        $cliente_nuevo["Last_Name"] = $_POST["apellido"];
                        $cliente_nuevo["Mobile"] = $_POST["telefono"];
                        $cliente_nuevo["Phone"] = $_POST["tel_residencia"];
                        $cliente_nuevo["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
                        $cliente_nuevo["Email"] = $_POST["correo"];
                        $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cliente_nuevo["Tipo"] = "Cliente";
                        $cliente_nuevo_id = $api->createRecords("Contacts", $cliente_nuevo);

                        $poliza_nueva["Name"] = $poliza;
                        $poliza_nueva["Estado"] =  true;
                        $poliza_nueva["Plan"] =  $cotizacion->getFieldValue('Subject');
                        $poliza_nueva["Aseguradora"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $poliza_nueva["Prima"] =  round($prima, 2);
                        $poliza_nueva["Deudor"] =  $cliente_nuevo_id;
                        $poliza_nueva["Ramo"] = "Automóvil";
                        $poliza_nueva["Socio"] =  $_SESSION["usuario"]['empresa_id'];
                        $poliza_nueva["Tipo"] =  $cotizacion->getFieldValue('Tipo_P_liza');
                        $poliza_nueva["Valor_Aseguradora"] =   $cotizacion->getFieldValue('Valor_Asegurado');
                        $poliza_nueva["Vigencia_desde"] =  date("Y-m-d");
                        $poliza_nueva["Vigencia_hasta"] =  date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
                        $poliza_nueva_id = $api->createRecords("P_lizas", $poliza_nueva);

                        $nuevo_bien["A_o"] = $cotizacion->getFieldValue('A_o_Fabricaci_n');
                        $nuevo_bien["Color"] = $_POST["color"];
                        $nuevo_bien["Marca"] = $cotizacion->getFieldValue('Marca')->getLookupLabel();
                        $nuevo_bien["Modelo"] = $cotizacion->getFieldValue('Modelo')->getLookupLabel();
                        $nuevo_bien["Name"] = $_POST["chasis"];
                        $nuevo_bien["Placa"] = $_POST["placa"];
                        $nuevo_bien["Uso"] = $cotizacion->getFieldValue('Uso_Veh_culo');
                        $nuevo_bien["Condicion"] = ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado";
                        $nuevo_bien["P_liza"] = $poliza_nueva_id;
                        $nuevo_bien["Tipo"] = "Automóvil";
                        $nuevo_bien["Tipo_de_veh_culo"] = $cotizacion->getFieldValue('Tipo_Veh_culo');
                        $nuevo_bien_id = $api->createRecords("Bienes", $nuevo_bien);

                        $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
                        $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
                        $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $nuevo_trato["Stage"] = "En trámite";
                        $nuevo_trato["Fecha_de_emisi_n"] =  date("Y-m-d");
                        $nuevo_trato["Closing_Date"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $nuevo_trato["Type"] = "Auto";
                        $nuevo_trato["Valor_Asegurado"] = $cotizacion->getFieldValue('Valor_Asegurado');
                        $nuevo_trato["P_liza"] = $poliza_nueva_id;
                        $nuevo_trato["Bien"] = $nuevo_bien_id;
                        $nuevo_trato["Cliente"] = $cliente_nuevo_id;
                        $nuevo_trato["Contrato"] = $contrato_id;
                        $nuevo_trato["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
                        $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
                        $nuevo_trato["Amount"] = round($comision_nobe, 2);
                        $nuevo_trato["Prima_Total"] = round($prima, 2);
                        $nuevo_trato["Prima_Neta"] = round($prima_neta, 2);
                        $nuevo_trato["ISC"] = round($isc, 2);
                        $nuevo_trato["Lead_Source"] = "Portal";
                        $nuevo_trato_id = $api->createRecords("Deals", $nuevo_trato);

                        $ruta = "public/path";
                        if (!is_dir($ruta)) {
                            mkdir($ruta, 0755, true);
                        }
                        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                        $name = basename($_FILES["cotizacion_firmada"]["name"]);
                        move_uploaded_file($tmp_name, "$ruta/$name");
                        $api->uploadAttachment("Deals", $nuevo_trato_id, "$ruta/$name");
                        unlink("$ruta/$name");

                        $cambios_cotizacion["Quote_Stage"] =  "Emitida";
                        $cambios_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
                        $cambios_cotizacion["Valid_Till"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $cambios_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cambios_cotizacion["Nombre"] = $_POST["nombre"];
                        $cambios_cotizacion["Apellido"] = $_POST["apellido"];
                        $cambios_cotizacion["Direcci_n"] = $_POST["direccion"];
                        $cambios_cotizacion["Tel_Celular"] = $_POST["telefono"];
                        $cambios_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                        $cambios_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cambios_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                        $cambios_cotizacion["Correo"] = $_POST["correo"];
                        $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;
                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $plan_detalles->getFieldValue("Vendor_Name")->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                        $api->update("Quotes", $cotizacion->getEntityId(), $cambios_cotizacion, $plan_seleccionado);
                        header("Location:" . constant("url") . "cotizaciones/detalles/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
                        exit();
                        break;

                    case 'Vida':
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            if ($plan->getDescription() == $_POST["aseguradora"]) {
                                $plan_id = $plan->getProduct()->getEntityId();
                                $prima = $plan->getNetTotal();
                                $prima_neta = $plan->getListPrice();
                                $isc = $plan->getTaxAmount();
                            }
                        }

                        $plan_detalles = $api->getRecord("Products", $plan_id);
                        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                        $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
                        foreach ($contratos as $contrato) {
                            if ($contrato->getFieldValue("Aseguradora")->getEntityId() == $plan_detalles->getFieldValue("Vendor_Name")->getEntityId()) {
                                $poliza = $contrato->getFieldValue('No_P_liza');
                                $comision_nobe = $prima * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                                $comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                                $comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                                $contrato_id = $contrato->getEntityId();
                            }
                        }

                        $cliente_nuevo["Vendor_Name"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
                        $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $cliente_nuevo["Mailing_Street"] = $_POST["direccion"];
                        $cliente_nuevo["First_Name"] = $_POST["nombre"];
                        $cliente_nuevo["Last_Name"] = $_POST["apellido"];
                        $cliente_nuevo["Mobile"] = $_POST["telefono"];
                        $cliente_nuevo["Phone"] = $_POST["tel_residencia"];
                        $cliente_nuevo["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
                        $cliente_nuevo["Email"] = $_POST["correo"];
                        $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cliente_nuevo["Tipo"] = "Cliente";
                        $cliente_nuevo_id = $api->createRecords("Contacts", $cliente_nuevo);

                        $poliza_nueva["Name"] = $poliza;
                        $poliza_nueva["Estado"] =  true;
                        $poliza_nueva["Plan"] =  $cotizacion->getFieldValue('Subject');
                        $poliza_nueva["Aseguradora"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $poliza_nueva["Prima"] =  round($prima, 2);
                        $poliza_nueva["Deudor"] =  $cliente_nuevo_id;
                        $poliza_nueva["Ramo"] = "Vida";
                        $poliza_nueva["Socio"] =  $_SESSION["usuario"]['empresa_id'];
                        $poliza_nueva["Tipo"] =  $cotizacion->getFieldValue('Tipo_P_liza');
                        $poliza_nueva["Valor_Aseguradora"] =   $cotizacion->getFieldValue('Valor_Asegurado');
                        $poliza_nueva["Vigencia_desde"] =  date("Y-m-d");
                        $poliza_nueva["Vigencia_hasta"] =  date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
                        $poliza_nueva_id = $api->createRecords("P_lizas", $poliza_nueva);

                        $nuevo_bien["Name"] = $_POST["rnc_cedula"];
                        $nuevo_bien["P_liza"] = $poliza_nueva_id;
                        $nuevo_bien["Tipo"] = "Persona";
                        $nuevo_bien_id = $api->createRecords("Bienes", $nuevo_bien);

                        $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
                        $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
                        $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $nuevo_trato["Stage"] = "En trámite";
                        $nuevo_trato["Fecha_de_emisi_n"] =  date("Y-m-d");
                        $nuevo_trato["Closing_Date"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $nuevo_trato["Type"] = "Vida";
                        $nuevo_trato["Valor_Asegurado"] = $cotizacion->getFieldValue('Valor_Asegurado');
                        $nuevo_trato["P_liza"] = $poliza_nueva_id;
                        $nuevo_trato["Bien"] = $nuevo_bien_id;
                        $nuevo_trato["Cliente"] = $cliente_nuevo_id;
                        $nuevo_trato["Contrato"] = $contrato_id;
                        $nuevo_trato["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
                        $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
                        $nuevo_trato["Amount"] = round($comision_nobe, 2);
                        $nuevo_trato["Prima_Total"] = round($prima, 2);
                        $nuevo_trato["Prima_Neta"] = round($prima_neta, 2);
                        $nuevo_trato["ISC"] = round($isc, 2);
                        $nuevo_trato["Lead_Source"] = "Portal";
                        $nuevo_trato_id = $api->createRecords("Deals", $nuevo_trato);

                        $ruta = "public/path";
                        if (!is_dir($ruta)) {
                            mkdir($ruta, 0755, true);
                        }
                        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                        $name = basename($_FILES["cotizacion_firmada"]["name"]);
                        move_uploaded_file($tmp_name, "$ruta/$name");
                        $api->uploadAttachment("Deals", $nuevo_trato_id, "$ruta/$name");
                        unlink("$ruta/$name");

                        $cambios_cotizacion["Quote_Stage"] =  "Emitida";
                        $cambios_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
                        $cambios_cotizacion["Valid_Till"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $cambios_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cambios_cotizacion["Nombre"] = $_POST["nombre"];
                        $cambios_cotizacion["Apellido"] = $_POST["apellido"];
                        $cambios_cotizacion["Direcci_n"] = $_POST["direccion"];
                        $cambios_cotizacion["Tel_Celular"] = $_POST["telefono"];
                        $cambios_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                        $cambios_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cambios_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                        $cambios_cotizacion["Correo"] = $_POST["correo"];
                        $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;
                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $plan_detalles->getFieldValue("Vendor_Name")->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                        $api->update("Quotes", $cotizacion->getEntityId(), $cambios_cotizacion, $plan_seleccionado);
                        header("Location:" . constant("url") . "cotizaciones/detalles/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
                        exit();
                        break;

                    case 'Desempleo':
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            if ($plan->getDescription() == $_POST["aseguradora"]) {
                                $plan_id = $plan->getProduct()->getEntityId();
                                $prima = $plan->getNetTotal();
                                $prima_neta = $plan->getListPrice();
                                $isc = $plan->getTaxAmount();
                            }
                        }

                        $plan_detalles = $api->getRecord("Products", $plan_id);
                        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                        $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
                        foreach ($contratos as $contrato) {
                            if ($contrato->getFieldValue("Aseguradora")->getEntityId() == $plan_detalles->getFieldValue("Vendor_Name")->getEntityId()) {
                                $poliza = $contrato->getFieldValue('No_P_liza');
                                $comision_nobe = $prima * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                                $comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                                $comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                                $contrato_id = $contrato->getEntityId();
                            }
                        }

                        $cliente_nuevo["Vendor_Name"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
                        $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $cliente_nuevo["Mailing_Street"] = $_POST["direccion"];
                        $cliente_nuevo["First_Name"] = $_POST["nombre"];
                        $cliente_nuevo["Last_Name"] = $_POST["apellido"];
                        $cliente_nuevo["Mobile"] = $_POST["telefono"];
                        $cliente_nuevo["Phone"] = $_POST["tel_residencia"];
                        $cliente_nuevo["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
                        $cliente_nuevo["Email"] = $_POST["correo"];
                        $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cliente_nuevo["Tipo"] = "Cliente";
                        $cliente_nuevo_id = $api->createRecords("Contacts", $cliente_nuevo);

                        $poliza_nueva["Name"] = $poliza;
                        $poliza_nueva["Estado"] =  true;
                        $poliza_nueva["Plan"] =  $cotizacion->getFieldValue('Subject');
                        $poliza_nueva["Aseguradora"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $poliza_nueva["Prima"] =  round($prima, 2);
                        $poliza_nueva["Deudor"] =  $cliente_nuevo_id;
                        $poliza_nueva["Ramo"] = "Vida";
                        $poliza_nueva["Socio"] =  $_SESSION["usuario"]['empresa_id'];
                        $poliza_nueva["Tipo"] =  $cotizacion->getFieldValue('Tipo_P_liza');
                        $poliza_nueva["Valor_Aseguradora"] =   $cotizacion->getFieldValue('Valor_Asegurado');
                        $poliza_nueva["Vigencia_desde"] =  date("Y-m-d");
                        $poliza_nueva["Vigencia_hasta"] =  date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
                        $poliza_nueva_id = $api->createRecords("P_lizas", $poliza_nueva);

                        $nuevo_bien["Name"] = $_POST["rnc_cedula"];
                        $nuevo_bien["P_liza"] = $poliza_nueva_id;
                        $nuevo_bien["Tipo"] = "Persona";
                        $nuevo_bien_id = $api->createRecords("Bienes", $nuevo_bien);

                        $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
                        $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
                        $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $nuevo_trato["Stage"] = "En trámite";
                        $nuevo_trato["Fecha_de_emisi_n"] =  date("Y-m-d");
                        $nuevo_trato["Closing_Date"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $nuevo_trato["Type"] = "Desempleo";
                        $nuevo_trato["Valor_Asegurado"] = $cotizacion->getFieldValue('Valor_Asegurado');
                        $nuevo_trato["P_liza"] = $poliza_nueva_id;
                        $nuevo_trato["Bien"] = $nuevo_bien_id;
                        $nuevo_trato["Cliente"] = $cliente_nuevo_id;
                        $nuevo_trato["Contrato"] = $contrato_id;
                        $nuevo_trato["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
                        $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
                        $nuevo_trato["Amount"] = round($comision_nobe, 2);
                        $nuevo_trato["Prima_Total"] = round($prima, 2);
                        $nuevo_trato["Prima_Neta"] = round($prima_neta, 2);
                        $nuevo_trato["ISC"] = round($isc, 2);
                        $nuevo_trato["Lead_Source"] = "Portal";
                        $nuevo_trato_id = $api->createRecords("Deals", $nuevo_trato);

                        $ruta = "public/path";
                        if (!is_dir($ruta)) {
                            mkdir($ruta, 0755, true);
                        }
                        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                        $name = basename($_FILES["cotizacion_firmada"]["name"]);
                        move_uploaded_file($tmp_name, "$ruta/$name");
                        $api->uploadAttachment("Deals", $nuevo_trato_id, "$ruta/$name");
                        unlink("$ruta/$name");

                        $cambios_cotizacion["Quote_Stage"] =  "Emitida";
                        $cambios_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
                        $cambios_cotizacion["Valid_Till"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $cambios_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cambios_cotizacion["Nombre"] = $_POST["nombre"];
                        $cambios_cotizacion["Apellido"] = $_POST["apellido"];
                        $cambios_cotizacion["Direcci_n"] = $_POST["direccion"];
                        $cambios_cotizacion["Tel_Celular"] = $_POST["telefono"];
                        $cambios_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                        $cambios_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cambios_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                        $cambios_cotizacion["Correo"] = $_POST["correo"];
                        $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;
                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $plan_detalles->getFieldValue("Vendor_Name")->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                        $api->update("Quotes", $cotizacion->getEntityId(), $cambios_cotizacion, $plan_seleccionado);
                        header("Location:" . constant("url") . "cotizaciones/detalles/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
                        exit();
                        break;

                    case 'Incendio':
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            if ($plan->getDescription() == $_POST["aseguradora"]) {
                                $plan_id = $plan->getProduct()->getEntityId();
                                $prima = $plan->getNetTotal();
                                $prima_neta = $plan->getListPrice();
                                $isc = $plan->getTaxAmount();
                            }
                        }

                        $plan_detalles = $api->getRecord("Products", $plan_id);
                        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                        $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
                        foreach ($contratos as $contrato) {
                            if ($contrato->getFieldValue("Aseguradora")->getEntityId() == $plan_detalles->getFieldValue("Vendor_Name")->getEntityId()) {
                                $poliza = $contrato->getFieldValue('No_P_liza');
                                $comision_nobe = $prima * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                                $comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                                $comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                                $contrato_id = $contrato->getEntityId();
                            }
                        }

                        $cliente_nuevo["Vendor_Name"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
                        $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $cliente_nuevo["Mailing_Street"] = $_POST["direccion"];
                        $cliente_nuevo["First_Name"] = $_POST["nombre"];
                        $cliente_nuevo["Last_Name"] = $_POST["apellido"];
                        $cliente_nuevo["Mobile"] = $_POST["telefono"];
                        $cliente_nuevo["Phone"] = $_POST["tel_residencia"];
                        $cliente_nuevo["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
                        $cliente_nuevo["Email"] = $_POST["correo"];
                        $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cliente_nuevo["Tipo"] = "Cliente";
                        $cliente_nuevo_id = $api->createRecords("Contacts", $cliente_nuevo);

                        $poliza_nueva["Name"] = $poliza;
                        $poliza_nueva["Estado"] =  true;
                        $poliza_nueva["Plan"] =  $cotizacion->getFieldValue('Subject');
                        $poliza_nueva["Aseguradora"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $poliza_nueva["Prima"] =  round($prima, 2);
                        $poliza_nueva["Deudor"] =  $cliente_nuevo_id;
                        $poliza_nueva["Ramo"] = "Vida";
                        $poliza_nueva["Socio"] =  $_SESSION["usuario"]['empresa_id'];
                        $poliza_nueva["Tipo"] =  $cotizacion->getFieldValue('Tipo_P_liza');
                        $poliza_nueva["Valor_Aseguradora"] =   $cotizacion->getFieldValue('Valor_Asegurado');
                        $poliza_nueva["Vigencia_desde"] =  date("Y-m-d");
                        $poliza_nueva["Vigencia_hasta"] =  date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
                        $poliza_nueva_id = $api->createRecords("P_lizas", $poliza_nueva);

                        $nuevo_bien["Name"] = $_POST["rnc_cedula"];
                        $nuevo_bien["P_liza"] = $poliza_nueva_id;
                        $nuevo_bien["Tipo"] = $cotizacion->getFieldValue('Riesgo');
                        $nuevo_bien_id = $api->createRecords("Bienes", $nuevo_bien);

                        $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
                        $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
                        $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                        $nuevo_trato["Stage"] = "En trámite";
                        $nuevo_trato["Fecha_de_emisi_n"] =  date("Y-m-d");
                        $nuevo_trato["Closing_Date"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $nuevo_trato["Type"] = "Incendio";
                        $nuevo_trato["Valor_Asegurado"] = $cotizacion->getFieldValue('Valor_Asegurado');
                        $nuevo_trato["P_liza"] = $poliza_nueva_id;
                        $nuevo_trato["Bien"] = $nuevo_bien_id;
                        $nuevo_trato["Cliente"] = $cliente_nuevo_id;
                        $nuevo_trato["Contrato"] = $contrato_id;
                        $nuevo_trato["Aseguradora"] = $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
                        $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
                        $nuevo_trato["Amount"] = round($comision_nobe, 2);
                        $nuevo_trato["Prima_Total"] = round($prima, 2);
                        $nuevo_trato["Prima_Neta"] = round($prima_neta, 2);
                        $nuevo_trato["ISC"] = round($isc, 2);
                        $nuevo_trato["Lead_Source"] = "Portal";
                        $nuevo_trato_id = $api->createRecords("Deals", $nuevo_trato);

                        $ruta = "public/path";
                        if (!is_dir($ruta)) {
                            mkdir($ruta, 0755, true);
                        }
                        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                        $name = basename($_FILES["cotizacion_firmada"]["name"]);
                        move_uploaded_file($tmp_name, "$ruta/$name");
                        $api->uploadAttachment("Deals", $nuevo_trato_id, "$ruta/$name");
                        unlink("$ruta/$name");

                        $cambios_cotizacion["Quote_Stage"] =  "Emitida";
                        $cambios_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
                        $cambios_cotizacion["Valid_Till"] = date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));
                        $cambios_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cambios_cotizacion["Nombre"] = $_POST["nombre"];
                        $cambios_cotizacion["Apellido"] = $_POST["apellido"];
                        $cambios_cotizacion["Direcci_n"] = $_POST["direccion"];
                        $cambios_cotizacion["Tel_Celular"] = $_POST["telefono"];
                        $cambios_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
                        $cambios_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
                        $cambios_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
                        $cambios_cotizacion["Correo"] = $_POST["correo"];
                        $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;
                        $plan_seleccionado[] = array(
                            "id" => $plan_id,
                            "prima" => $prima,
                            "cantidad" => 1,
                            "descripcion" => $plan_detalles->getFieldValue("Vendor_Name")->getLookupLabel(),
                            "impuesto" => "ITBIS 16",
                            "impuesto_valor" => 16
                        );
                        $api->update("Quotes", $cotizacion->getEntityId(), $cambios_cotizacion, $plan_seleccionado);
                        header("Location:" . constant("url") . "cotizaciones/detalles/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
                        exit();
                        break;
                }
            }
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/emitir.php";
        require_once "views/layout/footer_main.php";
    }
}
