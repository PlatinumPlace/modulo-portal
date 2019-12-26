<?php

class CotizacionController
{
    public $Deals;
    public $Quotes;

    function __construct()
    {
        $this->Deals = new Deals;
        $this->ZohoAPI = new ZohoAPI;
        $this->Quotes = new Quotes;
    }

    public function lista()
    {
        $tratos = $this->ZohoAPI->getMyRecords("Deals", "3222373000000751142");
        $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : "Cotizado/En trámite/Emitido/Abandonado";
        //$mydeals = $this->deal->getRecords($_SESSION['user_id']);

        require_once("core/views\cotizacion\lista.php");
    }

    public function crear()
    {
        if ($_POST) {

            //$this->dealsAPI->Contact_Name = $_SESSION['user_id'];
            $this->dealsAPI->Contact_Name = "3222373000000751142";
            $this->dealsAPI->Direcci_n_del_asegurado = $_POST['Direcci_n_del_asegurado'];
            $this->dealsAPI->A_o_de_Fabricacion = $_POST['A_o_de_Fabricacion'];
            $this->dealsAPI->Chasis = $_POST['Chasis'];
            $this->dealsAPI->Color = $_POST['Color'];
            $this->dealsAPI->Email_del_asegurado = $_POST['Email_del_asegurado'];
            $this->dealsAPI->Marca = $_POST['Marca'];
            $this->dealsAPI->Modelo = $_POST['Modelo'];
            $this->dealsAPI->Nombre_del_asegurado = $_POST['Nombre_del_asegurado'];
            $this->dealsAPI->Placa = $_POST['Placa'];
            $this->dealsAPI->Plan = $_POST['Plan'];
            $this->dealsAPI->Type = "Vehículo";
            $this->dealsAPI->RNC_Cedula_del_asegurado = $_POST['RNC_Cedula_del_asegurado'];
            $this->dealsAPI->Telefono_del_asegurado = $_POST['Telefono_del_asegurado'];
            $this->dealsAPI->Tipo_de_poliza = $_POST['Tipo_de_poliza'];
            $this->dealsAPI->Tipo_de_vehiculo = $_POST['Tipo_de_vehiculo'];
            $this->dealsAPI->Valor_Asegurado = $_POST['Valor_Asegurado'];
            $this->dealsAPI->Stage = "Prospeccion";
            $this->dealsAPI->Es_nuevo = $retVal = ($_POST['Es_nuevo'] == 0) ? true : false;

            $tratoid = $this->ZohoAPI->createRecord("Deals", $this->dealsAPI);
        }
        require_once("core/views\cotizacion\crear.php");
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
