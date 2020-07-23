<?php

class cotizaciones extends home
{
    public function buscar()
    {
        $api = new api;
        $url = $this->obtener_url();
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
        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/crear.php";
        require_once "views/layout/footer_main.php";
    }

    public function reporte()
    {
        $api = new api;
        $url = $this->obtener_url();
        $alerta = (isset($url[0])) ? $url[0] : null;

        if (isset($_POST["pdf"]) and $_POST["tipo_reporte"] == "auto") {
            $titulo = "Reporte Cotizaciones Auto";
            $prima_sumatoria = 0;
            $valor_sumatoria = 0;

            require_once "views/cotizaciones/descargar_reporte_auto.php";
            exit();
        }

        if (isset($_POST["csv"]) and $_POST["tipo_reporte"] == "auto") {
            $alerta = $this->reporte_auto($api);
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/reporte.php";
        require_once "views/layout/footer_main.php";
    }

    public function reporte_auto($api)
    {
        $titulo = "Reporte Cotizaciones Auto";
        $ruta_csv = "public/tmp/" . $titulo . ".csv";

        if (!is_dir("public/tmp")) {
            mkdir("public/tmp", 0755, true);
        }

        $contenido_csv = array(
            array($_SESSION["usuario"]['empresa_nombre']),
            array($titulo),
            array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
            array("Vendedor:", $_SESSION["usuario"]['nombre']),
            array("")
        );

        $contenido_csv[] = array(
            "Emision",
            "Vigencia",
            "Marca",
            "Modelo",
            "Tipo",
            "Año",
            "Plan",
            "Uso",
            "Condicion",
            "Tipo Póliza",
            "Valor",
            "Prima",
            "Aseguradora"
        );

        $prima_sumatoria = 0;
        $valor_sumatoria = 0;

        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $num_pagina = 1;
        do {
            $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 200);
            if (!empty($cotizaciones)) {
                $num_pagina++;

                foreach ($cotizaciones as $cotizacion) {
                    if (
                        date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  >= $_POST["desde"]
                        and
                        date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  <= $_POST["hasta"]
                        and
                        $cotizacion->getFieldValue("Tipo") == "Auto"
                        and
                        $cotizacion->getFieldValue("Deal_Name") == null
                    ) {
                        $planes = $cotizacion->getLineItems();

                        foreach ($planes as $plan) {
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
                                        $cotizacion->getFieldValue('Plan'),
                                        $cotizacion->getFieldValue('Uso_Veh_culo'),
                                        ($cotizacion->getFieldValue('Veh_culo_Nuevo') == true) ? "Nuevo" : "Usado",
                                        $cotizacion->getFieldValue('Tipo_P_liza'),
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
                                        $cotizacion->getFieldValue('Plan'),
                                        $cotizacion->getFieldValue('Uso_Veh_culo'),
                                        ($cotizacion->getFieldValue('Veh_culo_Nuevo') == true) ? "Nuevo" : "Usado",
                                        $cotizacion->getFieldValue('Tipo_P_liza'),
                                        number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                        number_format($plan->getNetTotal(), 2),
                                        $plan->getDescription()
                                    );
                                }
                            }
                        }
                    }
                }
            } else {
                $num_pagina = 0;
            }
        } while ($num_pagina > 0);


        $contenido_csv[] = array("");
        $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2,));
        $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2));

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
            header('Pragma: public');
            header('Content-Length: ' . filesize($ruta_csv));
            readfile($ruta_csv);
            unlink($ruta_csv);
            exit;
        } else {
            return 'No se encontraton resultados.';
        }
    }

    public function crear_auto()
    {
        $api = new api;

        if ($_POST) {
            $modelo = $api->detalles_registro("Modelos", $_POST["modelo"]);

            $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
            $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 10);
            foreach ($contratos as $contrato) {
                $prima = 0;

                $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                $planes = $api->buscar_criterio("Products", $criterio, 1, 2);
                foreach ($planes as $plan) {
                    $tipo_plan = strpos($_POST["tipo_plan"], "Ley");
                    if ($tipo_plan !== false) {
                        $prima = $plan->getFieldValue('Unit_Price');
                        $plan_id = $plan->getEntityId();
                    } else {
                        $plan_id = $plan->getEntityId();
                    }
                }

                if ($prima == 0) {
                    $criterio = "Contrato:equals:" . $contrato->getEntityId();

                    $tasa_valor = 0;
                    $tasas = $api->buscar_criterio("Tasas", $criterio, 1, 200);
                    foreach ($tasas as $tasa) {
                        if (
                            in_array($modelo->getFieldValue("Tipo"), $tasa->getFieldValue('Grupo_de_veh_culo'))
                            and
                            $tasa->getFieldValue('A_o') == $_POST["fabricacion"]
                        ) {
                            $tasa_valor = $tasa->getFieldValue('Valor');
                        }
                    }

                    $recargo_valor = 0;
                    $recargos = $api->buscar_criterio("Recargos", $criterio, 1, 200);
                    if (!empty($recargos)) {
                        foreach ($recargos as $recargo) {
                            if (in_array($modelo->getFieldValue("Tipo"), $recargo->getFieldValue('Grupo_de_veh_culo')) and $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"]) {
                                if (!empty($recargo->getFieldValue('Hasta')) and !empty($recargo->getFieldValue('Desde'))) {
                                    if ($_POST["fabricacion"] < $recargo->getFieldValue('Desde') and $_POST["fabricacion"] > $recargo->getFieldValue('Hasta')) {
                                        $recargo_valor = $recargo->getFieldValue('Porcentaje');
                                    }
                                } else {
                                    if (!empty($recargo->getFieldValue('Hasta')) and $_POST["fabricacion"] > $recargo->getFieldValue('Hasta')) {
                                        $recargo_valor = $recargo->getFieldValue('Porcentaje');
                                    } elseif (!empty($recargo->getFieldValue('Desde')) and $_POST["fabricacion"] < $recargo->getFieldValue('Desde')) {
                                        $recargo_valor = $recargo->getFieldValue('Porcentaje');
                                    }
                                }
                            }
                        }
                    }

                    $tasa_valor = $tasa_valor + (($tasa_valor * $recargo_valor) / 100);
                    $prima = $_POST["valor"] * $tasa_valor / 100;

                    if ($prima < $contrato->getFieldValue('Prima_M_nima') and $tasa_valor > 0) {
                        $prima = $contrato->getFieldValue('Prima_M_nima');
                    }
                }

                $tipo_plan = strpos($_POST["tipo_plan"], "Mensual");
                if ($tipo_plan !== false) {
                    $prima = $prima / 12;
                }

                $criterio = "Contrato:equals:" . $contrato->getEntityId();
                $num_pagina = 1;
                do {
                    $retringidos = $api->buscar_criterio("Restringidos", $criterio, $num_pagina, 200);
                    if (!empty($retringidos)) {
                        $num_pagina++;

                        foreach ($retringidos as $retringido) {
                            if (!empty($retringido->getFieldValue('Modelo'))) {
                                if ($retringido->getFieldValue('Modelo')->getEntityId() ==  $_POST["modelo"]) {
                                    $prima = 0;
                                }
                            } elseif ($retringido->getFieldValue('Marca')->getEntityId() ==  $_POST["marca"]) {
                                $prima = 0;
                            }
                        }
                    } else {
                        $num_pagina = 0;
                    }
                } while ($num_pagina > 0);

                if (in_array($_POST["uso"], $contrato->getFieldValue('Veh_culos_de_uso'))) {
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

            $nueva_cotizacion["Subject"] = "Plan " . $_POST["tipo_plan"] . " Auto";
            $nueva_cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
            $nueva_cotizacion["Quote_Stage"] = "En espera";
            $nueva_cotizacion["Tipo"] = "Auto";
            $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
            $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
            $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
            $nueva_cotizacion["Tipo_P_liza"] = $_POST["tipo_poliza"];
            $nueva_cotizacion["Plan"] = $_POST["tipo_plan"];
            $nueva_cotizacion["Marca"] = $_POST["marca"];
            $nueva_cotizacion["Modelo"] = $_POST["modelo"];
            $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
            $nueva_cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
            $nueva_cotizacion["Uso_Veh_culo"] =  $_POST["uso"];
            $nueva_cotizacion["Veh_culo_Nuevo"] = (isset($_POST["estado"])) ? true : false;
            $nueva_cotizacion["Tipo_Veh_culo"] =  $modelo->getFieldValue("Tipo");
            $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);

            header("Location:" . constant("url") . "cotizaciones/detalles_auto/$nuevo_cotizacion_id");
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/crear_auto.php";
        require_once "views/layout/footer_main.php";
    }

    public function detalles_auto()
    {
        $api = new api;
        $url = $this->obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $home = new home;
            $home->error();
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/detalles_auto.php";
        require_once "views/layout/footer_main.php";
    }

    public function descargar_auto()
    {
        $api = new api;
        $url = $this->obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $home = new home;
            $home->error();
            exit();
        }

        require_once "views/cotizaciones/descargar_auto.php";
    }

    public function emitir_auto()
    {
        $api = new api;
        $url = $this->obtener_url();

        if (!isset($url[0])) {
            $home = new home;
            $home->error();
            exit();
        }

        $id = $url[0];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue("Deal_Name") != null) {
            $home = new home;
            $home->error();
            exit();
        }

        if (
            date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= date("Y-m-d")
            and
            date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))  <= date("Y-m-d")
        ) {
            header("Location:" . constant("url") . "cotizaciones/detalles_auto/$id/No se puede emitir, la cotizacion esta vencida.");
            exit();
        }

        if ($_POST) {

            if (!empty($_FILES["cotizacion_firmada"]["name"])) {
                $ruta = "public/tmp";
                if (!is_dir($ruta)) {
                    mkdir($ruta, 0755, true);
                }

                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                $permitido = array("pdf");
                if (!in_array($extension, $permitido)) {
                    $alerta = "Para emitir solo se admiten documentos PDF.";
                } else {
                    $planes = $cotizacion->getLineItems();
                    foreach ($planes as $plan) {
                        if ($plan->getDescription() == $_POST["aseguradora"]) {
                            $plan_id = $plan->getProduct()->getEntityId();
                            $prima = $plan->getNetTotal();
                            $prima_neta = $plan->getListPrice();
                            $isc = $plan->getTaxAmount();
                        }
                    }


                    $plan_detalles = $api->detalles_registro("Products", $plan_id);


                    $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                    $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 10);
                    foreach ($contratos as $contrato) {
                        if ($contrato->getFieldValue("Aseguradora")->getEntityId() == $plan_detalles->getFieldValue("Vendor_Name")->getEntityId()) {
                            $poliza = $contrato->getFieldValue('No_P_liza');
                            $comision_nobe = $prima * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                            $comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                            $comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                            $contrato_id = $contrato->getEntityId();
                        }
                    }


                    if (empty($_POST["cliente_id"])) {
                        $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
                        $cliente_nuevo["Aseguradora"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                        $cliente_nuevo["Informar_a"] = $_SESSION["usuario"]['id'];
                        $cliente_nuevo["Socio"] = $_SESSION["usuario"]['empresa_id'];
                        $cliente_nuevo["Direcci_n"] = (isset($_POST["direccion"])) ? $_POST["direccion"] : null;
                        $cliente_nuevo["Name"] = $_POST["nombre"];
                        $cliente_nuevo["Apellido"] = (isset($_POST["apellido"])) ? $_POST["apellido"] : null;
                        $cliente_nuevo["Tel"] = (isset($_POST["telefono"])) ? $_POST["telefono"] : null;
                        $cliente_nuevo["Tel_Residencia"] = (isset($_POST["tel_residencia"])) ? $_POST["tel_residencia"] : null;
                        $cliente_nuevo["Tel_Trabajo"] = (isset($_POST["tel_trabajo"])) ? $_POST["tel_trabajo"] : null;
                        $cliente_nuevo["Fecha_de_Nacimiento"] = $_POST["fecha_nacimiento"];
                        $cliente_nuevo["Email"] = (isset($_POST["correo"])) ? $_POST["correo"] : null;

                        $cliente_nuevo_id = $api->crear_registro("Clientes", $cliente_nuevo);
                    } else {
                        $cliente_nuevo_id =  $_POST["cliente_id"];
                    }


                    $poliza_nueva["Name"] = $poliza;
                    $poliza_nueva["Estado"] =  true;
                    $poliza_nueva["Plan"] =  $cotizacion->getFieldValue('Plan');
                    $poliza_nueva["Aseguradora"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
                    $poliza_nueva["Prima"] =  round($prima, 2);
                    $poliza_nueva["Propietario"] =  $cliente_nuevo_id;
                    $poliza_nueva["Ramo"] = "Automóvil";
                    $poliza_nueva["Socio"] =  $_SESSION["usuario"]['empresa_id'];
                    $poliza_nueva["Tipo"] =  $cotizacion->getFieldValue('Tipo_P_liza');
                    $poliza_nueva["Valor_Aseguradora"] =   $cotizacion->getFieldValue('Valor_Asegurado');
                    $poliza_nueva["Vigencia_desde"] =  date("Y-m-d");
                    $poliza_nueva["Vigencia_hasta"] =  date("Y-m-d",  strtotime(date("Y-m-d") . "+ 1 years"));

                    $poliza_nueva_id = $api->crear_registro("P_lizas", $poliza_nueva);


                    $nuevo_bien["A_o"] = $cotizacion->getFieldValue('A_o_Fabricaci_n');
                    $nuevo_bien["Chasis"] = $_POST["chasis"];
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

                    $nuevo_bien_id = $api->crear_registro("Bienes", $nuevo_bien);


                    $nuevo_trato["Deal_Name"] = "Plan " . $cotizacion->getFieldValue('Plan') . " Auto";
                    $nuevo_trato["Contact_Name"] = $_SESSION["usuario"]['id'];
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
                    $nuevo_trato_id = $api->crear_registro("Deals", $nuevo_trato);

                    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                    $name = basename($_FILES["cotizacion_firmada"]["name"]);
                    move_uploaded_file($tmp_name, "$ruta/$name");
                    $api->adjuntar_archivo("Deals", $nuevo_trato_id, "$ruta/$name");
                    unlink("$ruta/$name");

                    $cambios_cotizacion["Quote_Stage"] =  "Confirmada";
                    $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;
                    $api->guardar_cambios_registro("Quotes", $id, $cambios_cotizacion);

                    header("Location:" . constant("url") . "tratos/detalles_auto/" . $nuevo_trato_id);
                    exit();
                }
            }
        }

        require_once "views/layout/header_main.php";
        require_once "views/cotizaciones/emitir_auto.php";
        require_once "views/layout/footer_main.php";
    }
}
