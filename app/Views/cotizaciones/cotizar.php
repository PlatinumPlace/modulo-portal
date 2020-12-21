<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cotizar</h1>
</div>

<?php if (empty($tipo)) : ?>
    <div class="row justify-content-center">
        <div class="col-sm-3">
            <div class="card mb-3 text-center">
                <img src="<?= base_url("img/auto.png") ?>" class="card-img-top">
                <a class="small text-white stretched-link" href="<?= site_url("cotizaciones/cotizar/auto") ?>"></a>
                <div class="card-body">
                    <h5 class="card-title">AUTO</h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card mb-3 text-center">
                <img src="<?= base_url("img/vida.png") ?>" class="card-img-top">
                <a class="small text-white stretched-link" href="<?= site_url("cotizaciones/cotizar/vida") ?>"></a>
                <div class="card-body">
                    <h5 class="card-title">VIDA/DESEMPLEO</h5>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($tipo == "auto") : ?>
    <form action="<?= site_url("cotizaciones/cotizarAuto") ?>" method="post">
        <?= csrf_field() ?>

        <div class="card mb-4">
            <h5 class="card-header">Vehículo</h5>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Marca</label>
                        <select name="marca" class="form-control" id="marca" onchange="modelosAJAX(this)" required>
                            <option value="" selected disabled>Selecciona una Marca</option>
                            <?php foreach ($marcas as $marca) : ?>
                                <option value="<?= $marca->getEntityId() ?>">
                                    <?= strtoupper($marca->getFieldValue('Name')) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Modelo</label>
                        <select name="modelo" class="form-control" id="modelos" required>
                            <option value="" selected disabled>Selecciona un modelo</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Año</label>
                        <input type="number" class="form-control" name="a_o" maxlength="4" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Uso</label>
                        <select name="uso" class="form-control">
                            <option value="Privado" selected>Privado</option>
                            <option value="Publico ">Publico</option>
                            <option value="Taxi">Taxi</option>
                            <option value="Rentado">Rentado</option>
                            <option value="Deportivo">Deportivo</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Condiciones</label>
                        <select name="condiciones" class="form-control">
                            <option value="Nuevo" selected>Nuevo</option>
                            <option value="Usado ">Usado</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Plan</label>
                        <select name="plan" class="form-control">
                            <option value="Mensual full" selected>Mensual Full</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Suma asegurada</label>
                        <input type="number" class="form-control" name="suma" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Cliente (opcional)</h5>
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

        <button class="btn btn-primary" type="submit">Cotizar</button>
    </form>

    <script>
        function modelosAJAX(val) {
            $.ajax({
                url: "<?= site_url("cotizaciones/modelos") ?>",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                type: "POST",
                data: {
                    marcaid: val.value
                },
                success: function(response) {
                    document.getElementById("modelos").innerHTML = response;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
<?php elseif ($tipo == "vida") : ?>
    <form action="<?= site_url("cotizaciones/cotizarVida") ?>" method="post">
        <?= csrf_field() ?>

        <div class="card mb-4">
            <h5 class="card-header">Deudor</h5>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Edad del deudor</label>
                        <input type="number" class="form-control" name="edad_deudor" maxlength="2" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Plazo (meses)</label>
                        <input type="number" class="form-control" name="plazo" maxlength="3" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Suma asegurada</label>
                        <input type="number" class="form-control" name="suma" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Codeudor (opcional)</h5>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Edad</label>
                        <input type="number" class="form-control" name="edad_codeudor" maxlength="2">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Desempleo (opcional)</h5>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Cuota mensual</label>
                        <input type="number" class="form-control" name="cuota">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Cliente (opcional)</h5>
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

        <button class="btn btn-primary" type="submit">Cotizar</button>
    </form>
<?php endif ?>

<br>

<?= $this->endSection() ?>