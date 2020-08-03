<h2 class="mt-4 text-uppercase">
    <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
        emitir cotización
    <?php else : ?>
        adjuntar documentos
    <?php endif ?>
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <div class="card mb-4">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/emitir/<?= $id ?>">

                    <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>

                        <h4>Cliente</h4>
                        <hr>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="rnc_cedula">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="nombre">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="apellido">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="telefono">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="tel_residencia">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="tel_trabajo">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                            <div class="col-sm-9">
                                <input required type="date" class="form-control" name="fecha_nacimiento">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="correo">
                            </div>
                        </div>

                        <br>
                        <h4>Vehículo</h4>
                        <hr>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Chasis</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="chasis">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Color</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="color">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Placa</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="placa">
                            </div>
                        </div>

                        <br>
                        <h4>Emitir con:</h4>
                        <hr>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Aseguradora</label>
                            <div class="col-sm-9">
                                <select required name="aseguradora" class="form-control">
                                    <option value="" selected disabled>Selecciona una Aseguradora</option>
                                    <?php
                                    $planes = $cotizacion->getLineItems();
                                    foreach ($planes as $plan) {
                                        if ($plan->getNetTotal() > 0) {
                                            $plan_detalles = $api->detalles_registro("Products", $plan->getProduct()->getEntityId());
                                            echo '<option value="' . $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() . '">' . $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Cotización Firmada</label>
                            <div class="col-sm-9">
                                <input required type="file" class="form-control-file" name="cotizacion_firmada">
                            </div>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-success">Emitir</button>

                    <?php else : ?>

                        <div class="form-group row">
                            <label for="modelo" class="col-sm-3 col-form-label font-weight-bold">
                                Documentos <br> <small>(Manten presionado Ctrl para seleccionar varios archivos)</small>
                            </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control-file" multiple name="documentos[]" required>
                            </div>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary">Adjuntar</button>

                    <?php endif ?>

                    |
                    <a href="<?= constant("url") ?>auto/detalles/<?= $id ?>" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
</div>