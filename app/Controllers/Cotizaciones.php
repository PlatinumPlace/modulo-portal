<?php

namespace App\Controllers;

use App\Libraries\Zoho;

class Cotizaciones extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function index()
    {
        $criteria = "Account_Name:equals:" . session()->get("empresaid");
        $cotizaciones =  $this->api->searchRecordsByCriteria("Quotes", $criteria, 1, 200);
        return view("cotizaciones/index", ["cotizaciones" => $cotizaciones]);
    }

    public function cotizar()
    {
        return view("cotizaciones/cotizar");
    }

    public function auto()
    {
        if ($this->request->getVar()) {
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
            return redirect()->to(site_url("cotizaciones/detalles/$id"));
        }

        $marcas = $this->api->getRecords("Marcas");
        sort($marcas);
        return view("auto/cotizar", ["marcas" => $marcas]);
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

    public function vida()
    {
        if ($this->request->getVar()) {
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
            return redirect()->to(site_url("cotizaciones/detalles/$id"));
        }

        return view("vida/cotizar");
    }

    public function detalles($id)
    {
        $cotizacion = $this->api->getRecord("Quotes", $id);
        return view("cotizaciones/detalles", ["cotizacion" => $cotizacion, "api" => $this->api]);
    }

    public function descargar($id)
    {
        $cotizacion = $this->api->getRecord("Quotes", $id);
        return view("cotizaciones/descargar", ["cotizacion" => $cotizacion, "api" => $this->api]);
    }

    public function documentos($id)
    {
        if ($this->request->getVar()) {
            $fichero = $this->api->downloadAttachment("Products", $this->request->getVar("plan"), $this->request->getVar("documento"), WRITEPATH . "uploads");
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

        $detalles = $this->api->getRecord("Quotes", $id);
        return view("cotizaciones/documentos", ["cotizacion" => $detalles, "api" => $this->api]);
    }
}
