<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zoho;

class UsuariosController extends Controller
{
    protected $api;

    function __construct(Zoho $api)
    {
        $this->api = $api;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("usuarios.crear");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $criteria = "((Email:equals:" . $request->input("email") . ") and (Contrase_a:equals:" . $request->input("contrase_a") . "))";
        if ($usuarios = $this->api->searchRecordsByCriteria("Contacts", $criteria, 1, 1)) {
            foreach ($usuarios as $usuario) {
                session()->put('id', $usuario->getEntityId());
                session()->put('nombre', $usuario->getFieldValue("First_Name") . " " . $usuario->getFieldValue("Last_Name"));
                session()->put('empresaid', $usuario->getFieldValue('Account_Name')->getEntityId());
                session()->put('usuario', $request->input("email"));
                session()->put('contrase_a', $request->input("contrase_a"));
                return redirect()->route("inicio");
            }
        } else {
            return back()->with("alerta", "Usuario no encontrado: correo o contraseña incorrectos");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("usuarios.editar");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->input("contrase_a_vieja") == session()->get('contrase_a')) {
            $this->api->update("Contacts", session("id"), ["Contrase_a" => $request->input("contrase_a_nueva")]);
            return back()->with("alerta", "Contraseña cambiada exitosamente, los cambios se reflejaran en el proximo inicio de sesión");
        } else {
            return back()->with("alerta", "Contraseña actual erronea");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        session()->flush();
        return redirect()->route("inicio");
    }
}
