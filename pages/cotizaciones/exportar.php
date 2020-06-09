<?php

$portal = new portal;
$cotizaciones = new cotizaciones;

$url = $portal->obtener_url();
$alerta  = (isset($url[0])) ? $url[0] : "";
$contrato = $cotizaciones->lista_aseguradoras();
$emitida = array("Emitido", "En trámite");

if (isset($_POST["pdf"])) {

    $post = array(
        "contrato_id" => $_POST["contrato_id"],
        "tipo_cotizacion" => $_POST["tipo_cotizacion"],
        "tipo_reporte" => $_POST["tipo_reporte"],
        "desde" => $_POST["desde"],
        "hasta" => $_POST["hasta"]
    );

    header("Location:" . constant("url") . "cotizaciones/descargar/" . json_encode($post));
    exit();
}
if (isset($_POST["csv"])) {
    $alerta = $cotizaciones->exportar_csv();
}

?>
<h2 class="text-uppercase text-center">
    Reporte de cotizaciones
</h2>

<div class="card">
    <div class="card-body">

        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <form method="POST" action="<?= constant("url") ?>cotizaciones/exportar">

            <h5>Reporte</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tipo</label>
                    <select name="tipo_reporte" class="form-control">
                        <option value="emisiones">Emisiones</option>
                        <option value="comisiones">Comisiones</option>
                        <option value="cotizaciones" selected>Cotizaciones</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tipo de Cotización</label>
                    <select name="tipo_cotizacion" class="form-control">
                        <option value="auto" selected>Auto</option>
                    </select>
                </div>
            </div>

            <br>

            <h5>Aseguradora</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nombre</label>
                    <select name="contrato_id" class="form-control" required>
                        <option value="" selected disabled>Selecciona una Aseguradora</option>
                        <?php
                        if (!empty($contrato)) {
                            foreach ($contrato as $id => $nombre_aseguradora) {
                                echo '<option value="' . $id . '">' . $nombre_aseguradora . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <br>

            <h5>Fecha</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Desde</label>
                    <input type="date" class="form-control" name="desde" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Hasta</label>
                    <input type="date" class="form-control" name="hasta" required>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                    |
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                </div>
            </div>

        </form>
    </div>
</div>