<?php
$cotizaciones = new cotizacion();
$marcas = $cotizaciones->listaMarcas();

if ($_POST) {
    $cotizaciones = new cotizacion();
    $contratos = $cotizaciones->listaContratos("Auto");
    $marca = $cotizaciones->detallesMarca();
    $modelo = $cotizaciones->detallesModelo();

    foreach ($contratos as $contrato) {
        $plan = $cotizaciones->seleccionarPlan($contrato);

        if ($_POST["tipo_plan"] == "Plan Ley") {
            $prima = $plan->getFieldValue('Unit_Price');
        } else {
            $prima = $cotizaciones->calcularPrimaAuto($contrato, $marca, $modelo);
        }

        if ($_POST["facturacion"] == "Mensual") {
            $prima = $prima / 12;
        }

        $planes[] = array(
            "id" => $plan->getEntityId(),
            "prima" => $prima,
            "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel()
        );
    }

    $id = $cotizaciones->crearAuto($modelo, $planes);
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización auto</h1>
</div>

<form method="POST" action="<?= constant("url") ?>cotizaciones/crearAuto">

    <div class="row">

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Nombre del cliente</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nombre" required="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula del cliente</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="rnc_cedula">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Valor Asegurado</label>

                <div class="col-sm-8">
                    <input type="number" class="form-control" name="valor" required="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tipo de plan</label>

                <div class="col-sm-8">
                    <select name="tipo_plan" class="form-control">
                        <option value="Plan Full" selected>Full</option>
                        <option value="Plan Ley">Ley</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Facturación</label>

                <div class="col-sm-8">
                    <select name="facturacion" class="form-control">
                        <option value="Mensual" selected>Mensual</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Marca del vehículo</label>

                <div class="col-sm-8">
                    <select class="form-control" id="marca" name="marca" onchange="obtener_modelos(this)" required="">
                        <option value="" selected disabled>Selecciona una Marca</option>
                        <?php
                        sort($marcas);
                        foreach ($marcas as $marca) {
                            echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Modelo del vehículo</label>

                <div class="col-sm-8">
                    <select class="form-control" id="modelo" name="modelo" required="">
                        <option value="" selected disabled>Selecciona un Modelo</option>
                        <div id="modelo"></div>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Año de fabricación del vehículo</label>

                <div class="col-sm-8">
                    <input type="number" class="form-control" name="fabricacion" maxlength="4" required="">
                </div>
            </div>

        </div>

    </div>

    <br>
    <button type="submit" class="btn btn-success">Crear</button>
    |
    <a href="<?= constant("url") ?>cotizaciones/crearAuto" class="btn btn-info">Limpiar</a>

</form>

<script>
    function obtener_modelos(val) {
        var url = "<?= constant("url") ?>";
        $.ajax({
            url: url + "helpers/lista_modelos.php",
            type: "POST",
            data: {
                marcas_id: val.value
            },
            success: function (response) {
                document.getElementById("modelo").innerHTML = response;
            }
        });
    }
</script>

<?php if (!empty($id)): ?>
    <script>
        var url = "<?= constant("url") ?>";
        var id = "<?= $id ?>";
        window.location = url + "cotizaciones/detallesAuto?id=" + id + "&alert=Cotización creada exitosamente";
    </script>
<?php endif; ?>
