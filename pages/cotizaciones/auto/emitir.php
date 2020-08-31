<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">emitir cotización auto</h1>
</div>

<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>?page=emitir&id=<?= $id ?>">

    <h4>Cliente</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-3">
            <label><b>Nombre</b></label>

            <input required type="text" class="form-control" name="nombre" value="<?= $cotizacion->getFieldValue('Nombre') ?>">
        </div>

        <div class="form-group col-md-3">
            <label><b>Apellido</b></label>

            <input required type="text" class="form-control" name="apellido">
        </div>

        <div class="form-group col-md-3">
            <label><b>RNC/Cédula</b></label>

            <input type="text" class="form-control" name="rnc_cedula" value="<?= $cotizacion->getFieldValue('RNC_C_dula') ?>">
        </div>

        <div class="form-group col-md-3">
            <label><b>Fecha de Nacimiento</b></label>

            <input type="date" class="form-control" name="fecha_nacimiento">
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label><b>Correo Electrónico</b></label>

            <input type="email" class="form-control" name="correo">
        </div>

        <div class="form-group col-md-6">
            <label><b>Dirección</b></label>

            <input type="text" class="form-control" name="direccion">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label><b>Tel. Celular</b></label>

            <input type="tel" class="form-control" name="telefono">
        </div>

        <div class="form-group col-md-4">
            <label><b>Tel. Residencial</b></label>

            <input type="tel" class="form-control" name="tel_residencia">
        </div>

        <div class="form-group col-md-4">
            <label><b>Tel. Trabajo</b></label>

            <input type="tel" class="form-control" name="tel_trabajo">
        </div>

    </div>

    <br>
    <h4>Vehículo</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-4">
            <label><b>Chasis</b></label>

            <input required type="text" class="form-control" name="chasis">
        </div>

        <div class="form-group col-md-4">
            <label><b>Placa</b></label>

            <input type="text" class="form-control" name="placa">
        </div>

        <div class="form-group col-md-4">
            <label><b>Color</b></label>

            <input type="text" class="form-control" name="color">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label><b>Uso</b></label>

            <select name="uso" class="form-control">
                <option value="Privado" selected>Privado</option>
                <option value="Publico">Publico</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label><b>Estado</b></label>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck" name="estado">
                <label class="form-check-label" for="gridCheck"> Nuevo </label>
            </div>
        </div>

    </div>

    <br>
    <h4>Emitir con:</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label><b>Aseguradora</b></label>
            <select required name="plan_id" class="form-control">
                <option value="" selected disabled>Selecciona una Aseguradora</option>
                <?php
                $planes = $cotizacion->getLineItems();
                foreach ($planes as $plan) {
                    if ($plan->getNetTotal() > 0) {
                        $plan_detalles = detalles_registro("Products", $plan->getProduct()->getEntityId());
                        echo '<option value="' . $plan->getId() . '">' . $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label><b>Cotización Firmada</b></label>

            <input required type="file" class="form-control-file" name="cotizacion_firmada">
        </div>

    </div>

    <br>
    <button type="submit" class="btn btn-success">Emitir</button>
    |
    <a href="<?= constant("url") ?>?page=detalles&id=<?= $id ?>" class="btn btn-info">Cancelar</a>
</form>