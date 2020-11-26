<?php

namespace App\Http\Controllers;

use App\Models\Poliza;
use Illuminate\Http\Request;

class PolizasController extends Controller
{
    protected $model;

    function __construct(Poliza $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $pag = 1;
        $emisiones = 0;
        $vencimientos = 0;
        $aseguradoras = array();

        do {
            if ($polizas = $this->model->lista($pag)) {
                $pag++;
                foreach ($polizas as $poliza) {
                    if (date("Y-m", strtotime($poliza->getFieldValue("Vigencia_desde"))) == date('Y-m')) {
                        $emisiones++;
                        $aseguradoras[] = $poliza->getFieldValue('Aseguradora')->getLookupLabel();
                    }

                    if (date("Y-m", strtotime($poliza->getFieldValue("Vigencia_hasta"))) == date('Y-m')) {
                        $vencimientos++;
                    }
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);

        $aseguradoras = array_count_values($aseguradoras);

        return view("polizas.index", [
            "emisiones" => $emisiones,
            "vencimientos" => $vencimientos,
            "aseguradoras" => $aseguradoras
        ]);
    }

    public function list($pag = 1)
    {
        if (!$polizas = $this->model->lista($pag, 10)) {
            $polizas = array();
        }

        return view("polizas.lista", ["polizas" => $polizas, "pag" => $pag]);
    }

    public function search(Request $request)
    {
        if (!$polizas = $this->model->buscar($request->input("parametro"), $request->input("busqueda"))) {
            $polizas = array();
        }

        return view("polizas.lista", ["polizas" => $polizas, "pag" => 1]);
    }

    public function emisiones()
    {
        $pag = 1;

        do {
            if ($polizas = $this->model->lista($pag)) {
                $pag++;
                foreach ($polizas as $poliza) {
                    if (date("Y-m", strtotime($poliza->getFieldValue("Vigencia_desde"))) == date('Y-m')) {
                        $emisiones[] = $poliza;
                    }
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);

        return view("polizas.emisiones", ["polizas" => $emisiones]);
    }

    public function vencimientos()
    {
        $pag = 1;

        do {
            if ($polizas = $this->model->lista($pag)) {
                $pag++;
                foreach ($polizas as $poliza) {
                    if (date("Y-m", strtotime($poliza->getFieldValue("Vigencia_hasta"))) == date('Y-m')) {
                        $vencimientos[] = $poliza;
                    }
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);

        return view("polizas.vencimientos", ["polizas" => $vencimientos]);
    }

    public function adjunto($id)
    {
        $id = explode(",", $id);
        $planid = $id[0];
        $adjuntoid = $id[1];
        $fichero = $this->model->rutaAdjunto($planid, $adjuntoid);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fichero) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fichero));
        readfile($fichero);
        unlink($fichero);
    }


    public function persona(Request $request)
    {
        $api = new Zoho;
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
            "Type" => "Persona",
            "Cuota" => $request->input("cuota"),
            "Plazo" => $request->input("plazo"),
            "Tipo_p_liza" => "Declarativa",
            "Vigencia_desde" => date("Y-m-d"),
            "Vigencia_hasta" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
        ];

        $id = $api->createRecords("Deals", $registro);
        $api->update("Quotes", $request->input("id"), ["Deal_Name" => $id]);

        $ruta = $request->file('cotizacion')->store('public');
        $api->uploadAttachment("Deals", $id, storage_path("app/$ruta"));
        unlink(storage_path("app/$ruta"));

        return redirect("poliza/$id");
    }
}
