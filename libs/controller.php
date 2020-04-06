<?php
class Controller
{
    // inicializa las clases view y api para usarlas como objetos de herencia
    function __construct()
    {
        $this->view = new View;
        $this->api = new Api;
    }
}
