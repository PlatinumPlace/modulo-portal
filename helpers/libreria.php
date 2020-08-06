<?php

function obtener_url()
{
    $url = rtrim($_GET['url'], "/");
    $url = explode('/', $url);

    $result = array();

    foreach ($url as $posicion => $valor) {
        if ($posicion > 1) {
            $result[] = $valor;
        }
    }

    return $result;
}

function calcular_edad($fecha)
{
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}

function verificar_token()
{
    if (!file_exists("php_sdk/zcrm_oauthtokens.txt") or filesize("php_sdk/zcrm_oauthtokens.txt") == 0) {
        require_once 'php_sdk/token.php';
        exit();
    }
}

function verificar_sesion()
{
    session_start();

    if (!isset($_SESSION["usuario"])) {
        require_once "controllers/contactos.php";
        $contactos = new contactos;
        $contactos->iniciar_sesion();
        exit();
    } else {
        if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
            session_destroy();
            header("Location:" . constant("url"));
            exit();
        }
    }
    $_SESSION["usuario"]["tiempo_activo"] = time();
}

function buscar_controlador()
{
    include "controllers/cotizaciones.php";
    $cotizaciones = new cotizaciones;

    if (isset($_GET['url'])) {

        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);

        if (isset($url[0]) and isset($url[1])) {
            $ubicacion_archivo = "controllers/" . $url[0] . ".php";
            if (file_exists($ubicacion_archivo)) {
                require_once $ubicacion_archivo;
                $controlador = new $url[0];

                if (method_exists($controlador, $url[1])) {
                    $controlador->{$url[1]}();
                } else {
                    require_once "views/error.php";
                }
            } else {
                require_once "views/error.php";
            }
        } else {
            require_once "views/error.php";
        }
    } else {
        $cotizaciones->inicio();
    }
}

function crear_cotizacion_auto($api)
{
    $modelo = $api->detalles_registro("Modelos", $_POST["modelo"]);

    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
    $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);
    foreach ($contratos as $contrato) {
        $prima = 0;

        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $api->buscar_criterio("Products", $criterio, 1, 2);
        foreach ($planes as $plan) {
            if ($plan->getFieldValue('Product_Category') == "Plan " . $_POST["tipo_plan"]) {
                $plan_id = $plan->getEntityId();
                $prima = $plan->getFieldValue('Unit_Price');
            }
        }

        if ($prima == 0) {
            $criterio = "Contrato:equals:" . $contrato->getEntityId();

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
                    if (
                        (in_array($modelo->getFieldValue("Tipo"), $recargo->getFieldValue('Grupo_de_veh_culo'))
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
            }

            if (!empty($recargo_valor)) {
                $tasa_valor = $tasa_valor + (($tasa_valor * $recargo_valor) / 100);
            }

            $prima = $_POST["valor"] * $tasa_valor / 100;

            if ($prima > 0 and $prima < $contrato->getFieldValue('Prima_M_nima')) {
                $prima = $contrato->getFieldValue('Prima_M_nima');
            }
        }

        if ($prima > 0 and $_POST["facturacion"] == "mensual") {
            $prima = $prima / 12;
        }

        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $num_pagina = 1;
        do {
            $retringidos = $api->buscar_criterio("Restringidos", $criterio, $num_pagina, 200);
            if (!empty($retringidos)) {
                $num_pagina++;

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

    $nueva_cotizacion["Subject"] = "Plan " . $_POST["facturacion"] . " " . $_POST["tipo_plan"];
    $nueva_cotizacion["Quote_Stage"] = "Cotizando";
    $nueva_cotizacion["Tipo"] = "Auto";
    $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
    $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
    $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
    $nueva_cotizacion["Tipo_P_liza"] = "Declarativa";
    $nueva_cotizacion["Plan"] = $_POST["tipo_plan"];
    $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];

    $nueva_cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
    $nueva_cotizacion["Nombre"] = $_POST["nombre"];
    $nueva_cotizacion["Apellido"] = $_POST["apellido"];
    $nueva_cotizacion["Direcci_n"] = $_POST["direccion"];
    $nueva_cotizacion["Tel_Celular"] = $_POST["telefono"];
    $nueva_cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
    $nueva_cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
    $nueva_cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
    $nueva_cotizacion["Correo"] = $_POST["correo"];

    $nueva_cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
    $nueva_cotizacion["Marca"] = $_POST["marca"];
    $nueva_cotizacion["Modelo"] = $_POST["modelo"];
    $nueva_cotizacion["Uso_Veh_culo"] =  $_POST["uso"];
    $nueva_cotizacion["Estado_Veh_culo"] = (!empty($_POST["estado"])) ? true : false;
    $nueva_cotizacion["Tipo_Veh_culo"] =  $modelo->getFieldValue("Tipo");

    $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);
    header("Location:" . constant("url") . "cotizaciones/detalles/$nuevo_cotizacion_id");
    exit();
}

function reporte_pendientes($api)
{
    $titulo = "Reporte Pendientes" . $_POST["tipo_cotizacion"];

    $contenido_csv = array(
        array($_SESSION["usuario"]['empresa_nombre']),
        array($titulo),
        array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
        array("Vendedor:", $_SESSION["usuario"]['nombre']),
        array("")
    );

    switch ($_POST["tipo_cotizacion"]) {
        case 'Auto':
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
    }

    $prima_sumatoria = 0;
    $valor_sumatoria = 0;
    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
    $cotizaciones = $api->buscar_criterio("Quotes", $criterio, 1, 200);

    if (!empty($cotizaciones)) {
        foreach ($cotizaciones as $cotizacion) {
            if (
                date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  >= $_POST["desde"]
                and
                date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  <= $_POST["hasta"]
                and
                $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"]
            ) {
                $planes = $cotizacion->getLineItems();
                foreach ($planes as $plan) {
                    if (
                        $plan->getNetTotal() > 0
                        and
                        (empty($_POST["aseguradora"])) or $_POST["aseguradora"] == $plan->getDescription()
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
        }
    } else {
        return "No existen resultados";
    }

    $contenido_csv[] = array("");
    $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2));
    $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2));

    $ruta_csv = "public/tmp/" . $titulo . ".csv";

    if ($valor_sumatoria > 0) {
        if (!is_dir("public/tmp")) {
            mkdir("public/tmp", 0755, true);
        }

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
        return 'No se encontraton resultados';
    }
}

