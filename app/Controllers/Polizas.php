<?php

namespace App\Controllers;

use App\Libraries\Zoho;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Polizas extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function index()
    {
        $criteria = "Account_Name:equals:" . session()->get("empresaid");
        $polizas =  $this->api->searchRecordsByCriteria("Deals", $criteria, 1, 200);
        return view("polizas/index", ["polizas" => $polizas]);
    }

    public function detalles($id)
    {
        $poliza = $this->api->getRecord("Deals", $id);
        $bien = $this->api->getRecord("Bienes", $poliza->getFieldValue('Bien')->getEntityId());
        return view("polizas/detalles", ["poliza" => $poliza, "bien" => $bien]);
    }

    public function descargar($id)
    {
        $poliza = $this->api->getRecord("Deals", $id);
        $bien = $this->api->getRecord("Bienes", $poliza->getFieldValue('Bien')->getEntityId());
        $imagen = $this->api->downloadPhoto("Vendors", $poliza->getFieldValue('Aseguradora')->getEntityId());
        $plan = $this->api->getRecord("Products", $poliza->getFieldValue('Coberturas')->getEntityId());
        return view("polizas/descargar", ["poliza" => $poliza, "imagen" => $imagen, "bien" => $bien, "plan" => $plan]);
    }

    public function emitir($id)
    {
        $detalles = $this->api->getRecord("Quotes", $id);
        if (!empty($detalles->getFieldValue('Deal_Name'))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view("polizas/emitir", ["cotizacion" => $detalles, "api" => $this->api]);
    }

    public function auto()
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

        return redirect()->to(site_url("polizas/detalles/$tratoid"));
    }

    public function vida()
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

        return redirect()->to(site_url("polizas/detalles/$tratoid"));
    }

    public function reportes()
    {
        if ($this->request->getVar()) {
            $spreadsheet = new Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', session("empresa"))
                ->setCellValue('A2', 'Vendedor')
                ->setCellValue('B2', session("nombre"))
                ->setCellValue('A3', 'Desde')
                ->setCellValue('B3', $this->request->getVar("desde"))
                ->setCellValue('C3', 'Hasta')
                ->setCellValue('D3', $this->request->getVar("hasta"))
                ->setCellValue('A4', " ");

            switch ($this->request->getVar("plan")) {
                case 'Auto':
                    $sheet->setCellValue('A5', "Inicio")
                        ->setCellValue('B5', "Fin")
                        ->setCellValue('C5', "Cliente")
                        ->setCellValue('D5', "Marca")
                        ->setCellValue('E5', "Modelo")
                        ->setCellValue('F5', "Tipo")
                        ->setCellValue('G5', "Año")
                        ->setCellValue('H5', "Suma Asegurada")
                        ->setCellValue('I5', "Plan")
                        ->setCellValue('L5', "Aseguradora")
                        ->setCellValue('J5', "Póliza")
                        ->setCellValue('K5', "Prima")
                        ->setCellValue('M5', "Comisión");
                    break;

                case 'Vida':
                    $sheet->setCellValue('A5', "Inicio")
                        ->setCellValue('B5', "Fin")
                        ->setCellValue('C5', "Deudor")
                        ->setCellValue('D5', "Codeudor")
                        ->setCellValue('E5', "Suma Asegurada")
                        ->setCellValue('F5', "Plan")
                        ->setCellValue('G5', "Aseguradora")
                        ->setCellValue('H5', "Póliza")
                        ->setCellValue('I5', "Prima")
                        ->setCellValue('L5', "Comisión");
                    break;
            }

            $pag = 0;
            $cont = 6;
            $comision = 0;
            $criteria = "Contact_Name:equals:" . session("id");
            do {
                if ($lista = $this->api->searchRecordsByCriteria("Deals", $criteria, $pag, 200)) {
                    $pag++;
                    foreach ($lista as $trato) {
                        if (
                            date("Y-m-d", strtotime($trato->getCreatedTime())) >= $this->request->getVar("desde")
                            and
                            date("Y-m-d", strtotime($trato->getCreatedTime())) <= $this->request->getVar("hasta")
                            and
                            $trato->getFieldValue("Type") == $this->request->getVar("plan")
                            and
                            (empty($this->request->getVar("aseguradoraid"))
                                or
                                (!empty($this->request->getVar("aseguradoraid"))
                                    and
                                    $trato->getFieldValue("Aseguradora")->getEntityId() == $this->request->getVar("aseguradoraid")))
                        ) {
                            $bien = $this->api->getRecord("Bienes", $trato->getFieldValue("Bien")->getEntityId());

                            switch ($this->request->getVar("plan")) {
                                case 'Auto':
                                    $sheet->setCellValue('A' . $cont,  $bien->getFieldValue("Vigencia_desde"))
                                        ->setCellValue('B' . $cont, $bien->getFieldValue("Vigencia_hasta"))
                                        ->setCellValue('C' . $cont, $bien->getFieldValue("Nombre") . " " . $bien->getFieldValue("Apellido"))
                                        ->setCellValue('D' . $cont, $bien->getFieldValue("Marca"))
                                        ->setCellValue('E' . $cont, $bien->getFieldValue("Modelo"))
                                        ->setCellValue('F' . $cont, $bien->getFieldValue("Tipo"))
                                        ->setCellValue('G' . $cont, $bien->getFieldValue("A_o"))
                                        ->setCellValue('H' . $cont, number_format($bien->getFieldValue("Suma_asegurada"), 2))
                                        ->setCellValue('I' . $cont, $bien->getFieldValue("Plan"))
                                        ->setCellValue('L' . $cont, $bien->getFieldValue('Aseguradora')->getLookupLabel())
                                        ->setCellValue('J' . $cont, $bien->getFieldValue('P_liza'))
                                        ->setCellValue('K' . $cont, number_format($trato->getFieldValue("Prima_total"), 2))
                                        ->setCellValue('M' . $cont, number_format($trato->getFieldValue("Comisi_n_corredor"), 2));
                                    break;

                                case 'Vida':
                                    $sheet->setCellValue('A' . $cont,  $bien->getFieldValue("Vigencia_desde"))
                                        ->setCellValue('B' . $cont, $bien->getFieldValue("Vigencia_hasta"))
                                        ->setCellValue('C' . $cont, $bien->getFieldValue("Nombre") . " " . $bien->getFieldValue("Apellido"))
                                        ->setCellValue('D' . $cont, $bien->getFieldValue("Nombre_codeudor") . " " . $bien->getFieldValue("Apellido_codeudor"))
                                        ->setCellValue('E' . $cont, number_format($bien->getFieldValue("Suma_asegurada"), 2))
                                        ->setCellValue('F' . $cont, $bien->getFieldValue("Plan"))
                                        ->setCellValue('G' . $cont, $bien->getFieldValue('Aseguradora')->getLookupLabel())
                                        ->setCellValue('H' . $cont, $bien->getFieldValue('P_liza'))
                                        ->setCellValue('I' . $cont, number_format($trato->getFieldValue("Prima_total"), 2))
                                        ->setCellValue('L' . $cont, number_format($trato->getFieldValue("Comisi_n_corredor"), 2));
                                    break;
                            }

                            $comision += $trato->getFieldValue("Comisi_n_corredor");
                            $cont++;
                        }
                    }
                } else {
                    $pag = 0;
                }
            } while ($pag > 1);

            if (empty($comision)) {
                session()->setFlashdata("alerta", "No se encontraron registros.");
                return redirect()->back();
            }

            $sheet->setCellValue('A' . ($cont + 1),  "")
                ->setCellValue('A' . ($cont + 2),  "Comisiones totales")
                ->setCellValue('B' . ($cont + 2), "RD$" . number_format($comision, 2));

            $excel = WRITEPATH . "uploads/emisiones de " .  $this->request->getVar("desde") . " a " . $this->request->getVar("hasta") . ".xlsx";

            $writer = new Xlsx($spreadsheet);
            $writer->save($excel);

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($excel) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($excel));
            readfile($excel);
            unlink($excel);
        }

        $criteria = "Corredor:equals:" . session("empresaid");
        $planes =  $this->api->searchRecordsByCriteria("Products", $criteria, 1, 200);
        return view("polizas/reportes", ["planes" => $planes]);
    }
}
