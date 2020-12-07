<div class="card mb-4">
    <div class="card-header">
        Vehículo
    </div>

    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Marca</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Marca') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Modelo</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Modelo') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Año</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('A_o_veh_culo') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Tipo</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Tipo_veh_culo') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Color</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Color') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Condiciones</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Condiciones') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Uso</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Uso') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Chasis</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Chasis') }}</label>
            </div>
        </div>
    </div>
</div>
