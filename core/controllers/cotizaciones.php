<?php

class cotizaciones
{
    public $dealsAPI;
    public $productsAPI;
    public $quotesAPI;

    function __construct()
    {
        $this->dealsAPI = new dealsAPI;
        $this->quotesAPI = new quotesAPI;
    }

    public function inicio()
    {
        $tratos = $this->dealsAPI->getRecords("3222373000000751142");
        $filtro= (isset($_GET['filtro'])) ? $_GET['filtro'] : "Cotizado/En trámite/Emitido/Abandonado" ;
        //$mydeals = $this->deal->getRecords($_SESSION['user_id']);

        require_once("core/views\cotizaciones\inicio.php");
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

            $tratoid = $this->dealsAPI->createRecord();

            if ($tratoid != null) {
                header("Location: index.php?controller=HomeController&action=alerta&origen=cotizaciones/crear&estado=exitoso&id=" . $tratoid);
            } else {
                header("Location: index.php?controller=HomeController&action=alerta&estado=error");
            }
        }
        require_once("core/views\cotizaciones\crear.php");
    }

    public function detalles()
    {
        $id = $_GET['id'];
        $trato = $this->dealsAPI->getRecord($id);
        $cotizacion = $this->quotesAPI->getRecordByCriteria($id);
        $productos = new productsAPI;
        require_once("core/views\cotizaciones\detalles.php");
    }

    public function emitir_poliza()
    {
        $id = $_GET['id'];
        $cotiazcion = $this->quotesAPI->getRecordByCriteria($id);
        $productos = new productsAPI;

        if ($_POST) {
            $this->dealsAPI->Aseguradora = $_POST["aseguradora"];
            $this->dealsAPI->Stage = "En trámite";
            $this->dealsAPI->updateRecord($id);

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

        require_once("core/views\cotizaciones/emitir_poliza.php");
    }
}