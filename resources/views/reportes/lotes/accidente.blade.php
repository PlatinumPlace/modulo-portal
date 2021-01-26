@extends('layouts.app')

@section('title', 'Reporte TUA')

@section('content')

    <style>
        @media all {
            div.saltopagina {
                display: none;
            }
        }

        @media print {
            div.saltopagina {
                display: block;
                page-break-before: always;
            }
        }

    </style>

    @foreach ($casos as $caso)
        <div class="row">
            <div class="col-4">
                <img src="{{ asset('img/tua.png') }}" width="170" height="170">
            </div>

            <div class="col-8">
                &nbsp;
            </div>

            <div class="col-12">
                &nbsp;
            </div>

            <h3>Reporte de accidente</h3>

            <div class="col-12">
                &nbsp;
            </div>

            <div class="col-6">
                <b>Núm de caso</b> <br>
                {{ $caso->getFieldValue('TUA') }}
            </div>

            <div class="col-6">
                <b>Asegurado</b> <br>
                {{ $caso->getFieldValue('Propietario') }}
            </div>

            <div class="col-6">
                <b>Póliza</b> <br>
                {{ $caso->getFieldValue('P_liza') }}
            </div>

            <div class="col-6">
                <b>Aseguradora</b> <br>
                {{ $caso->getFieldValue('Aseguradora') }}
            </div>

            <div class="col-6">
                <b>Inicio Vigencia</b> <br>
                {{ $caso->getFieldValue('Vigencia_desde') }}
            </div>

            <div class="col-6">
                <b>Fin Vigencia</b> <br>
                {{ $caso->getFieldValue('Vigencia_hasta') }}
            </div>

            <div class="col-6">
                <b>Plan</b> <br>
                {{ $caso->getFieldValue('Plan') }}
            </div>

            <div class="col-6">
                <b>Tipo de servicio</b> <br>
                {{ $caso->getFieldValue('Tipo_de_asistencia') }}
            </div>

            <div class="col-6">
                <b>Marca</b> <br>
                {{ $caso->getFieldValue('Marca') }}
            </div>

            <div class="col-6">
                <b>Modelo</b> <br>
                {{ $caso->getFieldValue('Modelo') }}
            </div>

            <div class="col-6">
                <b>Año</b> <br>
                {{ $caso->getFieldValue('A_o') }}
            </div>

            <div class="col-6">
                <b>Placa</b> <br>
                {{ $caso->getFieldValue('Placa') }}
            </div>

            <div class="col-6">
                <b>Chasis</b> <br>
                @if ($caso->getFieldValue('Bien'))
                    {{ $caso->getFieldValue('Bien')->getLookupLabel() }}
                @endif
            </div>

            <div class="col-6">
                <b>Color</b> <br>
                {{ $caso->getFieldValue('Color') }}
            </div>

            <div class="col-6">
                <b>Solicitante</b> <br>
                {{ $caso->getFieldValue('Solicitante') }}
            </div>

            <div class="col-6">
                <b>Teléfono</b> <br>
                {{ $caso->getFieldValue('Phone') }}
            </div>

            <div class="col-12">
                &nbsp;
            </div>

            <div class="col-6">
                <b>Punto A</b> <br>
                {{ $caso->getFieldValue('Punto_A') }}
            </div>

            <div class="col-6">
                <b>Punto B</b> <br>
                {{ $caso->getFieldValue('Punto_B') }}
            </div>

            <div class="col-12">
                &nbsp;
            </div>

            <div class="col-6">
                <b>Fecha</b> <br>
                {{ $caso->getFieldValue('Fecha') }}
            </div>

            <div class="col-6">
                <b>Zona</b> <br>
                {{ $caso->getFieldValue('Zona') }}
            </div>

            <div class="col-6">
                <b>Hora de llamada</b> <br>
                {{ date('H:i:s A', strtotime($caso->getFieldValue('Recibido'))) }}
            </div>

            <div class="col-6">
                <b>Tiempo de espera</b> <br>
                {{ $caso->getFieldValue('Tiempo_estimado') }}
            </div>

            <div class="col-6">
                <b>Hora contacto</b> <br>
                {{ date('H:i:s A', strtotime($caso->getFieldValue('Contacto'))) }}
            </div>

            <div class="col-6">
                <b>Hora de cierre</b> <br>
                {{ date('H:i:s A', strtotime($caso->getFieldValue('Concluido'))) }}
            </div>

            <div class="col-12">
                &nbsp;
            </div>

            <div class="col-12">
                <b>Observaciones</b> <br>
                {{ $caso->getFieldValue('Description') }}
            </div>
        </div>

        <div class="saltopagina"></div>

        @php
        $cont = 2
        @endphp

        @foreach ($api->getAttachments('Cases', $caso->getEntityId(), 1, 200) as $adjunto)
            @php
            $imagen = $api->downloadAttachment("Cases", $caso->getEntityId(), $adjunto->getId(),public_path("tmp"))
            @endphp

            <img src="{{ asset('tmp/' . basename($imagen)) }}" height="700" width="850">

            <div class="col-12">
                &nbsp;
            </div>

            @php
            $cont++
            @endphp

            @if ($cont % 2 == 0)
                <div class="saltopagina"></div>
            @endif

        @endforeach

        <script>
            setTimeout(function() {
                window.print();
                window.close();
            }, 2000);

        </script>
    @endforeach

@endsection
