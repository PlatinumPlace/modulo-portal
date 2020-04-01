<?php
class Controller
{
    function __construct()
    {
        $this->view = new View;
        $this->api = new Api;
    }
}
