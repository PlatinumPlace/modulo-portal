<?php

class HomeController
{
    public $ofertas;
    public $cotizaciones;
    public $productos;

    function __construct()
    {
        $this->ofertas = new Deals;
        $this->cotizaciones = new Quotes;
        $this->productos = new Products;
        $this->coberturas = new Coberturas;
    }

    public function pagina_principal()
    {
        $ofertas = $this->ofertas->buscar_por_contacto("3222373000000751142");
        $tratos_totales = 0;
        $tratos_emitidos = 0;
        $tratos_vencen = 0;
        $tratos_pendientes = 0;

        if (!empty($ofertas)) {
            foreach ($ofertas as $trato) {

                $tratos_totales += 1;

                if ($trato["Stage"] == "En trámite" || $trato["Stage"] == "Emitido" && date("m", strtotime($trato["Closing_Date"] . "- 1 month")) == date('m')) {
                    $tratos_emitidos += 1;
                }
                if ($trato["Stage"] == "En trámite" && date("m", strtotime($trato["Closing_Date"] . "- 1 month")) == date('m')) {
                    $tratos_vencen += 1;
                }
                if ($trato["Stage"] == "Cotizando") {
                    $tratos_pendientes += 1;
                }
            }
        }

        require("core/views/template/header.php");
        require("core/views/home/index.php");
        require("core/views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        if ($_POST) {

            foreach ($_POST as $key => $value) {
                echo $value;
            }

            $this->ofertas->Contact_Name = "3222373000000751142";
            $this->ofertas->Direcci_n_del_asegurado = $_POST['Direcci_n_del_asegurado'];
            $this->ofertas->A_o_de_Fabricacion = (int) $_POST['A_o_de_Fabricacion'];
            $this->ofertas->Chasis = $_POST['Chasis'];
            $this->ofertas->Color = $_POST['Color'];
            $this->ofertas->Email_del_asegurado = $_POST['Email_del_asegurado'];
            $this->ofertas->Marca = $_POST['Marca'];
            $this->ofertas->Modelo = $_POST['Modelo'];
            $this->ofertas->Nombre_del_asegurado = $_POST['Nombre_del_asegurado'];
            $this->ofertas->Apellido_del_asegurado = $_POST['Apellido_del_asegurado'];
            $this->ofertas->Placa = $_POST['Placa'];
            $this->ofertas->Plan = $_POST['Plan'];
            $this->ofertas->Type = "Vehículo";
            $this->ofertas->RNC_Cedula_del_asegurado = $_POST['RNC_Cedula_del_asegurado'];
            $this->ofertas->Telefono_del_asegurado = $_POST['Telefono_del_asegurado'];
            $this->ofertas->Tipo_de_poliza = $_POST['Tipo_de_poliza'];
            $this->ofertas->Tipo_de_vehiculo = $_POST['Tipo_de_vehiculo'];
            $this->ofertas->Valor_Asegurado = $_POST['Valor_Asegurado'];
            $this->ofertas->Es_nuevo = ($_POST['Es_nuevo'] == 0) ? true : false;

            $oferta_id = $this->ofertas->crear();
            $pagina_de_destino = "details";

            header('Location: ?page=loading&destiny=' . $pagina_de_destino . '&id=' . $oferta_id);
        }
        require("core/views/template/header.php");
        require("core/views/home/create.php");
        require("core/views/template/footer.php");
    }

    public function pantalla_de_carga()
    {
        require("core/views/template/header.php");
        require("core/views/home/load_page.php");
        require("core/views/template/footer.php");
    }

    public function detalles_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->ofertas->detalles($oferta_id);
        $cotizaciones = $this->cotizaciones->buscar_por_oferta($oferta_id);
        require("core/views/template/header.php");
        require("core/views/home/details.php");
        require("core/views/template/footer.php");
    }

    public function cotizaciones_lista()
    {
        $ofertas = $this->ofertas->buscar_por_contacto("3222373000000751142");
        $filtro = (isset($_GET['filter'])) ? $_GET['filter'] : "Cotizando/En trámite/Emitido/Abandonado";
        $estado = explode("/", $filtro);
        require("core/views/template/header.php");
        require("core/views/home/list.php");
        require("core/views/template/footer.php");
    }

    public function completar_cotizacion()
    {
        $oferta_id = $_GET['id'];
        $oferta = $this->ofertas->detalles($oferta_id);
        $cotizaciones = $this->cotizaciones->buscar_por_trato($oferta_id);

        if ($_POST) {
            if ($oferta['Stage'] == "Cotizando") {
                $this->ofertas->Aseguradora = $_POST["aseguradora"];
                $this->ofertas->actualizar($oferta_id);
            }

            if ($_FILES) {
                $rutaDeSubidas = dirname(__DIR__, 2) . "/file/contratos firmados/" . $oferta_id;
                if (!is_dir($rutaDeSubidas)) {
                    mkdir($rutaDeSubidas, 0777, true);
                }
                $extension = pathinfo($_FILES["firma"]["name"], PATHINFO_EXTENSION);
                $nombreArchivo = "Contrato Firmado." . $extension;
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
}
