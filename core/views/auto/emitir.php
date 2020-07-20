<h2 class="mt-4 text-uppercase text-center">
    seguro vehículo de motor plan <?= $cotizacion->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (isset($alerta)) : ?>
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

                <br>

                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/emitir/<?= $id ?>">

                    <div id="existente" style="display: none;">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Nombre</label>
                                    <select name="cliente_id" class="form-control">
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
                        </div>
                    </div>

                    <div id="nuevo">

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">RNC/Cédula <small>(sin guiones)</small> </label>
                                    <input type="text" class="form-control" name="rnc_cedula" maxlength="11">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Nombre</label>
                                    <input type="text" class="form-control" name="nombre">
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Apellido</label>
                                    <input type="text" class="form-control" name="apellido">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-groups">
                                    <label class="font-weight-bold">Dirección</label>
                                    <input type="text" class="form-control" name="direccion">
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tel. Celular</label>
                                <input type="tel" class="form-control" name="telefono">
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tel. Trabajo</label>
                                <input type="tel" class="form-control" name="tel_residencia">
                            </div>
                        </div>

                        <br>


                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Tel. Residencial</label>
                                <input type="tel" class="form-control" name="tel_trabajo">
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Correo Electrónico</label>
                                <input type="email" class="form-control" name="correo">
                            </div>
                        </div>

                        <br>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento">
                            </div>
                        </div>

                    </div>

                    <br>

                    <h4>Vehículo</h4> <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Chasis <small>(sin guiones,solo números y letras)</small></label>
                            <input type="text" class="form-control" name="chasis">
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Color</label>
                            <input type="text" class="form-control" name="color">
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Placa</label>
                            <input type="text" class="form-control" name="placa">
                        </div>
                    </div>


                    <br>

                    <h4>Emitir con:</h4> <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Aseguradora</label>
                            <select name="aseguradora_id" class="form-control" required>
                                <option value="" selected disabled>Selecciona una Aseguradora</option>
                                <?php
                                $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 10);
                                sort($contratos);
                                foreach ($contratos as $contrato) {
                                    echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getEntityId() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Cotización Firmada</label>
                            <input type="file" class="form-control-file" name="cotizacion_firmada" required>
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <button type="submit" class="btn btn-success">Emitir</button>
                                |
                                <a href="<?= constant("url") ?>auto/detalles/<?= $id ?>" class="btn btn-info">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
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