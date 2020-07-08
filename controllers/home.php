<?php

class home
{
    function error()
    {
        require_once 'views/home/error.php';
    }

    public function index()
    {
        $resumen = new resumen;
        $resultado = $resumen->resumen();
        require_once 'views/layout/header_main.php';
        require_once 'views/home/index.php';
        require_once 'views/layout/footer_main.php';
    }

    public function obtener_url()
    {
        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);
        $resultado = array();
        $cont = 0;
        foreach ($url as $posicion => $valor) {
            if ($posicion > 1) {
                $resultado[$cont] = $valor;
                $cont++;
            }
        }
        return $resultado;
    }
}
