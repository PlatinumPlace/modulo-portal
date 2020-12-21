<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Usuarios extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function editar()
    {
        return view("usuarios/editar");
    }

    public function cambiar()
    {
        if ($this->request->getVar("contrase_a_vieja") == session('contrase_a')) {
            $this->api->update("Contacts", session("id"), ["Contrase_a" => $this->request->getVar("contrase_a_nueva")]);
            return view("usuarios/editar", ["alerta" => "Contraseña cambiada exitosamente, los cambios se reflejaran en el proximo inicio de sesión"]);
        } else {
            return view("usuarios/editar", ["alerta" => "Contraseña actual erronea"]);
        }
    }
}
