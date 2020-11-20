<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class SesionesController extends Controller
{
    public function index()
    {
        return view("sesiones.index");
    }

    public function ingresar(Request $request)
    {
        $api = new Zoho;
        $criterio = "((Email:equals:" . $request->input("email") . ") and (Contrase_a:equals:" . $request->input("contrase_a") . "))";
        if ($usuarios = $api->searchRecordsByCriteria("Contacts", $criterio, 1, 1)) {
            foreach ($usuarios as $usuario) {
                session()->put('id', $usuario->getEntityId());
                session()->put('nombre', $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name"));
                session()->put('empresaid', $usuario->getFieldValue('Account_Name')->getEntityId());
                return redirect("/");
            }
        } else {
            return back()->with("alerta", "Usuario o contraseña incorrectos");
        }
    }

    public function salir()
    {
        session()->flush();
        return redirect("/");
    }
}
