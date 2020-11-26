<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuariosController extends Controller
{
    protected $model;

    function __construct(Usuario $model)
    {
        $this->model = $model;
    }

    public function create()
    {
        return view("usuarios.crear");
    }

    public function store(Request $request)
    {
        if ($usuario = $this->model->validar($request->input("email"), $request->input("contrase_a"))) {
            session()->put('id', $usuario->getEntityId());
            session()->put('nombre', $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name"));
            session()->put('empresaid', $usuario->getFieldValue('Account_Name')->getEntityId());
            session()->put('usuario', $request->input("email"));
            session()->put('contrase_a', $request->input("contrase_a"));
            return redirect("/");
        } else {
            return back()->with("alerta", "Usuario o contraseña incorrectos");
        }
    }

    public function edit()
    {
        return view("usuarios.editar");
    }

    public function update(Request $request)
    {
        if ($request->input("contrase_a_vieja") == session()->get('contrase_a')) {
            $this->model->actualizar(session("id"), $request->input("contrase_a_nueva"));
            return back()->with("alerta", "Contraseña cambiada exitosamente, los cambios se reflejaran en el proximo inicio de sesión");
        } else {
            return back()->with("alerta", "Contraseña actual erronea");
        }
    }

    public function destroy()
    {
        session()->flush();
        return redirect("/");
    }
}
