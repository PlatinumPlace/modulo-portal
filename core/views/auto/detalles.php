<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">cotización No. <?= $detalles->getFieldValue('Quote_Number') ?></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="<?= constant("url") ?>auto/emitir?id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Emitir</a>

            <a href="<?= constant("url") ?>auto/descargar?id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Nombre del cliente</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Nombre') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula del cliente</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('RNC_C_dula') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Valor Asegurado</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($detalles->getFieldValue('Valor_Asegurado'), 2) ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Plan</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Subject') ?>">
            </div>
        </div>

    </div>

    <div class="col-6">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Marca del vehículo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Marca')->getLookupLabel() ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Modelo del vehículo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Modelo')->getLookupLabel() ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Año de fabricación del vehículo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('A_o_Fabricaci_n') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Tipo de vehículo</label>

            <div class="col-sm-8">
                <input readonly type="text" class="form-control-plaintext" value="<?= $detalles->getFieldValue('Tipo_Veh_culo') ?>">
            </div>
        </div>

    </div>

</div>

<br>
<table class="table">

    <thead class="thead-dark">
        <tr>
            <th scope="col">Aseguradora</th>
            <th scope="col">Prima Neta</th>
            <th scope="col">ISC</th>
            <th scope="col">Prima Total</th>
            <th scope="col">Documentos</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $planes = $detalles->getLineItems();
        foreach ($planes as $plan) {
            echo "<tr>";
            echo "<td>" . $plan->getDescription() . "</td>";
            echo "<td>RD$" . number_format($plan->getListPrice(), 2) . "</td>";
            echo "<td>RD$" . number_format($plan->getTaxAmount(), 2) . "</td>";
            echo "<td>RD$" . number_format($plan->getNetTotal(), 2) . "</td>";

            $result = $cotizacion->contratoAdjuntos($plan->getProduct()->getEntityId());
            foreach ($result["adjuntos"] as $adjunto) {
                if ($plan->getNetTotal() > 0) {
                    echo '<td><a href="' . constant("url") . 'auto/detalles?id=' . $_GET["id"] . '&contract_id=' . $result["contrato_id"] . '&attachment_id=' . $adjunto->getId() . ' ">Descargar</a></td>';
                }
            }

            echo "</tr>";
        }
        ?>
    </tbody>

</table>