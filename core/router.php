<?php
// Aqui se incluyen los controladores que usaremos
include "core/controllers/HomeController.php";
include "core/models/dealAPI.php";
include "core/models/productAPI.php";
include "core/models/quoteAPI.php";
include "core/models/vendorAPI.php";
include "zohoapi/config.php";

//Aqui tomas las petisiones get
if (isset($_GET["controller"]) && isset($_GET["action"])) {

    //Aqui tomamos el nombre del controlador y lo usamos para crear una instancia de la clase de ese controlador
    $Controller = $_GET["controller"];
    $Controller = new $Controller;

    // Usamos la funcion de PHP call_user_func para llamar una funcion dentro de la clase
    // De ser necesario podemos pasar un array con valores que podria usar la funcion que esatmos usando
    // Tambies podemos tomar esos valores pasandolo a la funcion usando GET
    call_user_func(array($Controller, $_GET["action"]));
} else {
    $home = new HomeController;
    call_user_func(array($home, "pagina_inicio"));
}
