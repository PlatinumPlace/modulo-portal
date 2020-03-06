<?php

function validar()
{
    $api = new api;
    $criterio = "((Usuario:equals:" . $_POST['usuario'] . ") and (Contrase_a:equals:" . $_POST['clave'] . "))";
    $contactos = $api->searchRecordsByCriteria("Contacts", $criterio);
    if (!empty($contactos)) {
        foreach ($contactos as $contacto) {
            if ($contacto->getFieldValue("Estado") == true) {
                session_start();
                $_SESSION["usuario"]["id"] = $contacto->getEntityId();
                $_SESSION["usuario"]["nombre"] = $contacto->getFieldValue('First_Name')." ".$contacto->getFieldValue('Last_Name');
                $_SESSION["usuario"]["cuenta"] = $contacto->getFieldValue('Account_Name')->getLookupLabel();
                header("Location: index.php");
            } else {
                return "El usuario no esta activado.";
            }
        }
    } else {
        return "Usuario o contraseña incorrectos.";
    }
}
