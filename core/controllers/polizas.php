<?php

class polizas
{
    public function buscar()
    {
        $trato = new trato;
        $num_pag = (isset($_GET["page"])) ? $_GET["page"] : 1;

        if ($_POST) {
            $lista = $trato->buscar($num_pag, 10, $_POST['parametro'], $_POST['busqueda']);
        } else {
            $lista = $trato->lista($num_pag, 10);
        }

        require_once "core/views/layout/header.php";
        require_once "core/views/polizas/buscar.php";
        require_once "core/views/layout/footer.php";
    }

    public function detalles()
    {
        $trato = new trato;
        $detalles = $trato->detalles();

        if (empty($detalles)) {
            require_once "error.php";
            exit();
        }

        require_once "core/views/layout/header.php";

        if ($detalles->getFieldValue("Type") == "Auto") {
            require_once "core/views/polizas/detalles_auto.php";
        }

        require_once "core/views/layout/footer.php";
    }

    public function descargar()
    {
        $trato = new trato;
        $detalles = $trato->detalles();

        if (empty($detalles)) {
            require_once "error.php";
            exit();
        }

        $imagen_aseguradora = $trato->imagenAseguradora($detalles->getFieldValue('Aseguradora')->getEntityId());
        $cliente = $trato->detallesCliente($detalles->getFieldValue('Cliente')->getEntityId());

        if ($detalles->getFieldValue("Type") == "Auto") {
            $bien = $trato->detallesBien($detalles->getFieldValue('Bien')->getEntityId());
            $aseguradora = $trato->detallesAseguradora($detalles->getFieldValue('Aseguradora')->getEntityId());
            $coberturas = $trato->coberturas($detalles->getFieldValue('Contrato')->getEntityId());

            require_once "core/views/polizas/descargar_auto.php";
        }
    }
}
