<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form class="row justify-content-center" enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/emitir/<?= $resumen_id ?>">

    <div class="col-lg-10">

        <div class="card mb-4">
            <h5 class="card-header">Adjuntar Documentos</h5>
            <div class="card-body">

                <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
                    <div class="form-row">

                        <div class="col-md-6">
                            <label class="font-weight-bold">Aseguradora</label>
                            <select name="aseguradora_id" class="form-control" required>
                                <option value="" selected disabled>Selecciona una Aseguradora</option>
                                <?php
                                foreach ($cotizaciones as $cotizacion) {
                                    if ($cotizacion->getFieldValue('Grand_Total') > 0) {
                                        echo '<option value="' . $cotizacion->getFieldValue('Aseguradora')->getEntityId() . '">' . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="font-weight-bold">Cotización Firmada</label>
                            <input type="file" class="form-control-file" name="cotizacion_firmada" required>
                        </div>

                    </div>

                <?php else : ?>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Otros Documentos</label>
                            <input type="file" class="form-control-file" multiple name="documentos[]" required>
                        </div>
                    </div>

                <?php endif ?>

            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Opciones</h5>
            <div class="card-body">
                <button type="submit" class="btn btn-success">Completar</button>
            </div>
        </div>

    </div>

</form>