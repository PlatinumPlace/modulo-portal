<?php

class usuarios extends api
{
    public function crearSesion()
    {
        $criterio = "((Email:equals:" . $_POST['email'] . ") and (Contrase_a:equals:" . $_POST['pass'] . "))";
        $usuarios =  $this->searchRecordsByCriteria("Contacts", $criterio);
        foreach ($usuarios as $usuario) {
            $_SESSION["usuario"]['id'] = $usuario->getEntityId();
            $_SESSION["usuario"]['nombre'] = $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name");
            $_SESSION["usuario"]['empresa_id'] = $usuario->getFieldValue("Account_Name")->getEntityId();
            $_SESSION["usuario"]['empresa_nombre'] = $usuario->getFieldValue("Account_Name")->getLookupLabel();
            header("Location:?pagina=inicio");
            exit();
        }
    }
}
