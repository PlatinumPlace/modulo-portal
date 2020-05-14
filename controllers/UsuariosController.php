<?php

class UsuariosController
{

    public function index()
    {
        $usuario = new usuario;
        if (isset($_POST['submit'])) {
            $nuevo_usuario = $usuario->verificar($_POST['Email'], $_POST['Contrase_a']);
            if (!empty($nuevo_usuario)) {
                $resultado = $usuario->ingresar($nuevo_usuario);
                if (empty($resultado)) {
                    $alerta = "El usuario no esta disponible.";
                }
            } else {
                $alerta = "El usuario o contraseña incorrectos.";
            }
        }

        require_once("views/usuarios/index.php");
    }

    public function cerrar_sesion()
    {
        $usuario = new usuario;
        $usuario->salir();
        header("Location:" . constant("url"));
    }
}
