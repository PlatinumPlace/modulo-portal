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
        $ofertas_emitidos = 0;
        $ofertas_vencen = 0;
        $ofertas_pendientes = 0;
        if (!empty($ofertas)) {
            foreach ($ofertas as $oferta) {

                $ofertas_totales += 1;

                $oferta_id = $oferta->getEntityId();

                $criterio = "Deal_Name:equals:" . $oferta_id;
                $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio);

                foreach ($cotizaciones as $cotizacion) {
                    if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till") . "- 1 year")) == date('Y-m-d')) {
                        $ofertas_emitidos++;
                    }
                    if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m-d')) {
                        $ofertas_vencen++;
                    }
                }
                if ($oferta->getFieldValue("Stage") == "Cotizando") {
                    $ofertas_pendientes++;
                }
            }
        }

        require("core/views/template/header.php");
        require("core/views/home/index.php");
        require("core/views/template/footer.php");
    }

    public function pantalla_de_carga()
    {
        require("core/views/template/header.php");
        require("core/views/home/load_page.php");
        require("core/views/template/footer.php");
    }

    public function cotizaciones_lista()
    {
        $criterio = "Contact_Name:equals:" . "3222373000000751142";
        $ofertas = $this->api->searchRecordsByCriteria("Deals", $criterio);
        $filtro = (isset($_GET['filter'])) ? $_GET['filter'] : "Cotizando/En trámite/Emitido/Abandonado";
        $estado = explode("/", $filtro);
        require("core/views/template/header.php");
        require("core/views/home/list.php");
        require("core/views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        if (isset($_POST["submit"])) {
            $oferta["Contact_Name"] = "3222373000000751142";
            $oferta["Lead_Source"] = "Portal GNB";
            $oferta["Deal_Name"] = "Trato realizado desde el portal";
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
            $pagina_de_destino = "details";
            header('Location: ?page=loading&destiny=' . $pagina_de_destino . '&id=' . $oferta_id);
        }
        require("core/views/template/header.php");
        require("core/views/home/create.php");
        require("core/views/template/footer.php");
    }

    public function detalles_cotizacion()
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
        require("core/views/home/details.php");
        require("core/views/template/footer.php");
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

    public function descargar_cotizacion()
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
