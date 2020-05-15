<form method="POST" action="<?= constant('url') ?>cotizaciones/crear_auto">

    <div class="card">
        <h5 class="card-header">Tipo de Cotización</h5>

        <div class="card-body">

            <div class="form-group row">

                <label class="col-sm-2 col-form-label">Póliza</label>
                <div class="col-sm-4">
                    <select name="Tipo_de_poliza" class="form-control">
                        <option selected value="Declarativa">Declarativa</option>
                        <option value="Individual">Individual</option>
                    </select>
                </div>

                <label class="col-sm-2 col-form-label">Plan</label>
                <div class="col-sm-4">
                    <select name="Plan" class="form-control">
                        <option value="Mensual Full" selected>Mensual Full</option>
                        <option value="Anual Full">Anual Full</option>
                        <option value="Ley">Ley</option>
                    </select>
                </div>

            </div>
        </div>

    </div>

    <br>

    <div class="card">
        <h5 class="card-header">Datos de Vehículo</h5>

        <div class="card-body">

            <div class="form-group row">

                <label class="col-sm-2 col-form-label">Marca</label>
                <div class="col-sm-4">
                    <select class="form-control" name="Marca" id="marca" onchange="obtener_modelos(this)" required>
                        <option value="" selected disabled>Selecciona una Marca</option>
                        <?php
                        foreach ($marcas as $marca) {
                            echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <label class="col-sm-2 col-form-label">Modelo</label>
                <div class="col-sm-4">
                    <select class="form-control" name="Modelo" id="modelo" required>
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
                    <input type="text" class="form-control" name="Chasis">
                </div>

                <label class="col-sm-2 col-form-label">Color</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Color">
                </div>

            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label">Uso</label>
                <div class="col-sm-4">
                    <select name="Uso" class="form-control">
                        <option selected value="Privado">Privado</option>
                        <option value="Publico">Publico</option>
                    </select>
                </div>

                <label class="col-sm-2 col-form-label">Placa</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Placa">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-sm-2">¿Es nuevo?</div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="Es_nuevo">
                    </div>
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
                    <button type="submit" name="submit" class="btn btn-success">Cotizar</button>
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
</script>