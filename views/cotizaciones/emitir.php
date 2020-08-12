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
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
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
                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>cotizaciones/emitir/<?= $id ?>">

                    <h4>Deudor</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" name="rnc_cedula" value="<?= $cotizacion->getFieldValue('RNC_C_dula') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" name="nombre" value="<?= $cotizacion->getFieldValue('Nombre') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="apellido" value="<?= $cotizacion->getFieldValue('Apellido') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="direccion" value="<?= $cotizacion->getFieldValue('Direcci_n') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="telefono" value="<?= $cotizacion->getFieldValue('Tel_Celular') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="tel_residencia" value="<?= $cotizacion->getFieldValue('Tel_Residencial') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="tel_trabajo" value="<?= $cotizacion->getFieldValue('Tel_Trabajo') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="correo" value="<?= $cotizacion->getFieldValue('Correo') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                        <div class="col-sm-9">
                            <input readonly type="date" class="form-control" name="fecha_nacimiento" value="<?= $cotizacion->getFieldValue('Fecha_Nacimiento') ?>">
                        </div>
                    </div>

                    <?php if ($cotizacion->getFieldValue('Tipo') == "Auto") : ?>

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

                    <?php endif ?>

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
                                        $plan_detalles = $api->getRecord("Products", $plan->getProduct()->getEntityId());
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
                    |
                    <a href="<?= constant("url") ?>cotizaciones/detalles_auto/<?= $id ?>" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>

    </div>
</div>