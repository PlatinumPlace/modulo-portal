<?php
$api = new api;

if ($_POST) {
    $marca = $api->detalles("Marcas", $_POST["marca"]);
    $modelo = $api->detalles("Modelos", $_POST["modelo"]);

    $trato["Stage"] = "Cotizando";
    $trato["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
    $trato["Fecha_de_emisi_n"] = date("Y-m-d");
    $trato["Lead_Source"] = "Portal";
    $trato["Marca"] = $_POST["marca"];
    $trato["Modelo"] = $_POST["modelo"];
    $trato["A_o_veh_culo"] = $_POST["fabricacion"];
    $trato["Nombre"] = $_POST["nombre"];
    $trato["Contact_Name"] = $_SESSION["usuario"]['id'];
    $trato["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $trato["Deal_Name"] = "Cotización";
    $trato["Suma_asegurada"] = $_POST["suma"];
    $trato["Plan"] = $_POST["tipo_plan"];
    $trato["Type"] = "Auto";
    $trato["Tipo_veh_culo"] = $modelo->getFieldValue("Tipo");
    $trato_id = $api->crear("Deals", $trato);

    $criteria = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
    $contratos = $api->listaFiltrada("Contratos", $criteria);

    foreach ($contratos as $contrato) {
        $prima = 0;

        $criteria = "Vendor_Name:equals:" . $contrato->getFieldValue('Aseguradora')->getEntityId();
        $planes = $api->listaFiltrada("Products", $criteria);
        foreach ($planes as $detalles) {
            if ($detalles->getFieldValue('Unit_Price') > 0) {
                $prima  = $detalles->getFieldValue('Unit_Price');
            } else {
                $plan = $detalles;
            }
        }

        if (
            empty($prima)
            and
            in_array(
                $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                $marca->getFieldValue('Restringido_en')
            )
            or
            in_array(
                $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
                $modelo->getFieldValue('Restringido_en')
            )
        ) {
            $prima =  0;
        } else {
            $criteria = "Contrato:equals:" . $contrato->getEntityId();
            $tasas = $api->listaFiltrada("Tasas", $criteria);
            foreach ($tasas as $detalles) {
                if (
                    in_array($modelo->getFieldValue("Tipo"), $detalles->getFieldValue('Grupo_de_veh_culo'))
                    and
                    $detalles->getFieldValue('A_o') == $_POST["fabricacion"]
                ) {
                    $tasa = $detalles->getFieldValue('Valor');
                }
            }

            $recargos = $api->listaFiltrada("Recargos", $criteria);
            foreach ($recargos as $detalles) {
                if (
                    $detalles->getFieldValue('Marca')->getEntityId() == $_POST["marca"]
                    and
                    (empty($detalles->getFieldValue("Tipo"))
                        or
                        $detalles->getFieldValue("Tipo") == $modelo->getFieldValue("Tipo")
                        or
                        ($_POST["fabricacion"] > $detalles->getFieldValue('Desde')
                            and
                            $_POST["fabricacion"] < $detalles->getFieldValue('Hasta'))
                        or
                        $_POST["fabricacion"] > $detalles->getFieldValue('Desde')
                        or
                        $_POST["fabricacion"] < $detalles->getFieldValue('Hasta'))
                ) {
                    $recargo = $detalles->getFieldValue('Porcentaje');
                }
            }

            if (!empty($recargo)) {
                $tasa = ($tasa + ($tasa * $recargo));
            }

            $prima = $_POST["suma"] * $tasa / 100;

            if (!empty($prima) and $prima < $contrato->getFieldValue('Prima_M_nima')) {
                $prima = $contrato->getFieldValue('Prima_M_nima');
            }
        }

        if (strpos($_POST["tipo_plan"], 'mensual') !== false) {
            $prima = $prima / 12;
        }

        $cotizacion["Aseguradora"] = $contrato->getFieldValue('Aseguradora')->getEntityId();
        $cotizacion["Subject"] = "Plan " . $_POST["tipo_plan"];
        $cotizacion["Contrato"] = $contrato->getEntityId();
        $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
        $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
        $cotizacion["Deal_Name"] =  $trato_id;
        $cotizacion["Valid_Till"] =  date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
        $cotizacion["Quote_Stage"] = "Negociación";
        $cotizacion_id = $api->crear("Quotes", $cotizacion, $plan, $prima);
    }

    header("Location:index.php?page=detallesAuto&id=$trato_id");
    exit();
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización auto</h1>
</div>

<form method="POST" class="row" action="index.php?page=crearAuto">

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
                <select name="tipo_plan" class="form-control">
                    <option value="Mensual full" selected>Mensual Full</option>
                    <option value="Mensual ley">Mensual Ley</option>
                    <option value="Anual full">Anual Full</option>
                    <option value="Anual ley">Anual Ley</option>
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
                    $marcas = $api->lista("Marcas");
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
        <a href="index.php?page=crearAuto" class="btn btn-info">Limpiar</a>

    </div>

</form>

<script>
    function obtener_modelos(val) {
        $.ajax({
            url: "helpers/modelos.php",
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