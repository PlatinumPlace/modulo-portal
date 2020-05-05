<?php
class LoginController
{
    function __construct()
    {
        $this->usuario = new usuario;
    }
    public function iniciar_sesion()
    {
        if (isset($_POST['submit'])) {
            $resultado =  $this->usuario->validar();
            if (!empty($resultado)) {
                $usuario = $this->usuario->verificar_sesion($resultado);
                if (!empty($usuario)) {
                    $this->usuario->iniciar_sesion($usuario);
                    header("Location:" . constant("url"));
                    exit();
                } else {
                    $alerta = "El usuario no esta disponible.";
                }
            } else {
                $alerta = "El usuario o contraseña incorrectos.";
            }
        }
        require_once("views/template/header_login.php");
        require_once("views/Usuarios/index.php");
        require_once("views/template/footer_login.php");
    }
    public function cerrar_sesion()
    {
        $this->usuario->cerrar_sesion();
        header("Location:" . constant("url"));
        exit();
    }
}
