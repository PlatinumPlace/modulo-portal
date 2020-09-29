<?php
if ($_POST) {
    $trato["Stage"] = "Cotizando";
    $trato["Fecha"] = date("Y-m-d");
    $trato["Nombre"] = $_POST["nombre"];
    $trato["Contact_Name"] = $_SESSION["usuario"]['id'];
    $trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $trato["Deal_Name"] = "Cotización";
    $trato["Suma_asegurada"] = $_POST["suma"];
    $trato["Edad_deudor"] = $_POST["edad_deudor"];
    $trato["Edad_codeudor"] = $_POST["edad_codeudor"];
    $trato["Plazo"] = $_POST["plazo"];
    $trato["Cuota"] = (!empty($_POST["cuota"])) ? $_POST["cuota"] : 0;
    $trato["Plan"] = $_POST["tipo_plan"];
    $trato["Type"] = "Vida";
    $trato_id = crear("Deals", $trato);

    $criteria = "((Corredor:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:" . $_POST["tipo_plan"] . "))";
    $contratos = listaPorCriterio("Contratos", $criteria);
    foreach ($contratos as $contrato) {
        $prima = 0;

        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = listaPorCriterio("Products", $criterio);
        foreach ($planes as $plan) {
            $plan_id = $plan->getEntityId();
        }

        if (
            $_POST["suma"] < $contrato->getFieldValue('Suma_Asegurada_Max')
            and
            $_POST["edad_deudor"] < $contrato->getFieldValue('Edad_Max')
            and
            $_POST["Plazo"] < $contrato->getFieldValue('Plazo_Max')
            and
            $_POST["edad_deudor"] > $contrato->getFieldValue('Edad_Min')
        ) {
            $criterio = "Contrato:equals:" . $contrato->getEntityId();
            $tasas = listaPorCriterio("Tasas", $criterio);
            foreach ($tasas as $tasa) {
                switch ($tasa->getFieldValue('Tipo')) {
                    case 'Deudor':
                        $tasa_deudor = $tasa->getFieldValue('Valor') / 100;
                        break;

                    case 'Codeudor':
                        if (
                            !empty($_POST["edad_codeudor"])
                            and
                            $_POST["edad_codeudor"] < $contrato->getFieldValue('Edad_Max')
                            and
                            $_POST["edad_codeudor"] > $contrato->getFieldValue('Edad_Min')
                        ) {
                            $tasa_codeudor = $tasa->getFieldValue('Valor') / 100;
                        }
                        break;

                    case 'Vida':
                        $tasa_vida = $tasa->getFieldValue('Valor') / 100;
                        break;

                    case 'Desempleo':
                        $tasa_desempleo = $tasa->getFieldValue('Valor');
                        break;
                }
            }

            switch ($_POST["tipo_plan"]) {
                case 'Vida':
                    $prima = ($_POST["suma"] / 1000) * $tasa_deudor;

                    if (!empty($_POST["edad_codeudor"])) {
                        $prima += ($_POST["suma"] / 1000) * ($tasa_codeudor - $tasa_deudor);
                    }
                    break;

                case 'Vida/Desempleo':
                    $prima = ($_POST["suma"] / 1000) * $tasa_vida;
                    $prima += ($_POST["cuota"] / 1000) * $tasa_desempleo;
                    break;
            }
        }

        $cotizacion["Subject"] = "Plan " . $_POST["tipo_plan"];
        $cotizacion["Contrato"] = $contrato->getEntityId();
        $cotizacion["Aseguradora"] = $contrato->getFieldValue('Aseguradora')->getEntityId();
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Deal_Name"] = $trato_id;
        $cotizacion["Quote_Stage"] = "Negociación";
        crear("Quotes", $cotizacion, $plan_id, $prima);
    }

    header("Location:" . constant("url") . "cotizaciones/detalles?tipo=vida&id=$trato_id");
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización vida</h1>
</div>

<form method="POST" class="row" action="<?= constant("url") ?>cotizaciones/crear?tipo=vida">

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
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurado</label>
            <div class="col-sm-8">
                <input type="number" class="form-control" name="suma" required="">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plan</label>

            <div class="col-sm-8">
                <select name="tipo_plan" class="form-control">
                    <option value="Vida" selected>Vida</option>
                    <option value="Vida/Desempleo">Vida/Desempleo</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Edad del codeudor</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="edad_codeudor" maxlength="2">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plazo en meses</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="plazo" required>
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
        <a href="<?= constant("url") ?>cotizaciones/crear?tipo=vida" class="btn btn-info">Limpiar</a>

    </div>

</form>