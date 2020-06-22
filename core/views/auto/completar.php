<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form class="row" method="POST" action="<?= constant("url") ?>auto/completar/<?= $resumen_id ?>">

    <div class="col-xl-6">
        <div class="card mb-4">

            <div class="card-header">Vehículo</div>

            <div class="card-body">

                <div class="form-group">
                    <label class="small mb-1">Clientes</label>
                    <select name="cliente" class="form-control" onchange="mostrar_clientes(this)">
                        <option value="" selected disabled>Selecciona un opcion</option>
                        <option value="nuevo">Nuevo</option>
                        <option value="existente">Mis clientes</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Color</label>
                            <input type="text" class="form-control" name="color" value="<?= (isset($_POST["color"])) ? $_POST["color"] : $resumen->getFieldValue('Color'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Placa</label>
                            <input type="text" class="form-control" name="placa" value="<?= (isset($_POST["place"])) ? $_POST["place"] : $resumen->getFieldValue('Placa'); ?>">
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <label class="small mb-1">Chasis</label>
                    <input type="text" class="form-control" name="chasis" value="<?= (isset($_POST["chasis"])) ? $_POST["chasis"] : $resumen->getFieldValue('Chasis'); ?>">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="small mb-1">Uso</label>
                        <select name="uso" class="form-control">
                            <option selected disabled value="<?= $resumen->getFieldValue('Uso') ?>"><?= (isset($_POST["Uso"])) ? $_POST["Uso"] : $resumen->getFieldValue('Uso'); ?></option>
                            <option value="Privado">Privado</option>
                            <option value="Publico">Publico</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="small mb-1">&nbsp;</label>
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="nuevo" <?= ($resumen->getFieldValue('Es_nuevo') == true) ? "checked" : ""; ?> >
                            ¿Es nuevo?
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-xl-6">

        <div id="cliente_nuevo" style="display: none;">
            <div class="card mb-4">

                <div class="card-header">Cliente Nuevo</div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Nombre</label>
                            <input type="text" class="form-control" name="Nombre" value="<?= (isset($_POST["Nombre"])) ? $_POST["Nombre"] : ""; ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Apellido</label>
                            <input type="text" class="form-control" name="apellido" value="<?= (isset($_POST["apellido"])) ? $_POST["apellido"] : ""; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Dirección</label>
                        <input type="text" class="form-control" name="direccion" value="<?= (isset($_POST["direccion"])) ? $_POST["direccion"] : ""; ?>">
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">RNC/Cédula <small>(sin guiones)</small> </label>
                            <input type="text" class="form-control" name="rnc/cedula" maxlength="11" value="<?= (isset($_POST["rnc/cedula"])) ? $_POST["rnc/cedula"] : ""; ?>">
                        </div>

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Correo Electrónico</label>
                                <input type="email" class="form-control" name="correo" value="<?= (isset($_POST["correo"])) ? $_POST["correo"] : ""; ?>">
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tel. Celular</label>
                            <input type="tel" class="form-control" name="telefono" value="<?= (isset($_POST["telefono"])) ? $_POST["telefono"] : ""; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tel. Trabajo</label>
                            <input type="tel" class="form-control" name="tel_residencia" value="<?= (isset($_POST["tel_residencia"])) ? $_POST["tel_residencia"] : ""; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tel. Residencial</label>
                            <input type="tel" class="form-control" name="tel_trabajo" value="<?= (isset($_POST["tel_trabajo"])) ? $_POST["tel_trabajo"] : ""; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?= (isset($_POST["fecha_nacimiento"])) ? $_POST["fecha_nacimiento"] : ""; ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="clientes" style="display: none;">
            <div class="card mb-4">

                <div class="card-header">Clientes</div>

                <div class="card-body">

                    <div class="form-group">
                        <select name="mis_clientes" class="form-control">
                            <option selected value="">Ninguno</option>
                            <?php
                            do {
                                $clientes =  $this->searchRecordsByCriteria("Clientes", $criterio, $pagina, 200);
                                if (!empty($clientes)) {
                                    $pagina++;
                                    sort($clientes);
                                    foreach ($clientes as $cliente) {
                                        $nombre = $cliente->getFieldValue("Name") . " " . $cliente->getFieldValue("Apellidos");
                                        echo '<option value="' . $cliente->getEntityId() . '">' . strtoupper($nombre) . '</option>';
                                    }
                                } else {
                                    $pagina = 0;
                                }
                            } while ($pagina > 0);
                            ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-4">

            <div class="card-header">Opciones</div>

            <div class="card-body">
                <button type="submit" class="btn btn-success">Cotizar</button>
            </div>
        </div>

</form>

<script>
    function mostrar_clientes(opcion) {
        if (opcion.value === "nuevo") {
            document.getElementById("cliente_nuevo").style.display = "block";
            document.getElementById("clientes").style.display = "none";
        } else if (opcion.value === "existente") {
            document.getElementById("cliente_nuevo").style.display = "none";
            document.getElementById("clientes").style.display = "block";
        }
    }
</script>