<?php

class AutoController
{
    public $cotizacion;

    function __construct()
    {
        $this->cotizacion = new cotizacion;
    }

    public function descargar($id = null)
    {
        $resultado = $this->cotizacion->detalles($id);
        $cotizacion =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];
        $emitida = array("Emitido", "En trámite");

        if (
            $cotizacion->getFieldValue('Email') == null
            or
            empty($cotizacion)
            or
            empty($detalles)
            or
            $cotizacion->getFieldValue('Stage') == "Abandonado"
        ) {
            header("Location:?url=home/error");
            exit();
        }

        if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

            $imagen_aseguradora = $this->cotizacion->foto_aseguradora($cotizacion->getFieldValue("Aseguradora")->getEntityId());

            foreach ($detalles as $resumen) {
                $coberturas = $this->cotizacion->contrato_detalles($resumen->getFieldValue('Contrato')->getEntityId());
            }
        }

        require_once("core/views/auto/descargar.php");
    }

    public function detalles($datos = null)
    {
        $url = json_decode($datos, true);
        if (is_array($url)) {
            $id = $url["id"];
            $alerta = $url["alerta"];
        } else {
            $id = $url;
        }
        
        $resultado = $this->cotizacion->detalles($id);
        $cotizacion =  $resultado["oferta"];
        $detalles =  $resultado["cotizaciones"];

        if (
            empty($cotizacion)
            or
            empty($detalles)
        ) {
            header("Location:?url=home/error");
            exit();
        }

        $clientes = $this->cotizacion->lista_clientes();
        sort($clientes);
        $emitida = array("Emitido", "En trámite");

        if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {
            $documentos_adjuntos = $this->cotizacion->lista_documentos_adjuntos($id);
        }

        if ($cotizacion->getFieldValue("Stage") == "Abandonada") {
            $alerta = 'Cotización Abandonada';
        }

        if ($_POST) {
            if (isset($_POST["Completar"])) {
                $this->completar($id);
            } elseif (isset($_POST["emitir"])) {
                $this->emitir($id);
            }
        }

        require_once("core/views/template/header.php");
        require_once("core/views/auto/detalles.php");
        require_once("core/views/template/footer.php");
    }


    public function completar($id)
    {
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

        $peticion = array("id"=>$id,"alerta"=>"Cliente agregado corectamente");
        header("Location:?url=home/redirect/auto-detalles-" . json_encode($peticion));
        exit;
    }

    public function emitir($id)
    {
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

                $cambios["Aseguradora"] = $_POST["aseguradora"];
                $cambios["Stage"] = "En trámite";
                $cambios["Deal_Name"] = "Resumen";
                $this->cotizacion->actualizar($id, $cambios);

                $alerta =  "Póliza emitida,descargue la previsualizacion para obtener el carnet. ";
            } else {
                $alerta = "Error al cargar documentos, solo se permiten archivos PDF.";
            }
        }
        if (!empty($_FILES["documentos"]['name'][0])) {

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
        
        $peticion = array("id"=>$id,"alerta"=>$alerta);
        header("Location:?url=home/redirect/auto-detalles-" . json_encode($peticion));
        exit;
    }
}
