<?php

namespace App\Http\Controllers\Polizas;

use App\Http\Controllers\Controller;
use App\Models\Poliza;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    protected $model;

    function __construct(Poliza $model)
    {
        $this->model = $model;
    }
    
    public function create($id)
    {
        $detalles = $this->model->detallesCotizacion($id);
        $planes = $detalles->getLineItems();
        return view("polizas.auto.crear", ["detalles" => $detalles, "planes" => $planes, "api" => $this->model]);
    }

    public function store(Request $request)
    {
        $plan = explode(",", $request->input("plan"));
        $planid = $plan[0];
        $primaneta = $plan[1];
        $isc = $plan[2];
        $primatotal = $plan[3];
        $poliza = $plan[4];
        $comisionnobe = $plan[5];
        $comisionintermediario = $plan[6];
        $comisionaseguradora = $plan[7];
        $comisioncorredor = $plan[8];
        $aseguradoraid = $plan[9];

        $registro = [
            "Account_Name" => session("empresaid"),
            "Contact_Name" => session("id"),
            "Apellido" => $request->input("apellido"),
            "Aseguradora" => $aseguradoraid,
            "A_o_veh_culo" => $request->input("a_o"),
            "Chasis" => $request->input("chasis"),
            "Coberturas" => $planid,
            "Color" => $request->input("color"),
            "Comisi_n_aseguradora" => $comisionaseguradora,
            "Comisi_n_corredor" => $comisioncorredor,
            "Comisi_n_intermediario" => $comisionintermediario,
            "Condiciones" => $request->input("condiciones"),
            "Correo_electr_nico" => $request->input("correo"),
            "Direcci_n" => $request->input("direccion"),
            "Estado" => "Activo",
            "Stage" => "Cerrado ganado",
            "Closing_Date" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
            "Fecha_de_nacimiento" => $request->input("fecha_nacimiento"),
            "Amount" => $comisionnobe,
            "ISC" => $isc,
            "Marca" => $request->input("marca"),
            "Modelo" => $request->input("modelo"),
            "Nombre" => $request->input("nombre"),
            "Deal_Name" => $request->input("chasis"),
            "Placa" => $request->input("placa"),
            "Plan" => $request->input("plantipo"),
            "Prima_neta" => $primaneta,
            "Prima_total" => $primatotal,
            "P_liza" => $poliza,
            "Ramo" => "Automóvil",
            "RNC_C_dula" => $request->input("rnc_cedula"),
            "Suma_asegurada" => $request->input("suma"),
            "Tel_Celular" => $request->input("telefono"),
            "Tel_Residencia" => $request->input("tel_residencia"),
            "Tel_Trabajo" => $request->input("tel_trabajo"),
            "Type" => "Auto",
            "Tipo_p_liza" => "Declarativa",
            "Tipo_veh_culo" => $request->input("modelotipo"),
            "Uso" => $request->input("uso"),
            "Vigencia_desde" => date("Y-m-d"),
            "Vigencia_hasta" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
        ];

        $id = $this->model->crear($registro);
        $this->model->actualizarCotizacion($request->input("id"), $id);
        $this->model->adjuntarArchivo($id, $request->file('cotizacion')->store('public'));
        return redirect("poliza/auto/$id");
    }

    public function show($id)
    {
        $detalles = $this->model->detalles($id);
        return view("polizas.auto.detalles", ["detalles" => $detalles,  "api" => $this->model]);
    }

    public function download($id)
    {
        $detalles = $this->model->detalles($id);
        $imagen = $this->model->rutaImagenAseguradora($detalles->getFieldValue('Aseguradora')->getEntityId());
        $planDetalles = $this->model->detallesPlan($detalles->getFieldValue('Coberturas')->getEntityId());
        return view("polizas.auto.descargar", ["detalles" => $detalles, "imagen" => $imagen, "planDetalles" => $planDetalles]);
    }
}
