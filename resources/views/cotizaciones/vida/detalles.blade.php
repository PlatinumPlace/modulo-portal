<div class="card mb-4">
    <div class="card-header">
        Deudor
    </div>

    <div class="card-body">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Edad del deudor</label>
                <br>
                <label class="label-control">{{ $detalles->getFieldValue('Edad_deudor') }} años</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Edad del codeudor</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Edad_codeudor') }} años</label>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Plazo</label>
                <br>
                <label class="label-control"> {{ $detalles->getFieldValue('Plazo') }} meses</label>
            </div>

            @if ($detalles->getFieldValue('Plan') == 'Vida/desempleo')
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Cuota Mensual</label>
                    <br>
                    <label class="label-control"> RD${{ number_format($detalles->getFieldValue('Cuota'), 2) }}</label>
                </div>
            @endif
        </div>
    </div>
</div>
