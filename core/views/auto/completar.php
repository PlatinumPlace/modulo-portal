<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= constant("url") ?>auto/completar/<?= $id ?>">

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
                        <input type="text" class="form-control" name="Direcci_n" id="Direcci_n">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">Tel. Celular</label>
                        <input type="tel" class="form-control" name="Telefono" id="Telefono">
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
                    <input type="text" class="form-control" name="Chasis" required value="<?= $resumen->getFieldValue('Chasis') ?>">
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Color</label>
                    <input type="text" class="form-control" name="Color" required value="<?= $resumen->getFieldValue('Color') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Placa</label>
                    <input type="text" class="form-control" name="Placa" required value="<?= $resumen->getFieldValue('Placa') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-success">Completar</button>
                </div>
            </div>

        </form>
    </div>
</div>

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
            document.getElementById("Telefono").required = false;
            document.getElementById("Direcci_n").required = false;
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
            document.getElementById("Telefono").required = true;
            document.getElementById("Direcci_n").required = true;
        }

    }
</script>