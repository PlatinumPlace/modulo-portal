<?php

class portal
{

    function error()
    {
        require_once "pages/layout/header.php";
        require_once "pages/error.php";
        require_once "pages/layout/footer.php";
    }

    function iniciar_sesion()
    {
        if ($_POST) {
            $criterio = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
            $lista_usuarios = lista_filtrada_registros("Contacts", $criterio);
            foreach ($lista_usuarios as $usuario) {
                if ($usuario->getFieldValue("Estado") == true) {
                    $_SESSION["usuario"]['id'] = $usuario->getEntityId();
                    $_SESSION["usuario"]['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                    $_SESSION["usuario"]['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();
                    $_SESSION["usuario"]['empresa_nombre'] = $usuario->getFieldValue("Account_Name")->getLookupLabel();
                    $_SESSION["usuario"]['tiempo_activo'] = time();
                }
            }

            if (isset($_SESSION["usuario"])) {
                header("Location:" . constant("url"));
                exit();
            } else {
                $alerta = "Usuario o contraseña incorrectos";
            }
        }

        require_once "pages/layout/header.php";
        require_once "pages/usuarios/index.php";
        require_once "pages/layout/footer.php";
    }

    function cerrar_sesion()
    {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }

    function inicio()
    {
        $cotizaciones_total = 0;
        $cotizaciones_emitidas = 0;
        $cotizaciones_vencidas = 0;
        $aseguradoras = array();
        $num_pagina = 1;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

        do {
            $lista_cotizaciones = lista_filtrada_registros("Quotes", $criterio, $num_pagina);
            if (!empty($lista_cotizaciones)) {
                $num_pagina++;

                foreach ($lista_cotizaciones as $cotizacion) {
                    $cotizaciones_total += 1;

                    if (
                        $cotizacion->getFieldValue("Deal_Name") != null
                        and
                        date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')
                    ) {
                        $cotizaciones_emitidas += 1;

                        $aseguradoras[] = $cotizacion->getFieldValue('Aseguradora')->getLookupLabel();
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

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/index.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function buscar()
    {
        $url = obtener_url();
        $filtro = (isset($url[1])) ? $url[1] : "todos";
        $num_pagina = (isset($url[2])) ? $url[2] : 1;

        if ($_POST) {
            $criterio = "((Contact_Name:equals:" . $_SESSION["usuario"]["id"] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        }

        $lista_cotizaciones = lista_filtrada_registros("Quotes", $criterio, $num_pagina, 20);

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/buscar.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function crear()
    {
        $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
        $contratos = lista_filtrada_registros("Contratos", $criterio);

        foreach ($contratos as $contrato) {
            if ($contrato->getFieldValue('Tipo') == "Auto") {
                $auto = true;
            } elseif ($contrato->getFieldValue('Tipo') == "Vida") {
                $vida = true;
            } elseif ($contrato->getFieldValue('Tipo') == "Incendio") {
                $incendio = true;
            }
        }

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/crear.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function crear_vida()
    {
        if ($_POST) {
            $edad_deudor = calcular_edad($_POST["fecha_nacimiento"]);
            $edad_codeudor = (!empty($_POST["fecha_codeudor"])) ?  calcular_edad($_POST["fecha_codeudor"]) : null;
            $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Vida))";
            $contratos = lista_filtrada_registros("Contratos", $criterio);

            foreach ($contratos as $contrato) {
                $prima = 0;

                $criterio = "((Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId() . ") and (Product_Category:equals:Plan Vida))";
                $planes = lista_filtrada_registros("Products", $criterio);

                foreach ($planes as $plan) {
                    $plan_id = $plan->getEntityId();
                }

                $criterio = "Contrato:equals:" . $contrato->getEntityId();
                $tasas = lista_filtrada_registros("Tasas", $criterio);

                foreach ($tasas as $tasa) {
                    switch ($tasa->getFieldValue('Tipo')) {
                        case 'Deudor':
                            $tasa_deudor = $tasa->getFieldValue('Valor');
                            break;

                        case 'Codeudor':
                            $tasa_codeudor = $tasa->getFieldValue('Valor');
                            break;

                        case 'Vida':
                            $tasa_vida = $tasa->getFieldValue('Valor');
                            break;

                        case 'Desempleo':
                            $tasa_desempleo = $tasa->getFieldValue('Valor');
                            break;
                    }
                }

                if (!empty($_POST["desempleo"]) and !empty($_POST["cuota"])) {
                    $prima = calcular_prima_vida_desempleo($prima, $tasa_vida, $tasa_desempleo);
                } else {
                    $prima = calcular_prima_vida($prima, $tasa_deudor, $tasa_codeudor);
                }

                $planes_seleccionados[] = array(
                    "id" => $plan_id,
                    "prima" => $prima,
                    "descripcion" => $contrato->getEntityId()
                );
            }

            $id = crear_cotizacion_vida($planes_seleccionados);
            header("Location:" . constant("url") . "detalles_vida/$id");
            exit();
        }

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/vida/crear.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function crear_auto()
    {
        if ($_POST) {
            $marca = detalles_registro("Marcas", $_POST["marca"]);
            $modelo = detalles_registro("Modelos", $_POST["modelo"]);
            $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
            $contratos = lista_filtrada_registros("Contratos", $criterio);
            foreach ($contratos as $contrato) {
                $prima = 0;
                $contrato_id = $contrato->getEntityId();

                $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
                $planes = lista_filtrada_registros("Products", $criterio);

                foreach ($planes as $plan) {
                    if (
                        $_POST["tipo_plan"] == "Ley"
                        and
                        $plan->getFieldValue('Product_Category') == "Plan Ley"
                    ) {
                        $prima = $plan->getFieldValue('Unit_Price');
                        $plan_id = $plan->getEntityId();
                    } elseif ($plan->getFieldValue('Product_Category') == "Plan Full") {
                        $prima = calcular_prima_auto($contrato, $modelo->getFieldValue("Tipo"));
                        $plan_id = $plan->getEntityId();
                    }
                }

                if ($_POST["facturacion"] == "Mensual") {
                    $prima = $prima / 12;
                }

                $prima = verificar_restringido_auto($prima, $contrato->getFieldValue('Aseguradora')->getLookupLabel(), $marca, $modelo);

                $planes_seleccionados[] = array(
                    "id" => $plan_id,
                    "prima" => $prima,
                    "descripcion" => $contrato->getEntityId()
                );
            }

            $id = crear_cotizacion_auto($planes_seleccionados, $modelo->getFieldValue('Tipo'));
            header("Location:" . constant("url") . "detalles_auto/$id");
            exit();
        }

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/auto/crear.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function detalles_vida()
    {
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $alerta = (isset($url[2]) and !is_numeric($url[2])) ? $url[2] : null;

        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            $alerta = "Cotización Vencida.";
        }

        if (isset($url[2]) and isset($url[3]) and is_numeric($url[2]) and is_numeric($url[3])) {
            $documento = descargar_adjunto("Contratos", $url[2], $url[3]);
            $fileName = basename($documento);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: ');
            header('Content-Length: ' . filesize($documento));
            readfile($documento);
            unlink($documento);
            exit();
        }

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/vida/detalles.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function detalles_auto()
    {
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $alerta = (isset($url[2]) and !is_numeric($url[2])) ? $url[2] : null;

        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            $alerta = "Cotización Vencida.";
        }

        if (isset($url[2]) and isset($url[3]) and is_numeric($url[2]) and is_numeric($url[3])) {
            $documento = descargar_adjunto("Contratos", $url[2], $url[3]);
            $fileName = basename($documento);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: ');
            header('Content-Length: ' . filesize($documento));
            readfile($documento);
            unlink($documento);
            exit();
        }

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/auto/detalles.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function emitir_auto()
    {
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $alerta = (isset($url[2])) ? $url[2] : null;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (
            date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))
            or $cotizacion->getFieldValue("Deal_Name") != null
        ) {
            header("Location:" . constant("url") . "detalles_auto/$id");
            exit();
        }

        if ($_POST) {
            $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
            $permitido = array("pdf");

            if (!in_array($extension, $permitido)) {
                $alerta = "Para emitir solo se admiten documentos PDF";
            } else {
                $planes = $cotizacion->getLineItems();
                foreach ($planes as $plan) {
                    if ($plan->getId() == $_POST["aseguradora"]) {
                        $prima_total = $plan->getNetTotal();
                        $prima_neta = $plan->getListPrice();
                        $contrato_id = $plan->getDescription();
                    }
                }

                $contrato = detalles_registro("Contratos", $contrato_id);
                $poliza = $contrato->getFieldValue('No_P_liza');
                $comision_nobe = $prima_total * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                $comision_aseguradora = $prima_total * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                $comision_socio = $prima_total * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                $contrato_id = $contrato->getEntityId();

                $cliente_nuevo["Vendor_Name"] = $contrato->getFieldValue("Aseguradora")->getEntityId();
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
                $cliente_nuevo_id = crear_registro("Contacts", $cliente_nuevo);

                $poliza_nueva["Name"] = $poliza;
                $poliza_nueva["Estado"] = true;
                $poliza_nueva["Plan"] = $cotizacion->getFieldValue('Subject');
                $poliza_nueva["Aseguradora"] = $contrato->getFieldValue("Aseguradora")->getEntityId();
                $poliza_nueva["Prima"] = round($prima_total, 2);
                $poliza_nueva["Deudor"] = $cliente_nuevo_id;
                $poliza_nueva["Ramo"] = "Automóvil";
                $poliza_nueva["Socio"] = $_SESSION["usuario"]['empresa_id'];
                $poliza_nueva["Tipo"] = "Declarativa";
                $poliza_nueva["Valor_Aseguradora"] = $cotizacion->getFieldValue('Valor_Asegurado');
                $poliza_nueva["Vigencia_desde"] = date("Y-m-d");
                $poliza_nueva["Vigencia_hasta"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
                $poliza_nueva["Informar_a"] = $_SESSION["usuario"]['id'];
                $poliza_nueva_id = crear_registro("P_lizas", $poliza_nueva);

                $nuevo_bien["A_o"] = $cotizacion->getFieldValue('A_o_Fabricaci_n');
                $nuevo_bien["Color"] = $_POST["color"];
                $nuevo_bien["Marca"] = $cotizacion->getFieldValue('Marca')->getLookupLabel();
                $nuevo_bien["Modelo"] = $cotizacion->getFieldValue('Modelo')->getLookupLabel();
                $nuevo_bien["Name"] = $_POST["chasis"];
                $nuevo_bien["Placa"] = $_POST["placa"];
                $nuevo_bien["Uso"] = $_POST["uso"];
                $nuevo_bien["Condicion"] = (!empty($_POST["estado"])) ? "Nuevo" : "Usado";
                $nuevo_bien["P_liza"] = $poliza_nueva_id;
                $nuevo_bien["Tipo"] = "Automóvil";
                $nuevo_bien["Tipo_de_veh_culo"] = $cotizacion->getFieldValue('Tipo_Veh_culo');
                $nuevo_bien_id = crear_registro("Bienes", $nuevo_bien);

                $nuevo_trato["Deal_Name"] = $cotizacion->getFieldValue('Subject');
                $nuevo_trato["Contact_Name"] = $cliente_nuevo_id;
                $nuevo_trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
                $nuevo_trato["Stage"] = "En trámite";
                $nuevo_trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"));
                $nuevo_trato["Type"] = "Auto";
                $nuevo_trato["P_liza"] = $poliza_nueva_id;
                $nuevo_trato["Bien"] = $nuevo_bien_id;
                $nuevo_trato["Cliente"] = $cliente_nuevo_id;
                $nuevo_trato["Contrato"] = $contrato_id;
                $nuevo_trato["Comisi_n_Aseguradora"] = round($comision_aseguradora, 2);
                $nuevo_trato["Comisi_n_Socio"] = round($comision_socio, 2);
                $nuevo_trato["Amount"] = round($comision_nobe, 2);
                $nuevo_trato["Lead_Source"] = "Portal";
                $nuevo_trato_id = crear_registro("Deals", $nuevo_trato);

                emitir_cotizacion_auto(
                    $id,
                    $prima_neta,
                    $contrato_id,
                    $nuevo_trato_id,
                    $contrato->getFieldValue("Aseguradora")->getEntityId()
                );

                $ruta = "public/path";
                $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                $name = basename($_FILES["cotizacion_firmada"]["name"]);
                move_uploaded_file($tmp_name, "$ruta/$name");
                adjuntar_registro("Deals", $nuevo_trato_id, "$ruta/$name");
                unlink("$ruta/$name");

                header("Location:" . constant("url") . "detalles_auto/" . $cotizacion->getEntityId() . "/Póliza emitida, descargue para obtener el carnet");
                exit();
            }
        }

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/auto/emitir.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function descargar_vida()
    {
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "detalles_auto/$id");
            exit();
        }

        if ($cotizacion->getFieldValue("Deal_Name") != null) {
            $imagen_aseguradora = obtener_imagen_registro("Vendors", $cotizacion->getFieldValue("Aseguradora")->getEntityId());
        }

        require_once "pages/layout/header.php";
        require_once "pages/cotizaciones/vida/descargar.php";
        require_once "pages/layout/footer.php";
    }

    function descargar_auto()
    {
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "detalles_auto/$id");
            exit();
        }

        if ($cotizacion->getFieldValue("Deal_Name") != null) {
            $trato = detalles_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
            $cliente = detalles_registro("Contacts", $trato->getFieldValue("Contact_Name")->getEntityId());
            $bien = detalles_registro("Bienes", $trato->getFieldValue("Bien")->getEntityId());
            $coberturas = detalles_registro("Contratos", $trato->getFieldValue("Contrato")->getEntityId());
            $aseguradora = detalles_registro("Vendors", $cotizacion->getFieldValue("Aseguradora")->getEntityId());
            $imagen_aseguradora = obtener_imagen_registro("Vendors", $cotizacion->getFieldValue("Aseguradora")->getEntityId());
        }

        require_once "pages/layout/header.php";

        if ($cotizacion->getFieldValue("Deal_Name") == null) {
            require_once "pages/cotizaciones/auto/descargar_cotizando.php";
        } else {
            require_once "pages/cotizaciones/auto/descargar_emitido.php";
        }

        require_once "pages/layout/footer.php";
    }

    function emitir()
    {
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue('Deal_Name') != null) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "detalles/$id");
            exit();
        }
        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        switch ($cotizacion->getFieldValue('Plan')) {
            case "Full":
                if ($cotizacion->getFieldValue("Deal_Name") != null) {
                    require_once "pages/emitir/auto.php";
                } else {
                    require_once "pages/emitir/auto.php";
                }
                break;

            case "Ley":
                if ($cotizacion->getFieldValue("Deal_Name") != null) {
                    require_once "pages/emitir/auto.php";
                } else {
                    require_once "pages/emitir/auto.php";
                }
                break;
        }
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }

    function adjuntar()
    {
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $alerta = (isset($url[2]) and !is_numeric($url[2])) ? $url[2] : null;
        $num_pagina = (isset($url[2])) ? $url[2] : 1;
        $cotizacion = detalles_registro("Quotes", $id);

        if (empty($cotizacion)) {
            $this->error();
            exit();
        }

        if ($cotizacion->getFieldValue("Deal_Name") == null) {
            header("Location:" . constant("url") . "detalles_auto/$id");
            exit();
        }

        $documentos_adjuntos = lista_adjuntos("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());

        switch ($cotizacion->getFieldValue('Plan')) {
            case 'Full':
                $tipo = "auto";
                break;

            case 'Ley':
                $tipo = "auto";
                break;
        }

        if ($_FILES) {
            $ruta = "public/path";
            if (!is_dir($ruta)) {
                mkdir($ruta, 0755, true);
            }

            foreach ($_FILES["documentos"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                    $name = basename($_FILES["documentos"]["name"][$key]);
                    move_uploaded_file($tmp_name, "$ruta/$name");
                    adjuntar_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId(), "$ruta/$name");
                    unlink("$ruta/$name");
                }
            }

            header("Location:" . constant('url') . "adjuntar/$id/Documentos Adjuntados");
            exit();
        }

        require_once "pages/layout/header.php";
        require_once "pages/layout/sub_header.php";
        require_once "pages/cotizaciones/adjuntar.php";
        require_once "pages/layout/sub_footer.php";
        require_once "pages/layout/footer.php";
    }
}
