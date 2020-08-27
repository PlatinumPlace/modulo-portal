<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">emitir cotización auto</h1>
</div>

<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>emitir_auto/<?= $id ?>">

    <h4>Cliente</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label><strong>Nombre</strong></label>

            <input required type="text" class="form-control" name="nombre" value="<?= $cotizacion->getFieldValue('Nombre') ?>">
        </div>

        <div class="form-group col-md-4">
            <label><strong>Apellido</strong></label>

            <input required type="text" class="form-control" name="apellido">
        </div>

        <div class="form-group col-md-4">
            <label><strong>RNC/Cédula</strong></label>

            <input type="text" class="form-control" name="rnc_cedula" value="<?= $cotizacion->getFieldValue('RNC_C_dula') ?>">
        </div>

    </div>

    <div class="form-group">
        <label><strong>Dirección</strong></label>

        <input type="text" class="form-control" name="direccion">
    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label><strong>Tel. Celular</strong></label>

            <input type="tel" class="form-control" name="telefono">
        </div>

        <div class="form-group col-md-4">
            <label><strong>Tel. Residencial</strong></label>

            <input type="tel" class="form-control" name="tel_residencia">
        </div>

        <div class="form-group col-md-4">
            <label><strong>Tel. Trabajo</strong></label>

            <input type="tel" class="form-control" name="tel_trabajo">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label><strong>Correo Electrónico</strong></label>

            <input type="email" class="form-control" name="correo">
        </div>

        <div class="form-group col-md-6">
            <label><strong>Fecha de Nacimiento</strong></label>

            <input type="date" class="form-control" name="fecha_nacimiento">
        </div>

    </div>

    <br>
    <h4>Vehículo</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-4">
            <label><strong>Chasis</strong></label>

            <input required type="text" class="form-control" name="chasis">
        </div>

        <div class="form-group col-md-4">
            <label><strong>Placa</strong></label>

            <input type="text" class="form-control" name="placa">
        </div>

        <div class="form-group col-md-4">
            <label><strong>Color</strong></label>

            <input type="text" class="form-control" name="color">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label><strong>Uso</strong></label>

            <select name="uso" class="form-control">
                <option value="Privado" selected>Privado</option>
                <option value="Publico">Publico</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label><strong>Estado</strong></label>

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
            <label><strong>Aseguradora</strong></label> <select required name="aseguradora" class="form-control">
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
            <label><strong>Cotización Firmada</strong></label>

            <input required type="file" class="form-control-file" name="cotizacion_firmada">
        </div>

    </div>

    <br>
    <button type="submit" class="btn btn-success">Emitir</button>
    | <a href="<?= constant("url") ?>detalles_auto/<?= $id ?>" class="btn btn-info">Cancelar</a>
</form>