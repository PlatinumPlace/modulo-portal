@extends('layouts.base')

@section('title', 'Cotización No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    <style>
        @media print {
            .pie_pagina {
                position: fixed;
                margin: auto;
                height: 100px;
                width: 100%;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 1030;
            }
        }

    </style>

    <div class="container">
        <div class="row">
            <div class="col-2">
                <img src="{{ asset('img/logo.png') }}" alt="60" width="100" height="100">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    cotización <br>

                    @if ($detalles->getFieldValue('Tipo') == 'Vehículo')
                        seguro vehí­culo de motor <br> Plan Mensual
                    @elseif ($detalles->getFieldValue('Tipo') == 'Persona')
                        Plan
                    @endif

                    {{ $detalles->getFieldValue('Plan') }}
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> {{ date('d-m-Y') }} <br>
                <b>No. de cotización</b> <br> {{ $detalles->getFieldValue('Quote_Number') }} <br>
            </div>

            <div class="col-12">
                &nbsp;
            </div>



            @if ($detalles->getFieldValue('Tipo') == 'Vehículo')
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
                            {{ $detalles->getFieldValue('Marca')->getLookupLabel() }} <br>
                            {{ $detalles->getFieldValue('Modelo')->getLookupLabel() }} <br>
                            {{ $detalles->getFieldValue('A_o') }} <br>
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
                            {{ $detalles->getFieldValue('Tipo_veh_culo') }} <br>
                            {{ $detalles->getFieldValue('Uso') }} <br>
                            RD${{ number_format($detalles->getFieldValue('Suma_Asegurada'), 2) }}
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

                        @foreach ($planes as $plan)
                            @php
                            $planDetalles = $api->getRecord("Products",$plan->getProduct()->getEntityId())
                            @endphp

                            @if ($plan->getListPrice() > 0)
                                <div class="col-2">
                                    <div class="card border-0">
                                        @php
                                        $imagen =$api->downloadPhoto("Vendors",
                                        $planDetalles->getFieldValue('Vendor_Name')->getEntityId())
                                        @endphp

                                        <img src="{{ asset('img') . '/' . $imagen }}" height="43" width="90"
                                            class="card-img-top">

                                        <div class="card-body small">
                                            @php
                                            $riesgo_compresivo = $detalles->getFieldValue('Suma_Asegurada') *
                                            ($planDetalles->getFieldValue('Riesgos_comprensivos') / 100);
                                            $colision = $detalles->getFieldValue('Suma_Asegurada') *
                                            ($planDetalles->getFieldValue('Colisi_n_y_vuelco') / 100);
                                            $incendio = $detalles->getFieldValue('Suma_Asegurada') *
                                            ($planDetalles->getFieldValue('Incendio_y_robo') / 100);
                                            @endphp

                                            <p>
                                                RD${{ number_format($riesgo_compresivo) }}<br>
                                                {{ $planDetalles->getFieldValue('Riesgos_comprensivos_deducible') }}<br>
                                                {{ $planDetalles->getFieldValue('Rotura_de_cristales_deducible') }} <br>
                                                RD${{ number_format($colision) }} <br>
                                                RD$ {{ number_format($incendio) }} <br>
                                            </p>

                                            <p>
                                                <br>
                                                RD$
                                                {{ number_format($planDetalles->getFieldValue('Da_os_propiedad_ajena')) }}
                                                <br>
                                                RD$
                                                {{ number_format($planDetalles->getFieldValue('Lesiones_muerte_1_pers')) }}
                                                <br>
                                                RD$
                                                {{ number_format($planDetalles->getFieldValue('Lesiones_muerte_m_s_1_pers')) }}
                                                <br>
                                                RD${{ number_format($planDetalles->getFieldValue('Lesiones_muerte_1_pas')) }}
                                                <br>
                                                RD$
                                                {{ number_format($planDetalles->getFieldValue('Lesiones_muerte_m_s_1_pas')) }}
                                                <br>
                                            </p>

                                            <p>
                                                RD$ {{ number_format($planDetalles->getFieldValue('Riesgos_conductor')) }}
                                                <br>
                                                RD$ {{ number_format($planDetalles->getFieldValue('Fianza_judicial')) }}
                                                <br>
                                            </p>

                                            <br>

                                            <p>
                                                @if ($planDetalles->getFieldValue('Asistencia_vial') == 1)
                                                    Aplica <br>
                                                @else
                                                    No Aplica <br>
                                                @endif

                                                @if ($planDetalles->getFieldValue('Renta_veh_culo') == 1)
                                                    Aplica <br>
                                                @else
                                                    No Aplica <br>
                                                @endif

                                                @if ($planDetalles->getFieldValue('En_caso_de_accidente') == 1)
                                                    Aplica <br>
                                                @else
                                                    No Aplica <br>
                                                @endif
                                            </p>

                                            <br>
                                            <br>

                                            <p>
                                                RD$ {{ number_format($plan->getListPrice(), 2) }}<br>
                                                RD$ {{ number_format($plan->getTaxAmount(), 2) }} <br>
                                                RD$ {{ number_format($plan->getNetTotal(), 2) }} <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @elseif($detalles->getFieldValue('Tipo')=="Persona")
                <div class="col-12 d-flex justify-content-center bg-primary text-white">
                    <h6>DETALLES</h6>
                </div>

                <div class="col-6 border">
                    <div class="row">
                        <div class="col-6">
                            <b>Edad del deudor:</b><br>
                            <b>Plazo:</b><br>
                        </div>

                        <div class="col-6">
                            {{ $detalles->getFieldValue('Edad_deudor') }} años <br>
                            {{ $detalles->getFieldValue('Plazo') }} meses
                        </div>
                    </div>
                </div>

                <div class="col-6 border">
                    <div class="row">
                        <div class="col-6">
                            @if ($detalles->getFieldValue('Edad_codeudor'))
                                <b>Edad del codeudor:</b><br>
                            @endif

                            @if ($detalles->getFieldValue('Cuota'))
                                <b>Cuota mensual:</b>
                            @endif
                        </div>

                        <div class="col-6">
                            @if ($detalles->getFieldValue('Edad_codeudor'))
                                {{ $detalles->getFieldValue('Edad_codeudor') }} años <br>
                            @endif

                            @if ($detalles->getFieldValue('Cuota'))
                                RD${{ number_format($detalles->getFieldValue('Cuota'), 2) }}
                            @endif
                        </div>
                    </div>
                </div>

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
                                        RD${{ number_format($detalles->getFieldValue('Suma_Asegurada'), 2) }}<br>

                                        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
                                            RD${{ number_format($detalles->getFieldValue('Cuota'), 2) }} <br>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        @foreach ($planes as $plan)
                            @php
                            $planDetalles = $api->getRecord("Products",$plan->getProduct()->getEntityId())
                            @endphp

                            @if ($plan->getListPrice() > 0)
                                <div class="col-2">
                                    <div class="card border-0">
                                        @php
                                        $imagen =$api->downloadPhoto("Vendors",
                                        $planDetalles->getFieldValue('Vendor_Name')->getEntityId())
                                        @endphp

                                        <img src="{{ asset('img') . '/' . $imagen }}" height="43" width="90"
                                            class="card-img-top">

                                        <div class="card-body small">
                                            <p>
                                                @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
                                                    <br>
                                                @endif

                                                <br> <br>
                                                RD$ {{ number_format($plan->getListPrice(), 2) }}<br>
                                                RD$ {{ number_format($plan->getTaxAmount(), 2) }} <br>
                                                RD$ {{ number_format($plan->getNetTotal(), 2) }} <br>
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
                        @foreach ($planes as $plan)
                            @php
                            $planDetalles = $api->getRecord("Products",$plan->getProduct()->getEntityId());
                            $lista = $planDetalles->getFieldValue('Requisitos_deudor');
                            @endphp

                            @if ($plan->getListPrice() > 0)
                                <li>
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
                            @endif
                        @endforeach
                    </ul>

                    @if ($detalles->getFieldValue('Edad_codeudor'))
                        <h6 class="text-center">Requisitos del codeudor</h6>
                        <ul>
                            @foreach ($planes as $plan)
                                @php
                                $planDetalles = $api->getRecord("Products",$plan->getProduct()->getEntityId());
                                $lista = $planDetalles->getFieldValue('Requisitos_codeudor');
                                @endphp

                                @if ($plan->getListPrice() > 0)
                                    <li>
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
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="row pie_pagina">
        <div class="col-3">
            <p class="text-center">
                _______________________________ <br> Firma Cliente
            </p>
        </div>

        <div class="col-6">
            <p class="text-center">
                _______________________________ <br> Aseguradora Elegida
            </p>
        </div>

        <div class="col-3">
            <p class="text-center">
                _______________________________ <br> Fecha
            </p>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.print();
            window.location = "{{ url('cotizacion') . '/' . $detalles->getEntityId() }}";
        }, 500);

    </script>

@endsection
