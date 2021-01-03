<?php

namespace App\Controllers;

use App\Libraries\Zoho;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportes extends BaseController
{
    function __construct()
    {
        $this->api = new Zoho;
    }

    public function index($alerta = null)
    {
        $criteria = "Corredor:equals:" . session("empresaid");
        $planes =  $this->api->searchRecordsByCriteria("Products", $criteria, 1, 200);
        return view("reportes", ["planes" => $planes, "alerta" => $alerta]);
    }

    public function post()
    {
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
            $alerta = "No se encontraron registros.";
            return redirect()->to(site_url("reportes/$alerta"));
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
}
