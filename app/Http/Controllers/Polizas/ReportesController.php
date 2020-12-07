<?php

namespace App\Http\Controllers\Polizas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Zoho;

class ReportesController extends Controller
{
    protected $api;

    function __construct(Zoho $api)
    {
        $this->api = $api;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $spreadsheet = new Spreadsheet;

        $sheet = $spreadsheet->getActiveSheet();

        switch ($request->input("plan")) {
            case 'Auto':
                $sheet->setCellValue('A1', session("empresanombre"))
                    ->setCellValue('A2', 'Vendedor')
                    ->setCellValue('B2', session("nombre"))
                    ->setCellValue('A3', 'Desde')
                    ->setCellValue('B3', $request->input("desde"))
                    ->setCellValue('C3', 'Hasta')
                    ->setCellValue('D3', $request->input("hasta"))
                    ->setCellValue('A4', " ")
                    ->setCellValue('A5', "Inicio")
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
                        date("Y-m-d", strtotime($trato->getFieldValue("Vigencia_desde"))) >= $request->input("desde")
                        and
                        date("Y-m-d", strtotime($trato->getFieldValue("Vigencia_desde"))) <= $request->input("hasta")
                        and
                        $trato->getFieldValue("Type") == $request->input("plan")
                        and
                        (empty($request->input("aseguradoraid"))
                            or
                            (!empty($request->input("aseguradoraid"))
                                and
                                $trato->getFieldValue("Aseguradora")->getEntityId() == $request->input("aseguradoraid")))
                    ) {
                        $sheet->setCellValue('A' . $cont,  $trato->getFieldValue("Vigencia_desde"))
                            ->setCellValue('B' . $cont, $trato->getFieldValue("Closing_Date"))
                            ->setCellValue('C' . $cont, $trato->getFieldValue("Nombre") . " " . $trato->getFieldValue("Apellido"))
                            ->setCellValue('D' . $cont, $trato->getFieldValue("Marca"))
                            ->setCellValue('E' . $cont, $trato->getFieldValue("Modelo"))
                            ->setCellValue('F' . $cont, $trato->getFieldValue("Tipo_veh_culo"))
                            ->setCellValue('G' . $cont, $trato->getFieldValue("A_o_veh_culo"))
                            ->setCellValue('H' . $cont, number_format($trato->getFieldValue("Suma_asegurada"), 2))
                            ->setCellValue('I' . $cont, $trato->getFieldValue("Plan"))
                            ->setCellValue('L' . $cont, $trato->getFieldValue('Aseguradora')->getLookupLabel())
                            ->setCellValue('J' . $cont, $trato->getFieldValue('P_liza'))
                            ->setCellValue('K' . $cont, number_format($trato->getFieldValue("Prima_total"), 2))
                            ->setCellValue('M' . $cont, number_format($trato->getFieldValue("Comisi_n_corredor"), 2));

                        $comision += $trato->getFieldValue("Comisi_n_corredor");
                        $cont++;
                    }
                }
            } else {
                $pag = 0;
            }
        } while ($pag > 1);

        $sheet->setCellValue('A' . ($cont + 1),  "")
            ->setCellValue('A' . ($cont + 2),  "Comisiones totales")
            ->setCellValue('B' . ($cont + 2), "RD$" . number_format($comision, 2));

        $excel = "emisiones de " .  $request->input("desde") . " a " . $request->input("hasta") . ".xlsx";
        $excel =storage_path("app/public/$excel");

        $writer = new Xlsx($spreadsheet);
        $writer->save($excel);

        return back()->with("excel", $excel);
    }
}
