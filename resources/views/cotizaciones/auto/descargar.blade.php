<style>
    @media print {
        .pie_pagina {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    }

</style>

<div class="col-12 d-flex justify-content-center bg-primary text-white">
    <h6>VEHÍCULO</h6>
</div>

<div class="col-6 border">
    <div class="row">
        <div class="col-4">
            <b>Marca:</b><br>
            <b>Modelo:</b><br>
            <b>Año:</b>
        </div>

        <div class="col-8">
            {{ $cotizacion->getFieldValue('Marca')->getLookupLabel() }} <br>
            {{ $cotizacion->getFieldValue('Modelo')->getLookupLabel() }} <br>
            {{ $cotizacion->getFieldValue('A_o') }} <br>
        </div>
    </div>
</div>

<div class="col-6 border">
    <div class="row">
        <div class="col-4">
            <b>Tipo:</b><br>
            <b>Uso:</b><br>
            <b>Suma Asegurada:</b>
        </div>

        <div class="col-8">
            {{ $cotizacion->getFieldValue('Tipo_veh_culo') }} <br>
            {{ $cotizacion->getFieldValue('Uso') }} <br>
            RD${{ number_format($cotizacion->getFieldValue('Suma_asegurada'), 2) }}
        </div>
    </div>
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-12 d-flex justify-content-center bg-primary text-white">
    <h6>COBERTURAS</h6>
</div>

<div class="col-12 border">
    <div class="row">
        <div class="col-4">
            <div class="card border-0">
                <br>

                <div class="card-body small">
                    <p>
                        <b>DAÑOS PROPIOS</b><br>
                        Riesgos comprensivos<br>
                        Riesgos comprensivos (Deducible)<br>
                        Rotura de Cristales (Deducible)<br>
                        Colisión y vuelco<br>
                        Incendio y robo
                    </p>

                    <p>
                        <b>RESPONSABILIDAD CIVIL</b><br>
                        Daños Propiedad ajena<br>
                        Lesiones/Muerte 1 Pers<br>
                        Lesiones/Muerte más de 1 Pers<br>
                        Lesiones/Muerte 1 pasajero<br>
                        Lesiones/Muerte más de 1 pasajero<br>
                    </p>

                    <p>
                        <b>RIESGOS CONDUCTOR</b> <br>
                        <b>FIANZA JUDICIAL</b>
                    </p>

                    <p>
                        <b>COBERTURAS ADICIONALES</b><br>
                        Asistencia vial<br>
                        Renta Vehí­culo<br>
                        Casa del conductor / <br> Centro del Automovilista
                    </p>

                    <br>

                    <p>
                        <b>PRIMA NETA</b> <br>
                        <b>ISC</b> <br>
                        <b>PRIMA TOTAL</b> <br>
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
                            @php
                            $riesgo_compresivo = $cotizacion->getFieldValue('Suma_asegurada') *
                            ($plan->getFieldValue('Riesgos_comprensivos') / 100);
                            $colision = $cotizacion->getFieldValue('Suma_asegurada') *
                            ($plan->getFieldValue('Colisi_n_y_vuelco') / 100);
                            $incendio = $cotizacion->getFieldValue('Suma_asegurada') *
                            ($plan->getFieldValue('Incendio_y_robo') / 100);
                            @endphp

                            <p>
                                RD${{ number_format($riesgo_compresivo) }}<br>
                                {{ $plan->getFieldValue('Riesgos_comprensivos_deducible') }}<br>
                                {{ $plan->getFieldValue('Rotura_de_cristales_deducible') }} <br>
                                RD${{ number_format($colision) }} <br>
                                RD${{ number_format($incendio) }} <br>
                            </p>

                            <p>
                                <br>
                                RD$ {{ number_format($plan->getFieldValue('Da_os_propiedad_ajena')) }} <br>
                                RD$ {{ number_format($plan->getFieldValue('Lesiones_muerte_1_pers')) }} <br>
                                RD$ {{ number_format($plan->getFieldValue('Lesiones_muerte_m_s_1_pers')) }} <br>
                                RD${{ number_format($plan->getFieldValue('Lesiones_muerte_1_pas')) }} <br>
                                RD$ {{ number_format($plan->getFieldValue('Lesiones_muerte_m_s_1_pas')) }} <br>
                            </p>

                            <p>
                                RD$ {{ number_format($plan->getFieldValue('Riesgos_conductor')) }} <br>
                                RD$ {{ number_format($plan->getFieldValue('Fianza_judicial')) }} <br>
                            </p>

                            <br>

                            <p>
                                @if ($plan->getFieldValue('Asistencia_vial') == 1)
                                    Aplica <br>
                                @else
                                    No Aplica <br>
                                @endif

                                @if ($plan->getFieldValue('Renta_veh_culo') == 1)
                                    Aplica <br>
                                @else
                                    No Aplica <br>
                                @endif

                                @if ($plan->getFieldValue('En_caso_de_accidente') == 1)
                                    Aplica <br>
                                @else
                                    No Aplica <br>
                                @endif
                            </p>

                            <br>
                            <br>

                            <p>
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