function reporte_emitidos($api)
{
    $titulo = "Reporte Emitidos" . $_POST["tipo_cotizacion"];

    $contenido_csv = array(
        array($_SESSION["usuario"]['empresa_nombre']),
        array($titulo),
        array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
        array("Vendedor:", $_SESSION["usuario"]['nombre']),
        array("")
    );

    switch ($_POST["tipo_cotizacion"]) {
        case 'Auto':
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

    $prima_sumatoria = 0;
    $valor_sumatoria = 0;
    $comision_sumatoria = 0;
    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
    $cotizaciones = $api->buscar_criterio("Quotes", $criterio, 1, 200);

    if (!empty($cotizaciones)) {
        foreach ($cotizaciones as $cotizacion) {
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
                        (empty($_POST["aseguradora"])) or $_POST["aseguradora"] == $plan->getDescription()
                    ) {
                        switch ($_POST["tipo_cotizacion"]) {
                            case 'Auto':
                                $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());

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
        }
    } else {
        return "No existen resultados";
    }

    $contenido_csv[] = array("");
    $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2));
    $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2));
    $contenido_csv[] = array("Total Comisiones:", number_format($comision_sumatoria, 2));

    $ruta_csv = "public/tmp/" . $titulo . ".csv";

    if ($valor_sumatoria > 0) {
        if (!is_dir("public/tmp")) {
            mkdir("public/tmp", 0755, true);
        }

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
        return 'No se encontraton resultados';
    }
}


function adjuntar_documentos_cotizacion($id_trato, $id_cotizacion, $api)
{
    $ruta = "public/tmp";
    if (!is_dir($ruta)) {
        mkdir($ruta, 0755, true);
    }

    foreach ($_FILES["documentos"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
            $name = basename($_FILES["documentos"]["name"][$key]);
            move_uploaded_file($tmp_name, "$ruta/$name");
            $api->adjuntar_archivo("Deals", $id_trato, "$ruta/$name");
            unlink("$ruta/$name");
        }
    }

    header("Location:" . constant("url") . "cotizaciones/detalles/$id_cotizacion/Documentos Adjuntados.");
    exit();
}

