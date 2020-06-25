<?php if (!empty($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form class="row justify-content-center" method="POST" action="<?= constant("url") ?>auto/completar/<?= $resumen_id ?>">

    <div class="col-lg-10">

        <div class="card mb-4">
            <h5 class="card-header">Vehículo</h5>
            <div class="card-body">

                <div class="form-row">

                    <div class="col-md-6">
                        <label class="font-weight-bold">Chasis <small>(sin guiones,solo números y letras)</small></label>
                        <input type="text" class="form-control" name="chasis" value="<?= (isset($_POST["chasis"])) ? $_POST["chasis"] : $resumen->getFieldValue('Chasis'); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="font-weight-bold">Color</label>
                        <input type="text" class="form-control" name="color" value="<?= (isset($_POST["color"])) ? $_POST["color"] : $resumen->getFieldValue('Color'); ?>">
                    </div>

                </div>

                <br>


                <div class="form-row">

                    <div class="col-md-6">
                        <label class="font-weight-bold">Uso</label>
                        <select name="uso" class="form-control">
                            <option selected disabled value="<?= $resumen->getFieldValue('Uso') ?>"><?= (!empty($resumen->getFieldValue('Uso'))) ? $resumen->getFieldValue('Uso') : "Selecciona una opcion"; ?></option>
                            <option value="Privado">Privado</option>
                            <option value="Publico">Publico</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="font-weight-bold">Placa</label>
                        <input type="text" class="form-control" name="placa" value="<?= (isset($_POST["place"])) ? $_POST["place"] : $resumen->getFieldValue('Placa'); ?>">
                    </div>

                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">&nbsp;</label>
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="nuevo" <?= ($resumen->getFieldValue('Es_nuevo') == true) ? "checked" : ""; ?>>
                            ¿Es nuevo?
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Cliente</h5>
            <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Tipo</label>
                        <select name="tipo_cliente" class="form-control" onchange="tipo_clientes(this)">
                            <option value="" selected disabled>Selecciona un opcion</option>
                            <option value="nuevo">Nuevo</option>
                            <option value="existente">Existente</option>
                        </select>
                    </div>
                </div>

                <br>

                <div id="cliente_nuevo" style="display: none;">

                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">RNC/Cédula <small>(sin guiones)</small> </label>
                                <input type="text" class="form-control" name="rnc/cedula" maxlength="11" value="<?= (isset($_POST["rnc/cedula"])) ? $_POST["rnc/cedula"] : ""; ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="<?= (isset($_POST["nombre"])) ? $_POST["nombre"] : ""; ?>">
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Apellido</label>
                                <input type="text" class="form-control" name="apellido" value="<?= (isset($_POST["apellido"])) ? $_POST["apellido"] : ""; ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Dirección</label>
                                <input type="text" class="form-control" name="direccion" value="<?= (isset($_POST["direccion"])) ? $_POST["direccion"] : ""; ?>">
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="form-row">

                        <div class="col-md-6">
                            <label class="font-weight-bold">Tel. Celular</label>
                            <input type="tel" class="form-control" name="telefono" value="<?= (isset($_POST["telefono"])) ? $_POST["telefono"] : ""; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>

                        <div class="col-md-6">
                            <label class="font-weight-bold">Tel. Trabajo</label>
                            <input type="tel" class="form-control" name="tel_residencia" value="<?= (isset($_POST["tel_residencia"])) ? $_POST["tel_residencia"] : ""; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>

                    </div>

                    <br>


                    <div class="form-row">

                        <div class="col-md-6">
                            <label class="font-weight-bold">Tel. Residencial</label>
                            <input type="tel" class="form-control" name="tel_trabajo" value="<?= (isset($_POST["tel_trabajo"])) ? $_POST["tel_trabajo"] : ""; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>

                        <div class="col-md-6">
                            <label class="font-weight-bold">Correo Electrónico</label>
                            <input type="email" class="form-control" name="correo" value="<?= (isset($_POST["correo"])) ? $_POST["correo"] : ""; ?>">
                        </div>

                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?= (isset($_POST["fecha_nacimiento"])) ? $_POST["fecha_nacimiento"] : ""; ?>">
                        </div>
                    </div>

                </div>

                <div id="clientes" style="display: none;">

                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Clientes</label>
                                <select name="clientes" class="form-control">
                                    <option selected value="">Ninguno</option>
                                    <?php
                                    $pagina = 1;
                                    $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                    $clientes = array();
                                    do {
                                        $polizas =  $this->searchRecordsByCriteria("P_lizas", $criterio, $pagina, 200);
                                        if (!empty($polizas)) {
                                            $pagina++;
                                            sort($polizas);
                                            foreach ($polizas as $poliza) {
                                                $clientes[$poliza->getFieldValue('Propietario')->getEntityId()] = strtoupper($poliza->getFieldValue('Propietario')->getLookupLabel());
                                            }
                                        } else {
                                            $pagina = 0;
                                        }
                                    } while ($pagina > 0);
                                    $clientes =  array_unique($clientes);
                                    foreach ($clientes as $posicion => $valor) {
                                        echo '<option value="' . $posicion . '">' . $valor . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                    </div>

                </div>


            </div>


        </div>

        <div class="card mb-4">
            <h5 class="card-header">Opciones</h5>
            <div class="card-body">
                <button type="submit" class="btn btn-success">Completar</button>
            </div>
        </div>

    </div>

</form>

<script>
    function tipo_clientes(opcion) {
        if (opcion.value === "nuevo") {
            document.getElementById("cliente_nuevo").style.display = "block";
            document.getElementById("clientes").style.display = "none";
        } else if (opcion.value === "existente") {
            document.getElementById("cliente_nuevo").style.display = "none";
            document.getElementById("clientes").style.display = "block";
        }
    }
</script>