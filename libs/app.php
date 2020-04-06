<?php
// incluyen clases que haran referencia en mas de una ocacion
require_once "controllers/error.php";
require_once "controllers/login.php";
class App
{
    function __construct()
    {
        // toma la url (segun esta en el .htaccess), crear un array separado por /
        // el metodo seria: controlador/funcion/id o valor que se desea usar
        // TENER EN CUENTA QUE: 
        // solo la clase principal se llama sin una funcion (porque utiliza un constructor)
        $url = (isset($_GET['url'])) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        // reanuda o inicia las sesiones dentro del portal
        session_start();
        $sesion = new Login;
        // verifica el tiempo que tiene el usuario (si existe),
        // si no existe,no hace nada,
        // si el tiempo es menor al establecido no hace nada,si no,mata las sesion y redirige a index
        if (isset($_SESSION['tiempo'])) {
            $sesion->validar_tiempo();
        }
        // verifica no existe un usuario,
        // si no existe,redirige al controlador login para iniciar sesion,
        // haciendo que el codigo termine aqui
        if (!isset($_SESSION['usuario'])) {
            $sesion->iniciar_sesion();
            return false;
        }
        // valida si la no existe una peticion en la url
        // si no,redirege al controlador principal
        // haciendo que el codigo termine aqui
        if (empty($url[0])) {
            require_once "controllers/home.php";
            $controlador = new Home;
            return false;
        }
        // si la url tiene una peticion
        // compara si la peticion existe entre los archivos de la capeta controller
        // (teniendo en cuenta que los archivos deben tener el mismo nombre que la peticion)
        // si existe,instancia esa clase y llama la funcion que le sigue luego del / en la peticion
        // (si existe un elemento luego de la funcion separado por /,lo toma como variable dentro de la funcion)
        // si el controlador en la peticion no exite,redirige a la clase para errores
        // si existe el controlador pero no contiene la funcion de la peticion,redirige a la clase para errores
        $peticion = 'controllers/' . $url[0] . '.php';
        if (file_exists($peticion)) {
            require_once $peticion;
            $controlador = new $url[0];
            if (isset($url[1]) and method_exists($url[0], $url[1])) {
                if (isset($url[2])) {
                    $controlador->{$url[1]}($url[2]);
                } else {
                    $controlador->{$url[1]}();
                }
            } else {
                $controlador = new Desvio;
            }
        } else {
            $controlador = new Desvio;
        }
    }
}
