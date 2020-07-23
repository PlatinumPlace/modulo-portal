<h2 class="mt-4 text-uppercase text-center">
    cotización <br>
    seguro vehículo de motor <br>
    <?= $cotizacion->getFieldValue('Subject') ?>
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/detalles_auto/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
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

                <div class="row">
                    <div class="col-md-6">
                        <h4>Cliente</h4>
                    </div>
                    <div class="col-md-6">
                        <button onclick="existente()" class="btn btn-primary">Cliente Existente</button>
                    </div>
                </div>

                <hr>

                <div id="existente" style="display: none;">
                
                    <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>cotizaciones/emitir_auto/<?= $id ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cliente_id">Nombre</label>
                                <select required name="cliente_id" id="cliente_id" class="form-control">
                                    <option selected value="">Ninguno</option>
                                    <?php
                                    $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                    $num_pagina = 1;
                                    do {
                                        $clientes = $api->buscar_criterio("Clientes", $criterio, $num_pagina, 200);
                                        if (!empty($clientes)) {
                                            $num_pagina++;
                                            sort($clientes);
                                            foreach ($clientes as $cliente) {
                                                echo '<option value="' . $cliente->getEntityId() . '">' . strtoupper($cliente->getFieldValue("Name")) . " " . strtoupper($cliente->getFieldValue("Apellido")) . '</option>';
                                            }
                                        } else {
                                            $num_pagina = 0;
                                        }
                                    } while ($num_pagina > 0);
                                    ?>
                                </select>
                            </div>
                        </div>

                        <br>
                        <h4>Vehículo</h4>
                        <hr>

                        <div class="form-group">
                            <label for="chasis">Chasis <small>(sin guiones)</small></label>
                            <input required type="text" class="form-control" id="chasis" name="chasis">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="placa">Placa</label>
                                <input type="text" class="form-control" id="placa" name="placa">
                            </div>
                        </div>

                        <br>
                        <h4>Emitir con:</h4>
                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="aseguradora_id">Aseguradora</label>
                                <select required id="aseguradora_id" name="aseguradora" class="form-control">
                                    <option value="" selected disabled>Selecciona una Aseguradora</option>
                                    <?php
                                    $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                    $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 10);
                                    sort($contratos);
                                    foreach ($contratos as $contrato) {
                                        echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                    }
                                    ?>
                                </select> </div>
                            <div class="form-group col-md-6">
                                <label for="cotizacion_firmada">Cotización Firmada</label>
                                <input required type="file" class="form-control-file" name="cotizacion_firmada" id="cotizacion_firmada">
                            </div>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-success">Emitir</button>
                        |
                        <a href="<?= constant("url") ?>auto/detalles/<?= $id ?>" class="btn btn-info">Cancelar</a>

                    </form>

                </div>
                <div id="nuevo">

                    <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>cotizaciones/emitir_auto/<?= $id ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="rnc_cedula">RNC/Cédula <small>(sin guiones)</small></label>
                                <input required type="text" class="form-control" id="rnc_cedula" name="rnc_cedula" maxlength="11">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombre">Nombre</label>
                                <input required type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apellido">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="telefono">Tel. Celular</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tel_residencia">Tel. Trabajo</label>
                                <input type="tel" class="form-control" id="tel_residencia" name="tel_residencia">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tel_trabajo">Tel. Residencial</label>
                                <input type="tel" class="form-control" id="tel_trabajo" name="tel_trabajo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input required type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo">
                        </div>


                        <br>
                        <h4>Vehículo</h4>
                        <hr>

                        <div class="form-group">
                            <label for="chasis">Chasis <small>(sin guiones)</small></label>
                            <input required type="text" class="form-control" id="chasis" name="chasis">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="placa">Placa</label>
                                <input type="text" class="form-control" id="placa" name="placa">
                            </div>
                        </div>

                        <br>
                        <h4>Emitir con:</h4>
                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="aseguradora_id">Aseguradora</label>
                                <select required id="aseguradora_id" name="aseguradora" class="form-control">
                                    <option value="" selected disabled>Selecciona una Aseguradora</option>
                                    <?php
                                    $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                    $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 10);
                                    sort($contratos);
                                    foreach ($contratos as $contrato) {
                                        echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                    }
                                    ?>
                                </select> </div>
                            <div class="form-group col-md-6">
                                <label for="cotizacion_firmada">Cotización Firmada</label>
                                <input required type="file" class="form-control-file" name="cotizacion_firmada" id="cotizacion_firmada">
                            </div>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-success">Emitir</button>
                        |
                        <a href="<?= constant("url") ?>auto/detalles/<?= $id ?>" class="btn btn-info">Cancelar</a>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function existente() {
        if (document.getElementById("existente").style.display == "none") {
            document.getElementById("existente").style.display = "block";
            document.getElementById("nuevo").style.display = "none";
        } else {
            document.getElementById("nuevo").style.display = "block";
            document.getElementById("existente").style.display = "none";
        }
    }
</script>