<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zoho;

class CotizacionesVidaController extends Controller
{
    protected $api;

    function __construct(Zoho $api)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("cotizacionesVida.crear");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $planes = array();
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Vida))";
        $listaPlanes = $this->api->searchRecordsByCriteria("Products", $criterio, 1, 200);

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
                $criterio = "Plan:equals:" . $plan->getEntityId();
                $tasas = $this->api->searchRecordsByCriteria("Tasas", $criterio, 1, 200);
                foreach ($tasas as $tasa) {
                    switch ($tasa->getFieldValue('Tipo')) {
                        case 'Deudor':
                            $deudor = ($tasa->getFieldValue('Valor') / 100);
                            break;

                        case 'Codeudor':
                            $codeudor = ($tasa->getFieldValue('Valor') / 100);
                            break;

                        case 'Vida':
                            $vida = ($tasa->getFieldValue('Valor') / 100);
                            break;

                        case 'Desempleo':
                            $desempleo = $tasa->getFieldValue('Valor');
                            break;
                    }
                }

                if ($plan == "Vida") {
                    if (empty($edad_codeudor)) {
                        $prima = ($request->input("suma") / 1000) * $deudor;
                    } else {
                        $prima_deudor = ($request->input("suma") / 1000) * $deudor;
                        $prima_codeudor = ($request->input("suma") / 1000) * ($codeudor - $deudor);
                        $prima = $prima_deudor + $prima_codeudor;
                    }
                } else {
                    $prima_vida = ($request->input("suma") / 1000) * $vida;
                    $prima_desempleo =  ($request->input("cuota") / 1000) * $desempleo;
                    $prima = $prima_vida + $prima_desempleo;
                }
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
            "Tipo" => "Vida",
            "Suma_asegurada" =>  $request->input("suma"),
        ];

        $id = $this->api->createRecords("Quotes", $registro, $planes);
        return redirect()->route("cotizacionVida.show", $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizacionesVida.mostrar", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function descargar($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizacionesVida.descargar", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
    }
}
