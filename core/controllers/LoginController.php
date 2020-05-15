<?php

class LoginController
{

    public function index()
    {
        $usuario = new usuario;

        if (isset($_POST['submit'])) {

            $usuario_nuevo = $usuario->verificar($_POST['Email'], $_POST['Contrase_a']);

            if (!empty($usuario_nuevo)) {

                $resultado = $usuario->ingresar($usuario_nuevo);

                if (empty($resultado)) {

                    $alerta = "El usuario no esta disponible.";
                }
            } else {
                $alerta = "El usuario o contraseña incorrectos.";
            }
        }

        require_once("core/views/login/index.php");
    }

    public function cerrar_sesion()
    {
        $usuario = new usuario;

        $usuario->salir();

        header("Location:" . constant("url"));
    }

}
