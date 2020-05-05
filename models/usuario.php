<?php
class usuario extends zoho_api
{
    function __construct()
    {
        parent::__construct();
    }
    public function validar()
    {
        $Email = $_POST['Email'];
        $Contrase_a = $_POST['Contrase_a'];
        $criterio = "((Email:equals:$Email) and (Contrase_a:equals:$Contrase_a))";
        $usuarios = $this->searchRecordsByCriteria("Contacts", $criterio);
        if (!empty($usuarios)) {
            foreach ($usuarios as $usuario) {
                return $usuario;
            }
        }
    }
    public function verificar_sesion($usuario)
    {
        if ($usuario->getFieldValue("Estado") == true and $usuario->getFieldValue("Sesi_n_activa") == false) {
            $cambios["Sesi_n_activa"] = true;
            $this->updateRecord("Contacts", $cambios, $usuario->getEntityId());
            return $usuario;
        }
    }
    public function iniciar_sesion($usuarios)
    {
        $_SESSION['usuario_id'] = $usuarios->getEntityId();
        $_SESSION['usuario_nombre'] = $usuarios->getFieldValue("First_Name") . " " . $usuarios->getFieldValue("Last_Name");
        $_SESSION['empresa_id'] = $usuarios->getFieldValue("Account_Name")->getEntityId();
        $_SESSION['tiempo'] = time();
        setcookie("usuario_id", $usuarios->getEntityId(), time() + 259200);
    }
    public function cerrar_sesion()
    {
        $cambios["Sesi_n_activa"] = false;
        $this->updateRecord("Contacts", $cambios, $_SESSION['usuario_id']);
        session_unset();
        session_destroy();
        setcookie("usuario_id", '', 1);
    }
}
