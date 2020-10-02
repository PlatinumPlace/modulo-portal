<?php
$auto = new auto;
$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$trato = $auto->getRecord("Deals", $id);

if (empty($trato)) {
    require_once "views/error.php";
    exit();
}

if ($trato->getFieldValue("P_liza") != null) {
    header("Location:?pagina=adjuntar&id=$id");
    exit();
}

if ($_POST) {
    $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
    $permitido = array("pdf");

    if (!in_array($extension, $permitido)) {
        $alerta = "Para emitir solo se admiten documentos PDF";
        header("Location:?pagina=emitirAut&?id=$id&alerta=$alerta");
        exit();
    } else {
        $criteria = "Deal_Name:equals:" . $trato->getEntityId();
        $cotizaciones =  $auto->searchRecordsByCriteria("Quotes", $criteria);
        foreach ($cotizaciones as $cotizacion) {
            if ($cotizacion->getFieldValue('Aseguradora')->getEntityId() == $_POST["aseguradora_id"]) {
                $planes = $cotizacion->getLineItems();
                foreach ($planes as $plan) {
                    $prima_neta = round($plan->getListPrice(), 2);
                    $isc = round($plan->getTaxAmount(), 2);
                    $prima_total = round($plan->getNetTotal(), 2);
                }

                $contrato =  $auto->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());

                $contrato_id = $cotizacion->getFieldValue('Contrato')->getEntityId();
                $no_poliza = $contrato->getFieldValue('Name');
                $comision_nobe = $prima_total * $contrato->getFieldValue('Comisi_n_gruponobe') / 100;
                $comision_intermediario = $prima_total * $contrato->getFieldValue('Comisi_n_intermediario') / 100;
                $comision_aseguradora = $prima_total * $contrato->getFieldValue('Comisi_n_aseguradora') / 100;
                $comision_corredor = $prima_total * $contrato->getFieldValue('Comisi_n_corredor') / 100;

                $cambios["Quote_Stage"] = "Confirmada";
                $auto->update("Quotes", $cotizacion->getEntityId(), $cambios);
            }
        }

        $cliente_id = $auto->crearCliente();
        $poliza_id = $auto->crearPoliza($no_poliza, $cliente_id, $trato, $prima_total);
        $bien_id = $auto->crearBien($trato, $poliza_id);

        $auto->actualizarTrato(
            $poliza_id,
            $cliente_id,
            $bien_id,
            $prima_neta,
            $isc,
            $prima_total,
            $contrato_id,
            $comision_corredor,
            $comision_intermediario,
            $comision_nobe,
            $comision_aseguradora,
            $trato->getEntityId()
        );

        header("Location:?pagina=detallesAuto&id=$id");
        exit();
    }
}

?>
<br>

<?php if (isset($_GET["alerta"])) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $_GET["alerta"] ?>
    </div>
<?php endif ?>


<form enctype="multipart/form-data" class="row" method="POST" action="?pagina=emitirAuto&id=<?= $id ?>">

    <div class="mx-auto col-10" style="width: 200px;">

        <h5>Cliente</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nombre</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="nombre" value="<?= $trato->getFieldValue('Deal_Name') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Apellido</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="apellido">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">RNC/Cédula</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="rnc_cedula">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Fecha de Nacimiento</label>

            <div class="col-sm-8">
                <input type="date" class="form-control" name="fecha_nacimiento" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Correo Electrónico</label>

            <div class="col-sm-8">
                <input type="email" class="form-control" name="correo">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Dirección</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="direccion">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tel. Celular</label>

            <div class="col-sm-8">
                <input type="tel" class="form-control" name="telefono">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tel. Residencial</label>

            <div class="col-sm-8">
                <input type="tel" class="form-control" name="tel_residencia">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tel. Trabajo</label>

            <div class="col-sm-8">
                <input type="tel" class="form-control" name="tel_trabajo">
            </div>
        </div>

        <br>
        <h5>Vehículo</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Chasis</label>

            <div class="col-sm-8">
                <input required type="text" class="form-control" name="chasis">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Placa</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="placa">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Estado</label>

            <div class="col-sm-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck" name="estado">
                    <label class="form-check-label" for="gridCheck"> Nuevo </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Color</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="color">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Uso</label>

            <div class="col-sm-8">
                <select name="uso" class="form-control">
                    <option value="Privado" selected>Privado</option>
                    <option value="Publico">Publico</option>
                </select>
            </div>
        </div>

        <br>
        <h5>Emitir con</h5>
        <hr>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Aseguradora</label>

            <div class="col-sm-8">
                <select required name="aseguradora_id" class="form-control">
                    <option value="" selected disabled>Selecciona una Aseguradora</option>
                    <?php
                    $criteria = "Deal_Name:equals:" . $trato->getEntityId();
                    $cotizaciones = $auto->searchRecordsByCriteria("Quotes", $criteria);
                    foreach ($cotizaciones as $cotizacion) {
                        if ($cotizacion->getFieldValue('Grand_Total') > 0) {
                            echo '<option value="' . $cotizacion->getFieldValue('Aseguradora')->getEntityId() . '">' . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Cotización Firmada</label>

            <div class="col-sm-8">
                <input required type="file" class="form-control-file" name="cotizacion_firmada">
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success">Emitir</button>
        |
        <a href="?pagina=detallesAuto&id=<?= $id ?>" class="btn btn-info">Cancelar</a>

    </div>
</form>

<br> <br>