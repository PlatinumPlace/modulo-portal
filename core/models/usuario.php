<?php

class usuario
{
    public $api;

    public function __construct()
    {
        $this->api = new api;
    }

    public function listaFiltrada()
    {
        $criteria = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
        return $this->api->searchRecordsByCriteria("Contacts", $criteria);
    }

    public function crearSesion()
    {
        $usuarios = $this->listaFiltrada();
        foreach ($usuarios as $usuario) {
            if ($usuario->getFieldValue("Estado") == true) {
                $_SESSION["usuario"]['id'] = $usuario->getEntityId();
                $_SESSION["usuario"]['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                $_SESSION["usuario"]['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();
                $_SESSION["usuario"]['empresa_nombre'] = $usuario->getFieldValue("Account_Name")->getLookupLabel();
                $_SESSION["usuario"]['tiempo_activo'] = time();
            }
        }
    }
}
