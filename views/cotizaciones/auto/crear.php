<?php
if ($_POST) {
    $marca = detalles("Marcas", $_POST["marca"]);
    $modelo = detalles("Modelos", $_POST["modelo"]);

    $trato["Stage"] = "Cotizando";
    $trato["Fecha"] = date("Y-m-d");
    $trato["Marca"] = $marca->getFieldValue("Name");
    $trato["Modelo"] = $modelo->getFieldValue("Name");
    $trato["A_o_veh_culo"] = $_POST["fabricacion"];
    $trato["Nombre"] = $_POST["nombre"];
    $trato["Contact_Name"] = $_SESSION["usuario"]['id'];
    $trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $trato["Deal_Name"] = "Cotización";
    $trato["Suma_asegurada"] = $_POST["suma"];
    $trato["Plan"] = ucfirst($_POST["facturacion"]) . " " . $_POST["plan"];
    $trato["Type"] = "Auto";
    $trato["Tipo_veh_culo"] = $modelo->getFieldValue("Tipo");
    $trato_id = crear("Deals", $trato);

    $criterio = "((Corredor:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
    $contratos = listaPorCriterio("Contratos", $criterio);
    foreach ($contratos as $contrato) {
        $prima = 0;

        $criterio = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = listaPorCriterio("Products", $criterio);
        foreach ($planes as $plan) {
            $plan_id = $plan->getEntityId();
            if ($_POST["plan"] == "ley") {
                $prima = $plan->getFieldValue('Unit_Price');
            }
        }

        if (
            empty($prima)
            and
            !in_array(
                $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                $marca->getFieldValue('Restringido_en')
            )
            and
            !in_array(
                $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                $modelo->getFieldValue('Restringido_en')
            )
        ) {
            $criterio = "Contrato:equals:" . $contrato->getEntityId();

            $tasas = listaPorCriterio("Tasas", $criterio);
            foreach ($tasas as $tasa) {
                if (
                    in_array($modelo->getFieldValue("Tipo"), $tasa->getFieldValue('Grupo_de_veh_culo'))
                    and
                    $tasa->getFieldValue('A_o') == $_POST["fabricacion"]
                ) {
                    $tasa_valor = $tasa->getFieldValue('Valor');
                }
            }

            $recargos = listaPorCriterio("Recargos", $criterio);
            foreach ($recargos as $recargo) {
                if (
                    $recargo->getFieldValue('Marca')->getEntityId() == $_POST["marca"]
                    and
                    (empty($recargo->getFieldValue("Tipo"))
                        or
                        $recargo->getFieldValue("Tipo") == $modelo->getFieldValue("Tipo")
                        or
                        ($_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                            and
                            $_POST["fabricacion"] < $recargo->getFieldValue('Hasta'))
                        or
                        $_POST["fabricacion"] > $recargo->getFieldValue('Desde')
                        or
                        $_POST["fabricacion"] < $recargo->getFieldValue('Hasta'))
                ) {
                    $recargo_valor = $recargo->getFieldValue('Porcentaje');
                }
            }

            if (!empty($recargo_valor)) {
                $tasa_valor = ($tasa_valor + ($tasa_valor * $recargo_valor));
            }

            $prima = $_POST["suma"] * $tasa_valor / 100;

            if (!empty($prima) and $prima < $contrato->getFieldValue('Prima_M_nima')) {
                $prima = $contrato->getFieldValue('Prima_M_nima');
            }
        }

        if ($_POST["facturacion"] == "mensual") {
            $prima = $prima / 12;
        }

        $cotizacion["Subject"] = "Plan " . $_POST["facturacion"] . " " . $_POST["plan"];
        $cotizacion["Contrato"] = $contrato->getEntityId();
        $cotizacion["Aseguradora"] = $contrato->getFieldValue('Aseguradora')->getEntityId();
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Deal_Name"] = $trato_id;
        $cotizacion["Quote_Stage"] = "Negociación";
        crear("Quotes", $cotizacion, $plan_id, $prima);
    }

    header("Location:" . constant("url") . "cotizaciones/detalles?tipo=auto&id=$trato_id");
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización auto</h1>
</div>

<form method="POST" class="row" action="<?= constant("url") ?>cotizaciones/crear?tipo=auto">

    <div class="mx-auto col-10" style="width: 200px;">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre del cliente</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="nombre" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Suma Asegurado</label>

            <div class="col-sm-8">
                <input type="number" class="form-control" name="suma" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plan</label>

            <div class="col-sm-8">
                <select name="plan" class="form-control">
                    <option value="full" selected>Full</option>
                    <option value="ley">Ley</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Facturacion</label>

            <div class="col-sm-8">
                <select name="facturacion" class="form-control">
                    <option value="mensual" selected>Mensual</option>
                    <option value="anual">Anual</option>
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
                    $marcas = lista("Marcas");
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
        <a href="<?= constant("url") ?>cotizaciones/crear?tipo=auto" class="btn btn-info">Limpiar</a>

    </div>

</form>

<br><br>

<script>
    function obtener_modelos(val) {
        var url = "<?= constant("url") ?>" + "helpers/modelos.php";

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