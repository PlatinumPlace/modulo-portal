<?php

class HomeController
{
    public $dealAPI;
    public $productAPI;
    public $quoteAPI;

    function __construct()
    {
        $this->dealAPI = new dealAPI;
        $this->quoteAPI = new quoteAPI;
    }

    public function pagina_inicio()
    {
        $mydeals = $this->dealAPI->getRecords("3222373000000751142");
        //$mydeals = $this->deal->getRecords($_SESSION['user_id']);
        $ganancias_mensuales = 0;
        $ganancias_anuales = 0;
        $cotizaciones_pendientes = 0;
        foreach ($mydeals as $value) {
            if ($value["Stage"] == "Emitida" && date("m", strtotime($value["Closing_Date"] . "- 30 days")) == date('m')) {
                $ganancias_mensuales += $value["Amount"];
            }
            if ($value["Stage"] == "Emitida" && date("Y", strtotime($value["Closing_Date"] . "- 30 days")) == date('Y')) {
                $ganancias_anuales += $value["Amount"];
            }
            if ($value["Stage"] == "Cotizado") {
                $cotizaciones_pendientes += 1;
            }
        }

        require_once("core/views\home\inicio.php");
    }

    public function cotizaciones_pendientes()
    {
        $mydeals = $this->dealAPI->getRecords("3222373000000751142");
        //$mydeals = $this->deal->getRecords($_SESSION['user_id']);
        
        require_once("core/views\cotizaciones\cotizaciones_pendientes.php");
    }

    public function crear_cotizacion()
    {
        if ($_POST) {

            //$this->deal->Contact_Name = $_SESSION['user_id'];
            $this->dealAPI->Contact_Name = "3222373000000751142";
            $this->dealAPI->Direcci_n_del_asegurado = $_POST['Direcci_n_del_asegurado'];
            $this->dealAPI->A_o_de_Fabricacion = $_POST['A_o_de_Fabricacion'];
            $this->dealAPI->Chasis = $_POST['Chasis'];
            $this->dealAPI->Color = $_POST['Color'];
            $this->dealAPI->Email_del_asegurado = $_POST['Email_del_asegurado'];
            $this->dealAPI->Marca = $_POST['Marca'];
            $this->dealAPI->Modelo = $_POST['Modelo'];
            $this->dealAPI->Nombre_del_asegurado = $_POST['Nombre_del_asegurado'];
            $this->dealAPI->Placa = $_POST['Placa'];
            $this->dealAPI->Plan = $_POST['Plan'];
            $this->dealAPI->Ramo_de_la_p_liza = $_POST['Ramo_de_la_p_liza'];
            $this->dealAPI->RNC_Cedula_del_asegurado = $_POST['RNC_Cedula_del_asegurado'];
            $this->dealAPI->Telefono_del_asegurado = $_POST['Telefono_del_asegurado'];
            $this->dealAPI->Tipo_de_poliza = $_POST['Tipo_de_poliza'];
            $this->dealAPI->Tipo_de_vehiculo = $_POST['Tipo_de_vehiculo'];
            $this->dealAPI->Valor_Asegurado = $_POST['Valor_Asegurado'];
            $this->dealAPI->Es_nuevo = $retVal = ($_POST['Es_nuevo'] == 0) ? true : false;

            $dealid = $this->dealAPI->createRecord();
            if ($dealid != null) {
                header("Location: index.php?controller=HomeController&action=alerta&estado=exitoso&id=" . $dealid);
            } else {
                header("Location: index.php?controller=HomeController&action=alerta&estado=error");
            }
        }
        require_once("core/views\cotizaciones\crear.php");
    }

    public function alerta()
    {
        require_once("core/views\cotizaciones\alerta.php");
    }

    public function cotizacion_detalles()
    {
        $id = $_GET['id'];
        $deal = $this->dealAPI->getRecord($id);
        $quote = $this->quoteAPI->getRecordByCriteria($id);
        $productAPI = new productAPI;
        require_once("core/views\cotizaciones\detalles.php");
    }

    public function emitir_cotizacion()
    {
        $id = $_GET['id'];
        $quote = $this->quoteAPI->getRecordByCriteria($id);
        $productAPI = new productAPI;
        $vendorAPI = new vendorAPI;

        if ($_POST) {
            //$this->dealAPI->uploadAttachment($id, $_FILES["contratos"]["tmp_name"]);
        }

        require_once("core/views\cotizaciones/emitir.php");
    }
}
