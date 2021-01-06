<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Cotizar Vida</h1>
<hr>

<form action="<?= site_url("cotizaciones/vida") ?>" method="post">
    <?= csrf_field() ?>

    <div class="card mb-4">
        <h5 class="card-header">Vida/desempleo</h5>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Edad del deudor</label>
                    <input type="number" class="form-control" name="edad_deudor" maxlength="2" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Edad del codeudor</label>
                    <input type="number" class="form-control" name="edad_codeudor" maxlength="2">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Plazo (meses)</label>
                    <input type="number" class="form-control" name="plazo" maxlength="3" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Cuota mensual</label>
                    <input type="number" class="form-control" name="cuota">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Suma asegurada</label>
                    <input type="number" class="form-control" name="suma" required>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <h5 class="card-header">Deudor (opcional)</h5>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Nombre</label>
                    <input type="text" class="form-control" name="nombre">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Apellido</label>
                    <input type="text" class="form-control" name="apellido">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">RNC/Cédula</label>
                    <input type="text" class="form-control" name="rnc_cedula">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correo">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Dirección</label>
                    <input type="text" class="form-control" name="direccion">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Celular</label>
                    <input type="tel" class="form-control" name="telefono">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Residencial</label>
                    <input type="tel" class="form-control" name="tel_residencia">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Trabajo</label>
                    <input type="tel" class="form-control" name="tel_trabajo">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <h5 class="card-header">Codeudor (opcional)</h5>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Nombre</label>
                    <input type="text" class="form-control" name="nombre_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Apellido</label>
                    <input type="text" class="form-control" name="apellido_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">RNC/Cédula</label>
                    <input type="text" class="form-control" name="rnc_cedula_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correo_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Dirección</label>
                    <input type="text" class="form-control" name="direccion_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Celular</label>
                    <input type="tel" class="form-control" name="telefono_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Residencial</label>
                    <input type="tel" class="form-control" name="tel_residencia_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Trabajo</label>
                    <input type="tel" class="form-control" name="tel_trabajo_codeudor">
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" type="submit">Cotizar</button>
</form>

<br>

<?= $this->endSection() ?>