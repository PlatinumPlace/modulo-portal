<h1 class="mt-4">Exportar cotizaciones</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item active">Exportar</li>
</ol>

<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form class="row justify-content-center" method="POST" action="<?= constant("url") ?>cotizaciones/exportar">

    <div class="col-lg-10">
        <div class="card mb-4">

            <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de reporte</label>
                            <select name="tipo_reporte" class="form-control">
                                <option value="cotizaciones" selected>Cotizaciones</option>
                                <option value="emisiones">Emisiones</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de cotización</label>
                            <select name="tipo_cotizacion" class="form-control">
                                <option value="auto" selected>Auto</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Desde</label>
                            <input type="date" class="form-control" name="desde" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Hasta</label>
                            <input type="date" class="form-control" name="hasta" required>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Aseguradora</label>
                            <select name="aseguradora_id" class="form-control">
                                <option value="" selected>Todas</option>
                                <?php
                                if (!empty($aseguradoras)) {
                                    foreach ($aseguradoras as $id => $nombre) {
                                        echo '<option value="' . $id . '">' . $nombre . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                </div>

            </div>
        </div>

</form>