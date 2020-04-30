<?php

class ReporteController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $criterio = "Socio:equals:" . $_SESSION['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);
        if (isset($_POST["submit"])) {
            $contrato = $this->getRecord("Contratos", $_POST['contrato_id']);
            $criterio = "((Account_Name:equals:" . $contrato->getFieldValue("Socio")->getEntityId() . ") and (Aseguradora:equals:" .  $contrato->getFieldValue("Aseguradora")->getEntityId() . "))";
            $ofertas = $this->searchRecordsByCriteria("Deals", $criterio);
            if (!empty($ofertas)) {
                $csv = fopen("public/tmp/reporte.csv", 'w');
                fputcsv($csv, array($contrato->getFieldValue("Socio")->getLookupLabel()), ",");
                fputcsv($csv, array("Reporte " . $_POST['reporte_tipo'] . " de " . $_POST['tipo']), ",");
                fputcsv($csv,  array("Aseguradora: " . $contrato->getFieldValue("Aseguradora")->getLookupLabel()), ",");
                fputcsv($csv,  array("Poliza " . $contrato->getFieldValue('No_P_liza')), ",");
                fputcsv($csv,  array("Desde " . $_POST['inicio'] . " Hasta " . $_POST['fin']), ",");
                fputcsv($csv,  array(""), ",");
                if ($_POST['reporte_tipo'] == "polizas") {
                    fputcsv($csv,  array("Fecha de emision", "Nombre Asegurado", "Cedula", "Marca", "Modelo", "Ano", "Chasis", "Valor Aseg.", "Prima", "Plan", "Vendedor"), ",");
                } elseif ($_POST['reporte_tipo'] == "comisiones") {
                    fputcsv($csv,  array("Fecha de emision", "Nombre Asegurado", "Cedula", "Valor Aseg.", "Prima", "Plan", "Comision", "Vendedor"), ",");
                }
                foreach ($ofertas as $oferta) {
                    if (isset($_POST['usuario'])) {
                        if (
                            $oferta->getFieldValue("Contact_Name")->getEntityId() == $_SESSION['usuario_id']
                            and
                            $oferta->getFieldValue("Type") == $_POST['tipo']
                            and
                            date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n")))  > $_POST['inicio']
                            and
                            date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) < $_POST['fin']
                        ) {
                            $criterio = "Deal_Name:equals:" . $oferta->getEntityId();
                            $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio);
                            foreach ($cotizaciones as $cotizacion) {
                                $prima = round($cotizacion->getFieldValue("Grand_Total"), 2);
                                $comision = $cotizacion->getFieldValue("Importe_Socio");
                            }
                            if ($_POST['reporte_tipo'] == "polizas") {
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
                                        $prima,
                                        $oferta->getFieldValue('Plan'),
                                        $_SESSION['usuario_nombre']
                                    ),
                                    ","
                                );
                            } elseif ($_POST['reporte_tipo'] == "comisiones") {
                                fputcsv(
                                    $csv,
                                    array(
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                        $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                        $oferta->getFieldValue("RNC_Cedula"),
                                        round($oferta->getFieldValue('Valor_Asegurado'), 2),
                                        $prima,
                                        $oferta->getFieldValue('Plan'),
                                        $comision,
                                        $_SESSION['usuario_nombre']
                                    ),
                                    ","
                                );
                            }
                        }
                    } else {
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
                                $prima = round($cotizacion->getFieldValue("Grand_Total"), 2);
                                $comision = $cotizacion->getFieldValue("Importe_Socio");
                            }
                            if ($_POST['reporte_tipo'] == "polizas") {
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
                                        $prima,
                                        $oferta->getFieldValue('Plan'),
                                        $_SESSION['usuario_nombre']
                                    ),
                                    ","
                                );
                            } elseif ($_POST['reporte_tipo'] == "comisiones") {
                                fputcsv(
                                    $csv,
                                    array(
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                        $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                        $oferta->getFieldValue("RNC_Cedula"),
                                        round($oferta->getFieldValue('Valor_Asegurado'), 2),
                                        $prima,
                                        $comision,
                                        $oferta->getFieldValue('Plan'),
                                        $_SESSION['usuario_nombre']
                                    ),
                                    ","
                                );
                            }
                        }
                    }
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
        require_once("views/header.php");
        require_once("views/reporte/index.php");
        require_once("views/footer.php");
    }
}
