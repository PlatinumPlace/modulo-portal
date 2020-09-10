<?php
class usuarios
{
    public function ingresar()
    {
        if ($_POST) {
            $usuario = new usuario();
            $usuario->crearSesion();

            if (!$_SESSION["usuario"]) {
                header("Location:" . constant("url") . "usuarios/ingresar?alert=Usuario o contraseña incorrectos");
                exit();
            } else {
                header("Location:" . constant("url"));
                exit();
            }
        }
        
        require_once "core/views/usuarios/index.php";
    }

    function salir()
    {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }
}
