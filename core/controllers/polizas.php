<?php

class polizas {

    function lista() {
        require_once 'core/views/layout/header.php';
        require_once 'core/views/polizas/lista.php';
        require_once 'core/views/layout/footer.php';
    }

    function detallesAuto() {
        if (isset($_GET["attachment_id"])) {
            $polizas = new poliza();
            $detalles = $polizas->detalles();
            $polizas->descargarAdjuntoContrato($detalles->getFieldValue('Contrato')->getEntityId());
        }

        require_once 'core/views/layout/header.php';
        require_once 'core/views/polizas/auto/detalles.php';
        require_once 'core/views/layout/footer.php';
    }

    public function descargarAuto() {
        require_once 'core/views/polizas/auto/descargar.php';
    }

    function adjuntar() {
        require_once 'core/views/layout/header.php';
        require_once 'core/views/polizas/adjuntar.php';
        require_once 'core/views/layout/footer.php';
    }

}
