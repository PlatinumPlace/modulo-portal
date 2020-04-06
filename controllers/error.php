<?php
class Desvio extends Controller
{
    function __construct()
    {
        // inicializamos la clase controller
        parent::__construct();
        // asignamos un mensaje que se mostrara en la vista
        $this->view->mensaje = "Ha ocurrido un error";
        // llamamos a la vista
        $this->view->render("header");
        $this->view->render("error/index");
        $this->view->render("footer");

    }
}
