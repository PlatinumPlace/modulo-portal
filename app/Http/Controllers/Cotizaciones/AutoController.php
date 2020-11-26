<?php

namespace App\Http\Controllers\Cotizaciones;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion\Auto;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    protected $model;

    function __construct(Auto $model)
    {
        $this->model = $model;
    }

    public function create()
    {
        $marcas = $this->model->listaMarcas();
        asort($marcas);
        return view("cotizaciones.auto.crear", ["marcas" => $marcas]);
    }

    public function ajax(Request $request)
    {
        $pag = 1;
        do {
            if ($modelos = $this->model->listaModelos($request->input("marcaid"), $pag)) {
                $pag++;
                asort($modelos);
                foreach ($modelos as $modelo) {
                    echo '<option value="' . $modelo->getEntityId() . "," . $modelo->getFieldValue('Tipo') . '">' . strtoupper($modelo->getFieldValue('Name')) . '</option>';
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);
    }

    public function store(Request $request)
    {
        $modelo = explode(",", $request->input("modelo"));
        $modeloid = $modelo[0];
        $modelotipo = $modelo[1];
        $planes = $this->model->seleccionarPlanes(
            $request->input("uso"),
            $request->input("a_o"),
            $request->input("marca"),
            $modeloid,
            $modelotipo,
            $request->input("suma")
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
            "Fecha_de_nacimiento" => $request->input("fecha_nacimiento"),
            "Tel_Celular" => $request->input("telefono"),
            "Tel_Residencia" => $request->input("tel_residencia"),
            "Tel_Trabajo" => $request->input("tel_trabajo"),
            "Plan" => $request->input("plan"),
            "A_o" => $request->input("a_o"),
            "Marca" => $request->input("marca"),
            "Modelo" => $modeloid,
            "Uso" => $request->input("uso"),
            "Tipo" => "Auto",
            "Tipo_veh_culo" => $modelotipo,
            "Suma_asegurada" =>  $request->input("suma"),
            "Condiciones" =>  $request->input("condiciones")
        ];
        $id = $this->model->crear($registro, $planes);
        return redirect("cotizacion/auto/$id");
    }

    public function show($id)
    {
        $detalles = $this->model->detalles($id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.auto.detalles", ["detalles" => $detalles, "planes" => $planes, "api" => $this->model]);
    }

    public function download($id)
    {
        $detalles = $this->model->detalles($id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.auto.descargar", ["detalles" => $detalles, "planes" => $planes, "api" => $this->model]);
    }
}
