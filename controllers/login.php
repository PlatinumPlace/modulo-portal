<?php
class Login extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function iniciar_sesion()
    {
        if ($_POST) {
            $criterio = "((Email:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
            $contactos = $this->api->searchRecordsByCriteria("Contacts", $criterio);
            if (!empty($contactos)) {
                foreach ($contactos as $contacto) {
                    if ($contacto->getFieldValue("Estado") == true) {
                        $_SESSION['usuario'] = $contacto->getEntityId();
                        $_SESSION["tiempo"] = time();
                        header("Location: index.php");
                    } else {
                        echo '<script>alert("El usuario no esta activado")</script>';
                    }
                }
            } else {
                echo '<script>alert("Usuario o contraseña incorrectos")</script>';
            }
        }
        $this->view->render("login/index");
    }
    public function cerrar_sesion()
    {
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
    public function validar_tiempo()
    {
        $inactividad = 3600;
        $sessionTTL = time() - $_SESSION["tiempo"];
        if ($sessionTTL > $inactividad) {
            $this->cerrar_sesion();
        }
    }
}
