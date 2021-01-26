<?php

namespace App\Http\Controllers;

use App\Models\Zoho;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesController extends Controller
{
    function __construct()
    {
        $files = glob(public_path() . 'tmp/*'); //obtenemos todos los nombres de los ficheros
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); //elimino el fichero
            }
        }
    }

    public function polizas(Request $request)
    {
        $api = new Zoho;
        if ($request->input()) {
            $spreadsheet = new Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', session("empresa"))
                ->setCellValue('A2', 'Vendedor')
                ->setCellValue('B2', session("nombre"))
                ->setCellValue('A3', 'Desde')
                ->setCellValue('B3', $request->input("desde"))
                ->setCellValue('C3', 'Hasta')
                ->setCellValue('D3', $request->input("hasta"))
                ->setCellValue('A4', " ");

            switch ($request->input("plan")) {
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
                if ($lista = $api->searchRecordsByCriteria("Deals", $criteria, $pag, 200)) {
                    $pag++;
                    foreach ($lista as $trato) {
                        if (
                            date("Y-m-d", strtotime($trato->getCreatedTime())) >= $request->input("desde")
                            and
                            date("Y-m-d", strtotime($trato->getCreatedTime())) <= $request->input("hasta")
                            and
                            $trato->getFieldValue("Type") == $request->input("plan")
                            and
                            (empty($request->input("aseguradoraid"))
                                or
                                (!empty($request->input("aseguradoraid"))
                                    and
                                    $trato->getFieldValue("Aseguradora")->getEntityId() == $request->input("aseguradoraid")))
                        ) {
                            $bien = $api->getRecord("Bienes", $trato->getFieldValue("Bien")->getEntityId());

                            switch ($request->input("plan")) {
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

            $excel = public_path("tmp/emisiones de " .  $request->input("desde") . " a " . $request->input("hasta") . ".xlsx");

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
        $planes =  $api->searchRecordsByCriteria("Products", $criteria, 1, 200);
        return view("reportes.polizas", ["planes" => $planes]);
    }

    public function general($id)
    {
        $api = new Zoho;
        $caso = $api->getRecord("Cases", $id);
        $servicio = $api->getRecord("Products", $caso->getFieldValue('Product_Name')->getEntityId());
        return view('reportes.general', ["caso" => $caso, "servicio" => $servicio, "api" => $api]);
    }

    public function generalLote($id)
    {
        $api = new Zoho;
        $reporte = $api->getRecord("Reportes", $id);

        $caso_selec = array();
        $criteria = "Status:equals:Cerrado";
        $pag = 1;
        do {
            if ($casos =  $api->searchRecordsByCriteria("Cases", $criteria, $pag, 200)) {
                $pag++;
                asort($casos);
                foreach ($casos as $caso) {
                    if (
                        $caso->getFieldValue('Fecha') >= $reporte->getFieldValue('Desde')
                        and
                        $caso->getFieldValue('Fecha') <= $reporte->getFieldValue('Hasta')
                    ) {
                        $caso_selec[] = $caso;
                    }
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);

        return view('reportes.lotes.general', ["casos" => $caso_selec, "api" => $api]);
    }

    public function accidente($id)
    {
        $api = new Zoho;
        $caso = $api->getRecord("Cases", $id);
        return view('reportes.accidente', ["caso" => $caso, "api" => $api]);
    }

    public function accidenteLote($id)
    {
        $api = new Zoho;
        $reporte = $api->getRecord("Reportes", $id);

        $caso_selec = array();
        $criteria = "Status:equals:Cerrado";
        $pag = 1;
        do {
            if ($casos =  $api->searchRecordsByCriteria("Cases", $criteria, $pag, 200)) {
                $pag++;
                asort($casos);
                foreach ($casos as $caso) {
                    if (
                        $caso->getFieldValue('Fecha') >= $reporte->getFieldValue('Desde')
                        and
                        $caso->getFieldValue('Fecha') <= $reporte->getFieldValue('Hasta')
                        and
                        $caso->getFieldValue('Tipo_de_asistencia') == "Grúa por accidente"
                    ) {
                        $caso_selec[] = $caso;
                    }
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);

        return view('reportes.lotes.accidente', ["casos" => $caso_selec, "api" => $api]);
    }

    public function aseguradora($id)
    {
        $api = new Zoho;
        $caso = $api->getRecord("Cases", $id);
        return view('reportes.aseguradora', ["caso" => $caso, "api" => $api]);
    }

    public function aseguradoraLote($id)
    {
        $api = new Zoho;
        $reporte = $api->getRecord("Reportes", $id);

        $caso_selec = array();
        $criteria = "Status:equals:Cerrado";
        $pag = 1;
        do {
            if ($casos =  $api->searchRecordsByCriteria("Cases", $criteria, $pag, 200)) {
                $pag++;
                asort($casos);
                foreach ($casos as $caso) {
                    if (
                        $caso->getFieldValue('Fecha') >= $reporte->getFieldValue('Desde')
                        and
                        $caso->getFieldValue('Fecha') <= $reporte->getFieldValue('Hasta')
                    ) {
                        $caso_selec[] = $caso;
                    }
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 0);

        return view('reportes.lotes.aseguradora', ["casos" => $caso_selec, "api" => $api]);
    }
}
