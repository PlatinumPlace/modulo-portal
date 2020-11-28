@extends('portal')

@section('title', 'Póliza ' . $detalles->getFieldValue('P_liza'))

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if (date("Y-m", strtotime($detalles->getFieldValue("Vigencia_hasta"))) == date('Y-m'))
            <div class="alert alert-danger text-center" role="alert">
                <h6 class="alert-heading">
                    ¡Atencion, esta poliza vencera en {{ $detalles->getFieldValue('Vigencia_hasta') }}!
                </h6>
            </div>
            @endif


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

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Vigencia desde</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Vigencia_desde') }}
                        </label>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Vigencia hasta</label>
                        <label class="col-sm-9 col-form-label">
                            {{ $detalles->getFieldValue('Vigencia_hasta') }}
                        </label>
                    </div>

                        @if ($detalles->getFieldValue('Nombre_codeudor'))
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nombre del codeudor</label>
                                <label class="col-sm-9 col-form-label">
                                    {{ $detalles->getFieldValue('Nombre_codeudor') }}
                                </label>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Telefono del codeudor</label>
                                <label class="col-sm-9 col-form-label">
                                    {{ $detalles->getFieldValue('Tel_Celular_codeudor') }}
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
                            <a href="{{ route("polizaVida.descargar", $detalles->getEntityId()) }}"
                                class="btn btn-primary btn-block">Descargar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
