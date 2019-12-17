<?php

class HomeController
{
    public $dealAPI;
    public $productAPI;
    public $quoteAPI;

    function __construct()
    {
        $this->dealAPI = new dealAPI;
        $this->productAPI= new productAPI;
        $this->quoteAPI= new quoteAPI;
    }

    public function pagina_inicio()
    {
        require_once("core/views\home\inicio.php");
    }

    public function mis_cotizaciones()
    {
        $mydeals = $this->dealAPI->getRecords("3222373000000751142");
        //$mydeals = $this->deal->getRecords($_SESSION['user_id']);
        require_once("core/views\cotizaciones\inicio.php");
    }

    public function crear_cotizacion()
    {
        if ($_POST) {

            //$this->deal->Contact_Name = $_SESSION['user_id'];
            $this->deal->Contact_Name = "3222373000000751142";
            $this->deal->Direcci_n_del_asegurado = $_POST['Direcci_n_del_asegurado'];
            $this->deal->A_o_de_Fabricacion = $_POST['A_o_de_Fabricacion'];
            $this->deal->Chasis = $_POST['Chasis'];
            $this->deal->Color = $_POST['Color'];
            $this->deal->Email_del_asegurado = $_POST['Email_del_asegurado'];
            $this->deal->Marca = $_POST['Marca'];
            $this->deal->Modelo = $_POST['Modelo'];
            $this->deal->Nombre_del_asegurado = $_POST['Nombre_del_asegurado'];
            $this->deal->Placa = $_POST['Placa'];
            $this->deal->Plan = $_POST['Plan'];
            $this->deal->Ramo_de_la_p_liza = $_POST['Ramo_de_la_p_liza'];
            $this->deal->RNC_Cedula_del_asegurado = $_POST['RNC_Cedula_del_asegurado'];
            $this->deal->Telefono_del_asegurado = $_POST['Telefono_del_asegurado'];
            $this->deal->Tipo_de_poliza = $_POST['Tipo_de_poliza'];
            $this->deal->Tipo_de_vehiculo = $_POST['Tipo_de_vehiculo'];
            $this->deal->Valor_Asegurado = $_POST['Valor_Asegurado'];

            $dealid = $this->deal->createRecord();
            header("Location: index.php?controller=dealController&action=index");
        }
        require_once("core/views\cotizaciones\crear.php");
    }

    public function cotizacion_detalles()
    {
        $id = $_GET['id'];
        $deal = $this->deal->getRecord($id);
        $quote = new quoteAPI;
        $products = $quote->getRecordByCriteria($id);
        $productsDetail = new productAPI;
        require_once("core/views\cotizaciones\detalles.php");
    }
}