<?php

class usuarios extends api
{
    function __construct()
    {
        parent::__construct();
    }

    public function validar_usuario($correo, $pass)
    {
        $criterio = "((Email:equals:$correo) and (Contrase_a:equals:$pass))";
        $usuarios = $this->searchRecordsByCriteria("Contacts", $criterio, 1, 1);
        if ($usuarios) {
            foreach ($usuarios as $usuario) {
                if ($usuario->getFieldValue("Estado") == true) {
                    $_SESSION["usuario"]['id'] = $usuario->getEntityId();
                    $_SESSION["usuario"]['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
                    $_SESSION["usuario"]['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();
                    $_SESSION["usuario"]['tiempo_activo'] = time();
                    header("Location:" . constant("url"));
                    exit();
                } else {
                    return "El usuario no esta activo.";
                }
            }
        } else {
            return "Usuario o contraseña incorrectos.";
        }
    }
}
