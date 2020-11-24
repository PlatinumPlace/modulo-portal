@extends('layouts.portal')

@section('title', 'No. ' . $detalles->getFieldValue('Quote_Number'))

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

                    @if ($detalles->getFieldValue('Tipo') == 'Persona')
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

            @if ($detalles->getFieldValue('Tipo') == 'Vehículo')
                <div class="card mb-4">
                    <div class="card-header">
                        Vehículo
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Marca</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Marca')->getLookupLabel() }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Modelo</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Modelo')->getLookupLabel() }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Año</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('A_o') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tipo</label>
                            <label class="col-sm-9 col-form-label">
                                {{ $detalles->getFieldValue('Tipo_veh_culo') }}
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    Aseguradoras disponibles
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Motivo</th>
                                    <th>Prima Neta</th>
                                    <th>ISC</th>
                                    <th>Prima Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($planes as $plan)
                                    <tr>
                                        @php
                                        $planDetalles = $api->getRecord("Products",$plan->getProduct()->getEntityId())
                                        @endphp

                                        <td>{{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}</td>
                                        <td>{{ $plan->getDescription() }}</td>
                                        <td>RD${{ number_format($plan->getListPrice(), 2) }}</td>
                                        <td>RD${{ number_format($plan->getTaxAmount(), 2) }}</td>
                                        <td>RD${{ number_format($plan->getNetTotal(), 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <a href="{{ url('cotizacion/descargar') . '/' . $detalles->getEntityId() }}"
                                class="btn btn-primary btn-block">Descargar</a>

                            <a href="{{ url('emitir') . '/' . $detalles->getEntityId() }}"
                                class="btn btn-info btn-block">Emitir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
