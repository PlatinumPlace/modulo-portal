<div class="col-12">
    &nbsp;
</div>

<div class="col-12 d-flex justify-content-center bg-primary text-white">
    <h6>COBERTURAS/PRIMA MENSUAL</h6>
</div>

<div class="col-12 border">
    <div class="row">
        <div class="col-3">
            <div class="card border-0">
                <br>

                <div class="card-body small">
                    <p>
                        <b>Suma Asegurada Vida</b> <br>

                        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
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
                <br>

                <div class="card-body small">
                    <p>
                        RD${{ number_format($detalles->getFieldValue('Suma_asegurada'), 2) }}<br>

                        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
                            RD${{ number_format($detalles->getFieldValue('Cuota'), 2) }} <br>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-2">
            <div class="card border-0">
                <br><br>

                <div class="card-body small">
                    <p>
                        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
                            <br>
                        @endif

                        <br> <br>
                        RD$ {{ number_format($detalles->getFieldValue('Prima_neta'), 2) }}<br>
                        RD$ {{ number_format($detalles->getFieldValue('ISC'), 2) }} <br>
                        RD$ {{ number_format($detalles->getFieldValue('Prima_total'), 2) }} <br>
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
    <h6 class="text-center">Observaciones</h6>
    <ul>
        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
            <li>Pago de desempleo hasta por 6 meses.</li>
        @endif
    </ul>
</div>

<div class="col-6 border">
    <h6 class="text-center">Requisitos del deudor</h6>
    <ul>
        <li>
            @php
            $lista = $planDetalles->getFieldValue('Requisitos_codeudor');
            @endphp

            <b> {{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}:</b>

            @foreach ($planDetalles->getFieldValue('Requisitos_deudor') as $requisito)
                {{ $requisito }}

                @if ($requisito === end($lista))
                    .
                @else
                    ,
                @endif

            @endforeach
        </li>
    </ul>

    @if ($detalles->getFieldValue('Nombre_codeudor'))
        <h6 class="text-center">Requisitos del codeudor</h6>
        <ul>
            <li>
                @php
                $lista = $planDetalles->getFieldValue('Requisitos_codeudor');
                @endphp

                <b> {{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}:</b>

                @foreach ($planDetalles->getFieldValue('Requisitos_codeudor') as $requisito)
                    {{ $requisito }}

                    @if ($requisito === end($lista))
                        .
                    @else
                        ,
                    @endif
                @endforeach
            </li>
        </ul>
    @endif
</div>
</div>
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="row">
    <div class="col-3">
        <p class="text-center">
            _______________________________
            <br>
            Firma Cliente
        </p>
    </div>

    <div class="col-6">
        &nbsp;
    </div>

    <div class="col-3">
        <p class="text-center">
            _______________________________
            <br>
            Fecha
        </p>
    </div>
</div>
