@extends('layouts.app')

@section('title', 'Pólizas')

@section('content')

    <h1 class="mt-4">Pólizas</h1>
    <hr>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('polizas') }}">Pólizas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('reporte.polizas') }}">Reportes</a>
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
                            <th>Chasis o RNC/Cédula</th>
                            <th>Aseguradora</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Vendedor</th>
                            <th>Opcion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($polizas as $poliza)
                            <tr>
                                <td>{{ $poliza->getFieldValue('Bien')->getLookupLabel() }}</td>
                                <td>{{ $poliza->getFieldValue('Aseguradora')->getLookupLabel() }}</td>
                                <td>{{ date('d/m/Y', strtotime($poliza->getCreatedTime())) }}</td>
                                <td>{{ date('d/m/Y', strtotime($poliza->getFieldValue('Closing_Date'))) }}</td>
                                <td>{{ $poliza->getFieldValue('Contact_Name')->getLookupLabel() }}</td>
                                <td>
                                    <a href="{{ route('poliza.detalles', ['id' => $poliza->getEntityId()]) }}"
                                        title="Detalles">
                                        <i class="fas fa-info"></i>
                                    </a>
                                    |
                                    <a href="{{ route('poliza.descargar', ['id' => $poliza->getEntityId()]) }}"
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
