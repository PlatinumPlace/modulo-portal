<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Vehiculo;
use App\Models\Zoho;
use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    public function index($pagina = 1)
    {
        $api = new Zoho;
        $criterio = "Account_Name:equals:" . session("empresaid");
        if (!$lista = $api->searchRecordsByCriteria("Quotes", $criterio, $pagina, 10)) {
            $lista = array();
        }
        return view("cotizaciones.index", ["lista" => $lista, "pagina" => $pagina]);
    }

    public function buscar(Request $request)
    {
        $api = new Zoho;
        $criterio = "((Account_Name:equals:" . session("empresaid") . ") and (Quote_Number:equals:" . $request->input("busqueda") . "))";
        if (!$lista = $api->searchRecordsByCriteria("Quotes", $criterio, 1, 1)) {
            return back()->with("alerta", "No se pudo encontrar el parametro.");
        }
        return view("cotizaciones.index", ["lista" => $lista, "pagina" => 1]);
    }

    public function cotizar($tipo)
    {
        $api = new Zoho;
        switch ($tipo) {
            case 'vehiculo':
                $marcas = $api->getRecords("Marcas");
                asort($marcas);
                return view("cotizaciones.cotizar", ["tipo" => "vehiculo", "marcas" => $marcas]);
                break;

            case 'persona':
                return view("cotizaciones.cotizar", ["tipo" => "persona"]);
                break;
        }
    }

    public function modelosAJAX(Request $request)
    {
        $api = new Zoho;
        $pag = 1;
        $criterio = "Marca:equals:" . $request->input("marcaid");

        do {
            if ($modelos = $api->searchRecordsByCriteria("Modelos", $criterio, $pag, 200)) {
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

    public function vehiculo(Request $request)
    {
        $api = new Vehiculo;
        $modelo = explode(",", $request->input("modelo"));
        $modeloid = $modelo[0];
        $modelotipo = $modelo[1];
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Vehículo))";
        $listaPlanes = $api->searchRecordsByCriteria("Products", $criterio, 1, 200);
        $planes = array();

        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (in_array($request->input("uso"), $plan->getFieldValue('Restringir_veh_culos_de_uso'))) {
                $motivo = "Uso del vehículo restringido.";
            }

            if ((date("Y") - $request->input("a_o")) > $plan->getFieldValue('Max_antig_edad')) {
                $motivo = "La antigüedad del vehículo (" . (date("Y") - $request->input("a_o")) . ")  es mayor al limite establecido (" . $plan->getFieldValue('Max_antig_edad') . ")";
            }

            if ($api->verificarMarcaRestrida($plan->getFieldValue('Vendor_Name')->getEntityId(), $request->input("marca"))) {
                $motivo = "Marca restrigida.";
            }

            if ($api->verificarModeloRestringido($plan->getFieldValue('Vendor_Name')->getEntityId(), $modeloid)) {
                $motivo = "Modelo restrigido.";
            }

            if (empty($motivo)) {
                if ($prima = $api->calcularPrima($plan->getEntityId(), $modelotipo, $request->input("a_o"), $request->input("marca"), $request->input("suma"))) {
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
            "Tipo" => "Vehículo",
            "Tipo_veh_culo" => $modelotipo,
            "Suma_Asegurada" =>  $request->input("suma"),
            "Condiciones" =>  $request->input("condiciones")
        ];

        $id = $api->createRecords("Quotes", $registro, $planes);
        return redirect("cotizacion/$id");
    }

    public function persona(Request $request)
    {
        $api = new Persona;
        $id = $api->crear(
            $request->input("edad_deudor"),
            $request->input("edad_codeudor"),
            $request->input("plazo"),
            $request->input("cuota"),
            $request->input("plan"),
            $request->input("suma")
        );
        return redirect("cotizacion/$id");
    }

    public function detalles($id)
    {
        $api = new Zoho;
        $detalles = $api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.detalles", [
            "detalles" => $detalles,
            "planes" => $planes,
            "api" => $api
        ]);
    }

    public function descargar($id)
    {
        $api = new Zoho;
        $detalles = $api->getRecord("Quotes", $id);
        $planes = $detalles->getLineItems();
        return view("cotizaciones.descargar", [
            "detalles" => $detalles,
            "planes" => $planes,
            "api" => $api
        ]);
    }
}
