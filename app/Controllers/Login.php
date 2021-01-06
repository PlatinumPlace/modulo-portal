<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Login extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function index()
    {
        if ($this->request->getVar()) {
            $criteria = "((Email:equals:" . $this->request->getVar("email") . ") and (Contrase_a:equals:" . $this->request->getVar("contrase_a") . "))";
            $usuarios = $this->api->searchRecordsByCriteria("Contacts", $criteria, 1, 1);
            foreach ($usuarios as $usuario) {
                session()->set('id',  $usuario->getEntityId());
                session()->set('nombre', $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name"));
                session()->set('empresaid', $usuario->getFieldValue('Account_Name')->getEntityId());
                session()->set('empresa', $usuario->getFieldValue('Account_Name')->getLookupLabel());
                session()->set('usuario', $usuario->getFieldValue("Email"));
                session()->set('contrase_a',  $usuario->getFieldValue("Contrase_a"));
            }

            if (session()->has('id')) {
                return redirect()->to(site_url());
            } else {
                session()->setFlashdata("alerta", "Usuario o contraseña incorrectos");
                return redirect()->back();
            }
        }

        return view("login/index");
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to(site_url());
    }

    public function editar()
    {
        if ($this->request->getVar()) {
            if ($this->request->getVar("contrase_a_vieja") == session('contrase_a')) {
                $this->api->update("Contacts", session("id"), ["Contrase_a" => $this->request->getVar("contrase_a_nueva")]);

                session()->setFlashdata("alerta", "Contraseña cambiada exitosamente, los cambios se reflejaran en el proximo inicio de sesión");
                return redirect()->back();
            } else {
                session()->setFlashdata("alerta", "Usuario o contraseña incorrectos");
                return redirect()->back();
            }
        }

        return view("usuarios/editar");
    }
}
