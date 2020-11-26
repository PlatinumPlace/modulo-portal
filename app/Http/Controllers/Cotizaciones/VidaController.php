<?php

namespace App\Http\Controllers\Cotizaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion\Vida;

class VidaController extends Controller
{
    protected $model;

    function __construct(Vida $model)
    {
        $this->model = $model;
    }

    public function create()
    {
        return view("cotizaciones.vida.crear");
    }

    public function store(Request $request)
    {
        $planes = $this->model->seleccionarPlanes(
            $request->input("edad_deudor"),
            $request->input("edad_codeudor"),
            $request->input("plazo"),
            $request->input("suma"),
            $request->input("cuota")
        );
        $registro = [
            "Subject" => "Cotización",
            "Account_Name" => session("empresaid"),
            "Contact_Name" => session("id"),
            "Nombre" => $request->input("nombre"),
            "Apellido" => $request->input("apellido"),
            "RNC_C_dula" => $request->input("rnc_cedula"),
            "Correo_electr_nico" => $request->input("correo"),
            "Direcci_n" => $request->input("direccion"),
            "Tel_Celular" => $request->input("telefono"),
            "Tel_Residencia" => $request->input("tel_residencia"),
            "Tel_Trabajo" => $request->input("tel_trabajo"),
            "Plan" => $request->input("plan"),
            "Edad_codeudor" => $request->input("edad_codeudor"),
            "Edad_deudor" => $request->input("edad_deudor"),
            "Cuota" => $request->input("cuota"),
            "Plazo" => $request->input("plazo"),
            "Tipo" => "Vida",
            "Suma_asegurada" =>  $request->input("suma"),
        ];
        $id = $this->model->crear($registro, $planes);
        return redirect("cotizacion/vida/$id");
    }

    public function show($id)
    {
        $detalles = $this->model->detalles($id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.vida.detalles", ["detalles" => $detalles, "planes" => $planes, "api" => $this->model]);
    }

    public function download($id)
    {
        $detalles = $this->model->detalles($id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.vida.descargar", ["detalles" => $detalles, "planes" => $planes, "api" => $this->model]);
    }
}
