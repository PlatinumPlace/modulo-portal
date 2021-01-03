<?php

namespace App\Controllers\Emitir;

use App\Libraries\Zoho;
use App\Controllers\BaseController;

class Auto extends BaseController
{
	function __construct()
	{
		$this->api = new Zoho;
    }

    public function index($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        if (!empty($detalles->getFieldValue('Deal_Name'))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view("emitir/auto", ["cotizacion" => $detalles, "api" => $this->api]);
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
            "A_o" => $this->request->getVar("a_o"),
            "Name" => $this->request->getVar("chasis"),
            "Color" => $this->request->getVar("color"),
            "Email" => $this->request->getVar("correo"),
            "Direcci_n" => $this->request->getVar("direccion"),
            "Estado" => "Activo",
            "Fecha_de_nacimiento" => $this->request->getVar("fecha_nacimiento"),
            "Marca" => $this->request->getVar("marca"),
            "Modelo" => $this->request->getVar("modelo"),
            "Nombre" => $this->request->getVar("nombre"),
            "Placa" => $this->request->getVar("placa"),
            "Plan" => $this->request->getVar("plantipo"),
            "Prima" => $primatotal,
            "P_liza" => $poliza,
            "RNC_C_dula" => $this->request->getVar("rnc_cedula"),
            "Suma_asegurada" => $this->request->getVar("suma"),
            "Tel_Celular" => $this->request->getVar("telefono"),
            "Tel_Residencia" => $this->request->getVar("tel_residencia"),
            "Tel_Trabajo" => $this->request->getVar("tel_trabajo"),
            "Tipo" => $this->request->getVar("modelotipo"),
            "Vigencia_desde" => date("Y-m-d"),
            "Vigencia_hasta" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years"))
        ];

        $bienid =  $this->api->createRecords("Bienes", $bien);

        $trato = [
            "Deal_Name" => "Emisión",
            "Account_Name" => session("empresaid"),
            "Contact_Name" => session("id"),
            "Bien" => $bienid,
            "Aseguradora" => $aseguradoraid,
            "Coberturas" => $this->request->getVar("planid"),
            "Comisi_n_aseguradora" => round($comisionaseguradora, 2),
            "Comisi_n_corredor" => round($comisioncorredor, 2),
            "Comisi_n_intermediario" => round($comisionintermediario, 2),
            "Stage" => "Pre aprobada",
            "Closing_Date" => date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 years")),
            "Amount" => round($comisionnobe, 2),
            "ISC" => round($isc, 2),
            "Prima_neta" => round($primaneta, 2),
            "Prima_total" => round($primatotal, 2),
            "Type" => "Auto"
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