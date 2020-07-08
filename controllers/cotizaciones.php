<?php

class cotizaciones extends home
{
    public function buscar()
    {
        $url = $this->obtener_url();
        $filtro = (isset($url[0])) ? $url[0]  : null;
        $pagina = (isset($url[0])) ? $url[1]  : 1;

        require_once 'views/layout/header_main.php';
        require_once 'views/cotizaciones/buscar.php';
        require_once 'views/layout/footer_main.php';
    }
}
