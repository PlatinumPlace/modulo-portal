<?php
class Desvio extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->view->mensaje = "Ha ocurrido un error";
        $this->view->render("header");
        $this->view->render("error/index");
        $this->view->render("footer");

    }
}
