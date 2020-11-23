@extends('layouts.portal')

@section('title', 'Póliza ' . $detalles->getFieldValue('P_liza'))

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header">
                    Detalles
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Vendedor</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Contact_Name')->getLookupLabel() }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nombre Cliente</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Nombre') . ' ' . $detalles->getFieldValue('Apellido') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula Cliente</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('RNC_C_dula') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Suma Asegurada</label>
                        <label class="col-sm-9 col-form-label">
                            RD${{ number_format($detalles->getFieldValue('Suma_asegurada'), 2) }}
                        </label>
                    </div>

                    @if ($detalles->getFieldValue('Type') == 'Vehículo')
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Marca</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Marca') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Modelo</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Modelo') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Año</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('A_o_veh_culo') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tipo</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Tipo_veh_culo') }}
                            </label>
                        </div>
                    @elseif ($detalles->getFieldValue('Type') == 'Persona')
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Edad del deudor</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Edad_deudor') }} años
                            </label>
                        </div>

                        @if ($detalles->getFieldValue('Edad_codeudor'))
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Edad del codeudor</label>
                                <label class="col-sm-9 col-form-label">
                                    {{ $detalles->getFieldValue('Edad_codeudor') }} años
                                </label>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Plazo</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Plazo') }} meses
                            </label>
                        </div>

                        @if ($detalles->getFieldValue('Cuota'))
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Cuota Mensual</label>
                                <label class="col-sm-9 col-form-label">
                                    RD${{ number_format($detalles->getFieldValue('Cuota'), 2) }}
                                </label>
                            </div>
                        @endif

                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    Aseguradora
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Aseguradora')->getLookupLabel() }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Plan</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Plan') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Prima</label>
                        <label class="col-sm-9 col-form-label">
                            RD${{ number_format($detalles->getFieldValue('Prima_total'), 2) }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Documentos</label>
                        <label class="col-sm-9 col-form-label">
                            @php
                            $adjuntos = $api->getAttachments("Products",$detalles->getFieldValue('Coberturas')->getEntityId(),1,1);
                            @endphp

                            @foreach ($adjuntos as $adjunto)
                                <a href="{{ $adjunto->getId() }}">Descargar</a>
                            @endforeach
                        </label>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    Opciones
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            &nbsp;
                        </div>

                        <div class="col-sm-6">
                            <a href="{{ url('poliza/descargar') . '/' . $detalles->getEntityId() }}"
                                class="btn btn-primary btn-block">Descargar</a>

                            <a href="{{ url('poliza/adjuntar') . '/' . $detalles->getEntityId() }}"
                                class="btn btn-info btn-block">Emitir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
