<?php

class usuarios
{
    public $usuario;

    function __construct()
    {
        $this->usuario = new usuario;
    }

    public function iniciar_sesion()
    {

        if (isset($_POST['submit'])) {

            $usuario_nuevo = $this->usuario->verificar($_POST['Email'], $_POST['Contrase_a']);

            if (!empty($usuario_nuevo)) {

                $resultado = $this->usuario->ingresar($usuario_nuevo);

                if (empty($resultado)) {
                    $alerta = "El usuario no esta disponible.";
                } else {
                    header("Location:" . constant("url"));
                    exit();
                }
            } else {
                $alerta = "El usuario o contraseña incorrectos.";
            }
        }

        require_once("core/views/template/header_login.php");
        require_once("core/views/usuarios/index.php");
        require_once("core/views/template/footer_login.php");
    }

    public function cerrar_sesion()
    {
        $this->usuario->salir();

        header("Location:" . constant("url"));
        exit;
    }

    public function continuar_sesion()
    {
        $this->usuario->continuar();
    }
}
