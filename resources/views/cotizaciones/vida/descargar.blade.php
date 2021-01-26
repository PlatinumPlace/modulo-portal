@if ($cotizacion->getFieldValue('Edad_codeudor'))
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
                {{ $cotizacion->getFieldValue('Nombre_codeudor') . ' ' . $cotizacion->getFieldValue('Apellido_codeudor') }}
                <br>
                {{ $cotizacion->getFieldValue('RNC_C_dula_codeudor') }} <br>
                {{ $cotizacion->getFieldValue('Correo_electr_nico_codeudor') }} <br>
                {{ $cotizacion->getFieldValue('Direcci_n_codeudor') }}
            </div>
        </div>
    </div>

    <div class="col-6 border">
        <div class="row">
            <div class="col-4">
                <b>Tel. Residencia:</b><br>
                <b>Tel. Celular:</b><br>
                <b>Tel. Trabajo:</b> <br>
                <b>Edad:</b> <br>
            </div>

            <div class="col-8">
                {{ $cotizacion->getFieldValue('Tel_Celular_codeudor') }} <br>
                {{ $cotizacion->getFieldValue('Tel_Residencia_codeudor') }} <br>
                {{ $cotizacion->getFieldValue('Tel_Trabajo_codeudor') }} <br>
                {{ $cotizacion->getFieldValue('Edad_codeudor') }} <br>
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
                <br>

                <div class="card-body small">
                    <p>
                        <b>Suma Asegurada Vida</b> <br>

                        @if ($cotizacion->getFieldValue('Cuota'))
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
                        RD${{ number_format($cotizacion->getFieldValue('Suma_asegurada'), 2) }}<br>

                        @if ($cotizacion->getFieldValue('Cuota'))
                            RD${{ number_format($cotizacion->getFieldValue('Cuota'), 2) }}<br>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @foreach ($cotizacion->getLineItems() as $detalles)
            @php
            $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId())
            @endphp

            @if ($detalles->getListPrice() > 0)
                <div class="col-2">
                    <div class="card border-0">
                        @php
                        $imagen = $api->downloadPhoto("Vendors", $plan->getFieldValue('Vendor_Name')->getEntityId())
                        @endphp

                        <img src="{{ asset("img/$imagen") }}" height="43" width="90" class="card-img-top">

                        <div class="card-body small">
                            <p>
                                @if ($cotizacion->getFieldValue('Cuota'))
                                    <br>
                                @endif

                                <br> <br>
                                RD$ {{ number_format($detalles->getListPrice(), 2) }}<br>
                                RD$ {{ number_format($detalles->getTaxAmount(), 2) }} <br>
                                RD$ {{ number_format($detalles->getNetTotal(), 2) }} <br>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-6 border">
    <h6 class="text-center">Requisitos del deudor</h6>
    <ul>
        @foreach ($cotizacion->getLineItems() as $detalles)
            @php
            $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId());
            $lista = $plan->getFieldValue('Requisitos_deudor');
            @endphp

            @if ($detalles->getListPrice() > 0)
                <li>
                    <b> {{ $plan->getFieldValue('Vendor_Name')->getLookupLabel() }}:</b>

                    @foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito)
                        {{ $requisito }}

                        @if ($requisito === end($lista))
                            .
                        @else
                            ,
                        @endif
                    @endforeach
                </li>
            @endif


        @endforeach
    </ul>
</div>

@if ($cotizacion->getFieldValue('Edad_codeudor'))
    <div class="col-6 border">
        <h6 class="text-center">Requisitos del codeudor</h6>
        <ul>
            @foreach ($cotizacion->getLineItems() as $detalles)
                @php
                $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId());
                $lista = $plan->getFieldValue('Requisitos_codeudor');
                @endphp

                @if ($detalles->getListPrice() > 0)
                    <li>
                        <b> {{ $plan->getFieldValue('Vendor_Name')->getLookupLabel() }}:</b>

                        @foreach ($plan->getFieldValue('Requisitos_deudor') as $requisito)
                            {{ $requisito }}

                            @if ($requisito === end($lista))
                                .
                            @else
                                ,
                            @endif
                        @endforeach
                    </li>
                @endif

            @endforeach
        </ul>
    </div>
@endif

@if ($cotizacion->getFieldValue('Cuota'))
    <div class="col-6 border">
        <h6 class="text-center">Observaciones</h6>
        <ul>
            <li>Pago de desempleo hasta por 6 meses.</li>
        </ul>
    </div>
@endif
