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
        $ofertas_emiciones = 0;
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
                            $ofertas_emiciones++;
                            $filtro_emitidos = $oferta->getFieldValue("Stage");
                        }
                        if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m-d')) {
                            $ofertas_vencimientos++;
                            $filtro_vencen = $oferta->getFieldValue("Stage");
                        }
                    }
                }
            }
        }

        require("core/views/template/header.php");
        require("core/views/home/pagina_principal.php");
        require("core/views/template/footer.php");
    }

    public function buscar_cotizaciones()
    {
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
        }
        require("core/views/template/header.php");
        require("core/views/home/buscar_cotizaciones.php");
        require("core/views/template/footer.php");
    }

    public function lista_cotizaciones()
    {
        $criterio = "Contact_Name:equals:" . "3222373000000751142";
        $ofertas = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : null ;
        require("core/views/template/header.php");
        require("core/views/home/lista_cotizaciones.php");
        require("core/views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        if ($_POST) {
            $oferta["Contact_Name"] = "3222373000000751142";
            $oferta["Lead_Source"] = "Portal GNB";
            $oferta["Deal_Name"] = "Oferta realizado desde el portal";
            $oferta["Direcci_n_del_asegurado"] = $_POST['Direcci_n_del_asegurado'];
            $oferta["A_o_de_Fabricacion"] = (int) $_POST['A_o_de_Fabricacion'];
            $oferta["Chasis"] = $_POST['Chasis'];
            $oferta["Color"] = $_POST['Color'];
            $oferta["Email_del_asegurado"] = $_POST['Email_del_asegurado'];
            $oferta["Marca"] = $_POST['Marca'];
            $oferta["Modelo"] = $_POST['Modelo'];
            $oferta["Nombre_del_asegurado"] = $_POST['Nombre_del_asegurado'];
            $oferta["Apellido_del_asegurado"] = $_POST['Apellido_del_asegurado'];
            $oferta["Placa"] = $_POST['Placa'];
            $oferta["Plan"] = $_POST['Plan'];
            $oferta["Type"] = "Vehículo";
            $oferta["RNC_Cedula_del_asegurado"] = $_POST['RNC_Cedula_del_asegurado'];
            $oferta["Telefono_del_asegurado"] = $_POST['Telefono_del_asegurado'];
            $oferta["Tipo_de_poliza"] = $_POST['Tipo_de_poliza'];
            $oferta["Tipo_de_vehiculo"] = $_POST['Tipo_de_vehiculo'];
            $oferta["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $oferta["Es_nuevo"] = ($_POST['Es_nuevo'] == 0) ? true : false;
            $oferta_id = $this->api->createRecord("Deals", $oferta);
            if (!empty($oferta_id)) {
                $mensaje = "Cotización realizada exitosamente";
                $pagina_de_destino = "ver_cotizacion";
            }else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("core/views/template/header.php");
        require("core/views/home/crear_cotizacion.php");
        require("core/views/template/footer.php");

        if ($_POST) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var Modalelem = document.querySelector(".modal");
                        var instance = M.Modal.init(Modalelem);
                        instance.open();
                    });
                </script>';
        }
    }

    public function ver_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->api->getRecord("Deals", $oferta_id);
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);

        $contrato = null;
        $nombre_fichero = "file/contratos firmados/" . $oferta_id . ".pdf";
        if (file_exists($nombre_fichero)) {
            $contrato = true;
        }

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
        $oferta = $this->api->getRecord("Deals", $oferta_id);
        if ($_POST) {
            $ofertas_cambios["Contact_Name"] = "3222373000000751142";
            $ofertas_cambios["Direcci_n_del_asegurado"] = $_POST['Direcci_n_del_asegurado'];
            $ofertas_cambios["A_o_de_Fabricacion"] = (int) $_POST['A_o_de_Fabricacion'];
            $ofertas_cambios["Chasis"] = $_POST['Chasis'];
            $ofertas_cambios["Color"] = $_POST['Color'];
            $ofertas_cambios["Email_del_asegurado"] = $_POST['Email_del_asegurado'];
            $ofertas_cambios["Marca"] = $_POST['Marca'];
            $ofertas_cambios["Modelo"] = $_POST['Modelo'];
            $ofertas_cambios["Nombre_del_asegurado"] = $_POST['Nombre_del_asegurado'];
            $ofertas_cambios["Apellido_del_asegurado"] = $_POST['Apellido_del_asegurado'];
            $ofertas_cambios["Placa"] = $_POST['Placa'];
            $ofertas_cambios["Plan"] = $_POST['Plan'];
            $ofertas_cambios["Type"] = "Vehículo";
            $ofertas_cambios["RNC_Cedula_del_asegurado"] = $_POST['RNC_Cedula_del_asegurado'];
            $ofertas_cambios["Telefono_del_asegurado"] = $_POST['Telefono_del_asegurado'];
            $ofertas_cambios["Tipo_de_poliza"] = $_POST['Tipo_de_poliza'];
            $ofertas_cambios["Tipo_de_vehiculo"] = $_POST['Tipo_de_vehiculo'];
            $ofertas_cambios["Valor_Asegurado"] = $_POST['Valor_Asegurado'];
            $ofertas_cambios["Es_nuevo"] = ($_POST['Es_nuevo'] == 0) ? true : false;
            $this->api->updateRecord("Deals", $ofertas_cambios, $oferta_id);
            if (!empty($oferta_id)) {
                $mensaje = "Acción realizada exitosamente";
            }else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("core/views/template/header.php");
        require("core/views/home/editar_cotizacion.php");
        require("core/views/template/footer.php");

        if ($_POST) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var Modalelem = document.querySelector(".modal");
                        var instance = M.Modal.init(Modalelem);
                        instance.open();
                    });
                </script>';
        }
    }


    public function completar_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->api->getRecord("Deals", $oferta_id);
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);

        if ($_POST) {
            if ($oferta->getFieldValue('Stage') == "Cotizando") {
                $ofertas_cambios["Aseguradora"] = $_POST["aseguradora"];
                $this->api->updateRecord("Deals", $ofertas_cambios, $oferta_id);
            }

            if ($_FILES) {
                $rutaDeSubidas = dirname(__DIR__, 2) . "/file/contratos firmados/";
                if (!is_dir($rutaDeSubidas)) {
                    mkdir($rutaDeSubidas, 0777, true);
                }
                $extension = pathinfo($_FILES["firma"]["name"], PATHINFO_EXTENSION);
                $nombreArchivo = $oferta_id . "." . $extension;
                $nuevaUbicacion = $rutaDeSubidas . "/" . $nombreArchivo;
                $resultado = move_uploaded_file($_FILES["firma"]["tmp_name"], $nuevaUbicacion);
                if ($resultado === true) {
                    echo "Archivo subido correctamente";
                } else {
                    echo "Error al subir archivo";
                }
            }

            $pagina_de_destino = "details";
            header('Location: ?page=loading&destiny=' . $pagina_de_destino . '&id=' . $oferta_id);
        }
        require("core/views/template/header.php");
        require("core/views/home/complete.php");
        require("core/views/template/footer.php");
    }

    public function descargar2_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->api->getRecord("Deals", $oferta_id);
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        require("core/views/home/download_1.php");
    }

    public function descargar_poliza()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->api->getRecord("Deals", $oferta_id);
        $criterio = "Deal_Name:equals:" . $oferta_id;
        $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);
        require("core/views/home/download_2.php");
    }
}
