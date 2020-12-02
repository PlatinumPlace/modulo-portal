<br>
<h5>Vehículo</h5>
<hr>
<div class="form-row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Marca</label>
        <br>
        <label class="label-control">{{ $detalles->getFieldValue('Marca')->getLookupLabel() }}</label>
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Modelo</label>
        <br>
        <label class="label-control">{{ $detalles->getFieldValue('Modelo')->getLookupLabel() }}</label>
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Año</label>
        <br>
        <label class="label-control">{{ $detalles->getFieldValue('A_o') }}</label>
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Tipo</label>
        <br>
        <label class="label-control">{{ $detalles->getFieldValue('Tipo_veh_culo') }}</label>
    </div>
</div>
