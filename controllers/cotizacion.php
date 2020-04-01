<?php
class Cotizacion extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function buscar()
    {
        if ($_POST) {
            switch ($_POST['parametro']) {
                case 'numero':
                    $criterio = "((Contact_Name:equals:" . "3222373000002913137" . ") and (No_de_cotizaci_n:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'id':
                    $criterio = "((Contact_Name:equals:" . "3222373000002913137" . ") and (RNC_Cedula_del_asegurado:equals:" . $_POST['busqueda'] . "))";
                    break;
            }
            $this->view->resultado = $this->api->searchRecordsByCriteria("Deals", $criterio);
        } else {
            $criterio = "Contact_Name:equals:" . "3222373000002913137";
            $this->view->resultado = $this->api->searchRecordsByCriteria("Deals", $criterio);
        }
        $this->view->render("header");
        $this->view->render("cotizacion/buscar");
        $this->view->render("footer");
    }
    public function detalles($id)
    {
        $this->view->trato = $this->api->getRecord("Deals", $id);
        $this->view->cotizaciones = $this->view->trato->getFieldValue('Aseguradoras_Disponibles');
        $this->view->api = $this->api;
        function calcular($valor, $porciento)
        {
            return $valor * ($porciento / 100);
        }
        $this->view->render("header");
        $this->view->render("cotizacion/detalles");
        $this->view->render("footer");
    }
    public function completar($id)
    {
        $this->view->trato = $this->api->getRecord("Deals", $id);
        if (isset($_POST['submit'])) {
            $cambios["Chasis"] = $_POST['chasis'];
            $cambios["Color"] = $_POST['color'];
            $cambios["Placa"] = $_POST['placa'];
            $cambios["Uso"] = $_POST['uso'];
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
            $resultado = $this->api->updateRecord("Deals", $cambios, $id);
            echo '<script>alert("Cotización completada")</script>';
            echo '<script>window.location = "' . constant('url') . 'cotizacion/detalles/' . $id . '"</script>';
        }
        $this->view->render("header");
        $this->view->render("cotizacion/completar");
        $this->view->render("footer");
    }
    public function crear()
    {
        $this->view->api = $this->api;
        if (isset($_POST['submit'])) {
            $trato["Contact_Name"] = "3222373000002913137";
            $trato["Lead_Source"] = "Portal GNB";
            $trato["Deal_Name"] = "Cotización";
            $trato["A_o_de_Fabricacion"] = $_POST['A_o_de_Fabricacion'];
            $trato["Chasis"] = $_POST['chasis'];
            $trato["Color"] = $_POST['color'];
            $marca = $this->api->getRecord("Marcas", $_POST['marca']);
            $trato["Marca"] = $marca->getFieldValue('Name');
            $modelo = $this->api->getRecord("Modelos", $_POST['modelo']);
            $trato["Modelo"] = $modelo->getFieldValue('Name');
            $trato["Tipo_de_vehiculo"] = $modelo->getFieldValue('Tipo');
            $trato["Placa"] = $_POST['placa'];
            $trato["Plan"] = $_POST['plan'];
            $trato["Type"] = $_POST['cotizacion'];
            $trato["Uso"] = $_POST['uso'];
            $trato["Tipo_de_poliza"] = $_POST['poliza'];
            $trato["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $trato["Stage"] = "Cotizando";
            if (isset($_POST['estado'])) {
                $trato["Es_nuevo"] = true;
            } else {
                $trato["Es_nuevo"] = false;
            }
            $resultado = $this->api->createRecord("Deals", $trato);
            echo '<script>alert("Cotización creada")</script>';
            echo '<script>window.location = "' . constant('url') . 'cotizacion/cargando/' . $resultado['id'] . '"</script>';
        }
        $this->view->render("header");
        $this->view->render("cotizacion/crear");
        $this->view->render("footer");
    }
    public function cargando($id)
    {
        $this->view->id = $id;
        $this->view->render("header");
        $this->view->render("cotizacion/cargando");
        $this->view->render("footer");
    }
    public function descargar($id)
    {
        $this->view->trato = $this->api->getRecord("Deals", $id);
        $this->view->cotizaciones = $this->view->trato->getFieldValue('Aseguradoras_Disponibles');
        $this->view->api = $this->api;
        $this->view->id = $id;
        function calcular_1($valor, $porciento)
        {
            return $valor * ($porciento / 100);
        }
        $this->view->render("cotizacion/descargar");
    }
    public function emitir($id)
    {
        $this->view->trato = $this->api->getRecord("Deals", $id);
        $this->view->cotizaciones = $this->view->trato->getFieldValue('Aseguradoras_Disponibles');
        $this->view->api = $this->api;
        $this->view->id = $id;
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
                    $resultado =  $this->api->updateRecord("Deals", $cambios, $id);
                    $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
                    $name = basename($_FILES["cotizacion_firmada"]["name"]);
                    move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                    $this->api->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                    unlink("$ruta_cotizacion/$name");
                    echo '<script>alert("Póliza emitida,descargue la cotización para obtener el carnet")</script>';
                    echo '<script>window.location = "' . constant('url') . 'cotizacion/cargando/' . $resultado['id'] . '"</script>';
                } else {
                    echo '<script>alert("Error al cargar documentos,formatos adminitos: PDF");</script>';
                }
            }
            if (!empty($_FILES["documentos"]['name'][0])) {
                foreach ($_FILES["documentos"]["error"] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
                        $name = basename($_FILES["documentos"]["name"][$key]);
                        move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
                        $this->api->uploadAttachment("Deals", $id, "$ruta_cotizacion/$name");
                        unlink("$ruta_cotizacion/$name");
                    }
                }
            }
        }
        $this->view->render("header");
        $this->view->render("cotizacion/emitir");
        $this->view->render("footer");
    }
    public function lista($filtro)
    {
        $this->view->filtro = $filtro;
        $criterio = "Contact_Name:equals:" . "3222373000002913137";
        $this->view->resultado = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $this->view->render("header");
        $this->view->render("cotizacion/lista");
        $this->view->render("footer");
    }
}
