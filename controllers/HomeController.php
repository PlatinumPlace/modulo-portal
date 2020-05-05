<?php
class HomeController
{
    function __construct()
    {
        $this->cotizacion = new cotizacion;
    }
    public function error($alerta = null)
    {
        require_once("views/template/header.php");
        require_once("views/Home/error.php");
        require_once("views/template/footer.php");
    }
    public function pagina_principal()
    {
        $resultado = $this->cotizacion->total_mensual($_SESSION['usuario_id']);
        require_once("views/template/header.php");
        require_once("views/Home/index.php");
        require_once("views/template/footer.php");
    }
    public function cargando($nueva_url = null)
    {
        $url = explode("-", $nueva_url);
        $controlador = $url[0];
        $funcion = $url[1];
        $id = $url[2];
        require_once("views/template/header.php");
        require_once("views/Home/cargando.php");
        require_once("views/template/footer.php");
    }
}
