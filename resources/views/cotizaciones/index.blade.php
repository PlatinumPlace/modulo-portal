@extends('layouts.app')

@section('title', 'Cotizaciones')

@section('content')

    <h1 class="mt-4">Cotizaciones</h1>
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
                        <a class="nav-link active" aria-current="page" href="{{ route('cotizar.auto') }}">Cotizar Auto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cotizar.vida') }}">Cotizar Vida</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <hr>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. Cotización</th>
                            <th>Plan</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Fecha</th>
                            <th>Opcion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cotizaciones as $cotizacion)
                            <tr>
                                <td>{{ $cotizacion->getFieldValue('Quote_Number') }}</td>
                                <td>{{ $cotizacion->getFieldValue('Plan') }}</td>
                                <td>{{ $cotizacion->getFieldValue('Nombre') }}</td>
                                <td>{{ $cotizacion->getFieldValue('Contact_Name')->getLookupLabel() }}</td>
                                <td>{{ date('d/m/Y', strtotime($cotizacion->getCreatedTime())) }}</td>
                                <td>
                                    <a href="{{ route('cotizacion.detalles', ['id' => $cotizacion->getEntityId()]) }}"
                                        title="Detalles">
                                        <i class="fas fa-info"></i>
                                    </a>
                                    |

                                    @php
                                    $tipo="emitir.".strtolower($cotizacion->getFieldValue('Tipo'));
                                    @endphp

                                    <a href="{{ route($tipo, ['id' => $cotizacion->getEntityId()]) }}" title="Emitir">
                                        <i class="fas fa-user"></i>
                                    </a>
                                    |
                                    <a href="{{ route('cotizacion.descargar', ['id' => $cotizacion->getEntityId()]) }}"
                                        title="Descargar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
