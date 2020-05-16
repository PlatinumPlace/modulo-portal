<?php

class LoginController
{
    public $usuario;

    function __construct()
    {
        $this->usuario = new usuario;
    }

    public function index()
    {

        if (isset($_POST['submit'])) {

            $usuario_nuevo = $this->usuario->verificar($_POST['Email'], $_POST['Contrase_a']);

            if (!empty($usuario_nuevo)) {

                $resultado = $this->usuario->ingresar($usuario_nuevo);

                if (empty($resultado)) {
                    $alerta = "El usuario no esta disponible.";
                } else {
                    header("Location: " . constant('url'));
                    exit();
                }
            } else {
                $alerta = "El usuario o contraseña incorrectos.";
            }
        }

        require_once("core/views/login/index.php");
    }

    public function cerrar_sesion()
    {
        $this->usuario->salir();

        header("Location: " . constant('url'));
        exit;
    }
}
