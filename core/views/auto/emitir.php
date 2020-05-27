<div class="card">
    <div class="card-body">
        <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/emitir/<?= $id ?>">

            <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>

                <h5>Aseguradora</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Nombre</label>
                        <select name="aseguradora_id" class="form-control" required>
                            <option value="" selected disabled>Selecciona una Aseguradora</option>
                            <?php
                            foreach ($detalles as $resumen) {
                                if ($resumen->getFieldValue('Grand_Total') > 0) {
                                    echo '<option value="' . $resumen->getFieldValue('Aseguradora')->getEntityId() . '">' . $resumen->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Cotización Firmada</label>
                        <input type="file" class="form-control-file" name="cotizacion_firmada" required>
                    </div>
                </div>

            <?php else : ?>

                <h5>Adjuntar documentos a la cotización</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Expedientes</label>
                        <input type="file" class="form-control-file" multiple name="documentos[]" required>
                    </div>
                </div>

            <?php endif ?>

            <br>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" name="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>

        </form>
    </div>
</div>