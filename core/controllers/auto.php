<?php

class auto
{
    public $cotizacion;

    function __construct()
    {
        $this->cotizacion = new cotizacion;
    }

    public function detalles($url = null)
    {
        $url = json_decode($url, true);
        if (is_array($url)) {
            $id = $url[0];
            $alerta = $url[1];
        } else {
            $id = $url;
        }

        $resultado = $this->cotizacion->detalles($id);
        $resumen =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];
        $emitida = array("Emitido", "En trámite");

        if (
            empty($resumen)
            or
            empty($detalles)
        ) {
            header("Location:" . constant("url") . "cotizaciones/error");
            exit();
        }

        if (in_array($resumen->getFieldValue("Stage"), $emitida)) {
            $documentos_adjuntos = $this->cotizacion->lista_documentos_adjuntos($id);
        }

        if ($resumen->getFieldValue("Stage") == "Abandonada") {
            $alerta = 'Cotización Abandonada';
        }

        require_once("core/views/template/header.php");
        require_once("core/views/template/header_auto.php");
        require_once("core/views/auto/detalles.php");
        require_once("core/views/template/footer.php");
    }

    public function completar($id = null)
    {
        $resultado = $this->cotizacion->detalles($id);
        $resumen =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];

        if (
            empty($resumen)
            or
            empty($detalles)
            or
            $resumen->getFieldValue("Stage") == "Abandonada"
            or
            $resumen->getFieldValue("Email") != null
        ) {
            header("Location:" . constant("url") . "cotizaciones/error");
            exit();
        }

        $clientes = $this->cotizacion->lista_clientes();
        sort($clientes);

        if ($_POST) {

            $cambios["Chasis"] = $_POST["Chasis"];
            $cambios["Color"] = $_POST["Color"];
            $cambios["Placa"] = $_POST["Placa"];

            if (!empty($_POST["mis_clientes"])) {

                $cliente_info = $this->cotizacion->cliente_detalles($_POST["mis_clientes"]);

                $cambios["Direcci_n"] = $cliente_info->getFieldValue("Mailing_Street");
                $cambios["Nombre"] = $cliente_info->getFieldValue("First_Name");
                $cambios["Apellido"] = $cliente_info->getFieldValue("Last_Name");
                $cambios["RNC_Cedula"] = $cliente_info->getFieldValue("RNC_C_dula");
                $cambios["Telefono"] = $cliente_info->getFieldValue("Phone");
                $cambios["Tel_Residencia"] = $cliente_info->getFieldValue("Home_Phone");
                $cambios["Tel_Trabajo"] = $cliente_info->getFieldValue("Tel_Trabajo");
                $cambios["Fecha_de_Nacimiento"] = $cliente_info->getFieldValue("Date_of_Birth");
                $cambios["Email"] = $cliente_info->getFieldValue("Email");
            } else {

                $cambios["Direcci_n"] = $_POST["Direcci_n"];
                $cambios["Nombre"] = $_POST["Nombre"];
                $cambios["Apellido"] = $_POST["Apellido"];
                $cambios["RNC_Cedula"] = $_POST["RNC_Cedula"];
                $cambios["Telefono"] = (isset($_POST["Telefono"])) ? $_POST["Telefono"] : null;
                $cambios["Tel_Residencia"] = (isset($_POST["Tel_Residencia"])) ? $_POST["Tel_Residencia"] : null;
                $cambios["Tel_Trabajo"] = (isset($_POST["Tel_Trabajo"])) ? $_POST["Tel_Trabajo"] : null;
                $cambios["Fecha_de_Nacimiento"] = $_POST["Fecha_de_Nacimiento"];
                $cambios["Email"] = $_POST["Email"];
            }

            $this->cotizacion->actualizar($id, $cambios);

            $peticion = array($id, "Cliente agregado corectamente");
            header("Location:" . constant("url") . "cotizaciones/redirigir/auto-detalles-" . json_encode($peticion));
            exit;
        }

        require_once("core/views/template/header.php");
        require_once("core/views/template/header_auto.php");
        require_once("core/views/auto/completar.php");
        require_once("core/views/template/footer.php");
    }

    public function emitir($id = null)
    {
        $resultado = $this->cotizacion->detalles($id);
        $resumen =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];
        $emitida = array("Emitido", "En trámite");

        if (
            empty($resumen)
            or
            empty($detalles)
            or
            $resumen->getFieldValue("Stage") == "Abandonada"
        ) {
            header("Location:" . constant("url") . "cotizaciones/error");
            exit();
        }

        if ($_POST) {

            $ruta_cotizacion = "public/tmp";
            if (!is_dir($ruta_cotizacion)) {
                mkdir($ruta_cotizacion, 0755, true);
            }

            if (!empty($_FILES["cotizacion_firmada"]["name"])) {

                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                $permitido = array("pdf");

                if (in_array($extension, $permitido)) {

                    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                    $name = basename($_FILES["cotizacion_firmada"]["name"]);
                    move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");

                    $this->cotizacion->adjuntar_archivos($id, "$ruta_cotizacion/$name");

                    unlink("$ruta_cotizacion/$name");

                    $cambios["Aseguradora"] = $_POST["aseguradora_id"];
                    $cambios["Stage"] = "En trámite";
                    $cambios["Deal_Name"] = "Resumen";
                    $this->cotizacion->actualizar($id, $cambios);

                    $alerta = "Póliza emitida,descargue la previsualizacion para obtener el carnet. ";
                } else {
                    $alerta = "Error al cargar documentos, solo se permiten archivos PDF.";
                }
            } else if (!empty($_FILES["documentos"]['name'][0])) {

                foreach ($_FILES["documentos"]["error"] as $key => $error) {

                    if ($error == UPLOAD_ERR_OK) {

                        $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                        $name = basename($_FILES["documentos"]["name"][$key]);
                        move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");

                        $this->cotizacion->adjuntar_archivos($id, "$ruta_cotizacion/$name");

                        unlink("$ruta_cotizacion/$name");
                    }
                }

                $alerta = "Documentos adjuntados";
            }

            echo $alerta;

            $peticion = array($id, $alerta);
            header("Location:" . constant("url") . "cotizaciones/redirigir/auto-detalles-" . json_encode($peticion));
            exit;
        }

        require_once("core/views/template/header.php");
        require_once("core/views/template/header_auto.php");
        require_once("core/views/auto/emitir.php");
        require_once("core/views/template/footer.php");
    }

    public function descargar($id = null)
    {
        $resultado = $this->cotizacion->detalles($id);
        $resumen =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];
        $emitida = array("Emitido", "En trámite");

        if (
            $resumen->getFieldValue('Email') == null
            or
            empty($resumen)
            or
            empty($detalles)
            or
            $resumen->getFieldValue('Stage') == "Abandonado"
        ) {
            header("Location:?url=home/error");
            exit();
        }

        if (in_array($resumen->getFieldValue("Stage"), $emitida)) {

            $imagen_aseguradora = $this->cotizacion->foto_aseguradora($resumen->getFieldValue("Aseguradora")->getEntityId());

            foreach ($detalles as $info) {
                $coberturas = $this->cotizacion->contrato_detalles($info->getFieldValue('Contrato')->getEntityId());
            }
        }

        require_once("core/views/auto/descargar.php");
    }
}
