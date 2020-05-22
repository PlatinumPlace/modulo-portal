<?php

class usuario extends api
{

    function __construct()
    {
        parent::__construct();
    }

    public function verificar($Email, $Contrase_a)
    {
        $criterio = "((Email:equals:$Email) and (Contrase_a:equals:$Contrase_a))";
        return $this->searchRecordsByCriteria("Contacts", $criterio);
    }

    public function ingresar($usuarios)
    {
        foreach ($usuarios as $usuario) {

            if ($usuario->getFieldValue("Estado") == true) {

                $sesion['id'] = $usuario->getEntityId();
                $sesion['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                $sesion['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();

                setcookie("usuario", json_encode($sesion), time() + 3600,"/");

                return true;
            }
        }
    }

    public function salir()
    {
        setcookie("usuario", '', time() - 1, "/" );
    }

    public function continuar()
    {        
        $usuario = json_decode($_COOKIE["usuario"], true);

        $this->salir();

        setcookie("usuario", json_encode($usuario), time() + 3600,"/");
    }
}
