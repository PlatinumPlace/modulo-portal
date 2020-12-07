@extends('portal')

@section('title', 'Póliza ' . $detalles->getFieldValue('P_liza'))

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
        <a href="{{ route('polizas.descargar', $detalles->getEntityId()) }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Descargar</a>
    </div>

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
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Vendedor</label>
                            <br>
                            <label
                                class="label-control">{{ $detalles->getFieldValue('Contact_Name')->getLookupLabel() }}</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Suma Asegurada</label>
                            <br>
                            <label
                                class="label-control">RD${{ number_format($detalles->getFieldValue('Suma_asegurada'), 2) }}</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Plan</label>
                            <br>
                            <label class="label-control">{{ $detalles->getFieldValue('Plan') }}</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Plan</label>
                            <br>
                            <label class="label-control">{{ $detalles->getFieldValue('Plan') }}</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Vigencia desde</label>
                            <br>
                            <label class="label-control">{{ $detalles->getFieldValue('Vigencia_desde') }}</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Vigencia hasta</label>
                            <br>
                            <label class="label-control">{{ $detalles->getFieldValue('Vigencia_hasta') }}</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Aseguradora</label>
                            <br>
                            <label
                                class="label-control">{{ $detalles->getFieldValue('Aseguradora')->getLookupLabel() }}</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Prima Total</label>
                            <br>
                            <label class="label-control">
                                RD${{ number_format($detalles->getFieldValue('Prima_total'), 2) }}</label>
                        </div>
                    </div>
                </div>
            </div>

            @if ($detalles->getFieldValue('Type') == 'Auto')
                @include('polizas.auto.detalles')
            @elseif ($detalles->getFieldValue('Type') == 'Vida')
                @include('polizas.vida.detalles')
            @endif
        </div>
    </div>

@endsection
