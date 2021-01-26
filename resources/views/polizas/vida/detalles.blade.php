<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            @if ($bien->getFieldValue('Nombre_codeudor'))
                <div class="col-md-6 mb-3">
                    <label><b>Nombre del codeudor</b></label>
                    <br>
                    <label
                        class="label-control">{{ $bien->getFieldValue('Nombre_codeudor') . ' ' . $bien->getFieldValue('Apellido_codeudor') }}</label>
                </div>
            @endif

            @if ($bien->getFieldValue('Cuota'))
                <div class="col-md-6 mb-3">
                    <label><b>Cuota Mensual</b></label>
                    <br>
                    <label class="label-control">RD${{ number_format($bien->getFieldValue('Cuota'), 2) }}</label>
                </div>
            @endif

            <div class="col-md-6 mb-3">
                <label><b>Plazo</b></label>
                <br>
                <label class="label-control">{{ $bien->getFieldValue('Plazo') }} meses</label>
            </div>
        </div>
    </div>
</div>
