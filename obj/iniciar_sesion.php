<?php

class iniciar_sesion
{
    public $autenticar;

    function __construct()
    {
        $this->autenticacion = new autenticar;
    }

    public function verificar_usuario()
    {
        if ($_POST) {
            $resultado = $this->autenticacion->validar_usuario($_POST['usuario'], $_POST['clave']);
            if ($resultado == true) {
                header("Location: index.php");
            } elseif ($resultado == false) {
                $mensaje = "Usuario o Contraseña incorrectos";
            } else {
                //$mensaje = "Usuario desactivado";
            }
        }
        require("pages/iniciar_sesion/ingresar.php");
    }

    public function cerrar_sesion()
    {
        unset($_SESSION['usuario']);
        header("Location: index.php");
    }
}
