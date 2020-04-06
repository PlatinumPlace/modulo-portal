<?php
class View
{
    // toma el nombre del archivo .php y lo busca en la carpeta views
    // NOTA:se existe subcarperta: seria subcarpeta/vista.php
    public function render($nombre)
    {
        require "views/" . $nombre . ".php";
    }
}
