<?php

class HomeController extends api
{
    public function __construct()
    {
        parent::__construct();
    }
    public function pagina_principal()
    {
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        $ofertas = $this->searchRecordsByCriteria("Deals", $criterio);
        $total = 0;
        $emisiones = 0;
        $vencimientos = 0;
        $filtro_emisiones = "";
        $filtro_vencimientos = "";
        if (!empty($ofertas)) {
            foreach ($ofertas as $oferta) {
                $total += 1;
                if (
                    $oferta->getFieldValue("Cliente") != null
                    and
                    date("Y-m", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                ) {
                    $emisiones += 1;
                    $filtro_emisiones = $oferta->getFieldValue("Stage");
                }
                if (
                    $oferta->getFieldValue("Cliente") != null
                    and
                    date("Y-m", strtotime($oferta->getFieldValue("Closing_Date"))) == date('Y-m')
                ) {
                    $vencimientos += 1;
                    $filtro_vencimientos = $oferta->getFieldValue("Stage");
                }
            }
        }
        require_once("views/header.php");
        require_once("views/home/pagina_principal.php");
        require_once("views/footer.php");
    }
    public function buscar()
    {
        if (isset($_POST['submit'])) {
            $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
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
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        $resultado = $this->searchRecordsByCriteria("Deals", $criterio);
        require_once("views/header.php");
        require_once("views/home/lista.php");
        require_once("views/footer.php");
    }
}
