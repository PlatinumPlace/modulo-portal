<?php

class usuarios extends api
{
    function __construct()
    {
        parent::__construct();
    }

    public function iniciar_sesion()
    {
        if ($_POST) {

            $criterio = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
            $usuarios = $this->searchRecordsByCriteria("Contacts", $criterio, 1, 1);

            if ($usuarios) {
                foreach ($usuarios as $usuario) {
                    if ($usuario->getFieldValue("Estado") == true) {

                        $_SESSION["usuario"]['id'] = $usuario->getEntityId();
                        $_SESSION["usuario"]['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                        $_SESSION["usuario"]['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();
                        $_SESSION["usuario"]['empresa_nombre'] = $usuario->getFieldValue("Account_Name")->getLookupLabel();
                        $_SESSION["usuario"]['tiempo_activo'] = time();

                        header("Location:" . constant("url"));
                        exit();
                    } else {
                        $alerta = "El usuario no esta activo.";
                    }
                }
            } else {
                $alerta =  "Usuario o contraseña incorrectos.";
            }
        }
        require_once("core/views/layout/header_login.php");
        require_once("core/views/usuarios/login.php");
        require_once("core/views/layout/footer_login.php");
    }

    public function cerrar_sesion()
    {
        session_destroy();

        header("Location:" . constant("url"));
        exit();
    }
}
