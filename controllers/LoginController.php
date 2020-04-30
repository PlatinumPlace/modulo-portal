<?php

class LoginController extends api
{

    public function __construct()
    {
        parent::__construct();
    }
    public function iniciar_sesion()
    {
        if (isset($_POST['submit'])) {
            $criterio = "((Email:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
            $contactos = $this->searchRecordsByCriteria("Contacts", $criterio);
            if (!empty($contactos)) {
                foreach ($contactos as $contacto) {
                    if (
                        $contacto->getFieldValue("Estado") == true
                        and
                        $contacto->getFieldValue("Sesi_n_activa") == false
                    ) {
                        $cambios["Sesi_n_activa"] = true;
                        $this->updateRecord("Contacts", $cambios, $contacto->getEntityId());
                        $_SESSION['usuario_id'] = $contacto->getEntityId();
                        $_SESSION['usuario_nombre'] = $contacto->getFieldValue("First_Name") . " " . $contacto->getFieldValue("Last_Name");
                        $_SESSION['empresa_id'] = $contacto->getFieldValue("Account_Name")->getEntityId();
                        $_SESSION['tiempo'] = time();
                        setcookie("usuario_id", $contacto->getEntityId(), time() + 259200);
                        header("Location:" . constant("url"));
                        exit();
                    } else {
                        $alerta = "El usuario no esta disponible.";
                    }
                }
            } else {
                $alerta = "El usuario o contraseña incorrectos.";
            }
        }
        require_once("views/login/entrar.php");
    }
    public function cerrar_sesion()
    {
        $cambios["Sesi_n_activa"] = false;
        $this->updateRecord("Contacts", $cambios, $_SESSION['usuario_id']);
        session_unset();
        session_destroy();
        setcookie("usuario_id", '', 1);
        header("Location:" . constant("url"));
        exit();
    }
}
