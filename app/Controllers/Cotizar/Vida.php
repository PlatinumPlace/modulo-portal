<?php

namespace App\Controllers\Cotizar;

use App\Libraries\Zoho;
use App\Controllers\BaseController;
use App\Libraries\CalcularPrima;

class Vida extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
        $this->calcularprima = new CalcularPrima;
    }

    public function index()
    {
        return view("cotizar/vida");
    }

    public function post()
    {
        $planes = array();
        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Vida))";
        $listaPlanes = $this->api->searchRecordsByCriteria("Products", $criterio, 1, 200);

        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (
                $this->request->getVar("edad_deudor") > $plan->getFieldValue('Edad_max')
                or
                (!empty($this->request->getVar("edad_codeudor"))
                    and
                    $this->request->getVar("edad_codeudor") > $plan->getFieldValue('Edad_max'))
            ) {
                $motivo = "La edad del deudor/codeudor es mayor al limite establecido.";
            }

            if (
                $this->request->getVar("edad_deudor") < $plan->getFieldValue('Edad_min')
                or (!empty($this->request->getVar("edad_codeudor"))
                    and
                    $this->request->getVar("edad_codeudor") < $plan->getFieldValue('Edad_min'))
            ) {
                $motivo = "La edad del deudor/codeudor es menor al limite establecido.";
            }

            if ($this->request->getVar("plazo") > $plan->getFieldValue('Plazo_max')) {
                $motivo = "El plazo es mayor al limite establecido.";
            }

            if ($this->request->getVar("suma") > $plan->getFieldValue('Suma_asegurada_max')) {
                $motivo = "La suma asegurada es mayor al limite establecido.";
            }

            if (empty($motivo)) {
                $criterio = "Plan:equals:" . $plan->getEntityId();
                $tasas = $this->api->searchRecordsByCriteria("Tasas", $criterio, 1, 200);

                $prima = $this->calcularprima->deudor($tasas, $this->request->getVar("suma"));
                $plantipo = "Vida";

                if ($this->request->getVar("edad_codeudor")) {
                    $prima = $this->calcularprima->codeudor($tasas, $this->request->getVar("suma"), $prima);
                }

                if ($this->request->getVar("cuota")) {
                    $prima = $this->calcularprima->desempleo($tasas, $this->request->getVar("suma"), $this->request->getVar("cuota"));
                    $plantipo = "Vida/desempleo";
                }
            }

            $planes[] = ["id" => $plan->getEntityId(), "precio" => $prima, "descripcion" => $motivo];
        }

        $registro = [
            "Subject" => "Cotización",
            "Account_Name" => session("empresaid"),
            "Contact_Name" => session("id"),
            "Nombre" => $this->request->getVar("nombre"),
            "Apellido" => $this->request->getVar("apellido"),
            "RNC_C_dula" => $this->request->getVar("rnc_cedula"),
            "Correo_electr_nico" => $this->request->getVar("correo"),
            "Direcci_n" => $this->request->getVar("direccion"),
            "Tel_Celular" => $this->request->getVar("telefono"),
            "Tel_Residencia" => $this->request->getVar("tel_residencia"),
            "Tel_Trabajo" => $this->request->getVar("tel_trabajo"),
            "Plan" => $plantipo,
            "Edad_codeudor" => $this->request->getVar("edad_codeudor"),
            "Edad_deudor" => $this->request->getVar("edad_deudor"),
            "Cuota" => $this->request->getVar("cuota"),
            "Plazo" => $this->request->getVar("plazo"),
            "Tipo" => "Vida",
            "Suma_asegurada" =>  $this->request->getVar("suma"),
            "Nombre_codeudor" => $this->request->getVar("nombre_codeudor"),
            "Apellido_codeudor" => $this->request->getVar("apellido_codeudor"),
            "Tel_Celular_codeudor" => $this->request->getVar("telefono_codeudor"),
            "Tel_Residencia_codeudor" => $this->request->getVar("tel_residencia_codeudor"),
            "Tel_Trabajo_codeudor" => $this->request->getVar("tel_trabajo_codeudor"),
            "RNC_C_dula_codeudor" => $this->request->getVar("rnc_cedula_codeudor"),
            "Fecha_de_nacimiento_codeudor" => $this->request->getVar("fecha_nacimiento_codeudor"),
            "Direcci_n_codeudor" => $this->request->getVar("direccion_codeudor"),
            "Correo_electr_nico_codeudor" => $this->request->getVar("correo_codeudor"),
        ];

        $id = $this->api->createRecords("Quotes", $registro, $planes);
        return redirect()->to(site_url("detalles/cotizacion/$id"));
    }
}