function emitir_auto($cotizacion, $api)
{
    $ruta = "public/tmp";
    if (!is_dir($ruta)) {
        mkdir($ruta, 0755, true);
    }

    $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
    $permitido = array("pdf");
    if (!in_array($extension, $permitido)) {
        return "Para emitir solo se admiten documentos PDF.";
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

        $cliente_nuevo["Vendor_Name"] =  $plan_detalles->getFieldValue("Vendor_Name")->getEntityId();
        $cliente_nuevo["Reporting_To"] = $_SESSION["usuario"]['id'];
        $cliente_nuevo["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cliente_nuevo["Mailing_Street"] = (!empty($_POST["direccion"])) ? $_POST["direccion"] : null;
        $cliente_nuevo["First_Name"] = $_POST["nombre"];
        $cliente_nuevo["Last_Name"] = (!empty($_POST["apellido"])) ? $_POST["apellido"] : null;
        $cliente_nuevo["Mobile"] = (!empty($_POST["telefono"])) ? $_POST["telefono"] : null;
        $cliente_nuevo["Phone"] = (!empty($_POST["tel_residencia"])) ? $_POST["tel_residencia"] : null;
        $cliente_nuevo["Tel_Trabajo"] = (!empty($_POST["tel_trabajo"])) ? $_POST["tel_trabajo"] : null;
        $cliente_nuevo["Date_of_Birth"] = $_POST["fecha_nacimiento"];
        $cliente_nuevo["Email"] = (!empty($_POST["correo"])) ? $_POST["correo"] : null;
        $cliente_nuevo["RNC_C_dula"] = $_POST["rnc_cedula"];
        $cliente_nuevo["Tipo"] = "Cliente";

        $cliente_nuevo_id = $api->crear_registro("Contacts", $cliente_nuevo);


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

        $poliza_nueva_id = $api->crear_registro("P_lizas", $poliza_nueva);


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

        $nuevo_bien_id = $api->crear_registro("Bienes", $nuevo_bien);


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
        $nuevo_trato_id = $api->crear_registro("Deals", $nuevo_trato);

        $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
        $name = basename($_FILES["cotizacion_firmada"]["name"]);
        move_uploaded_file($tmp_name, "$ruta/$name");
        $api->adjuntar_archivo("Deals", $nuevo_trato_id, "$ruta/$name");
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

        $api->guardar_cambios_registro("Quotes", $cotizacion->getEntityId(), $cambios_cotizacion, $plan_seleccionado);

        header("Location:" . constant("url") . "cotizaciones/detalles/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
        exit();
    }
}

function crear_cotizacion_vida($api)
{
    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Vida))";
    $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);

    $edad_deudor = calcular_edad($_POST["fecha_nacimiento"]);
    $edad_codeudor = (!empty($_POST["fecha_codeudor"])) ?  calcular_edad($_POST["fecha_codeudor"]) : null;

    foreach ($contratos as $contrato) {
        $prima = 0;

        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $api->buscar_criterio("Products", $criterio, 1, 2);
        foreach ($planes as $plan) {
            if ($plan->getFieldValue('Product_Category') == "Plan Vida") {
                $plan_id = $plan->getEntityId();
            }
        }

        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $api->buscar_criterio("Tasas", $criterio, 1, 200);
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

    $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);

    header("Location:" . constant("url") . "cotizaciones/detalles/$nuevo_cotizacion_id");
    exit();
}

function crear_cotizacion_desempleo($api)
{
    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Desempleo))";
    $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);

    foreach ($contratos as $contrato) {
        $prima = 0;

        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $api->buscar_criterio("Products", $criterio, 1, 2);
        foreach ($planes as $plan) {
            if ($plan->getFieldValue('Product_Category') == "Plan Vida") {
                $plan_id = $plan->getEntityId();
            }
        }

        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $api->buscar_criterio("Tasas", $criterio, 1, 200);
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

    $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);

    header("Location:" . constant("url") . "cotizaciones/detalles/$nuevo_cotizacion_id");
    exit();
}

function crear_cotizacion_incendio($api)
{
    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Incendio))";
    $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);

    foreach ($contratos as $contrato) {
        $prima = 0;

        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $api->buscar_criterio("Products", $criterio, 1, 2);
        foreach ($planes as $plan) {
            if ($plan->getFieldValue('Product_Category') == "Plan Vida") {
                $plan_id = $plan->getEntityId();
            }
        }

        $criterio = "Contrato:equals:" . $contrato->getEntityId();
        $tasas = $api->buscar_criterio("Tasas", $criterio, 1, 200);
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

    $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);

    header("Location:" . constant("url") . "cotizaciones/detalles/$nuevo_cotizacion_id");
    exit();
}
