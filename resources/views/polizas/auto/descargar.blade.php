<div class="col-12 d-flex justify-content-center bg-primary text-white">
    <h6>VEHÍCULO</h6>
</div>

<div class="col-6 border">
    <div class="row">
        <div class="col-4">
            <b>Marca:</b><br>
            <b>Modelo:</b><br>
            <b>Año:</b><br>
            <b>Tipo:</b><br>
            <b>Suma Asegurada:</b>
        </div>

        <div class="col-8">
            {{ $detalles->getFieldValue('Marca') }} <br>
            {{ $detalles->getFieldValue('Modelo') }} <br>
            {{ $detalles->getFieldValue('A_o_veh_culo') }} <br>
            {{ $detalles->getFieldValue('Tipo_veh_culo') }} <br>
            RD${{ number_format($detalles->getFieldValue('Suma_asegurada'), 2) }}
        </div>
    </div>
</div>

<div class="col-6 border">
    <div class="row">
        <div class="col-4">
            <b>Chasis:</b><br>
            <b>Placa:</b><br>
            <b>Color:</b><br>
            <b>Uso:</b><br>
            <b>Condicion:</b>
        </div>

        <div class="col-8">
            {{ $detalles->getFieldValue('Chasis') }} <br>
            {{ $detalles->getFieldValue('Placa') }} <br>
            {{ $detalles->getFieldValue('Color') }} <br>
            {{ $detalles->getFieldValue('Uso') }} <br>
            {{ $detalles->getFieldValue('Condiciones') }} <br>
        </div>
    </div>
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

        <div class="col-2">
            &nbsp;
        </div>

        <div class="col-2">
            <div class="card border-0">
                <br><br>

                <div class="card-body small">
                    @php
                    $riesgo_compresivo = $detalles->getFieldValue('Suma_asegurada') *
                    ($planDetalles->getFieldValue('Riesgos_comprensivos') / 100);
                    $colision = $detalles->getFieldValue('Suma_asegurada') *
                    ($planDetalles->getFieldValue('Colisi_n_y_vuelco') / 100);
                    $incendio = $detalles->getFieldValue('Suma_asegurada') *
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

<div class="col-6 border small">
    <br>
    <img src="{{ asset('img') . '/' . $imagen }}" width="150" height="60">
    <br><br>

    <div class="row">

        <div class="col-4">
            <p>
                <b>Póliza:</b><br>
                <b>Marca:</b> <br>
                <b>Modelo:</b> <br>
                <b>Chasis:</b> <br>
                <b>Placa:</b> <br>
                <b>Año:</b> <br>
                <b>Desde:</b> <br>
                <b>Hasta:</b>
            </p>
        </div>

        <div class="col-8">
            <p>
                {{ $detalles->getFieldValue('P_liza') }} <br>
                {{ $detalles->getFieldValue('Marca') }} <br>
                {{ $detalles->getFieldValue('Modelo') }} <br>
                {{ $detalles->getFieldValue('Chasis') }} <br>
                {{ $detalles->getFieldValue('Placa') }} <br>
                {{ $detalles->getFieldValue('A_o_veh_culo') }} <br>
                {{ $detalles->getFieldValue('Vigencia_desde') }} <br>
                {{ $detalles->getFieldValue('Vigencia_hasta') }} <br>
            </p>
        </div>

    </div>

</div>

<div class="col-6 border small">
    <div class="text-center font-weight-bold">EN CASO DE ACCIDENTE</div>
    <p>
        Realiza el levantamiento del acta policial y obténga la siguente cotizacionrmación:

    <ul>
        <li>Nombre,dirección y teléfonos del conductor,los lesionados,del propietario y de los testigos.
        </li>
        <li>Número de placa y póliza del vehí­culo involucrado, y nombre de la aseguradora</li>
    </ul>

    <b>EN CASO DE ROBO:</b> Notifica de inmediato a la Policía y a la Aseguradora. <br>

    <div class="text-center"><b>RESERVE SU DERECHO</b></div>
    </p>

    <p>
        <b>Aseguradora:</b> Tel.{{ $planDetalles->getFieldValue('Tel_aseguradora') }}
    </p>

    <div class="row">
        <div class="col-md-8">
            @if ($planDetalles->getFieldValue('En_caso_de_accidente'))
                <p>
                    <b>{{ $planDetalles->getFieldValue('En_caso_de_accidente') }}</b> <br>
                    Tel. Sto. Dgo {{ $planDetalles->getFieldValue('Tel_santo_domingo') }} <br>
                    Tel. Santiago {{ $planDetalles->getFieldValue('Tel_santiago') }}
                </p>
            @endif
        </div>

        <div class="col-md-4">
            @if ($planDetalles->getFieldValue('Asistencia_vial') == 1)
                <p>
                    <b>Asistencia vial 24 horas</b> <br>
                    Tel. {{ $planDetalles->getFieldValue('Tel_asistencia_vial') }}
                </p>
            @endif
        </div>
    </div>
</div>
