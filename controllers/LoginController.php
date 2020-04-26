<?php

class LoginController extends api
{

    public function __construct()
    {
        parent::__construct();
    }
    public function entrar()
    {
        if (isset($_POST['submit'])) {
            $criterio = "((Email:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
            $contactos = $this->searchRecordsByCriteria("Contacts", $criterio);
            foreach ($contactos as $contacto) {
                if (
                    $contacto->getFieldValue("Estado") == true
                    and
                    $contacto->getFieldValue("Sesi_n_activa") == false
                ) {
                    $cambios["Sesi_n_activa"] = true;
                    $this->updateRecord("Contacts", $cambios, $contacto->getEntityId());
                    $_SESSION['usuario_id'] = $contacto->getEntityId();
                    $_SESSION['tiempo'] = time();
                    header("Location:" . constant("url"));
                    exit();
                } else {
                    $alerta = "El usuario no esta disponible.";
                }
            }
        }
        require_once("views/login/entrar.php");
    }
    public function salir()
    {
        session_destroy();
        $cambios["Sesi_n_activa"] = false;
        $this->updateRecord("Contacts", $cambios, $_SESSION['usuario_id']);
        header("Location:" . constant("url"));
        exit();
    }
    public function validar()
    {
        session_start();
        if (!isset($_SESSION["usuario_id"])) {
            $this->entrar();
            exit();
        } else {
            if (time() - $_SESSION['tiempo'] > 3600) {
                $this->salir();
            } else {
                $_SESSION['tiempo'] = time();
            }
        }
    }
}
