<?php

class AutoController extends api
{
    public function __construct()
    {
        parent::__construct();
    }
    public function crear()
    {
        if (isset($_POST['submit'])) {
            $oferta["Lead_Source"] = "Portal GNB";
            $oferta["Deal_Name"] = "Cotización";
            $oferta["Type"] = "Auto";
            $oferta["Stage"] = "Cotizando";
            $oferta["Contact_Name"] =  $_SESSION['usuario_id'];
            $oferta["Tipo_de_poliza"] = $_POST["Tipo_de_poliza"];
            $oferta["Plan"] = $_POST["Plan"];
            $oferta["Marca"] = $_POST['Marca'];
            $oferta["Modelo"] =  $_POST['Modelo'];
            $modelo = $this->getRecord("Modelos", $_POST['Modelo']);
            $oferta["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
            $oferta["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $oferta["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
            $oferta["Chasis"] = $_POST['Chasis'];
            $oferta["Color"] = $_POST['Color'];
            $oferta["Uso"] = $_POST['Uso'];
            $oferta["Placa"] =  $_POST['Placa'];
            if (isset($_POST['estado'])) {
                $oferta["Es_nuevo"]  = true;
            } else {
                $oferta["Es_nuevo"]  = false;
            }
            $id = $this->createRecord("Deals", $oferta);
            $direccion = 'auto-detalles-' . $id;
            header("Location:" . constant('url') . 'home/cargando/' . $direccion);
            exit;
        }
        require_once("views/header.php");
        require_once("views/auto/crear.php");
        require_once("views/footer.php");
    }
    public function detalles($id = null)
    {
        $oferta = $this->getRecord("Deals", $id);
        if (empty($oferta)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $criterio = "Deal_Name:equals:" . $id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
        if (empty($cotizaciones)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $emitida = array("Emitido", "En trámite");
        if (in_array($oferta->getFieldValue("Stage"), $emitida)) {
            $imagen_aseguradora = $this->downloadPhoto("Vendors", $oferta->getFieldValue('Aseguradora')->getEntityId(), "public/img/");
            foreach ($cotizaciones as $cotizacion) {
                $contrato = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
            }
        }
        require_once("views/header.php");
        require_once("views/auto/detalles.php");
        require_once("views/footer.php");
    }
    public function completar($id = null)
    {
        $oferta = $this->getRecord("Deals", $id);
        if (empty($oferta)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        if (isset($_POST['submit'])) {
            $cambios["Chasis"] = $_POST['Chasis'];
            $cambios["Color"] = $_POST['Color'];
            $cambios["Placa"] = $_POST['Placa'];
            $cambios["Direcci_n"] = $_POST['Direcci_n'];
            $cambios["Email"] = $_POST['Email'];
            $cambios["Nombre"] = $_POST['Nombre'];
            $cambios["Apellido"] = $_POST['Apellido'];
            $cambios["RNC_Cedula"] = $_POST['RNC_Cedula'];
            $cambios["Telefono"] = $_POST['Telefono'];
            $cambios["Tel_Residencia"] = $_POST['Tel_Residencia'];
            $cambios["Tel_Trabajo"] = $_POST['Tel_Trabajo'];
            $cambios["Fecha_de_Nacimiento"] = $_POST['Fecha_de_Nacimiento'];
            $this->updateRecord("Deals", $cambios, $id);
            header("Location:" . constant('url') . 'auto/detalles/' . $id);
            exit;
        }
        require_once("views/header.php");
        require_once("views/auto/completar.php");
        require_once("views/footer.php");
    }
    public function descargar($id = null)
    {
        $oferta = $this->getRecord("Deals", $id);
        if (empty($oferta)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $criterio = "Deal_Name:equals:" . $id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
        if (empty($cotizaciones)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $emitida = array("Emitido", "En trámite");
        if (in_array($oferta->getFieldValue("Stage"), $emitida)) {
            $aseguradora = $this->getRecord("Vendors", $oferta->getFieldValue('Aseguradora')->getEntityId());
            $imagen_aseguradora = $this->downloadPhoto("Vendors", $oferta->getFieldValue('Aseguradora')->getEntityId(), "public/img/");
            foreach ($cotizaciones as $cotizacion) {
                $poliza = $cotizacion->getFieldValue('P_liza')->getLookupLabel();
                $contrato = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
            }
        }
        require_once("views/auto/descargar.php");
    }
    public function emitir($id = null)
    {
        $oferta = $this->getRecord("Deals", $id);
        if (empty($oferta)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $criterio = "Deal_Name:equals:" . $id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
        if (empty($cotizaciones)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $emitida = array("Emitido", "En trámite");
        if (isset($_POST['submit'])) {
            $ruta_cotizacion = "public/tmp";
            if (!is_dir($ruta_cotizacion)) {
                mkdir($ruta_cotizacion, 0755, true);
            }
            if (!empty($_FILES["cotizacion_firmada"]["name"])) {
                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                $permitido = array("pdf");
                if (in_array($extension, $permitido)) {
                    $cambios["Aseguradora"] = $_POST["aseguradora"];
                    $cambios["Stage"] = "En trámite";
                    $cambios["Deal_Name"] = "Resumen";
                    $this->updateRecord("Deals", $cambios, $id);
                    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                    $name = basename($_FILES["cotizacion_firmada"]["name"]);
                    move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                    $this->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                    unlink("$ruta_cotizacion/$name");
                    $direccion = 'auto-descargar-' . $id;
                    $alerta =
                        "Póliza emitida,descargue la previsualizacion para obtener el carnet. "
                        .
                        '<a href="' . constant("url") . 'home/cargando/' . $direccion . '" class="btn btn-link">Descargar</a>';
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
                        $this->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                        unlink("$ruta_cotizacion/$name");
                    }
                }
                $alerta = "Archivos Adjuntados.";
            }
        }
        require_once("views/header.php");
        require_once("views/auto/emitir.php");
        require_once("views/footer.php");
    }
}
