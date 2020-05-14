<?php

class usuario extends zoho_api
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

            if ($usuario->getFieldValue("Estado") == true and $usuario->getFieldValue("Sesi_n_activa") == false) {

                $cambios["Sesi_n_activa"] = true;
                $this->updateRecord("Contacts", $usuario->getEntityId(), $cambios);

                $_SESSION['usuario_id'] = $usuario->getEntityId();
                $_SESSION['usuario_nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                $_SESSION['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();
                $_SESSION['tiempo'] = time();
                setcookie("usuario_id", $usuario->getEntityId(), time() + 259200);
                setcookie("tiempo", time(), time() + 259200);

                header("Location:" . constant("url"));
                exit();
            }
        }
    }

    public function salir()
    {
        $cambios["Sesi_n_activa"] = false;
        $this->updateRecord("Contacts", $_SESSION['usuario_id'], $cambios);

        session_destroy();
        setcookie("usuario_id", '', time() - 1, "/portal");
        setcookie("tiempo", '', time() - 1, "/portal");
    }
}
