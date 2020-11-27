<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zoho;

class CotizacionesAutoController extends Controller
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
        $marcas = $this->api->getRecords("Marcas");
        sort($marcas);
        return view("cotizacionesAuto.crear", ["marcas" => $marcas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $modelo = explode(",", $request->input("modelo"));
        $modeloid = $modelo[0];
        $modelotipo = $modelo[1];
        $planes = array();

        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Auto))";
        $listaPlanes = $this->api->searchRecordsByCriteria("Products", $criterio, 1, 200);
        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (in_array($request->input("uso"), $plan->getFieldValue('Restringir_veh_culos_de_uso'))) {
                $motivo = "Uso del vehículo restringido.";
            }

            if ((date("Y") - $request->input("a_o")) > $plan->getFieldValue('Max_antig_edad')) {
                $motivo = "La antigüedad del vehículo (" . (date("Y") - $request->input("a_o")) . ")  es mayor al limite establecido (" . $plan->getFieldValue('Max_antig_edad') . ")";
            }

            $criterio = "((Marca:equals:" . $request->input("marca") . ") and (Aseguradora:equals:" . $plan->getFieldValue('Vendor_Name')->getEntityId() . "))";
            if ($marcas = $this->api->searchRecordsByCriteria("Restringidos", $criterio, 1, 200)) {
                foreach ($marcas as $marca) {
                    if (empty($marca->getFieldValue('Modelo'))) {
                        $motivo = "Marca restrigida.";
                    }
                }
            }

            $criterio = "((Modelo:equals:$modeloid) and (Aseguradora:equals:" . $plan->getFieldValue('Vendor_Name')->getEntityId() . "))";
            if ($modelos = $this->api->searchRecordsByCriteria("Restringidos", $criterio, 1, 200)) {
                foreach ($modelos as $modelo) {
                    $motivo = "Modelo restrigido.";
                }
            }

            if (empty($motivo)) {
                $criterio = "Plan:equals:" . $plan->getEntityId();
                $tasas = $this->api->searchRecordsByCriteria("Tasas", $criterio, 1, 200);
                foreach ($tasas as $tasa) {
                    if (
                        in_array($modelotipo, $tasa->getFieldValue('Grupo_de_veh_culo'))
                        and
                        $tasa->getFieldValue('A_o') == $request->input("a_o")
                    ) {
                        $tasavalor = $tasa->getFieldValue('Valor') / 100;
                    }
                }

                if ($tasavalor) {
                    $criterio = "Plan:equals:" . $plan->getEntityId();
                    if ($recargos = $this->api->searchRecordsByCriteria("Recargos", $criterio, 1, 200)) {
                        foreach ($recargos as $recargo) {
                            if (
                                $recargo->getFieldValue('Marca')->getEntityId() == $request->input("marca")
                                and
                                (($modelotipo == $recargo->getFieldValue("Tipo")
                                    or
                                    empty($recargo->getFieldValue("Tipo")))
                                    and
                                    ((empty($recargo->getFieldValue('Desde'))
                                        and
                                        empty($recargo->getFieldValue('Hasta')))
                                        or
                                        ($request->input("a_o") > $recargo->getFieldValue('Desde')
                                            and
                                            $request->input("a_o") < $recargo->getFieldValue('Hasta'))
                                        or
                                        ($request->input("a_o") > $recargo->getFieldValue('Desde')
                                            or
                                            $request->input("a_o") < $recargo->getFieldValue('Hasta'))))
                            ) {
                                $recargovalor = $recargo->getFieldValue('Valor') / 100;
                            }
                        }
                    }

                    if (!empty($recargovalor)) {
                        $tasavalor = ($tasavalor + ($tasavalor * $recargovalor));
                    }

                    $prima = $request->input("suma") * $tasavalor;

                    if ($prima < $plan->getFieldValue('Prima_m_nima')) {
                        $prima = $plan->getFieldValue('Prima_m_nima');
                    }

                    $prima = $prima / 12;
                } else {
                    $motivo = "No existen tasas para el tipo de vehículo especificado.";
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

        $id = $this->api->createRecords("Quotes", $registro, $planes);
        return redirect()->route("cotizacionAuto.show", $id);
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
        return view("cotizacionesAuto.mostrar", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
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

    public function modelos(Request $request)
    {
        $pag = 1;
        $criteria = "Marca:equals:" . $request->input("marcaid");

        do {
            if ($modelos = $this->api->searchRecordsByCriteria("Modelos", $criteria, $pag, 200)) {
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

    public function descargar($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizacionesAuto.descargar", ["detalles" => $detalles, "planes" => $planes, "api" => $this->api]);
    }
}
