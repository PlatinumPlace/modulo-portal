<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zoho;

class PolizasAutoController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("polizasAuto.crear", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            "Stage" => "En trámite",
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

        $id =  $this->api->createRecords("Deals", $registro);

        $this->api->update("Quotes", $request->input("id"), ["Deal_Name" => $id]);

        $ruta = $request->file('cotizacion')->store("public");
        $this->api->uploadAttachment("Deals", $id, storage_path("app/$ruta"));
        unlink(storage_path("app/$ruta"));

        return redirect()->route("polizaAuto.show", $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalles = $this->api->getRecord("Deals", $id);
        return view("polizasAuto.mostrar", ["detalles" => $detalles, "api" => $this->api]);
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
        $detalles = $this->api->getRecord("Deals", $id);
        $imagen = $this->api->downloadPhoto("Vendors", $detalles->getFieldValue('Aseguradora')->getEntityId());
        $planDetalles = $this->api->getRecord("Products", $detalles->getFieldValue('Coberturas')->getEntityId());
        return view("polizasAuto.descargar", ["detalles" => $detalles, "imagen" => $imagen, "planDetalles" => $planDetalles]);
    }
}
