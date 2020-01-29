<?php

class HomeController
{
    public $api;

    function __construct()
    {
        $this->api = new API;
    }

    public function pagina_principal()
    {
        $criterio = "Contact_Name:equals:" . "3222373000000751142";
        $ofertas = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $ofertas_totales = 0;
        $ofertas_emisiones = 0;
        $ofertas_vencimientos = 0;
        if (!empty($ofertas)) {
            foreach ($ofertas as $oferta) {
                $ofertas_totales += 1;
                $oferta_id = $oferta->getEntityId();
                $criterio = "Deal_Name:equals:" . $oferta_id;
                $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
                if (!empty($cotizaciones)) {
                    foreach ($cotizaciones as $cotizacion) {
                        if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till") . "- 1 year")) == date('Y-m-d')) {
                            $ofertas_emisiones++;
                            $filtro_emisiones = $oferta->getFieldValue("Stage");
                        }
                        if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m-d')) {
                            $ofertas_vencimientos++;
                            $filtro_vencimientos = $oferta->getFieldValue("Stage");
                        }
                    }
                }
            }
        }

        require("core/views/template/header.php");
        require("core/views/home/pagina_principal.php");
        require("core/views/template/footer.php");
    }

    public function lista_cotizaciones()
    {
        $criterio = "Contact_Name:equals:" . "3222373000000751142";
        $ofertas = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : null;
        if ($_POST) {
            switch ($_POST['opcion']) {
                case 'nombre':
                    $criterio = "((Contact_Name:equals:" . "3222373000000751142" . ") and (Nombre_del_asegurado:equals:" . $_POST['busqueda'] . "))";
                    break;
                    /*
                case 'numero':
                    $criterio = "((Contact_Name:equals:" . "3222373000000751142" . ") and (Quote_Number:equals:" . $_POST['busqueda'] . "))";
                    break;
                    */
            }
            $ofertas = $this->api->searchRecordsByCriteria("Deals", $criterio);
        } else {
            $criterio = "Contact_Name:equals:" . "3222373000000751142";
            $ofertas = $this->api->searchRecordsByCriteria("Deals", $criterio);
        }
        require("core/views/template/header.php");
        require("core/views/home/lista_cotizaciones.php");
        require("core/views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        $marcas = $this->api->getRecords("Marcas");
        $marca_id = null;
        if ($_POST) {
            $oferta["Contact_Name"] = "3222373000000751142";
            $oferta["Lead_Source"] = "Portal GNB";
            $oferta["Deal_Name"] = "Oferta realizado desde el portal";
            $oferta["Direcci_n_del_asegurado"] = $_POST['direccion'];
            $oferta["A_o_de_Fabricacion"] = (int) $_POST['A_o_de_Fabricacion'];
            $oferta["Chasis"] = $_POST['chasis'];
            $oferta["Color"] = $_POST['color'];
            $oferta["Email_del_asegurado"] = $_POST['email'];
            $oferta["Marca"] = $_POST['marca'];
            $oferta["Modelo"] = $_POST['modelo'];
            $oferta["Nombre_del_asegurado"] = $_POST['nombre'];
            $oferta["Apellido_del_asegurado"] = $_POST['apellido'];
            $oferta["Placa"] = $_POST['placa'];
            $oferta["Plan"] = $_POST['plan'];
            $oferta["Type"] = "Vehículo";
            $oferta["RNC_Cedula_del_asegurado"] = $_POST['id'];
            $oferta["Telefono_del_asegurado"] = $_POST['telefono'];
            $oferta["Tipo_de_poliza"] = $_POST['poliza'];
            $oferta["Tipo_de_vehiculo"] = $_POST['Tipo_de_vehiculo'];
            $oferta["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $oferta["Es_nuevo"] = ($_POST['estado'] == 0) ? true : false;
            $resultado = $this->api->createRecord("Deals", $oferta);
            if (!empty($resultado)) {
                $mensaje = "Cotización realizada exitosamente";
            } else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("core/views/template/header.php");
        require("core/views/home/crear_cotizacion.php");
        require("core/views/template/footer.php");
        if ($_POST) {
            echo '<script>$("#Modal").modal("show")</script>';
        }
    }

    public function ver_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->api->getRecord("Deals", $oferta_id);
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        require("core/views/template/header.php");
        require("core/views/home/ver_cotizacion.php");
        require("core/views/template/footer.php");
    }

    public function descargar_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->api->getRecord("Deals", $oferta_id);
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        require("core/views/home/descargar_cotizacion.php");
    }

    public function editar_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $marcas = $this->api->getRecords("Marcas");
        $marca_id = null;
        if ($_POST) {
            $oferta["A_o_de_Fabricacion"] = (int) $_POST['A_o_de_Fabricacion'];
            $oferta["Marca"] = $_POST['marca'];
            $oferta["Modelo"] = $_POST['modelo'];
            $oferta["Plan"] = $_POST['plan'];
            $oferta["Tipo_de_poliza"] = $_POST['poliza'];
            $oferta["Tipo_de_vehiculo"] = $_POST['Tipo_de_vehiculo'];
            $oferta["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $oferta["Es_nuevo"] = ($_POST['estado'] == 0) ? true : false;
            $resultado = $this->api->updateRecord("Deals", $oferta, $oferta_id);
            if (!empty($resultado)) {
                $mensaje = "Cambios realizados exitosamente";
            } else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("core/views/template/header.php");
        require("core/views/home/editar_cotizacion.php");
        require("core/views/template/footer.php");

        if ($_POST) {
            echo '<script>$("#Modal").modal("show")</script>';
        }
    }

    public function eliminar_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        if (!empty($cotizaciones)) {
            foreach ($cotizaciones as $cotizacion) {
                $cotizacion_id = $cotizacion->getEntityId();
                break;
            }
        }
        $resultado_1 = $this->api->deleteRecord("Quotes", $cotizacion_id);
        $resultado = $this->api->deleteRecord("Deals", $oferta_id);
        require("core/views/template/header.php");
        require("core/views/home/lista_cotizaciones.php");
        require("core/views/template/footer.php");
    }

    public function emitir_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $ruta_cotizacion = "file/Cotizaciones/" . $oferta_id;
        if ($_POST) {
            $oferta = $this->api->getRecord("Deals", $oferta_id);
            if ($oferta->getFieldValue('Aseguradora') == null) {
                $ofertas_cambios["Aseguradora"] = $_POST["aseguradora"];
                $resultado = $this->api->updateRecord("Deals", $ofertas_cambios, $oferta_id);
            }
            if (isset($_FILES["cotizacion_firmada"])) {
                $rutaDeSubidas = dirname(__DIR__, 2) . "/" . $ruta_cotizacion;
                if (!is_dir($rutaDeSubidas)) {
                    mkdir($rutaDeSubidas, 0777, true);
                }
                $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
                $archivonombre = $_FILES["cotizacion_firmada"]["name"];
                $nombreArchivo = $archivonombre . "." . $extension;
                $nuevaUbicacion = $rutaDeSubidas . "/" . $nombreArchivo;
                move_uploaded_file($_FILES["cotizacion_firmada"]["tmp_name"], $nuevaUbicacion);
            }
            if (isset($_FILES["expedientes"])) {
                $rutaDeSubidas = dirname(__DIR__, 2) . "/" . $ruta_cotizacion;
                if (!is_dir($rutaDeSubidas)) {
                    mkdir($rutaDeSubidas, 0777, true);
                }
                foreach ($_FILES["expedientes"]['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES["expedientes"]["name"][$key]) {
                        $extension = pathinfo($_FILES["expedientes"]["name"][$key], PATHINFO_EXTENSION);
                        $archivonombre = $_FILES["expedientes"]["name"][$key];
                        $nombreArchivo = $archivonombre . "." . $extension;
                        $nuevaUbicacion = $rutaDeSubidas . "/" . $nombreArchivo;
                        move_uploaded_file($_FILES["expedientes"]["tmp_name"][$key], $nuevaUbicacion);
                    }
                }
            }
            if (!empty($resultado)) {
                $mensaje = "Acción realizada exitosamente";
            } else {
                if (isset($_FILES["expedientes"])) {
                    $mensaje = "Archivos subidos exitosamente";
                } else {
                    $mensaje = "Ha ocurrido un error,intentelo mas tarde";
                }
            }
        } else {
            $criterio = "Deal_Name:equals:" . $oferta_id;
            $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        }
        require("core/views/template/header.php");
        require("core/views/home/emitir_cotizacion.php");
        require("core/views/template/footer.php");
        if ($_POST) {
            echo '<script>$("#Modal").modal("show")</script>';
        }
    }
}
