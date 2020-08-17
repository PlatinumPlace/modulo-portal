<?php

class usuarios extends api {

    function ingresar_usuario() {
        $criterio = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
        $result = $this->searchRecordsByCriteria("Contacts", $criterio);
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
    }

}
