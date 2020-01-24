<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4><?= $mensaje ?></h4>
    </div>
    <div class="modal-footer">
        <?php if (!empty($resultado)) : ?>
            <a href="?pagina=ver_cotizacion&id=<?= $resultado["id"] ?>" class="modal-close waves-effect waves-green btn-flat">Ver detalles de la cotización</a>
        <?php endif ?>
    </div>
</div>
<div class="row">
    <form class="col s12" method="post" action="?pagina=crear_cotizacion">
        <div class="col s12 center">
            <h5>Cliente</h5>
        </div>
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="Nombre" type="text" class="validate" name="Nombre_del_asegurado" required>
                                <label for="Nombre">Nombre</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="Apellido" type="tel" class="validate" name="Apellido_del_asegurado">
                                <label for="Apellido">Apellido</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="RNC/Cédula" type="text" class="validate" name="RNC_Cedula_del_asegurado" required>
                                <label for="RNC/Cédula">RNC/Cédula</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <i class="material-icons prefix">phone</i>
                                <input id="Teléfono" type="tel" class="validate" name="Telefono_del_asegurado">
                                <label for="Teléfono">Teléfono</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <input id="Correo" type="email" class="validate" name="Email_del_asegurado">
                                <label for="Correo">Correo</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">home</i>
                                <input id="Dirección" type="text" class="validate" name="Direcci_n_del_asegurado">
                                <label for="Dirección">Dirección</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 center">
            <h5>Seguro</h5>
        </div>
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <select name="Plan">
                                    <option selected value="Mensual Full">Mensual Full</option>
                                    <option value="Anual Full">Anual Full</option>
                                    <option value="Mensual Ley">Mensual Ley</option>
                                    <option value="Anual Ley">Anual Ley</option>
                                </select>
                                <label>Tipo de plan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <select name="Tipo_de_poliza">
                                    <option selected value="Declarativa">Declarativa</option>
                                    <option value="Individual">Individual</option>
                                </select>
                                <label>Tipo de póliza</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 center">
            <h5>Vehículo</h5>
        </div>
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <select class="browser-default" name="Marca" id="Marca" onchange="modelos(this.value)">
                                    <option selected>Selecciona una marca</option>
                                    <?php if (!empty($marcas)) : ?>
                                        <?php foreach ($marcas as $marca) : ?>
                                            <option value="<?= $marca->getEntityId() ?>"><?= $marca->getFieldValue('Name') ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                            <div class="input-field">
                                <input id="Tipo_de_vehiculo" type="text" class="validate" name="Tipo_de_vehiculo" required>
                                <label for="Tipo_de_vehiculo">Tipo</label>
                            </div>
                            <div class="input-field">
                                <input id="Chasis" type="text" class="validate" name="Chasis" required>
                                <label for="Chasis">Chasis</label>
                            </div>
                            <div class="input-field">
                                <input id="Valor_Asegurado" type="number" class="validate" name="Valor_Asegurado" required>
                                <label for="Valor_Asegurado">Valor Asegurado</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <select class="browser-default" name="Modelo" id="Modelo">
                                    <option selected>Selecciona un modelo</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <input id="Placa" type="text" class="validate" name="Placa">
                                <label for="Placa">Placa</label>
                            </div>
                            <div class="input-field">
                                <input id="Color" type="text" class="validate" name="Color">
                                <label for="Color">Color</label>
                            </div>
                            <div class="input-field">
                                <select name="A_o_de_Fabricacion">
                                    <?php
                                    $fecha_actual = date("d-m-Y");
                                    for ($i = 0; $i < 60; $i++) {
                                        $valor = date("Y", strtotime($fecha_actual . "- " . $i . " year"));
                                        echo '<option value="' . $valor . '">' . $valor . '</option>';
                                    }
                                    ?>
                                </select>
                                <label>Año de Fabricación</label>
                            </div>
                            <div class="input-field">
                                <label>
                                    <input type="checkbox" name="Es_nuevo" checked="checked" value="0" />
                                    <span>Es nuevo?</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <button class="btn waves-effect waves-light" type="submit" name="submit">Cotizar
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>
</div>
<script>
    function modelos(marca_id) {
        options = '';
        options += '<option>' + marca_id + '</option>';
        document.getElementById("Modelo").innerHTML = options;
    }
</script>