@extends('layouts.app')

@section('title', 'Cotizaciones No.' . $cotizacion->getFieldValue('Quote_Number'))

@section('content')

    <h1 class="mt-4">Cotización No. {{ $cotizacion->getFieldValue('Quote_Number') }}</h1>
    <hr>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('cotizaciones') }}">Cotizaciones</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="{{ route('cotizacion.detalles', ['id' => $cotizacion->getEntityId()]) }}">Detalles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('cotizacion.descargar', ['id' => $cotizacion->getEntityId()]) }}">Descargar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('documentos', ['id' => $cotizacion->getEntityId()]) }}">Documentos</a>
                    </li>
                    @php
                    $tipo="emitir.".strtolower($cotizacion->getFieldValue('Tipo'));
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route($tipo, ['id' => $cotizacion->getEntityId()]) }}">Emitir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <hr>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><b>Vendedor</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Contact_Name')->getLookupLabel() }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Suma Asegurada</b></label>
                    <br>
                    <label class="label-control">RD$
                        {{ number_format($cotizacion->getFieldValue('Suma_asegurada'), 2) }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Plan</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Plan') }}</label>
                </div>
            </div>
        </div>
    </div>

    @if ($cotizacion->getFieldValue('Tipo') == 'Auto')
        @include('cotizaciones.auto.detalles')
    @elseif ($cotizacion->getFieldValue('Tipo') == "Vida")
        @include('cotizaciones.vida.detalles')
    @endif

    <div class="card mb-4">
        <h5 class="card-header">Cliente</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><b>Nombre</b></label>
                    <br>
                    <label
                        class="label-control">{{ $cotizacion->getFieldValue('Nombre') . ' ' . $cotizacion->getFieldValue('Apellido') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Teléfono</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Tel_Celular') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Correo</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Correo_electr_nico') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Dirección</b></label>
                    <br>
                    <label class="label-control">{{ $cotizacion->getFieldValue('Direcci_n') }}</label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <h5 class="card-header">Aseguradoras disponibles</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
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
                        @foreach ($cotizacion->getLineItems() as $detalles)
                            @php
                            $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId())
                            @endphp
                            <tr>
                                <td>{{ $plan->getFieldValue('Vendor_Name')->getLookupLabel() }}</td>
                                <td>{{ $detalles->getDescription() }}</td>
                                <td>RD${{ number_format($detalles->getListPrice(), 2) }}</td>
                                <td>RD${{ number_format($detalles->getTaxAmount(), 2) }}</td>
                                <td>RD${{ number_format($detalles->getNetTotal(), 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
