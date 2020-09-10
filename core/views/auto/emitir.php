<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">emitir cotización auto</h1>
</div>

<?php if (isset($_GET["alert"])) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $_GET["alert"] ?>
    </div>
<?php endif ?>

<form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/emitir?id=<?= $_GET["id"] ?>">

    <h4>Cliente</h4>
    <hr>
    <div class="row">

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Nombre</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="nombre" value="<?= $detalles->getFieldValue('Nombre') ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Apellido</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="apellido">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="rnc_cedula" value="<?= $detalles->getFieldValue('RNC_C_dula') ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Fecha de Nacimiento</label>

                <div class="col-sm-8">
                    <input type="date" class="form-control" name="fecha_nacimiento">
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Correo Electrónico</label>

                <div class="col-sm-8">
                    <input type="email" class="form-control" name="correo">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Dirección</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="direccion">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Celular</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="telefono">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Residencial</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="tel_residencia">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Trabajo</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="tel_trabajo">
                </div>
            </div>

        </div>

    </div>

    <br>
    <h4>Vehículo</h4>
    <hr>
    <div class="row">

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Chasis</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="chasis">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Placa</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="placa">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Estado</label>

                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="estado">
                        <label class="form-check-label" for="gridCheck"> Nuevo </label>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Color</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="color">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Uso</label>

                <div class="col-sm-8">
                    <select name="uso" class="form-control">
                        <option value="Privado" selected>Privado</option>
                        <option value="Publico">Publico</option>
                    </select>
                </div>
            </div>

        </div>

    </div>

    <br>
    <h4>Emitir con:</h4>
    <hr>
    <div class="row">

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Aseguradora</label>

                <div class="col-sm-8">
                    <select required name="plan_id" class="form-control">
                        <option value="" selected disabled>Selecciona una Aseguradora</option>
                        <?php
                        $planes = $detalles->getLineItems();
                        foreach ($planes as $plan) {
                            if ($plan->getNetTotal() > 0) {
                                echo '<option value="' . $plan->getId() . '">' . $plan->getDescription() . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Cotización Firmada</label>

                <div class="col-sm-8">
                    <input required type="file" class="form-control-file" name="cotizacion_firmada">
                </div>
            </div>

        </div>

    </div>

    <br>
    <button type="submit" class="btn btn-success">Emitir</button>
    |
    <a href="<?= constant("url") ?>auto/detalles?id=<?= $_GET["id"] ?>" class="btn btn-info">Cancelar</a>
</form>

<br><br>