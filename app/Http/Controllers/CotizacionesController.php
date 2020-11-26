<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Cotizacion;
use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    protected $model;

    function __construct(Cotizacion $model)
    {
        $this->model = $model;
    }

    public function index($pag = 1)
    {
        if (!$cotizaciones = $this->model->lista($pag, 10)) {
            $cotizaciones = array();
        }
        return view("cotizaciones.index", ["cotizaciones" => $cotizaciones, "pag" => $pag]);
    }

    public function search(Request $request)
    {
        if (!$cotizaciones = $this->model->buscar($request->input("busqueda"))) {
            $cotizaciones = array();
        }
        return view("cotizaciones.index", ["cotizaciones" => $cotizaciones, "pag" => 1]);
    }

    public function create()
    {
        return view("cotizaciones.crear");
    }

    public function persona(Request $request)
    {
        $api = new Persona;
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Persona))";
        $listaPlanes = $api->searchRecordsByCriteria("Products", $criterio, 1, 200);
        $planes = array();

        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (
                $request->input("edad_deudor") > $plan->getFieldValue('Edad_max')
                or
                (!empty($request->input("edad_codeudor"))
                    and
                    $request->input("edad_codeudor") > $plan->getFieldValue('Edad_max'))
            ) {
                $motivo = "La edad del deudor/codeudor es mayor al limite establecido.";
            }

            if (
                $request->input("edad_deudor") < $plan->getFieldValue('Edad_min')
                or (!empty($request->input("edad_codeudor"))
                    and
                    $request->input("edad_codeudor") < $plan->getFieldValue('Edad_min'))
            ) {
                $motivo = "La edad del deudor/codeudor es menor al limite establecido.";
            }

            if ($request->input("plazo") > $plan->getFieldValue('Plazo_max')) {
                $motivo = "El plazo es mayor al limite establecido.";
            }

            if ($request->input("suma") > $plan->getFieldValue('Suma_asegurada_max')) {
                $motivo = "La suma asegurada es mayor al limite establecido.";
            }

            if (empty($motivo)) {
                $prima = $api->calcularPrima(
                    $plan->getEntityId(),
                    $request->input("plan"),
                    $request->input("cuota"),
                    $request->input("suma"),
                    $request->input("edad_codeudor")
                );
            }

            $planes[] = ["id" => $plan->getEntityId(), "precio" => $prima, "descripcion" => $motivo];
        }

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
            "Tipo" => "Persona",
            "Suma_asegurada" =>  $request->input("suma"),
        ];

        $id = $api->createRecords("Quotes", $registro, $planes);
        return redirect("cotizacion/$id");
    }
}
