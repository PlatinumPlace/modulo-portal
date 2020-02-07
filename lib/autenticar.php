<?php

include "../api/vendor/autoload.php";
include "../models/api_model.php";

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

function autenticar($usuario, $clave)
{
    $api = new api_model;
    $criterio = "((Usuario:equals:" . $usuario . ") and (Contrase_a:equals:" . $clave . "))";
    $contactos = $api->searchRecordsByCriteria("Contacts", $criterio);
    if (!empty($contactos)) {
        foreach ($contactos as $contacto) {
            if ($contacto->getFieldValue("Estado") == true) {
                session_start();
                $_SESSION["usuario"]["nombre"] = $contacto->getFieldValue("First_Name");
                $_SESSION["usuario"]["id"] = $contacto->getEntityId();
                return true;
            } else {
                return "El usuario no esta activado.";
            }
        }
    } else {
        return false;
    }
}
