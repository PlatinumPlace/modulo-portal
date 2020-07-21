<h1 class="mt-4 text-uppercase">crear cotización para auto</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>cotizaciones/crear_auto">Crear Auto</a></li>
</ol>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>cotizaciones/crear_auto">
                    <div class="form-group row">
                        <label for="marca" class="col-sm-3 col-form-label">Marca</label>
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
                        <label for="modelo" class="col-sm-3 col-form-label">Modelo</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="modelo" id="modelo" required>
                                <option value="" selected disabled>Selecciona un Modelo</option>
                                <div id="modelo"></div>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="uso" class="col-sm-3 col-form-label">Uso</label>
                        <div class="col-sm-9">
                            <select name="uso" id="uso" class="form-control">
                                <option value="Privado" selected>Privado</option>
                                <option value="Publico">Publico</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">¿Es nuevo?</div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="estado">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fabricacion" class="col-sm-3 col-form-label">Año de fabricación</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" id="fabricacion" name="fabricacion" maxlength="4">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tipo_poliza" class="col-sm-3 col-form-label">Tipo de póliza</label>
                        <div class="col-sm-9">
                            <select name="tipo_poliza" id="tipo_poliza" class="form-control">
                                <option selected value="Declarativa">Declarativa</option>
                                <option value="Individual">Individual</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipo_plan" class="col-sm-3 col-form-label">Tipo de plan</label>
                        <div class="col-sm-9">
                            <select name="tipo_plan" id="tipo_plan" class="form-control">
                                <option value="Mensual Full" selected>Mensual Full</option>
                                <option value="Anual Full">Anual Full</option>
                                <option value="Ley">Ley</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="valor" class="col-sm-3 col-form-label">Valor Asegurado</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" id="valor" name="valor">
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Crear</button>
                    
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