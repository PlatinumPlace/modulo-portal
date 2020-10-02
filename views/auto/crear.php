<?php
$auto = new auto;

if ($_POST) {
    $marca = $auto->getRecord("Marcas", $_POST["marca"]);
    $modelo = $auto->getRecord("Modelos", $_POST["modelo"]);
    $trato_id = $auto->crearTrato($marca, $modelo);

    $criterio = "((Corredor:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
    $contratos = $auto->searchRecordsByCriteria("Contratos", $criterio);
    foreach ($contratos as $contrato) {
        $plan = $auto->selecionarPlan($contrato);

        if (strpos($_POST["plan"], "ley") === true) {
            $prima = $plan->getFieldValue('Unit_Price');
        } else {
            $prima = $auto->calcularPrima($contrato, $marca, $modelo);
        }

        $auto->crearCotizacion($contrato, $trato_id, $plan->getEntityId(), $prima);
    }

    header("Location:?pagina=detallesAuto_1&id=$trato_id");
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización</h1>
</div>


<form method="POST" class="row" action="?pagina=crearAuto">

    <div class="mx-auto col-10" style="width: 200px;">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre del cliente</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="nombre" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurada</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="suma" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plan</label>

            <div class="col-sm-8">
                <select name="plan" class="form-control">
                    <option value="mensual full" selected>Mensual Full</option>
                    <option value="mensual ley">Mensual Ley</option>
                </select>
            </div>
        </div>

        <br>
        <h5>Vehí­culo</h5>
        <hr>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Marca</label>

            <div class="col-sm-8">
                <select class="form-control" id="marca" name="marca" onchange="obtener_modelos(this)" required>
                    <option value="" selected disabled>Selecciona una Marca</option>
                    <?php
                    $marcas = $auto->getRecords("Marcas");
                    sort($marcas);
                    foreach ($marcas as $marca) {
                        echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Modelo</label>

            <div class="col-sm-8">
                <select class="form-control" id="modelo" name="modelo" required>
                    <option value="" selected disabled>Selecciona un Modelo</option>
                    <div id="modelo"></div>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Año</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="fabricacion" maxlength="4" required>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success">Crear</button>
        |
        <a href="?pagina=crearAuto" class="btn btn-info">Limpiar</a>

    </div>

</form>

<script>
    function obtener_modelos(val) {
        var url = "helpers/modelos.php";

        $.ajax({
            url: url,
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