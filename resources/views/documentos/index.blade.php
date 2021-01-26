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
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Aseguradora</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cotizacion->getLineItems() as $detalles)
                            @php
                            $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId())
                            @endphp

                            <tr>
                                <td>{{ $plan->getFieldValue('Vendor_Name')->getLookupLabel() }}</td>
                                @foreach ($api->getAttachments('Products', $detalles->getProduct()->getEntityId(), 1, 200) as $adjunto)
                                    <td>
                                        <form action="{{ route('documentos', ['id' => $cotizacion->getEntityId()]) }}"
                                            method="post">
                                            @csrf

                                            <label><b>{{ strtoupper($adjunto->getFileName()) }}</b></label> <br>

                                            <input value="{{ $detalles->getProduct()->getEntityId() }}" name="plan"
                                                hidden />
                                            <input value="{{ $adjunto->getId() }}" name="documento" hidden />

                                            <button type="submit" class="btn btn-link">Descargar</button>
                                        </form>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
