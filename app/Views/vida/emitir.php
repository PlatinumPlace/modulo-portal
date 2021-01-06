<input type="text" value="<?= $cotizacion->getFieldValue('Edad_codeudor') ?>" name="edad_deudor" hidden />
<input type="text" value="<?= $cotizacion->getFieldValue('Edad_deudor') ?>" name="edad_codeudor" hidden />
<input type="text" value="<?= $cotizacion->getFieldValue('Cuota') ?>" name="cuota" hidden />
<input type="text" value="<?= $cotizacion->getFieldValue('Plazo') ?>" name="plazo" hidden />

<?php if (!empty($cotizacion->getFieldValue('Edad_codeudor'))) : ?>
    <div class="card mb-4">
        <h5 class="card-header">Codeudor</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><b>Nombre</b></label>
                    <input required type="text" class="form-control" name="nombre_codeudor" value="<?= $cotizacion->getFieldValue('Nombre_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Apellido</b></label>
                    <input type="text" class="form-control" name="apellido_codeudor" value="<?= $cotizacion->getFieldValue('Apellido_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>RNC/Cédula</b></label>
                    <input required type="text" class="form-control" name="rnc_cedula_codeudor" value="<?= $cotizacion->getFieldValue('RNC_C_dula_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Fecha de Nacimiento</b></label>
                    <input type="date" class="form-control" name="fecha_nacimiento_codeudor" required value="<?= $cotizacion->getFieldValue('Fecha_de_nacimiento_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Correo Electrónico</b></label>
                    <input type="email" class="form-control" name="correo_codeudor" value="<?= $cotizacion->getFieldValue('Correo_electr_nico_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Dirección</b></label>
                    <input type="text" class="form-control" name="direccion_codeudor" value="<?= $cotizacion->getFieldValue('Direcci_n_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Tel. Celular</b></label>
                    <input type="tel" class="form-control" name="telefono_codeudor" value="<?= $cotizacion->getFieldValue('Tel_Celular_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Tel. Residencial</b></label>
                    <input type="tel" class="form-control" name="tel_residencia_codeudor" value="<?= $cotizacion->getFieldValue('Tel_Residencia_codeudor') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Tel. Trabajo</b></label>
                    <input type="tel" class="form-control" name="tel_trabajo_codeudor" value="<?= $cotizacion->getFieldValue('Tel_Trabajo_codeudor') ?>">
                </div>
            </div>
        </div>
    </div>
<?php endif ?>