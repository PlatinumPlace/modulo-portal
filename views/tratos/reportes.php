<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tratos = new tratos;
$criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
$num_pag = 1;

if ($_POST) {

    $spreadsheet = new Spreadsheet();

    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', $_SESSION["usuario"]["empresa_nombre"])
        ->setCellValue('A2', 'Vendedor')
        ->setCellValue('B2', $_SESSION["usuario"]["nombre"])
        ->setCellValue('A3', 'Desde')
        ->setCellValue('B3', $_POST["desde"])
        ->setCellValue('C3', 'Hasta')
        ->setCellValue('D3', $_POST["hasta"])
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

    $cont = 6;
    $comision = 0;

    do {
        $lista = $tratos->searchRecordsByCriteria("Deals", $criterio, $num_pag);
        if (!empty($lista)) {
            $num_pag++;
            foreach ($lista as $trato) {
                if (
                    $trato->getFieldValue("P_liza") != null
                    and
                    date("Y-m-d", strtotime($trato->getFieldValue("Fecha"))) >= $_POST["desde"]
                    and
                    date("Y-m-d", strtotime($trato->getFieldValue("Fecha"))) <= $_POST["hasta"]
                    and
                    $trato->getFieldValue("Type") == $_POST["tipo"]
                    and
                    (empty($_POST["aseguradora_id"])
                        or
                        (!empty($_POST["aseguradora_id"])
                            and
                            $trato->getFieldValue("Aseguradora")->getEntityId() == $_POST["aseguradora_id"]))
                ) {

                    $sheet->setCellValue('A' . $cont,  $trato->getFieldValue("Fecha"))
                        ->setCellValue('B' . $cont, $trato->getFieldValue("Closing_Date"))
                        ->setCellValue('C' . $cont, $trato->getFieldValue("Deal_Name"))
                        ->setCellValue('D' . $cont, $trato->getFieldValue("Marca"))
                        ->setCellValue('E' . $cont, $trato->getFieldValue("Modelo"))
                        ->setCellValue('F' . $cont, $trato->getFieldValue("Tipo_veh_culo"))
                        ->setCellValue('G' . $cont, $trato->getFieldValue("A_o_veh_culo"))
                        ->setCellValue('H' . $cont, number_format($trato->getFieldValue("Suma_asegurada"), 2))
                        ->setCellValue('I' . $cont, $trato->getFieldValue("Plan"))
                        ->setCellValue('L' . $cont, $trato->getFieldValue('Aseguradora')->getLookupLabel())
                        ->setCellValue('J' . $cont, $trato->getFieldValue('P_liza')->getLookupLabel())
                        ->setCellValue('K' . $cont, number_format($trato->getFieldValue("Prima_total"), 2))
                        ->setCellValue('M' . $cont, number_format($trato->getFieldValue("Comisi_n_corredor"), 2));

                    $comision += $trato->getFieldValue("Comisi_n_corredor");
                    $cont++;
                }
            }
        } else {
            $num_pag = 0;
        }
    } while ($num_pag > 1);

    if (!empty($comision)) {
        $sheet->setCellValue('A' . ($cont + 1),  "")
            ->setCellValue('A' . ($cont + 2),  "Comisiones totales")
            ->setCellValue('B' . ($cont + 2), "RD$" . number_format($comision, 2));

        $excel = "public/path/emisiones de " . $_POST["desde"] . " a " . $_POST["hasta"] . ".xlsx";

        $writer = new Xlsx($spreadsheet);
        $writer->save($excel);

        $fileName = basename($excel);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: ');
        header('Content-Length: ' . filesize($excel));
        readfile($excel);
        unlink($excel);
        exit();
    } else {
        $alerta = "No se encontraron resultados";
        header("Location:?pagina=reportes&alerta=$alerta");
        exit();
    }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">reporte de emisiones</h1>
</div>

<?php if (isset($_GET["alerta"])) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $_GET["alerta"] ?>
    </div>
<?php endif ?>

<form method="POST" class="row" action="?pagina=reportes">

    <div class="mx-auto col-10" style="width: 200px;">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Desde</label>

            <div class="col-sm-8">
                <input type="date" class="form-control" name="desde" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Hasta</label>

            <div class="col-sm-8">
                <input type="date" class="form-control" name="hasta" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Modulo</label>

            <div class="col-sm-8">
                <select name="tipo" class="form-control">
                    <option value="Auto" selected>Auto</option>
                    <option value="Vida">Vida</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Aseguradora</label>

            <div class="col-sm-8">
                <select name="aseguradora_id" class="form-control">
                    <option value="" selected>Todas</option>
                    <?php
                    $criterio = "Corredor:equals:" . $_SESSION["usuario"]["empresa_id"];
                    $contratos = $tratos->searchRecordsByCriteria("Contratos", $criterio);
                    foreach ($contratos as $contrato) {
                        echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getEntityId() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success" value="csv">Exportar a excel</button>

    </div>

</form>

<br><br>