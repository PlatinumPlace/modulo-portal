<div class="card mb-4">
    <div class="card-header">
        Deudor
    </div>

    <div class="card-body">
        <div class="form-group row">
            @if ($detalles->getFieldValue('Nombre_codeudor'))
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Nombre del codeudor</label>
                    <br>
                    <label class="label-control"> {{ $detalles->getFieldValue('Nombre_codeudor') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Telefono del codeudor</label>
                    <br>
                    <label class="label-control"> {{ $detalles->getFieldValue('Tel_Celular_codeudor') }}</label>
                </div>
            @endif

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Plazo</label>
                <br>
                <label class="label-control">{{ $detalles->getFieldValue('Plazo') }} meses</label>
            </div>

            @if ($detalles->getFieldValue('Cuota'))
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Cuota Mensual</label>
                    <br>
                    <label class="label-control">RD${{ number_format($detalles->getFieldValue('Cuota'), 2) }}</label>
                </div>
            @endif
        </div>
    </div>
</div>
