<?php
class Login extends Controller
{
    function __construct()
    {
        // inicializamos las clases api y view del controlador padre
        parent::__construct();
    }
    public function iniciar_sesion()
    {
        // si existe post
        if (isset($_POST['submit'])) {
            // el criterio seria buscar todos los registros de contacto filtrados por el campo email y el campo contraseña
            $criterio = "((Email:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
            $contactos = $this->api->searchRecordsByCriteria("Contacts", $criterio);
            // si el criterio existe
            if (!empty($contactos)) {
                // NOTA: teniendo en cuenta que el campo email del crm es unico,solo habra 1 registro en el foreach
                foreach ($contactos as $contacto) {
                    // filtra que registros estan en estado activo
                    if ($contacto->getFieldValue("Estado") == true) {
                        // toma el id del usurio en una variable de sesion
                        $_SESSION['usuario'] = $contacto->getEntityId();
                        // toma el tiempo unix en una varible de sesion
                        $_SESSION["tiempo"] = time();
                        // redirige al index con las variable de sesion creadas
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
        // elimina cualquer sesion abierta
        session_unset();
        session_destroy();
        // redirige al index con las variable de sesion eliminadas
        header("Location: index.php");
    }
    public function validar_tiempo()
    {
        // crea un limite de tiempo en seg para la sesion abierta
        $inactividad = 3600;
        // calcula si el tiempo de sesion hasta el momento
        $sessionTTL = time() - $_SESSION["tiempo"];
        // si la sesion es mayor al limite establecido
        if ($sessionTTL > $inactividad) {
            // inicia la funcion "cerrar_sesion" de la clase login
            $this->cerrar_sesion();
        }
    }
}
