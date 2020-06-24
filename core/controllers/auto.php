<?php

class auto extends cotizaciones
{
    function __construct()
    {
        parent::__construct();
    }

    public function detalles($resumen_id = null)
    {
        $resumen = $this->getRecord("Deals", $resumen_id);
        $criterio = "Deal_Name:equals:$resumen_id";
        $cotizaciones =  $this->searchRecordsByCriteria("Quotes", $criterio, 1, 200);
        $emitida = array("Emitido", "En trámite");

        $url = $this->obtener_url();
        $alerta = $url[0];

        if (isset($_GET["page"])) {
            $num_pagina = $_GET["page"];
        } else {
            $num_pagina = 1;
        }

        if (empty($resumen)) {
            header("Location:" . constant("url") . "portal/error");
            exit();
        }

        if (empty($cotizaciones)) {
            $alerta = "Ha ocurrido un error cotizando,verifica los datos y intentelo de nuevo.";
        }

        if (in_array($resumen->getFieldValue("Stage"), $emitida)) {
            $documentos_adjuntos = $this->getAttachments("Deals", $resumen_id, $num_pagina, 3);
        }

        if ($resumen->getFieldValue("Stage") == "Abandonada") {
            $alerta = 'Cotización Abandonada';
        }

        require_once("core/views/layout/header_main.php");
        require_once("core/views/layout/header_auto.php");
        require_once("core/views/auto/detalles.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function completar($resumen_id = null)
    {
        $resumen = $this->getRecord("Deals", $resumen_id);
        $criterio = "Deal_Name:equals:$resumen_id";
        $cotizaciones =  $this->searchRecordsByCriteria("Quotes", $criterio, 1, 200);
        $emitida = array("Emitido", "En trámite");

        if (
            empty($resumen)
            or
            empty($cotizaciones)
            or
            $resumen->getFieldValue("Stage") == "Abandonada"
            or
            $resumen->getFieldValue('Email') != null
        ) {
            header("Location:" . constant("url") . "portal/error");
            exit();
        }

        $pagina = 1;
        $criterio = "Informar_a:equals:" . $_SESSION["usuario"]["id"];

        if ($_POST) {

            $cambios["Chasis"] = (isset($_POST["chasis"])) ? $_POST["chasis"] : null;
            $cambios["Color"] = (isset($_POST["color"])) ? $_POST["color"] : null;
            $cambios["Placa"] = (isset($_POST["placa"])) ? $_POST["placa"] : null;
            $cambios["Uso"] = (isset($_POST["uso"])) ? $_POST["uso"] : null;
            $cambios["Es_nuevo"] = (!empty($_POST["nuevo"])) ? true : false;

            if (isset($_POST["cliente"]) and $_POST["cliente"] == "nuevo") {

                $cambios["Direcci_n"] = (isset($_POST["direccion"])) ? $_POST["direccion"] : null;
                $cambios["Nombre"] = (isset($_POST["nombre"])) ? $_POST["nombre"] : null;
                $cambios["Apellido"] = (isset($_POST["apellido"])) ? $_POST["apellido"] : null;
                $cambios["RNC_Cedula"] = (isset($_POST["rnc/cedula"])) ? $_POST["rnc/cedula"] : null;
                $cambios["Telefono"] = (isset($_POST["telefono"])) ? $_POST["telefono"] : null;
                $cambios["Tel_Residencia"] = (isset($_POST["tel_residencia"])) ? $_POST["tel_residencia"] : null;
                $cambios["Tel_Trabajo"] = (isset($_POST["tel_trabajo"])) ? $_POST["tel_trabajo"] : null;
                $cambios["Fecha_de_Nacimiento"] = (isset($_POST["fecha_nacimiento"])) ? $_POST["fecha_nacimiento"] : null;
                $cambios["Email"] = (isset($_POST["correo"])) ? $_POST["correo"] : null;
            } elseif (isset($_POST["cliente"]) and $_POST["cliente"] == "existente") {

                $cliente = $this->getRecord("Clientes", $_POST["mis_clientes"]);

                $cambios["Direcci_n"] = $cliente->getFieldValue("Direcci_n");
                $cambios["Nombre"] = $cliente->getFieldValue("Name");
                $cambios["Apellido"] = $cliente->getFieldValue("Apellidos");
                $cambios["RNC_Cedula"] = $cliente->getFieldValue("RNC_C_dula");
                $cambios["Telefono"] = $cliente->getFieldValue("Tel_fono");
                $cambios["Tel_Residencia"] = $cliente->getFieldValue("Tel_Residencia");
                $cambios["Tel_Trabajo"] = $cliente->getFieldValue("Tel_Trabajo");
                $cambios["Fecha_de_Nacimiento"] = $cliente->getFieldValue("Fecha_de_Nacimiento");
                $cambios["Email"] = $cliente->getFieldValue("Email");
            }

            if (
                empty($cambios["Nombre"])
                or
                empty($cambios["Email"])
                or
                empty($cambios["RNC_Cedula"])
                or
                empty($cambios["Fecha_de_Nacimiento"])
                or
                empty($cambios["Chasis"])
            ) {
                $alerta = "Debes completar almenos: Chasis,RNC/cedula,Nombre,Correo y Fecha de nacimiento.";
            } else {
                $this->updateRecord("Deals", $resumen_id, $cambios);

                $alerta = "Cliente agregado";
                $nueva_url = array("auto", "detalles", $resumen_id, $alerta);
                header("Location:" . constant("url") . "home/redirigir/" . json_encode($nueva_url));
                exit;
            }
        }


        require_once("core/views/layout/header_main.php");
        require_once("core/views/layout/header_auto.php");
        require_once("core/views/auto/completar.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function descargar($resumen_id = null)
    {
        $resumen = $this->getRecord("Deals", $resumen_id);
        $criterio = "Deal_Name:equals:$resumen_id";
        $cotizaciones =  $this->searchRecordsByCriteria("Quotes", $criterio, 1, 200);
        $emitida = array("Emitido", "En trámite");
        $ruta = "public/img";

        if (
            empty($resumen)
            or
            empty($cotizaciones)
            or
            $resumen->getFieldValue("Stage") == "Abandonada"
            or
            $resumen->getFieldValue('Email') == null
        ) {
            header("Location:" . constant("url") . "portal/error");
            exit();
        }

        if (in_array($resumen->getFieldValue("Stage"), $emitida)) {

            foreach ($cotizaciones  as $cotizacion) {
                $poliza = $cotizacion->getFieldValue('P_liza')->getLookupLabel();
                $coberturas = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
            }

            if (!is_dir($ruta)) {
                mkdir($ruta, 0755, true);
            }

            $imagen_aseguradora =  $this->downloadPhoto("Vendors", $resumen->getFieldValue("Aseguradora")->getEntityId(), "$ruta/");
        }

        require_once("core/views/auto/descargar.php");
    }

    public function emitir($resumen_id = null)
    {
        $resumen = $this->getRecord("Deals", $resumen_id);
        $criterio = "Deal_Name:equals:$resumen_id";
        $cotizaciones =  $this->searchRecordsByCriteria("Quotes", $criterio, 1, 200);
        $emitida = array("Emitido", "En trámite");
        $ruta = "public/img";

        if (
            empty($resumen)
            or
            empty($cotizaciones)
            or
            $resumen->getFieldValue("Stage") == "Abandonada"
            or
            $resumen->getFieldValue('Email') == null
        ) {
            header("Location:" . constant("url") . "portal/error");
            exit();
        }

        if ($_POST) {

            $ruta = "public/tmp";
            if (!is_dir($ruta)) {
                mkdir($ruta, 0755, true);
            }

            if (!empty($_FILES["cotizacion_firmada"]["name"])) {

                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                $permitido = array("pdf");

                if (in_array($extension, $permitido)) {

                    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                    $name = basename($_FILES["cotizacion_firmada"]["name"]);
                    move_uploaded_file($tmp_name, "$ruta/$name");
                    $this->uploadAttachment("Deals", $resumen_id, "$ruta/$name");
                    unlink("$ruta/$name");
                    $cambios["Aseguradora"] = $_POST["aseguradora_id"];
                    $cambios["Stage"] = "En trámite";
                    $cambios["Deal_Name"] = "Resumen";
                    $this->updateRecord("Deals", $resumen_id, $cambios);

                    $alerta = "Cotizacion emitida,descargue la previsualizacion para obtener el carnet.";
                    $nueva_url = array("auto", "detalles", $resumen_id, $alerta);
                    header("Location:" . constant("url") . "home/redirigir/" . json_encode($nueva_url));
                    exit;
                } else {
                    $alerta = "Error al cargar documentos, solo se permiten archivos PDF.";
                }
            } else if (!empty($_FILES["documentos"]['name'][0])) {

                foreach ($_FILES["documentos"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                        $name = basename($_FILES["documentos"]["name"][$key]);
                        move_uploaded_file($tmp_name, "$ruta/$name");
                        $this->uploadAttachment("Deals", $resumen_id, "$ruta/$name");
                        unlink("$ruta/$name");
                    }
                }

                $alerta =  "Documentos adjuntados";
                header("Location:" . constant("url") . "auto/detalles/$resumen_id/$alerta");
                exit;
            }
        }

        require_once("core/views/layout/header_main.php");
        require_once("core/views/layout/header_auto.php");
        require_once("core/views/auto/emitir.php");
        require_once("core/views/layout/footer_main.php");
    }
}
