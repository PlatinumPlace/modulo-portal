<?php
class Controller
{
    // inicializa las clases view y api para usarlas como objetos de herencia
    function __construct()
    {
        $this->api = new Api;
        $this->view = new View;
    }
}
