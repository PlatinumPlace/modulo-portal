<?php
class reporte extends zoho_api
{
    function __construct()
    {
        parent::__construct();
    }
    public function obtener_contratos($empresa_id)
    {
        $criterio = "Socio:equals:" . $empresa_id;
        return $this->searchRecordsByCriteria("Contratos", $criterio);
    }
    public function exportar_excel()
    {
        $contrato = $this->getRecord("Contratos", $_POST['contrato_id']);
        $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (Aseguradora:equals:" .  $contrato->getFieldValue("Aseguradora")->getEntityId() . "))";
        $ofertas = $this->searchRecordsByCriteria("Deals", $criterio);
        if (!empty($ofertas)) {
            $csv = fopen("public/tmp/reporte.csv", 'w');
            fputcsv($csv, array($contrato->getFieldValue("Socio")->getLookupLabel()), ",");
            fputcsv($csv, array("Reporte " . $_POST['reporte_tipo'] . " de " . $_POST['tipo']), ",");
            fputcsv($csv, array("Aseguradora:", $contrato->getFieldValue("Aseguradora")->getLookupLabel()), ",");
            fputcsv($csv, array("Poliza:", $contrato->getFieldValue('No_P_liza')), ",");
            fputcsv($csv, array("Desde:", $_POST['inicio'], "Hasta:", $_POST['fin']), ",");
            fputcsv($csv, array("Vendedor:", $_SESSION['usuario_nombre']), ",");
            fputcsv($csv, array("Formato de moneda:", "RD$"), ",");
            fputcsv($csv, array(""), ",");
            if ($_POST['reporte_tipo'] == "polizas") {
                fputcsv($csv,  array("Fecha de emision", "Nombre Asegurado", "Cedula", "Marca", "Modelo", "Ano", "Chasis", "Valor Aseg.", "Prima Neta sin Impuestos", "Plan"), ",");
            } elseif ($_POST['reporte_tipo'] == "comisiones") {
                fputcsv($csv,  array("Fecha de emision", "Nombre Asegurado", "Cedula", "Valor Aseg.", " Prima con Impuestos ", "Plan", "Comision"), ",");
            }
            $total_prima = 0;
            $total_comision = 0;
            foreach ($ofertas as $oferta) {
                if (
                    $oferta->getFieldValue("Type") == $_POST['tipo']
                    and
                    date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n")))  > $_POST['inicio']
                    and
                    date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) < $_POST['fin']
                ) {
                    $criterio = "Deal_Name:equals:" . $oferta->getEntityId();
                    $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
                    foreach ($cotizaciones as $cotizacion) {
                        $prima_ci = round($cotizacion->getFieldValue("Grand_Total"), 2);
                        $planes = $cotizacion->getLineItems();
                        foreach ($planes as $plan) {
                            $prima_si = round($plan->getTotalAfterDiscount(), 2);
                        }
                        $comision = $cotizacion->getFieldValue("Importe_Socio");
                    }
                    if ($_POST['reporte_tipo'] == "polizas") {
                        $total_prima += $prima_ci;
                        fputcsv(
                            $csv,
                            array(
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                $oferta->getFieldValue("RNC_Cedula"),
                                $oferta->getFieldValue('Marca')->getLookupLabel(),
                                $oferta->getFieldValue('Modelo')->getLookupLabel(),
                                $oferta->getFieldValue('A_o_de_Fabricacion'),
                                $oferta->getFieldValue('Chasis'),
                                round($oferta->getFieldValue('Valor_Asegurado'), 2),
                                $prima_ci,
                                $oferta->getFieldValue('Plan')
                            ),
                            ","
                        );
                    } elseif ($_POST['reporte_tipo'] == "comisiones") {
                        $total_prima += $prima_si;
                        $total_comision += $comision;
                        fputcsv(
                            $csv,
                            array(
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                $oferta->getFieldValue("RNC_Cedula"),
                                round($oferta->getFieldValue('Valor_Asegurado'), 2),
                                $prima_si,
                                $oferta->getFieldValue('Plan'),
                                $comision
                            ),
                            ","
                        );
                    }
                }
            }
            if ($_POST['reporte_tipo'] == "polizas") {
                fputcsv($csv,  array("", "", "", "", "", "", "", "Total", $total_prima), ",");
            } elseif ($_POST['reporte_tipo'] == "comisiones") {
                fputcsv($csv,  array("", "", "", "Total", $total_prima, "Total", $total_comision), ",");
            }
            fclose($csv);
            $nombre_csv = "Reporte de  " . $_POST['reporte_tipo'] . " de " . $_POST['tipo'] . " de " . $contrato->getFieldValue("Aseguradora")->getLookupLabel();
            $alerta = "Reporte generado exitosamente. "
                .
                '<a href="' . constant("url") . 'public/tmp/reporte.csv" download="' . $nombre_csv . '.csv" class="btn btn-link">Descargar</a>';
        } else {
            $alerta =  "El reporte esta vacio.";
        }
    }
    public function exportar_pdf()
    {
        # code...
    }
}
