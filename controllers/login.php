<?php

class LoginController extends Api
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
                    if ($contacto->getFieldValue("Estado") == true) {
                        $_SESSION['usuario_id'] = $contacto->getEntityId();
                        $_SESSION['tiempo'] = time();
                        header("Location: index.php");
                        exit();
                    } else {
                        $alerta = "El usuario no esta activado";
                    }
                }
            } else {
                $alerta = "Usuario o contraseña incorrectos";
            }
        }
        require_once("views/login/index.php");
    }
    public function cerarr_sesion()
    {
        session_destroy();
        header("Location:" . constant("url"));
    }
}
