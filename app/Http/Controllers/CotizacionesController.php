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
}
