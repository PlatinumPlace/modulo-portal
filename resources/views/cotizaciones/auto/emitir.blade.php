<input type="text" value="{{ $detalles->getEntityId() }}" name="id" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Plan') }}" name="plantipo" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Marca')->getLookupLabel() }}" name="marca" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Modelo')->getLookupLabel() }}" name="modelo" hidden>
<input type="text" value="{{ $detalles->getFieldValue('A_o') }}" name="a_o" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Tipo_veh_culo') }}" name="modelotipo" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Condiciones') }}" name="condiciones" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Suma_asegurada') }}" name="suma" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Uso') }}" name="uso" hidden>

<div class="card mb-4">
    <div class="card-header">
        Vehículo
    </div>

    <div class="card-body">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Chasis</label>
                <input required type="text" class="form-control" name="chasis">
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Placa</label>
                <input type="text" class="form-control" name="placa">
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Color</label>
                <input type="text" class="form-control" name="color">
            </div>
        </div>
    </div>
</div>