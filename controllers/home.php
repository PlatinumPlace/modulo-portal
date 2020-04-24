<?php

class HomeController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        $tratos = $this->searchRecordsByCriteria("Deals", $criterio);
        $total = 0;
        $emisiones = 0;
        $vencimientos = 0;
        $filtro_emisiones = "";
        $filtro_vencimientos = "";
        if (!empty($tratos)) {
            foreach ($tratos as $trato) {
                $total += 1;
                if (
                    $trato->getFieldValue("Cliente") != null
                    and
                    date("Y-m", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                ) {
                    $emisiones += 1;
                    $filtro_emisiones = $trato->getFieldValue("Stage");
                }
                if (
                    $trato->getFieldValue("Cliente") != null
                    and
                    date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date('Y-m')
                ) {
                    $vencimientos += 1;
                    $filtro_vencimientos = $trato->getFieldValue("Stage");
                }
            }
        }
        require_once("views/header.php");
        require_once("views/home/index.php");
        require_once("views/footer.php");
    }
    public function buscar()
    {
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        if (isset($_POST['submit'])) {
            switch ($_POST['parametro']) {
                case 'numero':
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (No_Cotizaci_n:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'id':
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (RNC_Cedula:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'nombre':
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (Nombre:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'apellido':
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (Apellido:equals:" . $_POST['busqueda'] . "))";
                    break;
                case 'chasis':
                    $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (Chasis:equals:" . $_POST['busqueda'] . "))";
                    break;
            }
        }
        $resultado = $this->searchRecordsByCriteria("Deals", $criterio);
        require_once("views/header.php");
        require_once("views/home/buscar.php");
        require_once("views/footer.php");
    }
    public function cargando($datos)
    {
        $informacion = explode("-", $datos);
        $id = $informacion[0];
        $origen = $informacion[1];
        require_once("views/header.php");
        require_once("views/home/cargando.php");
        require_once("views/footer.php");
    }
    public function lista($datos)
    {
        $filtro = $datos;
        $criterio = "Contact_Name:equals:" .  $_SESSION['usuario_id'];
        $resultado = $this->searchRecordsByCriteria("Deals", $criterio);
        require_once("views/header.php");
        require_once("views/home/lista.php");
        require_once("views/footer.php");
    }
}
