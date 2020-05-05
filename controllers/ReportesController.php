<?php
class ReportesController
{
    function __construct()
    {
        $this->reporte = new reporte;
    }
    public function index()
    {
        $contratos = $this->reporte->obtener_contratos($_SESSION['empresa_id']);
        if (isset($_POST["excel"])) {
             
        }
        if (isset($_POST["pdf"])) {
             
        }
        require_once("views/template/header.php");
        require_once("views/Reportes/index.php");
        require_once("views/template/footer.php");
    }
}
