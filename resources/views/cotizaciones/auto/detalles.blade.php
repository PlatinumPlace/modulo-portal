<div class="card mb-4">
    <h5 class="card-header">Vehículo</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label><b>Marca</b></label>
                <br>
                <label class="label-control">{{ $cotizacion->getFieldValue('Marca')->getLookupLabel() }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Modelo</b></label>
                <br>
                <label class="label-control">{{ $cotizacion->getFieldValue('Modelo')->getLookupLabel() }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Año</b></label>
                <br>
                <label class="label-control">{{ $cotizacion->getFieldValue('A_o') }}</label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Tipo</b></label>
                <br>
                <label class="label-control">{{ $cotizacion->getFieldValue('Tipo_veh_culo') }}</label>
            </div>
        </div>
    </div>
</div>
