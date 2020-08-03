<?php

class auto extends cotizaciones
{
    function crear()
    {
        $api = new api;

        if ($_POST) {
            $modelo = $api->detalles_registro("Modelos", $_POST["modelo"]);

            $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
            $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 200);
            foreach ($contratos as $contrato) {
                $prima = 0;

                $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                $planes = $api->buscar_criterio("Products", $criterio, 1, 2);
                foreach ($planes as $plan) {

                    if (
                        $_POST["tipo_plan"] == "full"
                        and
                        $plan->getFieldValue('Product_Category') == "Plan Full"
                    ) {
                        $plan_id = $plan->getEntityId();
                    } elseif (
                        $_POST["tipo_plan"] == "ley"
                        and
                        $plan->getFieldValue('Product_Category') == "Plan Ley"
                    ) {
                        $prima = $plan->getFieldValue('Unit_Price');
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

            $nueva_cotizacion["Subject"] = "Plan " . ucfirst($_POST["facturacion"]) . " " . ucfirst($_POST["tipo_plan"]);
            $nueva_cotizacion["Quote_Stage"] = "Cotizando";
            $nueva_cotizacion["Tipo"] = "Auto";
            $nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
            $nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $nueva_cotizacion["Fecha_emisi_n"] =  date("Y-m-d");
            $nueva_cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
            $nueva_cotizacion["Tipo_P_liza"] = "";
            $nueva_cotizacion["Plan"] = ucfirst($_POST["tipo_plan"]);
            $nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
            $nueva_cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
            $nueva_cotizacion["Marca"] = $_POST["marca"];
            $nueva_cotizacion["Modelo"] = $_POST["modelo"];
            $nueva_cotizacion["Uso_Veh_culo"] =  $_POST["uso"];
            $nueva_cotizacion["Veh_culo_Nuevo"] = (!empty($_POST["estado"])) ? true : false;
            $nueva_cotizacion["Tipo_Veh_culo"] =  $modelo->getFieldValue("Tipo");
            $nuevo_cotizacion_id = $api->crear_registro("Quotes", $nueva_cotizacion, $plan_seleccionado);

            header("Location:" . constant("url") . "auto/detalles/$nuevo_cotizacion_id");
            exit();
        }

        require_once "views/layout/header_main.php";
        require_once "views/auto/crear.php";
        require_once "views/layout/footer_main.php";
    }

    public function extracto()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[2])) {
            require_once "views/error.php";
            exit();
        }

        $id = $url[2];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
        $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue('P_liza')->getEntityId());
        $imagen_aseguradora = $api->obtener_imagen("Vendors", $poliza->getFieldValue('Aseguradora')->getEntityId(), "public/img");

        require_once "views/auto/extracto.php";
    }

    public function emitir()
    {
        $api = new api;
        $url = obtener_url();

        if (!isset($url[2])) {
            require_once "views/error.php";
            exit();
        }

        $id = $url[2];
        $cotizacion = $api->detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
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
                    $poliza_nueva["Plan"] =  $cotizacion->getFieldValue('Plan');
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

                    $cambios_cotizacion["Quote_Stage"] =  "Emitida";
                    $cambios_cotizacion["Deal_Name"] = $nuevo_trato_id;

                    $plan_seleccionado[] = array(
                        "id" => $plan_id,
                        "prima" => $prima,
                        "cantidad" => 1,
                        "descripcion" => $plan_detalles->getFieldValue("Vendor_Name")->getEntityId(),
                        "impuesto" => "ITBIS 16",
                        "impuesto_valor" => 16
                    );

                    $api->guardar_cambios_registro("Quotes", $id, $cambios_cotizacion,$plan_seleccionado);

                    header("Location:" . constant("url") . "auto/detalles/$id/Póliza emitida, descargue para obtener el carnet");
                    exit();
                }
            }
        }

        require_once "views/layout/header_main.php";
        require_once "views/auto/emitir.php";
        require_once "views/layout/footer_main.php";
    }
}
