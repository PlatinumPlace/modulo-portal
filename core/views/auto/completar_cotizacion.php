<form method="POST" action="<?= constant('url') ?>auto/completar_cotizacion/<?= $cotizacion->getEntityId() ?>">

    <?php if (!empty($alerta)) : ?>
        <div class="alert alert-primary" role="alert">
            <?= $alerta ?>
        </div>
    <?php endif ?>


    <ul class="nav border">
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="mis_clientes()">Clientes Existentes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="cliente_nuevo()">Cliente Nuevo</a>
        </li>
    </ul>

    <br>

    <div id="mis_clientes" style="display: none">

        <div class="card">
            <h5 class="card-header">Mis Clientes</h5>
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <select name="mis_clientes" class="form-control">
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

            </div>
        </div>

        <br>

    </div>

    <div id="cliente_nuevo" style="display: none">

        <div class="card">
            <h5 class="card-header">Cliente</h5>
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">RNC/Cédula</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="RNC_Cedula" id="RNC_Cedula">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="Nombre" id="Nombre">
                    </div>

                    <label class="col-sm-2 col-form-label">Apellido</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="Apellido" id="Apellido">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Direcci_n">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Celular</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="Telefono">
                    </div>

                    <label class="col-sm-2 col-form-label">Tel. Trabajo</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="Tel_Residencia">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Residencial</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="Tel_Trabajo">
                    </div>

                    <label class="col-sm-2 col-form-label">Correo Electrónico</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="Email" id="Email">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="Fecha_de_Nacimiento" id="Fecha_de_Nacimiento">
                    </div>
                </div>

            </div>
        </div>

        <br>

    </div>

    <div class="card">
        <h5 class="card-header">Vehículo</h5>
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Chasis</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Chasis" required value="<?= $cotizacion->getFieldValue('Chasis') ?>">
                </div>

                <label class="col-sm-2 col-form-label">Color</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Color" required value="<?= $cotizacion->getFieldValue('Color') ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Placa</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Placa" required value="<?= $cotizacion->getFieldValue('Placa') ?>">
                </div>
            </div>

        </div>
    </div>

    <br>
    <div class="row">

        <div class="col-md-8">
            &nbsp;
        </div>

        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Opciones</h5>
                <div class="card-body">
                    <button type="submit" name="submit" class="btn btn-success">Completar</button>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    var x = document.getElementById("mis_clientes");
    var y = document.getElementById("cliente_nuevo");

    function mis_clientes() {

        if (x.style.display === "none") {

            x.style.display = "block";
            y.style.display = "none";

            document.getElementById("mis_clientes").required = true;
            document.getElementById("RNC_Cedula").required = false;
            document.getElementById("Nombre").required = false;
            document.getElementById("Apellido").required = false;
            document.getElementById("Email").required = false;
            document.getElementById("Fecha_de_Nacimiento").required = false;
        }

    }

    function cliente_nuevo() {

        if (y.style.display === "none") {

            y.style.display = "block";
            x.style.display = "none";

            document.getElementById("mis_clientes").required = false;
            document.getElementById("RNC_Cedula").required = true;
            document.getElementById("Nombre").required = true;
            document.getElementById("Apellido").required = true;
            document.getElementById("Email").required = true;
            document.getElementById("Fecha_de_Nacimiento").required = true;
        }

    }
</script>