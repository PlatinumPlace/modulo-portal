<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function ingresar(Request $request)
    {
        if ($request->input()) {
            $api = new Zoho;
            $criteria = "((Email:equals:" . $request->input("email") . ") and (Contrase_a:equals:" . $request->input("contrase_a") . "))";
            $usuarios = $api->searchRecordsByCriteria("Contacts", $criteria, 1, 1);

            foreach ($usuarios as $usuario) {
                $request->session()->put('id',  $usuario->getEntityId());
                $request->session()->put('nombre', $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name"));
                $request->session()->put('empresaid', $usuario->getFieldValue('Account_Name')->getEntityId());
                $request->session()->put('empresa', $usuario->getFieldValue('Account_Name')->getLookupLabel());
                $request->session()->put('usuario', $usuario->getFieldValue("Email"));
                $request->session()->put('contrase_a',  $usuario->getFieldValue("Contrase_a"));
                return redirect()->route("inicio");
            }

            return back()->with('alerta', "Usuario o contraseña incorrectos");
        }

        return view("login.ingresar");
    }

    public function salir(Request $request)
    {
        $request->session()->flush();
        return redirect()->route("ingresar");
    }
}
