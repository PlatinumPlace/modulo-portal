@extends('layouts.portal')

@section('title', 'Pólizas')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Buscar póliza
        </div>

        <div class="card-body">
            <form class="form-inline" method="POST" action="{{ url('polizas') }}">
                @csrf

                <div class="form-group mb-2">
                    <select class="form-control" name="parametro" required>
                        <option value="Nombre">Nombre del cliente</option>
                        <option value="RNC_C_dula">RNC/Cédula</option>
                    </select>
                </div>

                <div class="form-group mx-sm-3 mb-2 col-6">
                    <input type="text" class="form-control col-9" name="busqueda" required>
                </div>

                <button type="submit" class="btn btn-success mb-2">Buscar</button>
                |
                <a href="{{ url('polizas') }}" class="btn btn-info mb-2">Limpiar</a>
            </form>
        </div>
    </div>

    @if (session()->get('alerta'))
        <div class="alert alert-danger" role="alert">{{ session()->get('alerta') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Lista de pólizas (Max: 10)
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>RNC/Cédula</th>
                            <th>Plan</th>
                            <th>Vigencia hasta</th>
                            <th>Opcion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($polizas as $poliza)
                            <tr>
                                <td>{{ $poliza->getFieldValue('Nombre') . ' ' . $poliza->getFieldValue('Apellido') }}</td>
                                <td>{{ $poliza->getFieldValue('RNC_C_dula') }}</td>
                                <td>{{ $poliza->getFieldValue('Plan') }}</td>
                                <td>{{ date('d/m/Y', strtotime($poliza->getFieldValue('Vigencia_hasta'))) }}</td>
                                <td>
                                    <a href="{{ url('poliza') . '/' . strtolower($poliza->getFieldValue('Type')) . '/' . $poliza->getEntityId() }}"
                                        title="Detalles">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    |
                                    <a href="{{ url('poliza') . '/' . strtolower($poliza->getFieldValue('Type')) . '/descargar/' . $poliza->getEntityId() }}"
                                        title="Descargar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <p>No se encontraron registros.</p>
                        @endforelse
                    </tbody>
                </table>

                <br>

                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="{{ url('polizas') . '/' . ($pag - 1) }}">Anterior</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="{{ url('polizas') . '/' . ($pag + 1) }}">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection
