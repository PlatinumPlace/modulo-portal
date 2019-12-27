<?php

class CotizacionController
{
    public $Deals;
    public $Quotes;

    function __construct()
    {
        $this->oferta = new Deals;
        $this->Quotes = new Quotes;
    }

    public function lista()
    {
        $tratos = $this->oferta->buscar_por_contacto("3222373000000751142");
        $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : "Cotizado/En trámite/Emitido/Abandonado";
       
        require("core/views/template/header.php");
        require("core/views/cotizacion/lista.php");
        require("core/views/template/footer.php");
    }

    public function crear_auto()
    {
        if ($_POST) {

            $this->oferta->Contact_Name = "3222373000000751142";
            $this->oferta->Direcci_n_del_asegurado = $_POST['Direcci_n_del_asegurado'];
            $this->oferta->A_o_de_Fabricacion = $_POST['A_o_de_Fabricacion'];
            $this->oferta->Chasis = $_POST['Chasis'];
            $this->oferta->Color = $_POST['Color'];
            $this->oferta->Email_del_asegurado = $_POST['Email_del_asegurado'];
            $this->oferta->Marca = $_POST['Marca'];
            $this->oferta->Modelo = $_POST['Modelo'];
            $this->oferta->Nombre_del_asegurado = $_POST['Nombre_del_asegurado'];
            $this->oferta->Placa = $_POST['Placa'];
            $this->oferta->Plan = $_POST['Plan'];
            $this->oferta->Type = "Vehículo";
            $this->oferta->RNC_Cedula_del_asegurado = $_POST['RNC_Cedula_del_asegurado'];
            $this->oferta->Telefono_del_asegurado = $_POST['Telefono_del_asegurado'];
            $this->oferta->Tipo_de_poliza = $_POST['Tipo_de_poliza'];
            $this->oferta->Tipo_de_vehiculo = $_POST['Tipo_de_vehiculo'];
            $this->oferta->Valor_Asegurado = $_POST['Valor_Asegurado'];
            $this->oferta->Stage = "Prospeccion";
            $this->oferta->Es_nuevo = ($_POST['Es_nuevo'] == 0) ? true : false;

            $oferta_id = $this->oferta->crear();

            header("?page=alerta");
        }
        require("core/views/template/header.php");
        require("core/views/cotizacion/crear.php");
        require("core/views/template/footer.php");
    }

    public function detalles()
    {
        $id = $_GET['id'];
        $trato = $this->ZohoAPI->getRecord("Deals", $id);
        $cotizacion = $this->Quotes->getRecordByOtherId($id);
        $productos = new Products;
        require_once("core/views\cotizacion\detalles.php");
    }

    public function emitir_poliza()
    {
        $id = $_GET['id'];
        $cotiazcion = $this->Quotes->getRecordByOtherId($id);
        $productos = new Products;

        if ($_POST) {
            $this->dealsAPI->Aseguradora = $_POST["aseguradora"];
            $this->dealsAPI->Stage = "En trámite";
            $this->ZohoAPI->updateRecord("Deals", $id,$this->dealsAPI);

            if ($_FILES) {
                $rutaDeSubidas = dirname(__DIR__, 2) . "/file/contratos firmados/" . $id;
                if (!is_dir($rutaDeSubidas)) {
                    mkdir($rutaDeSubidas, 0777, true);
                }
                $extension = pathinfo($_FILES["firmas"]["name"], PATHINFO_EXTENSION);
                $nombreArchivo = "Contrato Firmado." . $extension;
                $nuevaUbicacion = $rutaDeSubidas . "/" . $nombreArchivo;
                $resultado = move_uploaded_file($_FILES["firmas"]["tmp_name"], $nuevaUbicacion);
                if ($resultado === true) {
                    echo "Archivo subido correctamente";
                } else {
                    echo "Error al subir archivo";
                }
            }
            header("Location: index.php?controller=HomeController&action=alerta&estado=exitoso&origen=cotizaciones/emitir_poliza&id=" . $id);
        }

        require_once("core/views\cotizacion/emitir_poliza.php");
    }
}
