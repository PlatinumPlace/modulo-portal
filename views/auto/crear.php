<h1 class="mt-4 text-uppercase">crear cotización auto</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>cotizaciones/crear">Crear</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>auto/crear">Auto</a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>auto/crear">

                    <h4>Vehículo</h4>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Marca</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)" required>
                                <option value="" selected disabled>Selecciona una Marca</option>
                                <?php
                                $num_pagina = 1;
                                do {
                                    $marcas = $api->lista_registros("Marcas", $num_pagina, 200);
                                    if (!empty($marcas)) {
                                        $num_pagina++;
                                        sort($marcas);
                                        foreach ($marcas as $marca) {
                                            echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                                        }
                                    } else {
                                        $num_pagina = 0;
                                    }
                                } while ($num_pagina > 0);
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Modelo</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="modelo" id="modelo" required>
                                <option value="" selected disabled>Selecciona un Modelo</option>
                                <div id="modelo"></div>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Uso</label>
                        <div class="col-sm-9">
                            <select name="uso" class="form-control">
                                <option value="privado" selected>Privado</option>
                                <option value="publico">Publico</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Año de fabricación</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" name="fabricacion" maxlength="4">
                        </div>
                    </div>

                    <br>
                    <h4>Plan</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tipo de plan</label>
                        <div class="col-sm-9">
                            <select name="tipo_plan" class="form-control">
                                <option value="full" selected>Full</option>
                                <option value="ley">Ley</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Facturación</label>
                        <div class="col-sm-9">
                            <select name="facturacion" class="form-control">
                                <option value="mensual" selected>Mensual</option>
                                <option value="anual">Anual</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Valor Asegurado</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" name="valor">
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Crear</button>
                    |
                    <a href="<?= constant("url") ?>cotizaciones/crear" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtener_modelos(val) {
        var url = "<?= constant("url") ?>";
        $.ajax({
            url: url + "helpers/lista_modelos.php",
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