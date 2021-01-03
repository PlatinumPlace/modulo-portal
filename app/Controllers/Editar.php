<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Editar extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function index()
    {
        return view("editar");
    }

    public function post()
    {
        if ($this->request->getVar("contrase_a_vieja") == session('contrase_a')) {
            $this->api->update("Contacts", session("id"), ["Contrase_a" => $this->request->getVar("contrase_a_nueva")]);
            $alerta = "Contraseña cambiada exitosamente, los cambios se reflejaran en el proximo inicio de sesión";
            return view("editar", ["alerta" => $alerta]);
        } else {
            return view("editar", ["alerta" => "Las contraseñas no coinciden"]);
        }
    }
}
