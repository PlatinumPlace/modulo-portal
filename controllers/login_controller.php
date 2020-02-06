<?php

class login_controller
{
    public function autenticacion()
    {
        $mensaje="";
        if ($_POST) {
            $api = new api_model;
            $criterio = "((Usuario:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
            $contactos = $api->searchRecordsByCriteria("Contacts", $criterio);
            if (!empty($contactos)) {
                foreach ($contactos as $contacto) {
                    if ($contacto->getFieldValue("Estado") == true) {
                        session_start();
                        $_SESSION["usuario"]["nombre"] = $contacto->getFieldValue("First_Name");
                        $_SESSION["usuario"]["id"] = $contacto->getEntityId();
                        header("Location: index.php");
                    }else {
                        $mensaje="El usuario no esta activado.";
                    }
                }
            }else {
                $mensaje="Usuario o contraseña incorrectos.";
            }
        }
        require("views/login/ingresar.php");
    }

    public function cerrar_sesion()
    {
        unset($_SESSION['usuario']);
        header("Location: index.php");
    }
}
