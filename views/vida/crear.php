<?php
$vida = new vida;

if (empty($_POST["desempleo"])) {
    $plan_nombre = "Vida";
} else {
    $plan_nombre = "Vida/Desempleo";
}

$trato_id = $vida->crearTrato($plan_nombre);

$criteria = "((Corredor:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:$plan_nombre))";
$contratos = $vida->searchRecordsByCriteria("Contratos", $criteria);
foreach ($contratos as $contrato) {
    $plan_id = $vida->selecionarPlan($contrato);
    $prima = $vida->calcularPrima($contrato);
    $vida->crearCotizacion($plan_nombre, $contrato, $trato_id, $plan_id, $prima);
}

header("Location:?pagina=detallesVida&id=$trato_id");
exit();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización</h1>
</div>

<form method="POST" class="row" action="?pagina=crearVida">

    <div class="mx-auto col-10" style="width: 200px;">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre del deudor</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="nombre" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Edad del deudor</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="edad_deudor" maxlength="2" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Edad del codeudor</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="edad_codeudor" maxlength="2">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurado</label>
            <div class="col-sm-8">
                <input type="number" class="form-control" name="suma" required="">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plazo en meses</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="plazo" required>
            </div>
        </div>

        <br>
        <h5>Desempleo</h5>
        <hr>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">¿Incluir desempleo?</label>

            <div class="col-sm-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck" name="desempleo">
                    <label class="form-check-label" for="gridCheck"> Si </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Cuota Mensual</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="cuota">
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success">Crear</button>
        |
        <a href="?pagina=crearVida" class="btn btn-info">Limpiar</a>

    </div>

</form>

<br><br>