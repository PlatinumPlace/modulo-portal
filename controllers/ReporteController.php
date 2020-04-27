<?php

class ReporteController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }
    public function poliza()
    {
        $criterio = "Socio:equals:" . $_SESSION['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);
        if (isset($_POST["submit"])) {
            $contrato = $this->getRecord("Contratos", $_POST['contrato']);
            $criterio = "((Contact_Name:equals:" . $_SESSION['usuario_id'] . ") and (Aseguradora:equals:" .  $contrato->getFieldValue("Aseguradora")->getEntityId() . "))";
            $ofertas = $this->searchRecordsByCriteria("Deals", $criterio);
            if (!empty($ofertas)) {
                $reporte = 'public/tmp/Reporte Pólizas Emitidas de ' . $_POST['tipo'] . '.csv';
                $csv = fopen($reporte, 'w+');
                fputs($csv, $contrato->getFieldValue("Socio")->getLookupLabel() . "\n");
                fputs($csv, "Reporte Pólizas Emitidas de " . $_POST['tipo'] . "\n");
                fputs($csv, "Aseguradora: " . $contrato->getFieldValue("Aseguradora")->getLookupLabel() . "\n");
                fputs($csv, "Poliza " . $contrato->getFieldValue('No_P_liza') . "\n");
                fputs($csv, "Desde " . $_POST['inicio'] . " Hasta " . $_POST['fin'] . "\n");
                fputs($csv, "" . "\n");
                fputs($csv, "Fecha de emision,Nombre Asegurado,Cédula,Marca,Modelo,Año,Chasis,Valor Aseg.,Prima,Plan,Vendedor" . "\n");
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
                            $planes = $cotizacion->getLineItems();
                            foreach ($planes as $plan) {
                                $prima = round($plan->getNetTotal(), 2);
                            }
                        }
                        $valores =
                            date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n")))
                            . "," .
                            $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido")
                            . "," .
                            $oferta->getFieldValue("RNC_Cedula")
                            . "," .
                            $oferta->getFieldValue('Marca')->getLookupLabel()
                            . "," .
                            $oferta->getFieldValue('Modelo')->getLookupLabel()
                            . "," .
                            $oferta->getFieldValue('A_o_de_Fabricacion')
                            . "," .
                            $oferta->getFieldValue('Chasis')
                            . "," .
                            round($oferta->getFieldValue('Valor_Asegurado'), 2)
                            . "," .
                            $prima
                            . "," .
                            $oferta->getFieldValue('Plan')
                            . "," .
                            $_SESSION['usuario_nombre'];
                        fputs($csv, $valores . "\n");
                    }
                }
                fclose($csv);
                $alerta =
                    "Reporte generado exitosamente. "
                    .
                    '<a href="' . constant("url") . $reporte . '.csv" class="btn btn-link">Descargar</a>';
            } else {
                $alerta = "El reporte esta vacio.";
            }
        }
        require_once("views/header.php");
        require_once("views/reporte/poliza.php");
        require_once("views/footer.php");
    }
}
