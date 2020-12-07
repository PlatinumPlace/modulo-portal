@extends('base')

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
                <img src="{{ asset('img/logo.png') }}" width="100" height="100">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    cotización <br>

                    @if ($detalles->getFieldValue('Tipo') == 'Auto')
                        seguro vehí­culo de motor <br>
                    @endif

                    Plan {{ $detalles->getFieldValue('Plan') }}
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> {{ date('d-m-Y') }} <br>
                <b>No. de cotización</b> <br> {{ $detalles->getFieldValue('Quote_Number') }} <br>
            </div>

            <div class="col-12">
                &nbsp;
            </div>

            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>CLIENTE</h6>
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
                        {{ $detalles->getFieldValue('Nombre') . ' ' . $detalles->getFieldValue('Apellido') }} <br>
                        {{ $detalles->getFieldValue('RNC_C_dula') }} <br>
                        {{ $detalles->getFieldValue('Correo_electr_nico') }} <br>
                        {{ $detalles->getFieldValue('Direcci_n') }}
                    </div>
                </div>
            </div>

            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Tel. Residencia:</b><br>
                        <b>Tel. Celular:</b><br>
                        <b>Tel. Trabajo:</b>
                    </div>

                    <div class="col-8">
                        {{ $detalles->getFieldValue('Tel_Celular') }} <br>
                        {{ $detalles->getFieldValue('Tel_Residencia') }} <br>
                        {{ $detalles->getFieldValue('Tel_Trabajo') }}
                    </div>
                </div>
            </div>

            @if ($detalles->getFieldValue('Tipo') == 'Auto')
                @include('cotizaciones.auto.descargar')
            @elseif ($detalles->getFieldValue('Tipo') == 'Vida')
                @include('cotizaciones.vida.descargar')
            @endif

        </div>
    </div>

    @if ($detalles->getFieldValue('Tipo') == 'Auto')
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
    @elseif ($detalles->getFieldValue('Tipo') == 'Vida')
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
    @endif

    <script>
        setTimeout(function() {
            window.print();
            window.location = "{{ route('cotizaciones.detalles', $detalles->getEntityId()) }}";
        }, 500);

    </script>

@endsection
