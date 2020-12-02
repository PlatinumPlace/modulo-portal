@extends('base')

@section('title', 'Póliza ' . $detalles->getFieldValue('P_liza'))

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <img src="{{ asset('img') . '/' . $imagen }}" width="170" height="100">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">

                    @if ($detalles->getFieldValue('Type') == 'Auto')
                        resumen coberturas <br>
                        seguro vehí­culo de motor <br>
                    @endif

                    Plan {{ $detalles->getFieldValue('Plan') }}
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> {{ date('d-m-Y') }} <br>
                <b>Póliza</b> <br> {{ $detalles->getFieldValue('P_liza') }} <br>
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

            @if ($detalles->getFieldValue('Type') == 'Auto')
                @include('auto.descargar.poliza')
            @elseif ($detalles->getFieldValue('Type') == 'Vida')
                @include('vida.descargar.poliza')
            @endif
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.print();
            window.location = "{{ route('polizas.detalles', $detalles->getEntityId()) }}";
        }, 500);

    </script>

@endsection
