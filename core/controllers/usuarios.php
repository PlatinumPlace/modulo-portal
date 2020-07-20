<?php
class usuarios
{
    public function iniciar_sesion()
    {
        if ($_POST) {
            $api = new api;

            $criterio = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
            $usuarios = $api->buscar_criterio("Contacts", $criterio, 1, 1);

            if (!empty($usuarios)) {
                foreach ($usuarios as $usuario) {
                    if ($usuario->getFieldValue("Estado") == true) {
                        $_SESSION["usuario"]['id'] = $usuario->getEntityId();
                        $_SESSION["usuario"]['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                        $_SESSION["usuario"]['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();
                        $_SESSION["usuario"]['empresa_nombre'] = $usuario->getFieldValue("Account_Name")->getLookupLabel();
                        $_SESSION["usuario"]['tiempo_activo'] = time();
                    }
                }

                header("Location:" . constant("url"));
                exit();
            } else {
                $alerta = "Usuario o contraseña incorrectos.";
            }
        }
        require_once "core/views/usuarios/index.php";
    }

    public function cerrar_sesion()
    {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }
}
