<?php

namespace App\Controllers\Cotizar;

use App\Libraries\Zoho;
use App\Controllers\BaseController;
use App\Libraries\CalcularPrima;

class Auto extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
        $this->calcularprima = new CalcularPrima;
    }

    public function index()
    {
        $marcas = $this->api->getRecords("Marcas");
        sort($marcas);
        return view("cotizar/auto", ["marcas" => $marcas]);
    }

    public function modelos()
    {
        $pag = 1;
        $criteria = "Marca:equals:" . $this->request->getVar("marcaid");
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

    public function post()
    {
        $modelo = explode(",", $this->request->getVar("modelo"));
        $modeloid = $modelo[0];
        $modelotipo = $modelo[1];
        $planes = array();

        $criterio = "((Corredor:equals:" . session("empresaid") . ") and (Product_Category:equals:Auto))";
        $listaPlanes = $this->api->searchRecordsByCriteria("Products", $criterio, 1, 200);
        foreach ($listaPlanes as $plan) {
            $prima = 0;
            $motivo = "";

            if (in_array($this->request->getVar("uso"), $plan->getFieldValue('Restringir_veh_culos_de_uso'))) {
                $motivo = "Uso del vehículo restringido.";
            }

            if ((date("Y") - $this->request->getVar("a_o")) > $plan->getFieldValue('Max_antig_edad')) {
                $motivo = "La antigüedad del vehículo (" . (date("Y") - $this->request->getVar("a_o")) . ")  es mayor al limite establecido (" . $plan->getFieldValue('Max_antig_edad') . ")";
            }

            $criterio = "((Marca:equals:" . $this->request->getVar("marca") . ") and (Aseguradora:equals:" . $plan->getFieldValue('Vendor_Name')->getEntityId() . "))";
            $marcas = $this->api->searchRecordsByCriteria("Restringidos", $criterio, 1, 200);
            foreach ($marcas as $marca) {
                if (empty($marca->getFieldValue('Modelo'))) {
                    $motivo = "Marca restrigida.";
                }
            }

            $criterio = "((Modelo:equals:$modeloid) and (Aseguradora:equals:" . $plan->getFieldValue('Vendor_Name')->getEntityId() . "))";
            $modelos = $this->api->searchRecordsByCriteria("Restringidos", $criterio, 1, 200);
            foreach ($modelos as $modelo) {
                $motivo = "Modelo restrigido.";
            }

            if (empty($motivo)) {
                $prima = $this->calcularprima->auto(
                    $this->api,
                    $plan->getEntityId(),
                    $modelotipo,
                    $this->request->getVar("a_o"),
                    $this->request->getVar("marca"),
                    $this->request->getVar("suma")
                );

                if ($prima < $plan->getFieldValue('Prima_m_nima')) {
                    $prima = $plan->getFieldValue('Prima_m_nima');
                }

                $prima = $prima / 12;

                if (empty($prima)) {
                    $motivo = "No existen tasas para el tipo de vehículo especificado.";
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
            "Fecha_de_nacimiento" => $this->request->getVar("fecha_nacimiento"),
            "Tel_Celular" => $this->request->getVar("telefono"),
            "Tel_Residencia" => $this->request->getVar("tel_residencia"),
            "Tel_Trabajo" => $this->request->getVar("tel_trabajo"),
            "Plan" => $this->request->getVar("plan"),
            "A_o" => $this->request->getVar("a_o"),
            "Marca" => $this->request->getVar("marca"),
            "Modelo" => $modeloid,
            "Uso" => $this->request->getVar("uso"),
            "Tipo" => "Auto",
            "Tipo_veh_culo" => $modelotipo,
            "Suma_asegurada" =>  $this->request->getVar("suma"),
            "Condiciones" =>  $this->request->getVar("condiciones")
        ];

        $id = $this->api->createRecords("Quotes", $registro, $planes);
        return redirect()->to(site_url("detalles/cotizacion/$id"));
    }
}
