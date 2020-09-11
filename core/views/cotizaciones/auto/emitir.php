<?php
$cotizaciones = new cotizacion();
$detalles = $cotizaciones->detalles();

if ($_POST) {
    $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
    $permitido = array("pdf");

    if (!in_array($extension, $permitido)) {
        $alerta = "Para emitir solo se admiten documentos PDF";
    } else {
        $planes = $detalles->getLineItems();
        foreach ($planes as $plan) {
            if ($plan->getId() == $_POST["plan_id"]) {
                $contratos = $cotizaciones->listaContratos();

                foreach ($contratos as $contrato) {
                    if ($plan->getDescription() == $contrato->getFieldValue('Aseguradora')->getLookupLabel()) {
                        $prima_neta = $plan->getListPrice();
                        $isc = $plan->getTaxAmount();
                        $prima_total = $plan->getNetTotal();
                        $no_poliza = $contrato->getFieldValue('No_P_liza');
                        $comision_nobe = $prima_total * $contrato->getFieldValue('Comisi_n_GrupoNobe') / 100;
                        $comision_aseguradora = $prima_total * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
                        $comision_socio = $prima_total * $contrato->getFieldValue('Comisi_n_Socio') / 100;
                        $contrato_id = $contrato->getEntityId();
                        $aseguradora_id = $contrato->getFieldValue('Aseguradora')->getEntityId();
                    }
                }
            }
        }

        $cliente_id = $cotizaciones->crearCliente($aseguradora_id);

        $poliza_id = $cotizaciones->crearPoliza(
                $no_poliza,
                $detalles->getFieldValue('Subject'),
                $aseguradora_id,
                $prima_total,
                $cliente_id,
                "Automóvil",
                $detalles->getFieldValue('Valor_Asegurado')
        );

        $bien_id = $cotizaciones->crearBienAuto(
                $detalles->getFieldValue('A_o_Fabricaci_n'),
                $detalles->getFieldValue('Marca')->getLookupLabel(),
                $detalles->getFieldValue('Modelo')->getLookupLabel(),
                $detalles->getFieldValue('Tipo_Veh_culo'),
                $poliza_id
        );

        $trato_id = $cotizaciones->crearTrato(
                $detalles->getFieldValue('Subject'),
                "Auto",
                $poliza_id,
                $bien_id,
                $cliente_id,
                $contrato_id,
                $aseguradora_id,
                $comision_aseguradora,
                $comision_socio,
                $comision_nobe,
                $prima_neta,
                $isc,
                $prima_total,
                $detalles->getFieldValue('Valor_Asegurado')
        );

        $cotizaciones->adjuntarTrato($trato_id);

        $cotizaciones->emitir($trato_id);
    }
}
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">emitir cotización auto</h1>
</div>

<?php if (isset($alerta)) : ?>
    <div class="alert alert-primary" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>

<form enctype="multipart/form-data" method="POST" action="<?= constant("url") . "cotizaciones/emitirAuto?id=" . $_GET["id"] ?>">

    <h4>Cliente</h4>
    <hr>
    <div class="row">

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Nombre</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="nombre" value="<?= $detalles->getFieldValue('Nombre') ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Apellido</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="apellido">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">RNC/Cédula</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="rnc_cedula" value="<?= $detalles->getFieldValue('RNC_C_dula') ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Fecha de Nacimiento</label>

                <div class="col-sm-8">
                    <input type="date" class="form-control" name="fecha_nacimiento">
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Correo Electrónico</label>

                <div class="col-sm-8">
                    <input type="email" class="form-control" name="correo">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Dirección</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="direccion">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Celular</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="telefono">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Residencial</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="tel_residencia">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Tel. Trabajo</label>

                <div class="col-sm-8">
                    <input type="tel" class="form-control" name="tel_trabajo">
                </div>
            </div>

        </div>

    </div>

    <br>
    <h4>Vehículo</h4>
    <hr>
    <div class="row">

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Chasis</label>

                <div class="col-sm-8">
                    <input required type="text" class="form-control" name="chasis">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Placa</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="placa">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Estado</label>

                <div class="col-sm-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="estado">
                        <label class="form-check-label" for="gridCheck"> Nuevo </label>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Color</label>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="color">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Uso</label>

                <div class="col-sm-8">
                    <select name="uso" class="form-control">
                        <option value="Privado" selected>Privado</option>
                        <option value="Publico">Publico</option>
                    </select>
                </div>
            </div>

        </div>

    </div>

    <br>
    <h4>Emitir con:</h4>
    <hr>
    <div class="row">

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Aseguradora</label>

                <div class="col-sm-8">
                    <select required name="plan_id" class="form-control">
                        <option value="" selected disabled>Selecciona una Aseguradora</option>
                        <?php
                        $planes = $detalles->getLineItems();
                        foreach ($planes as $plan) {
                            if ($plan->getNetTotal() > 0) {
                                echo '<option value="' . $plan->getId() . '">' . $plan->getDescription() . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="form-group row">
                <label class="col-sm-4 col-form-label font-weight-bold">Cotización Firmada</label>

                <div class="col-sm-8">
                    <input required type="file" class="form-control-file" name="cotizacion_firmada">
                </div>
            </div>

        </div>

    </div>

    <br>
    <button type="submit" class="btn btn-success">Emitir</button>
    |
    <a href="<?= constant("url") . "cotizaciones/detallesAuto?id=" . $_GET["id"] ?>" class="btn btn-info">Cancelar</a>
</form>

<br><br>

<?php if (empty($detalles) or $detalles->getFieldValue("Deal_Name") != null): ?>
    <script>
        var url = "<?= constant("url") ?>";
        window.location = url + "home/error";
    </script>
<?php endif; ?>

<?php if (!empty($trato_id)): ?>
    <script>
        var url = "<?= constant("url") ?>";
        var id = "<?= $trato_id ?>";
        window.location = url + "polizas/detallesAuto?id=" + id + "&alert=Cotizacion emitida exitosamente";
    </script>
<?php endif; ?>