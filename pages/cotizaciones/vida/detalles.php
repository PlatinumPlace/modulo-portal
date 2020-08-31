<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2 text-uppercase">cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">

            <?php if ($cotizacion->getFieldValue("Deal_Name") != null) : ?>
                <a href="<?= constant("url") ?>?page=adjuntar&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">Adjuntar</a>
            <?php else : ?>
                <a href="<?= constant("url") ?>?page=emitir&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">Emitir</a>
            <?php endif ?>

            <a href="<?= constant("url") ?>?page=descargar&id=<?= $id ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
        </div>
    </div>

</div>

<?php if (isset($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<br>
<h4>Deudor</h4>
<hr>
<div class="form-row">

    <div class="form-group col-md-3">
        <label><b>Nombre</b></label>

        <input readonly type="text" class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Nombre') ?>">
    </div>

    <div class="form-group col-md-3">
        <label><b>RNC/Cédula</b></label>

        <input readonly type="text" class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('RNC_C_dula') ?>">
    </div>

    <div class="form-group col-md-3">
        <label><b>Valor Asegurado</b></label>

        <input readonly type="text" class="form-control-plaintext" value="RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>">
    </div>

    <div class="form-group col-md-3">
        <label><b>Plan</b></label>

        <input readonly type="text" class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Subject') ?>">
    </div>

</div>

<br>
<h4>Detalles</h4>
<hr>
<div class="form-row">

    <div class="form-group col-md-3">
        <label><b>Desempleo</b></label>

        <input readonly type="text" class="form-control-plaintext" value="<?= (!empty($cotizacion->getFieldValue('Desempleo'))) ? "Aplica" : "No Aplica"; ?>">
    </div>

    <div class="form-group col-md-3">
        <label><b>Edad Deudor</b></label>

        <input readonly type="text" class="form-control-plaintext" value="<?= calcular_edad($cotizacion->getFieldValue('Fecha_Nacimiento')) ?>  Años">
    </div>

    <?php if (!empty($cotizacion->getFieldValue('Fecha_Nacimiento_Codeudor'))) : ?>
        <div class="form-group col-md-3">
            <label><b>Edad Codeudor</b></label>

            <input readonly type="text" class="form-control-plaintext" value="<?= calcular_edad($cotizacion->getFieldValue('Fecha_Nacimiento_Codeudor')) ?> Años">
        </div>
    <?php endif ?>

    <div class="form-group col-md-3">
        <label><b>Plazo</b></label>

        <input readonly type="text" class="form-control-plaintext" value="<?= $cotizacion->getFieldValue('Plazo') ?> Meses">
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
        $planes = $cotizacion->getLineItems();
        foreach ($planes as $plan) {
            $plan_detalles = detalles_registro("Products", $plan->getProduct()->getEntityId());
            $adjuntos = lista_adjuntos("Contratos", $plan->getDescription());

            echo "<tr>";
            echo "<td>" . $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() . "</td>";
            echo "<td>RD$" . number_format($plan->getListPrice(), 2) . "</td>";
            echo "<td>RD$" . number_format($plan->getTaxAmount(), 2) . "</td>";
            echo "<td>RD$" . number_format($plan->getNetTotal(), 2) . "</td>";

            foreach ($adjuntos as $adjunto) {
                if ($plan->getNetTotal() > 0) {
                    echo '<td><a href="' . constant("url") .
                        '?page=detalles&id=' . $id .
                        '&contract_id=' . $plan->getDescription() .
                        '&attachment_id=' . $adjunto->getId() . ' ">Descargar</a></td>';
                }
            }

            echo "</tr>";
        }
        ?>
    </tbody>

</table>