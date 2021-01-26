<div class="card mb-4">
    <h5 class="card-header">Vida/desempleo</h5>
    <div class="card-body">
        <div class="row">
            @if ($cotizacion->getFieldValue('Cuota'))
                <div class="col-md-6 mb-3">
                    <label><b>Cuota Mensual</b></label>
                    <br>
                    <label class="label-control">RD${{ number_format($cotizacion->getFieldValue('Cuota'), 2) }}</label>
                </div>
            @endif

            <div class="col-md-6 mb-3">
                <label><b>Plazo</b></label>
                <br>
                <label class="label-control">{{ $cotizacion->getFieldValue('Plazo') }} meses</label>
            </div>
        </div>
    </div>
</div>

@if ($cotizacion->getFieldValue('Edad_codeudor'))
    <div class="card mb-4">
        <h5 class="card-header">Codeudor</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><b>Nombre</b></label>
                    <br>
                    <label
                        class="label-control">{{ $cotizacion->getFieldValue('Nombre_codeudor') . ' ' . $cotizacion->getFieldValue('Apellido_codeudor') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Teléfono</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Tel_Celular_codeudor') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Correo</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Correo_electr_nico_codeudor') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Dirección</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Direcci_n_codeudor') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Edad</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Edad_codeudor') }}</label>
                </div>
            </div>
        </div>
    </div>
@endif
