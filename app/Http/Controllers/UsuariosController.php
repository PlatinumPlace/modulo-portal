<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function editar(Request $request)
    {
        if ($request->input()) {
            if ($this->request->input("contrase_a_vieja") == session('contrase_a')) {
                $api = new Zoho;
                $api->update("Contacts", session("id"), ["Contrase_a" => $request->input("contrase_a_nueva")]);
                return back()->with('alerta', "Contraseña cambiada exitosamente, los cambios se reflejaran en el proximo inicio de sesión");
            } else {
                return back()->with('alerta', "Usuario o contraseña incorrectos");
            }
        }

        return view("usuarios.editar");
    }
}
