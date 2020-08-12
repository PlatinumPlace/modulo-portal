<?php
class contactos
{
    public function index()
    {
        if ($_POST) {
            $api = new api;
            $criterio = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
            $result = $api->searchRecordsByCriteria("Contacts", $criterio, 1, 1);

            foreach ($result as $contacto) {
                if ($contacto->getFieldValue("Estado") == true) {
                    $_SESSION["usuario"]['id'] = $contacto->getEntityId();
                    $_SESSION["usuario"]['nombre'] = $contacto->getFieldValue("First_Name") . " " . $contacto->getFieldValue("Last_Name");
                    $_SESSION["usuario"]['empresa_id'] = $contacto->getFieldValue("Account_Name")->getEntityId();
                    $_SESSION["usuario"]['empresa_nombre'] = $contacto->getFieldValue("Account_Name")->getLookupLabel();
                    $_SESSION["usuario"]['tiempo_activo'] = time();

                    header("Location:" . constant("url"));
                    exit();
                }
            }

            $alerta =  "Usuario o contraseña incorrectos.";
        }

        require_once "views/contactos/index.php";
    }

    public function cerrar_sesion()
    {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }
}
