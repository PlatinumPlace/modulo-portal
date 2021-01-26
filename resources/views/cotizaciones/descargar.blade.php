@extends('layouts.app')

@section('title', 'Cotizaciones No.' . $cotizacion->getFieldValue('Quote_Number'))

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <img src="{{ asset('img/logo.png') }}" width="100" height="100">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    cotización <br>

                    @if ($cotizacion->getFieldValue('Tipo') == 'Auto')
                        seguro vehí­culo de motor <br>
                    @endif

                    Plan {{ $cotizacion->getFieldValue('Plan') }}
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> {{ date('d-m-Y') }}<br>
                <b>No. de cotización</b> <br> {{ $cotizacion->getFieldValue('Quote_Number') }}<br>
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
                        {{ $cotizacion->getFieldValue('Nombre') . ' ' . $cotizacion->getFieldValue('Apellido') }} <br>
                        {{ $cotizacion->getFieldValue('RNC_C_dula') }} <br>
                        {{ $cotizacion->getFieldValue('Correo_electr_nico') }} <br>
                        {{ $cotizacion->getFieldValue('Direcci_n') }}
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
                        {{ $cotizacion->getFieldValue('Tel_Celular') }} <br>
                        {{ $cotizacion->getFieldValue('Tel_Residencia') }} <br>
                        {{ $cotizacion->getFieldValue('Tel_Trabajo') }}
                    </div>
                </div>
            </div>

            <div class="col-12">
                &nbsp;
            </div>

            @if ($cotizacion->getFieldValue('Tipo') == 'Auto')
                @include('cotizaciones.auto.descargar')
            @elseif ($cotizacion->getFieldValue('Tipo') == "Vida")
                @include('cotizaciones.vida.descargar')
            @endif
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

    <div class="row pie_pagina">
        <div class="col-4">
            <p class="text-center">
                _______________________________ <br> Firma Cliente
            </p>
        </div>

        <div class="col-4">
            <p class="text-center">
                _______________________________ <br> Aseguradora Elegida
            </p>
        </div>

        <div class="col-4">
            <p class="text-center">
                _______________________________ <br> Fecha
            </p>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.print();
            window.location = "{{ route('cotizacion.detalles', ['id' => $cotizacion->getEntityId()]) }}";
        }, 2000);

    </script>

@endsection
