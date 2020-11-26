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
}
