<?php

if ($_POST) {

    $api = new api;

    $criterio = "((Email:equals:" . $_POST['Email'] . ") and (Contrase_a:equals:" . $_POST['Contrase_a'] . "))";

    $usuarios = $api->searchRecordsByCriteria("Contacts", $criterio, 1, 1);

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

require_once("pages/usuarios/iniciar_sesion_vista.php");
