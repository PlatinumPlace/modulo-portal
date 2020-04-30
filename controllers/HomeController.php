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
        $pendientes = 0;
        $emisiones = 0;
        $vencimientos = 0;
        $filtro_pendientes = "";
        $filtro_emisiones = "";
        $filtro_vencimientos = "";
        $emitida = array("Emitido", "En trámite");
        if (!empty($ofertas)) {
            foreach ($ofertas as $oferta) {
                $total += 1;
                if (
                    !in_array($oferta->getFieldValue("Stage"), $emitida)
                    and
                    date("Y-m", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                ) {
                    $pendientes += 1;
                    $filtro_pendientes = $oferta->getFieldValue("Stage");
                }
                if (
                    in_array($oferta->getFieldValue("Stage"), $emitida)
                    and
                    date("Y-m", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                ) {
                    $emisiones += 1;
                    $filtro_emisiones = $oferta->getFieldValue("Stage");
                }
                if (
                    in_array($oferta->getFieldValue("Stage"), $emitida)
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
            $resultado = $this->searchRecordsByCriteria("Deals", $criterio);
            if (empty($resultado)) {
                $alerta = "No se encontraron registros";
            }
        }
        require_once("views/header.php");
        require_once("views/home/buscar.php");
        require_once("views/footer.php");
    }
    public function cargando($nueva_url = null)
    {
        $url = explode("-", $nueva_url);
        $controlador = $url[0];
        $funcion = $url[1];
        $id = $url[2];
        require_once("views/header.php");
        require_once("views/home/cargando.php");
        require_once("views/footer.php");
    }
    public function lista($filtro = null)
    {
        $criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
        $resultado = $this->searchRecordsByCriteria("Deals", $criterio);
        require_once("views/header.php");
        require_once("views/home/lista.php");
        require_once("views/footer.php");
    }
}
