<h2 class="text-uppercase text-center">
    cotización No. <?= $cotizacion->getFieldValue('No_Cotizaci_n') ?>
    <br>
    seguro vehículo de motor
    <br>
    plan <?= $cotizacion->getFieldValue('Plan') ?>
</h2>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Opciones</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#" onclick="mostrar_detalles()">
                    <i class="tiny material-icons">details</i> Detalles
                </a>
            </li>
            <?php if ($cotizacion->getFieldValue('Email') == null) : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="mostrar_completar()">
                        <i class="tiny material-icons">content_paste</i> Completar
                    </a>
                </li>
            <?php else : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="#" onclick="mostrar_emitir()">
                        <i class="tiny material-icons">folder_shared</i> Emitir
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?url=auto/descargar/<?= $cotizacion->getEntityId() ?>">
                        <i class="tiny material-icons">file_download</i> Descargar
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>

<br>

<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>

    <br>
<?php endif ?>

<div id="detalles">

    <?php if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>
        <div class="card-deck">
            <div class="card">
                <h5 class="card-header">Documentos</h5>
                <div class="card-body">
                    <a download="Condiciones del Vehículos.pdf" href="public/files/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                    <a download="Formulario de Conocimiento.pdf" href="public/files/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                    <a download="Formulario de Inspección de Vehículos.pdf" href="public/files/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
                </div>
            </div>

            <div class="card">
                <h5 class="card-header">Documentos Adjuntos</h5>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                        foreach ($documentos_adjuntos as $documento) {
                            echo '<li class="list-group-item">' . $documento->getFileName() . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <br>
    <?php endif ?>

    <div class="card">
        <div class="card-body">

            <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                <h5>Cliente</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">RNC/Cédula</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('RNC_Cedula') ?></label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Nombre</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Nombre') ?></label>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Apellido</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Apellido') ?></label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Dirección</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Direcci_n') ?></label>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tel. Celular</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Telefono') ?></label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tel. Trabajo</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Tel_Trabajo') ?></label>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tel. Residencial</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Tel_Residencia') ?></label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Correo Electrónico</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Email') ?></label>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Fecha de Nacimiento</label>
                        <br>
                        <label><?= $cotizacion->getFieldValue('Fecha_de_Nacimiento') ?></label>
                    </div>
                </div>

                <br>
            <?php endif ?>

            <h5>Vehículo</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Marca</label>
                    <br>
                    <label><?= strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel()) ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Modelo</label>
                    <br>
                    <label><?= strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel()) ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Año de fabricación</label>
                    <br>
                    <label><?= $cotizacion->getFieldValue('A_o_de_Fabricacion') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Valor Asegurado</label>
                    <br>
                    <label><?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Chasis</label>
                    <br>
                    <label><?= $cotizacion->getFieldValue('Chasis') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Color</label>
                    <br>
                    <label><?= $cotizacion->getFieldValue('Color') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Uso</label>
                    <br>
                    <label><?= $cotizacion->getFieldValue('Uso') ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Placa</label>
                    <br>
                    <label><?= $cotizacion->getFieldValue('Placa') ?></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Estado</label>
                    <br>
                    <label><?= ($cotizacion->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tipo</label>
                    <br>
                    <label><?= $cotizacion->getFieldValue('Tipo_de_veh_culo') ?></label>
                </div>
            </div>

        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Aseguradora</th>
                            <th scope="col">Prima Neta</th>
                            <th scope="col">ISC</th>
                            <th scope="col">Prima Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalles as $resumen) : ?>
                            <tr>
                                <th scope="row">
                                    <?= $resumen->getFieldValue('Aseguradora')->getLookupLabel() ?>
                                </th>
                                <?php if ($resumen->getFieldValue('Grand_Total') == 0) : ?>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                    <td>N/A</td>
                                <?php else : ?>
                                    <?php $planes = $resumen->getLineItems() ?>
                                    <?php foreach ($planes as $plan) : ?>
                                        <td>RD$<?= number_format($plan->getTotalAfterDiscount(), 2) ?></td>
                                        <td>RD$<?= number_format($plan->getTaxAmount(), 2) ?></td>
                                        <td>RD$<?= number_format($plan->getNetTotal(), 2) ?></td>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="completar" style="display: none">
    <div class="card">
        <div class="card-body">

            <form method="POST" action="?url=auto/detalles/<?= $cotizacion->getEntityId() ?>">


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button type="button" class="btn btn-primary" onclick="mostrar_clientes()">Clientes</button>
                    </div>

                    <div class="form-group col-md-6">
                        <button type="button" class="btn btn-success" onclick="mostrar_cliente_nuevo()">Cliente Nuevo</button>
                    </div>
                </div>

                <br>

                <div id="clientes">
                    <h5>Mis Clientes</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Nombre</label>
                            <select name="mis_clientes" class="form-control" required>
                                <option selected value="">Ninguno</option>
                                <?php
                                foreach ($clientes as $cliente) {
                                    $nombre = $cliente->getFieldValue("First_Name") . " " . $cliente->getFieldValue("Last_Name");
                                    echo '<option value="' . $cliente->getEntityId() . '">' . strtoupper($nombre) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <br>
                </div>

                <div id="cliente_nuevo" style="display: none">
                    <h5>Cliente</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">RNC/Cédula</label>
                            <input type="text" class="form-control" name="RNC_Cedula" id="RNC_Cedula">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Nombre</label>
                            <input type="text" class="form-control" name="Nombre" id="Nombre">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Apellido</label>
                            <input type="text" class="form-control" name="Apellido" id="Apellido">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Dirección</label>
                            <input type="text" class="form-control" name="Direcci_n">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tel. Celular</label>
                            <input type="tel" class="form-control" name="Telefono">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tel. Trabajo</label>
                            <input type="tel" class="form-control" name="Tel_Residencia">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tel. Residencial</label>
                            <input type="tel" class="form-control" name="Tel_Trabajo">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Correo Electrónico</label>
                            <input type="email" class="form-control" name="Email" id="Email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="Fecha_de_Nacimiento" id="Fecha_de_Nacimiento">
                        </div>
                    </div>

                    <br>
                </div>

                <h5>Vehículo</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Chasis</label>
                        <input type="text" class="form-control" name="Chasis" required value="<?= $cotizacion->getFieldValue('Chasis') ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Color</label>
                        <input type="text" class="form-control" name="Color" required value="<?= $cotizacion->getFieldValue('Color') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Placa</label>
                        <input type="text" class="form-control" name="Placa" required value="<?= $cotizacion->getFieldValue('Placa') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button type="submit" name="Completar" class="btn btn-success">Completar</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<div id="emitir" style="display: none">
    <form enctype="multipart/form-data" method="POST" action="?url=auto/detalles/<?= $cotizacion->getEntityId() ?>">
        <div class="card">
            <div class="card-body">
                <?php if (!isset($_POST['submit']) and !in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>

                    <h5>Aseguradora</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Nombre</label>
                            <select name="aseguradora" class="form-control">
                                <?php
                                foreach ($detalles as $resumen) {
                                    if ($resumen->getFieldValue('Grand_Total') > 0) {
                                        echo '<option value="' . $resumen->getFieldValue('Aseguradora')->getEntityId() . '">' . $resumen->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Cotización Firmada</label>
                            <input type="file" class="form-control-file" id="cotizacion" name="cotizacion_firmada">
                        </div>
                    </div>

                <?php else : ?>

                    <h5>Adjuntar documentos a la cotización</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Expedientes</label>
                            <input type="file" class="form-control-file" id="expedientes" multiple name="documentos[]">
                        </div>
                    </div>

                <?php endif ?>

                <br>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button type="submit" name="emitir" class="btn btn-success">Aceptar</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    var detalles = document.getElementById("detalles");
    var completar = document.getElementById("completar");
    var emitir = document.getElementById("emitir");

    function mostrar_detalles() {
        if (detalles.style.display === "none") {

            detalles.style.display = "block";

            completar.style.display = "none";
            emitir.style.display = "none";
        }
    }

    function mostrar_completar() {
        if (completar.style.display === "none") {

            completar.style.display = "block";

            detalles.style.display = "none";
            emitir.style.display = "none";
        }
    }


    function mostrar_emitir() {
        if (emitir.style.display === "none") {

            emitir.style.display = "block";

            detalles.style.display = "none";
            completar.style.display = "none";
        }
    }
</script>

<script>
    var clientes = document.getElementById("clientes");
    var cliente_nuevo = document.getElementById("cliente_nuevo");

    function mostrar_clientes() {

        if (clientes.style.display === "none") {

            clientes.style.display = "block";
            cliente_nuevo.style.display = "none";

            clientes.required = true;
            document.getElementById("RNC_Cedula").required = false;
            document.getElementById("Nombre").required = false;
            document.getElementById("Apellido").required = false;
            document.getElementById("Email").required = false;
            document.getElementById("Fecha_de_Nacimiento").required = false;
        }

    }

    function mostrar_cliente_nuevo() {

        if (cliente_nuevo.style.display === "none") {

            cliente_nuevo.style.display = "block";
            clientes.style.display = "none";

            clientes.required = false;
            document.getElementById("RNC_Cedula").required = true;
            document.getElementById("Nombre").required = true;
            document.getElementById("Apellido").required = true;
            document.getElementById("Email").required = true;
            document.getElementById("Fecha_de_Nacimiento").required = true;
        }

    }
</script>