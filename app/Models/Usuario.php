<?php

namespace App\Models;

class Usuario extends Zoho
{
    public function validar($email, $pass)
    {
        $criterio = "((Email:equals:$email) and (Contrase_a:equals:$pass))";
        if ($usuarios = $this->searchRecordsByCriteria("Contacts", $criterio, 1, 1)) {
            foreach ($usuarios as $usuario) {
                return $usuario;
            }
        }
    }

    public function actualizar($id, $pass)
    {
        $this->update("Contacts", $id, ["Contrase_a" => $pass]);
    }
}
