<?php

class App
{
    function __construct()
    {
        // toma la url (segun esta en el .htaccess), crear un array separado por /
        // el metodo seria: clases/funcion/valor
        $this->url = (isset($_GET['url'])) ? $_GET['url'] : null;
        $this->url = explode('/', rtrim($this->url, '/'));
    }
    public function iniciar_sesion()
    {
        require_once "libs/login.php";
        $login = new Login;
        $login->iniciar_sesion();
        return false;
    }
    public function validar_sesion()
    {
        // crea un limite de tiempo en seg para la sesion abierta
        $inactividad = 3600;
        // calcula si el tiempo de sesion hasta el momento
        $sessionTTL = time() - $_SESSION["tiempo"];
        // si la sesion es mayor al limite establecido
        if ($sessionTTL > $inactividad) {
            // inicia la funcion "cerrar_sesion" de la clase login
            require_once "libs/login.php";
            $login = new Login;
            $login->cerrar_sesion();
        }
    }
    public function login()
    {
        if (strtolower($this->url[0]) == "login") {
            require_once "libs/login.php";
            $login = new Login;
            if (isset($this->url[1]) and method_exists("login", $this->url[1])) {
                if (!empty($this->url[2])) {
                    $portal->{$this->url[1]}($this->url[2]);
                } else {
                    $portal->{$this->url[1]}();
                }
            } else {
                require("pages/error.php");
            }
        }
    }
    public function portal()
    {
        // valida si la no existe una peticion en la url
        // si no,redirege a la libreria principal
        // haciendo que el codigo termine aqui
        if (empty($this->url[0])) {
            require_once "libs/home.php";
            $portal = new Home;
            $portal->pagina_principal();
        } else {
            // si la url tiene una peticion
            // compara si la peticion existe entre los archivos de la capeta libs
            // (teniendo en cuenta que los archivos deben tener el mismo nombre que la peticion)
            // si existe,instancia esa clase y llama la funcion que le sigue luego del / en la peticion
            // (si existe un elemento luego de la funcion separado por /,lo toma como ..
            // ... variable dentro de la funcion)
            // si la libreria en la peticion no exite,redirige a la clase para errores
            // si existe la libreria pero no contiene la funcion de la peticion,redirige a ... 
            // ... la clase para errores
            $peticion = 'libs/' . strtolower($this->url[0]) . '.php';
            if (file_exists($peticion)) {
                require_once $peticion;
                $portal = new $this->url[0];
                if (isset($this->url[1]) and method_exists($this->url[0], $this->url[1])) {
                    if (!empty($this->url[2])) {
                        $portal->{$this->url[1]}($this->url[2]);
                    } else {
                        $portal->{$this->url[1]}();
                    }
                } else {
                    require("pages/error.php");
                }
            } else {
                require("pages/error.php");
            }
        }
        return false;
    }
}
