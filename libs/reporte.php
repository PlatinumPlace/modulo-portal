<?php
class Reporte extends Api
{
    function __construct()
    {
        // inicializamos la clase api
        parent::__construct();
    }
    public function exportarCSV()
    {
        $contacto = $this->getRecord("Contacts", $_SESSION['usuario']);
        $criterio = "Socio:equals:" . $contacto->getFieldValue("Account_Name")->getEntityId();
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio);
        if (isset($_POST["submit"])) {
            $criterio = "((Contact_Name:equals:" . $_SESSION['usuario'] . ") and (Aseguradora:equals:" . $_POST['aseguradora'] . "))";
            $tratos = $this->searchRecordsByCriteria("Deals", $criterio);
            if (!empty($tratos)) {
                $csv = fopen('public/tmp/reporte.csv', 'w');
                if ($csv) {
                    fputs($csv, "Codigo, Nombre, Importe" . "\n");
                    foreach ($tratos as $trato) {
                        if (
                            $trato->getFieldValue("P_liza") != null
                            and
                            date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n")))  > $_POST['inicio']
                            and
                            date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) < $_POST['fin']
                        ) {
                            fputs($csv, "1,2,3" . "\n");
                        }
                    }
                    fclose($csv);
                    header("Location:" . constant("url")."public/tmp/reporte.csv");
                    unlink(constant("url")."public/tmp/reporte.csv");
                } else {

                    echo "El archivo no existe o no se pudo crear";
                }
            }
        }
        require("pages/header.php");
        require("pages/reporte/index.php");
        require("pages/footer.php");
    }
}
