<h1 class="mt-4">Crear cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item active">Crear</li>
</ol>

<?php if (isset($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form class="row" method="POST" action="<?= constant("url") ?>cotizaciones/crear">

    <div class="col-xl-6">
        <div class="card mb-4">

            <div class="card-header">Cotización</div>

            <div class="card-body">

                <div class="form-group">
                    <label class="small mb-1">Tipo de cotización</label>
                    <select name="tipo_cotizacion" class="form-control" onchange="tipo_de_cotizacion(this)">
                        <option value="" selected disabled>Selecciona un tipo</option>
                        <option value="auto">Auto</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de póliza</label>
                            <select name="tipo_poliza" class="form-control">
                                <option selected value="Declarativa">Declarativa</option>
                                <option value="Individual">Individual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de plan</label>
                            <select name="tipo_plan" class="form-control">
                                <option value="Mensual Full" selected>Mensual Full</option>
                                <option value="Anual Full">Anual Full</option>
                                <option value="Ley">Ley</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <label class="small mb-1">Valor Asegurado</label>
                    <input class="form-control" type="number" name="valor" />
                </div>

            </div>
        </div>
    </div>

    <div class="col-xl-6">

        <div id="auto" style="display: none;">
            <div class="card mb-4">

                <div class="card-header">Vehículo</div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="small mb-1">Marca</label>
                        <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)">
                            <option value="" selected disabled>Selecciona una Marca</option>
                            <?php
                            foreach ($marcas as $marca) {
                                echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="small mb-1">Modelo</label>
                        <select class="form-control" name="modelo" id="modelo">
                            <option value="" selected disabled>Selecciona un Modelo</option>
                            <div id="modelo"></div>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="small mb-1">Año de fabricación</label>
                                <input class="form-control" type="number" name="fabricacion" maxlength="4" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="small mb-1">Uso</label>
                                <select name="uso" class="form-control">
                                    <option selected value="Privado">Privado</option>
                                    <option value="Publico">Publico</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="small mb-1">Color</label>
                                <input type="text" class="form-control" name="color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="small mb-1">Placa</label>
                                <input type="text" class="form-control" name="placa">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small mb-1">Chasis</label>
                        <input type="text" class="form-control" name="chasis">
                    </div>

                    <div class="form-group col-md-6">
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="nuevo">
                            <div class="font-weight-bold">¿Es nuevo?</div>
                        </div>
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
    </div>

</form>


<script>
    function tipo_de_cotizacion(tipo) {
        if (tipo.value === "auto") {
            document.getElementById("auto").style.display = "block";
        } else {
            document.getElementById("auto").style.display = "none";
        }
    }

    function obtener_modelos(val) {
        var url = "<?= constant("url") ?>";

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
</script>