<?php

class autenticar
{
    public $api;

    function __construct()
    {
        $this->api = new api;
    }

    public function validar_usuario($usuario, $clave)
    {
        $criterio = "((Usuario:equals:" . $usuario . ") and (Contrase_a:equals:" . $clave . "))";
        $contactos = $this->api->searchRecordsByCriteria("Contacts", $criterio);

        if (!empty($contactos)) {
            foreach ($contactos as $contacto) {
                if ($contacto->getFieldValue("Estado") == true) {
                    session_start();
                    $_SESSION["usuario"]["nombre"] = $contacto->getFieldValue("First_Name");
                    $_SESSION["usuario"]["id"] = $contacto->getEntityId();
                } else {
                    //
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
