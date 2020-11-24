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
                            {{ $detalles->getFieldValue('Contact_Name') ? $detalles->getFieldValue('Contact_Name')->getLookupLabel() : '' }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Suma Asegurada</label>
                        <label class="col-sm-9 col-form-label">
                            RD${{ number_format($detalles->getFieldValue('Suma_asegurada'), 2) }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Plan</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Plan') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    Cliente
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Nombre') . ' ' . $detalles->getFieldValue('Apellido') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('RNC_C_dula') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Correo_electr_nico') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Fecha_de_nacimiento') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Direcci_n') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Tel_Celular') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Tel_Residencia') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Tel_Trabajo') }}
                        </label>
                    </div>
                </div>
            </div>

            @if ($detalles->getFieldValue('Type') == 'Vehículo')
                <div class="card mb-4">
                    <div class="card-header">
                        Vehículo
                    </div>

                    <div class="card-body">
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

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Color</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Color') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Condiciones</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Condiciones') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Uso</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Uso') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Chasis</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Chasis') }}
                            </label>
                        </div>
                    </div>
                </div>
            @endif

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
                        <label class="col-sm-3 col-form-label font-weight-bold">Prima Neta</label>
                        <label class="col-sm-9 col-form-label">
                            RD${{ number_format($detalles->getFieldValue('Prima_neta'), 2) }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">ISC</label>
                        <label class="col-sm-9 col-form-label">
                            RD${{ number_format($detalles->getFieldValue('ISC'), 2) }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Prima Total</label>
                        <label class="col-sm-9 col-form-label">
                            RD${{ number_format($detalles->getFieldValue('Prima_total'), 2) }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Documentos</label>
                        <label class="col-sm-9 col-form-label">
                            @if ($detalles->getFieldValue('Coberturas'))
                                @php
                                $adjuntos =
                                $api->getAttachments("Products",$detalles->getFieldValue('Coberturas')->getEntityId(),1,200);
                                @endphp

                                @foreach ($adjuntos as $adjunto)

                                    @if ($adjunto->getFileName() == 'vida.pdf' and $detalles->getFieldValue('Plan') == 'Vida')
                                        <a
                                            href="{{ url('adjunto') . '/' . $detalles->getFieldValue('Coberturas')->getEntityId() . ',' . $adjunto->getId() }}">Descargar</a>
                                    @elseif($adjunto->getFileName() =="desempleo.pdf" and
                                        $detalles->getFieldValue('Plan')=="Vida/desempleo")
                                        <a
                                            href="{{ url('adjunto') . '/' . $detalles->getFieldValue('Coberturas')->getEntityId() . ',' . $adjunto->getId() }}">Descargar</a>
                                    @elseif($detalles->getFieldValue('Type')=="Vehículo")
                                        <a
                                            href="{{ url('adjunto') . '/' . $detalles->getFieldValue('Coberturas')->getEntityId() . ',' . $adjunto->getId() }}">Descargar</a>
                                    @endif

                                @endforeach
                            @endif
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
