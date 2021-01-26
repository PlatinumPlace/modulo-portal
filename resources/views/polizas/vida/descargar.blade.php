@if ($bien->getFieldValue('Nombre_codeudor'))
    <div class="col-12 d-flex justify-content-center bg-primary text-white">
        <h6>CODEUDOR</h6>
    </div>

    <div class="col-6 border">
        <div class="row">
            <div class="col-4">
                <b>Nombre:</b><br>
                <b>RNC/Cédula:</b><br>
                <b>Email:</b><br>
                <b>Dirección:</b>
            </div>

            <div class="col-8">
                {{ $bien->getFieldValue('Nombre_codeudor') . ' ' . $bien->getFieldValue('Apellido_codeudor') }} <br>
                {{ $bien->getFieldValue('RNC_C_dula_codeudor') }} <br>
                {{ $bien->getFieldValue('Correo_electr_nico_codeudor') }} <br>
                {{ $bien->getFieldValue('Direcci_n_codeudor') }}
            </div>
        </div>
    </div>

    <div class="col-6 border">
        <div class="row">
            <div class="col-4">
                <b>Tel. Residencia:</b><br>
                <b>Tel. Celular:</b><br>
                <b>Tel. Trabajo:</b> <br>
                <b>Fecha de nacimiento:</b> <br>
            </div>

            <div class="col-8">
                {{ $bien->getFieldValue('Tel_Celular_codeudor') }} <br>
                {{ $bien->getFieldValue('Tel_Residencia_codeudor') }} <br>
                {{ $bien->getFieldValue('Tel_Trabajo_codeudor') }} <br>
                {{ $bien->getFieldValue('Fecha_de_nacimiento_codeudor') }} <br>
            </div>
        </div>
    </div>

    <div class="col-12">
        &nbsp;
    </div>
@endif

<div class="col-12 d-flex justify-content-center bg-primary text-white">
    <h6>COBERTURAS/PRIMA MENSUAL</h6>
</div>

<div class="col-12 border">
    <div class="row">
        <div class="col-3">
            <div class="card border-0">
                <div class="card-body small">
                    <p>
                        <b>Suma Asegurada Vida</b> <br>

                        @if ($bien->getFieldValue('Cuota'))
                            <b>Cuota Mensual de Prestamo</b><br>
                        @endif

                        <br> <br>
                        <b>Prima Neta</b> <br>
                        <b>ISC</b> <br>
                        <b>Prima Total</b>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card border-0">
                <div class="card-body small">
                    <p>
                        RD${{ number_format($bien->getFieldValue('Suma_asegurada'), 2) }}<br>

                        @if ($bien->getFieldValue('Cuota'))
                            RD${{ number_format($bien->getFieldValue('Cuota'), 2) }}<br>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-2">
            <div class="card border-0">
                <div class="card-body small">
                    <p>
                        @if ($bien->getFieldValue('Cuota'))
                            <br>
                        @endif

                        <br> <br><br>
                        RD$ {{ number_format($poliza->getFieldValue('Prima_neta'), 2) }}<br>
                        RD$ {{ number_format($poliza->getFieldValue('ISC'), 2) }} <br>
                        RD$ {{ number_format($poliza->getFieldValue('Prima_total'), 2) }} <br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-6 border">
    <h6 class="text-center"><b>Requisitos del deudor</b></h6>
    <ul>
        @php
        $lista = $plan->getFieldValue('Requisitos_deudor')
        @endphp

        @foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito)
            <li>{{ $requisito }}</li>
        @endforeach
        </li>
    </ul>
</div>

@if ($bien->getFieldValue('Nombre_codeudor'))
    <div class="col-6 border">
        <h6 class="text-center"><b>Requisitos del codeudor</b></h6>
        <ul>
            @php
            $lista = $plan->getFieldValue('Requisitos_codeudor')
            @endphp

            @foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito)
                <li>{{ $requisito }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($bien->getFieldValue('Cuota'))
    <div class="col-6 border">
        <h6 class="text-center"><b>Observaciones</b></h6>
        <ul>
            <li>Pago de desempleo hasta por 6 meses.</li>
        </ul>
    </div>
@endif
