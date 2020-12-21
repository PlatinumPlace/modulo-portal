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
        return view("login/ingresar");
    }

    public function ingresar()
    {
        $criteria = "((Email:equals:" . $this->request->getVar("email") . ") and (Contrase_a:equals:" . $this->request->getVar("contrase_a") . "))";
        if ($usuarios = $this->api->searchRecordsByCriteria("Contacts", $criteria, 1, 1)) {
            foreach ($usuarios as $usuario) {
                session()->set('id',  $usuario->getEntityId());
                session()->set('nombre', $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name"));
                session()->set('empresaid', $usuario->getFieldValue('Account_Name')->getEntityId());
                session()->set('empresa', $usuario->getFieldValue('Account_Name')->getLookupLabel());
                session()->set('usuario', $usuario->getFieldValue("Email"));
                session()->set('contrase_a',  $usuario->getFieldValue("Contrase_a"));
            }
        }

        if (session()->has("usuario")) {
            return redirect()->to(site_url());
        } else {
            return view("login/ingresar", ["alerta" => "Usuario o contraseña incorrectos"]);
        }
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to(site_url());
    }
}
