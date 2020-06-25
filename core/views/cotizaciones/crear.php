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

<form class="row justify-content-center" method="POST" action="<?= constant("url") ?>cotizaciones/crear">

    <div class="col-lg-10">

        <div class="card mb-4">
            <h5 class="card-header">Cotización</h5>
            <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Tipo de cotización</label>
                            <select name="tipo_cotizacion" class="form-control" onchange="tipo_de_cotizacion(this)">
                                <option value="" selected disabled>Selecciona un tipo</option>
                                <option value="auto">Auto</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Tipo de póliza</label>
                            <select name="tipo_poliza" class="form-control">
                                <option selected value="Declarativa">Declarativa</option>
                                <option value="Individual">Individual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Tipo de plan</label>
                            <select name="tipo_plan" class="form-control">
                                <option value="Mensual Full" selected>Mensual Full</option>
                                <option value="Anual Full">Anual Full</option>
                                <option value="Ley">Ley</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="font-weight-bold">Valor Asegurado</label>
                            <input class="form-control" type="number" name="valor" value="<?= (isset($_POST["valor"])) ? $_POST["valor"] : null ?>" />
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="auto" style="display: none;">
            <div class="card mb-4">
                <h5 class="card-header">Vehículo</h5>
                <div class="card-body">

                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Marca</label>
                                <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)">
                                    <option value="" selected disabled>Selecciona una Marca</option>
                                    <?php
                                    $pagina = 1;
                                    do {
                                        $marcas =  $this->getRecords("Marcas", $pagina, 200);
                                        if (!empty($marcas)) {
                                            $pagina++;
                                            sort($marcas);
                                            foreach ($marcas as $marca) {
                                                echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                                            }
                                        } else {
                                            $pagina = 0;
                                        }
                                    } while ($pagina > 0);
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Modelo</label>
                                <select class="form-control" name="modelo" id="modelo">
                                    <option value="" selected disabled>Selecciona un Modelo</option>
                                    <div id="modelo"></div>
                                </select>
                            </div>
                        </div>

                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <label class="font-weight-bold">Año de fabricación</label>
                                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" class="form-control" name="fabricacion" value="<?= (isset($_POST["fabricacion"])) ? $_POST["fabricacion"] : null ?>" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Opciones</h5>
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