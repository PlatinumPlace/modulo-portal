<?php

namespace App\Controllers\Cotizar;

use App\Controllers\BaseController;

class Cotizaciones extends BaseController
{
    public function index()
    {
        return view("cotizar/cotizaciones");
    }
}
