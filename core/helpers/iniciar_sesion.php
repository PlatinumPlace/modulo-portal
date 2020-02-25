<?php

$api = new api;
$criterio = "((Usuario:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
$contactos = $api->searchRecordsByCriteria("Contacts", $criterio);
if (!empty($contactos)) {
    foreach ($contactos as $contacto) {
        if ($contacto->getFieldValue("Estado") == true) {
            session_start();
            $_SESSION["usuario"]["id"] = $contacto->getEntityId();
            header("Location: index.php");
        } else {
            $mensaje = "El usuario no esta activado.";
        }
    }
} else {
    $mensaje = "Usuario o contraseña incorrectos.";
}
