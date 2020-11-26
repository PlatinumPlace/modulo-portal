<?php

namespace App\Http\Controllers\polizas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poliza;

class VidaController extends Controller
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
        return view("polizas.vida.crear", ["detalles" => $detalles, "planes" => $planes, "api" => $this->model]);
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
            "Coberturas" => $planid,
            "Comisi_n_aseguradora" => $comisionaseguradora,
            "Comisi_n_corredor" => $comisioncorredor,
            "Comisi_n_intermediario" => $comisionintermediario,
            "Correo_electr_nico" => $request->input("correo"),
            "Correo_electr_nico_codeudor" => $request->input("correo_codeudor"),
            "Direcci_n" => $request->input("direccion"),
            "Direcci_n_codeudor" => $request->input("direccion_codeudor"),
            "Estado" => "Activo",
            "Stage" => "Cerrado ganado",
            "Closing_Date" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
            "Fecha_de_nacimiento" => $request->input("fecha_nacimiento"),
            "Fecha_de_nacimiento_codeudor" => $request->input("fecha_nacimiento_codeudor"),
            "Amount" => $comisionnobe,
            "ISC" => $isc,
            "Nombre" => $request->input("nombre"),
            "Deal_Name" => $request->input("rnc_cedula"),
            "Plan" => $request->input("plantipo"),
            "Prima_neta" => $primaneta,
            "Prima_total" => $primatotal,
            "P_liza" => $poliza,
            "Ramo" => "",
            "RNC_C_dula" => $request->input("rnc_cedula"),
            "RNC_C_dula_codeudor" => $request->input("rnc_cedula_codeudor"),
            "Suma_asegurada" => $request->input("suma"),
            "Tel_Celular" => $request->input("telefono"),
            "Tel_Residencia" => $request->input("tel_residencia"),
            "Tel_Trabajo" => $request->input("tel_trabajo"),
            "Tel_Celular_codeudor" => $request->input("telefono_codeudor"),
            "Tel_Residencia_codeudor" => $request->input("tel_residencia_codeudor"),
            "Tel_Trabajo_codeudor" => $request->input("tel_trabajo_codeudor"),
            "Type" => "Vida",
            "Cuota" => $request->input("cuota"),
            "Plazo" => $request->input("plazo"),
            "Tipo_p_liza" => "Declarativa",
            "Vigencia_desde" => date("Y-m-d"),
            "Vigencia_hasta" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
        ];

        $id = $this->model->crear($registro);
        $this->model->actualizarCotizacion($request->input("id"), $id);
        $this->model->adjuntarArchivo($id, $request->file('cotizacion')->store('public'));
        return redirect("poliza/vida/$id");
    }

    public function show($id)
    {
        $detalles = $this->model->detalles($id);
        return view("polizas.vida.detalles", ["detalles" => $detalles,  "api" => $this->model]);
    }

    public function download($id)
    {
        $detalles = $this->model->detalles($id);
        $imagen = $this->model->rutaImagenAseguradora($detalles->getFieldValue('Aseguradora')->getEntityId());
        $planDetalles = $this->model->detallesPlan($detalles->getFieldValue('Coberturas')->getEntityId());
        return view("polizas.vida.descargar", ["detalles" => $detalles, "imagen" => $imagen, "planDetalles" => $planDetalles]);
    }
}
