<input value="<?= $cotizacion->getFieldValue('Marca')->getLookupLabel() ?>" name="marca" hidden />
<input value="<?= $cotizacion->getFieldValue('Modelo')->getLookupLabel() ?>" name="modelo" hidden />
<input value="<?= $cotizacion->getFieldValue('A_o') ?>" name="a_o" hidden />
<input value="<?= $cotizacion->getFieldValue('Tipo_veh_culo') ?>" name="modelotipo" hidden />
<input value="<?= $cotizacion->getFieldValue('Condiciones') ?>" name="condiciones" hidden />
<input value="<?= $cotizacion->getFieldValue('Uso') ?>" name="uso" hidden />

<div class="card mb-4">
    <h5 class="card-header">Vehículo</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label><b>Chasis</b></label>
                <input required type="text" class="form-control" name="chasis">
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Placa</b></label>
                <input type="text" class="form-control" name="placa">
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Color</b></label>
                <input type="text" class="form-control" name="color">
            </div>
        </div>
    </div>
</div>