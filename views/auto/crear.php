<form method="POST" action="<?= constant('url') ?>auto/crear">
    <div class="row">

        <div class="col-lg-9">
            <div class="card my-9">
                <div class="card-header">
                    <h5>Tipo de Cotización</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Póliza</label>
                        <div class="col-sm-4">
                            <select name="poliza" class="form-control">
                                <option selected value="Declarativa">Declarativa</option>
                                <option value="Individual">Individual</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">Para</label>
                        <div class="col-sm-4">
                            <select name="tipo" class="form-control">
                                <option value="Auto" selected>Auto</option>
                                <option value="Vida">Vida</option>
                                <option value="Incendio Hipotecario">Incendio Hipotecario</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Plan</label>
                        <div class="col-sm-4">
                            <select name="plan" class="form-control">
                                <option value="Mensual Full" selected>Mensual Full</option>
                                <option value="Anual Full">Anual Full</option>
                                <option value="Ley">Ley</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card my-8">
                <div class="card-header">
                    <h5>Datos de Vehículo</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Marca</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)" required>
                                <option value="" selected disabled>Selecciona una Marca</option>
                                <?php
                                $marcas = $this->getRecords("Marcas");
                                sort($marcas);
                                foreach ($marcas as $marca) {
                                    echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">Modelo</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="modelo" id="modelo" required>
                                <option value="" selected disabled>Selecciona un Modelo</option>
                                <div id="modelo"></div>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Valor Asegurado</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="Valor_Asegurado" required>
                        </div>
                        <label class="col-sm-2 col-form-label">Año de fabricación</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="A_o_de_Fabricacion" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Chasis</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="chasis">
                        </div>
                        <label class="col-sm-2 col-form-label">Color</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="color">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Uso</label>
                        <div class="col-sm-4">
                            <select name="uso" class="form-control">
                                <option selected value="Privado">Privado</option>
                                <option value="Publico">Publico</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">Placa</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="placa">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">¿Es nuevo?</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="estado">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="col my-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Opciones</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row justify-content-md-center">
                            <button type="submit" name="submit" class="btn btn-success">Cotizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
<input value="<?= constant('url') ?>" id="url" hidden>
<script>
    function obtener_modelos(val) {
        var url = document.getElementById("url").value; {
            $.ajax({
                url: url + "libs/obtener_modelos.php",
                type: "POST",
                data: {
                    marcas_id: val.value
                },
                success: function(response) {
                    document.getElementById("modelo").innerHTML = response;
                }
            });
        }
    }
</script>';