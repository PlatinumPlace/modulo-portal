<?php

namespace App\Controllers\Emitir;

use App\Libraries\Zoho;
use App\Controllers\BaseController;

class Vida extends BaseController
{
	function __construct()
	{
		$this->api = new Zoho;
	}

	public function index($id)
    {
        $cotizacion = $this->api->getRecord("Quotes", $id);
        if (!empty($cotizacion->getFieldValue('Deal_Name'))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view("emitir/vida", ["cotizacion" => $cotizacion, "api" => $this->api]);
    }
	
	public function post()
    {
        $cotizacion = $this->api->getRecord("Quotes", $this->request->getVar("id"));
        foreach ($cotizacion->getLineItems() as $detalles) {
            if ($this->request->getVar("planid") == $detalles->getProduct()->getEntityId()) {
                $plan = $this->api->getRecord("Products", $detalles->getProduct()->getEntityId());
                $comisionnobe = $detalles->getNetTotal() * ($plan->getFieldValue('Comisi_n_grupo_nobe') / 100);
                $comisionintermediario = $detalles->getNetTotal() * ($plan->getFieldValue('Comisi_n_intermediario') / 100);
                $comisionaseguradora = $detalles->getNetTotal() * ($plan->getFieldValue('Comisi_n_aseguradora') / 100);
                $comisioncorredor = $detalles->getNetTotal() * ($plan->getFieldValue('Comisi_n_corredor') / 100);
                $aseguradoraid = $plan->getFieldValue('Vendor_Name')->getEntityId();
                $primaneta = round($detalles->getListPrice(), 2);
                $isc = round($detalles->getTaxAmount(), 2);
                $primatotal = round($detalles->getNetTotal(), 2);
                $poliza = $plan->getFieldValue('P_liza');
            }
        }

        $bien = [
            "Apellido" => $this->request->getVar("apellido"),
            "Aseguradora" => $aseguradoraid,
            "Corredor" => session("empresaid"),
            "Name" => $this->request->getVar("rnc_cedula"),
            "Email" => $this->request->getVar("correo"),
            "Direcci_n" => $this->request->getVar("direccion"),
            "Estado" => "Activo",
            "Fecha_de_nacimiento" => $this->request->getVar("fecha_nacimiento"),
            "Nombre" => $this->request->getVar("nombre"),
            "Plan" => $this->request->getVar("plantipo"),
            "Prima" => $primatotal,
            "P_liza" => $poliza,
            "RNC_C_dula" => $this->request->getVar("rnc_cedula"),
            "Suma_asegurada" => $this->request->getVar("suma"),
            "Tel_Celular" => $this->request->getVar("telefono"),
            "Tel_Residencia" => $this->request->getVar("tel_residencia"),
            "Tel_Trabajo" => $this->request->getVar("tel_trabajo"),
            "Vigencia_desde" => date("Y-m-d"),
            "Vigencia_hasta" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
            "Cuota" => $this->request->getVar("cuota"),
            "Plazo" => $this->request->getVar("plazo"),
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

        $bienid =  $this->api->createRecords("Bienes", $bien);

        $trato = [
            "Account_Name" => session("empresaid"),
            "Contact_Name" => session("id"),
            "Bien" => $bienid,
            "Aseguradora" => $aseguradoraid,
            "Coberturas" => $this->request->getVar("planid"),
            "Comisi_n_aseguradora" => $comisionaseguradora,
            "Comisi_n_corredor" => $comisioncorredor,
            "Comisi_n_intermediario" => $comisionintermediario,
            "Stage" => "Pre aprobada",
            "Closing_Date" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
            "Amount" => $comisionnobe,
            "ISC" => $isc,
            "Deal_Name" => "Emisión",
            "Prima_neta" => $primaneta,
            "Prima_total" => $primatotal,
            "Type" => "Vida"
        ];

        $tratoid =  $this->api->createRecords("Deals", $trato);

        $this->api->update("Quotes", $this->request->getVar("id"), [
            "Deal_Name" => $tratoid,
            "Valid_Till" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"))
        ]);

        if ($imagefile = $this->request->getFiles()) {
            foreach ($imagefile['documentos'] as $img) {
                $newName = $img->getRandomName();
                $img->move(WRITEPATH . 'uploads', $newName);
                $this->api->uploadAttachment("Deals", $tratoid, WRITEPATH . "uploads/$newName");
                unlink(WRITEPATH . "uploads/$newName");
            }
        }

        return redirect()->to(site_url("detalles/poliza/$tratoid"));
    }
}