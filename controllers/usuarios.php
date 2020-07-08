<?php

class usuarios
{
    public function iniciar_sesion()
    {
        if ($_POST) {
            $usuario = new usuario();
            $usuario->validar_usuario();
            if (isset($_SESSION["usuario"])) {
                header("Location:" . constant("url"));
                exit();
            } else {
                $alerta = "Usuario o contraseña incorrectos.";
            }
        }
        require_once "views/layout/header_login.php";
        require_once "views/usuarios/index.php";
        require_once "views/layout/footer_login.php";
    }
}
