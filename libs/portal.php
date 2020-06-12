<?php

class portal
{
    public function obtener_url()
    {
        $resultado = array();
        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);
        foreach ($url as $campo => $valor) {
            if ($campo >= 2) {
                $resultado[] = $valor;
            }
        }
        return $resultado;
    }
}
