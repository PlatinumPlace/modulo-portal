<?php
class Login extends Api
{
    function __construct()
    {
        // inicializamos la clase api
        parent::__construct();
    }
    public function iniciar_sesion()
    {
        if (isset($_POST['submit'])) {
            // el criterio seria buscar todos los registros de contacto filtrados por el campo email y el campo contraseña
            $criterio = "((Email:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
            $contactos = $this->searchRecordsByCriteria("Contacts", $criterio);
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
                        exit;
                    } else {
                        $alerta = "El usuario no esta activado";
                    }
                }
            } else {
                $alerta = "Usuario o contraseña incorrectos";
            }
        }
        require("pages/login/index.php");
    }
    public function cerrar_sesion()
    {
        // elimina cualquer sesion abierta
        session_unset();
        session_destroy();
        // redirige al index con las variable de sesion eliminadas
        header("Location: index.php");
        exit;
    }
}
