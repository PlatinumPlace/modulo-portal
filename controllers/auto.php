<?php

class AutoController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }
    public function crear()
    {
        if (isset($_POST['submit'])) {
            $oferta["Contact_Name"] =  $_SESSION['usuario_id'];
            $oferta["Lead_Source"] = "Portal GNB";
            $oferta["Deal_Name"] = "Cotización";
            $oferta["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
            $oferta["Chasis"] = $_POST['chasis'];
            $oferta["Color"] = $_POST['color'];
            $oferta["Marca"] = $_POST['marca'];
            $oferta["Modelo"] = $_POST['modelo'];
            $modelo = $this->getRecord("Modelos", $_POST['modelo']);
            $trato["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
            $oferta["Placa"] = $_POST['placa'];
            $oferta["Plan"] = $_POST['plan'];
            $oferta["Type"] = $_POST['tipo'];
            $oferta["Uso"] = $_POST['uso'];
            $oferta["Tipo_de_poliza"] = $_POST['poliza'];
            $oferta["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $oferta["Stage"] = "Cotizando";
            if (isset($_POST['estado'])) {
                $oferta["Es_nuevo"] = true;
            } else {
                $oferta["Es_nuevo"] = false;
            }
            $datos = $this->createRecord("Deals", $oferta) . "-auto";
            $direccion = constant('url') . 'home/cargando/' . $datos;
            header("Location:" . $direccion);
            exit;
        }
        require_once("views/header.php");
        require_once("views/auto/crear.php");
        require_once("views/footer.php");
    }
    public function completar($datos)
    {
        $id = $datos;
        $trato = $this->getRecord("Deals", $id);
        if (empty($trato)) {
            require("pages/header.php");
            require("pages/error.php");
            require("pages/footer.php");
            exit;
        }
        if (isset($_POST['submit'])) {
            $cambios["Chasis"] = $_POST['chasis'];
            $cambios["Color"] = $_POST['color'];
            $cambios["Placa"] = $_POST['placa'];
            if (isset($_POST['Uso'])) {
                $cambios["Uso"] = $_POST['uso'];
            }
            if (isset($_POST['estado'])) {
                $cambios["Es_nuevo"] = true;
            } else {
                $cambios["Es_nuevo"] = false;
            }
            $cambios["Direcci_n"] = $_POST['direccion'];
            $cambios["Email"] = $_POST['email'];
            $cambios["Nombre"] = $_POST['nombre'];
            $cambios["Apellido"] = $_POST['apellido'];
            $cambios["RNC_Cedula"] = $_POST['cedula'];
            $cambios["Telefono"] = $_POST['telefono'];
            $cambios["Tel_Residencia"] = $_POST['telefono_2'];
            $cambios["Tel_Trabajo"] = $_POST['telefono_1'];
            $cambios["Fecha_de_Nacimiento"] = $_POST['Fecha_de_Nacimiento'];
            $this->updateRecord("Deals", $cambios, $id);
            $direccion = constant('url') . 'auto/detalles/' . $id;
            header("Location:" . $direccion);
            exit;
        }
        require_once("views/header.php");
        require_once("views/auto/completar.php");
        require_once("views/footer.php");
    }
    public function descargar($datos)
    {
        $id = $datos;
        $trato = $this->getRecord("Deals", $id);
        if (empty($trato)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $criterio = "Deal_Name:equals:" . $id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
        require_once("views/auto/descargar.php");
    }
    public function emitir($datos)
    {
        $id = $datos;
        $trato = $this->getRecord("Deals", $id);
        if (empty($trato)) {
            require("pages/header.php");
            require("pages/error.php");
            require("pages/footer.php");
            exit;
        }
        $criterio = "Deal_Name:equals:" . $id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
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
                    $alerta =
                        "Póliza emitida,descargue la previsualizacion para obtener el carnet. "
                        .
                        '<a href="' . constant("url") . 'auto/descargar/' . $id . '" class="btn btn-link">Descargar</a>                    ';
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
    public function detalles($datos)
    {
        $id = $datos;
        $trato = $this->getRecord("Deals", $id);
        if (empty($trato)) {
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit;
        }
        $criterio = "Deal_Name:equals:" . $id;
        $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
        require_once("views/header.php");
        require_once("views/auto/detalles.php");
        require_once("views/footer.php");
    }
}
