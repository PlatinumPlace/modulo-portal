<?php

include "api.php";
include "controller.php";

session_start();
$controller=new controller;

if (!isset($_SESSION["usuario"])) {
    $controller->ingresar();
    exit();
}

if (!empty($_GET["page"])) {
    if (method_exists($controller, $_GET["page"])) {
        $controller->{$_GET["page"]}();
    } else {
        $controller->error();
    }
} else {
    $controller->inicio();
}