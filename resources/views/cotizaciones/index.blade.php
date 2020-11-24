@extends('layouts.portal')

@section('title', 'Cotizaciones')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Buscar cotización
        </div>

        <div class="card-body">
            <form class="form-inline" method="POST" action="{{ url('cotizaciones') }}">
                @csrf

                <div class="form-group mb-2">
                    <input type="text" readonly class="form-control-plaintext" value="Número de Cotización">
                </div>

                <div class="form-group mx-sm-3 mb-2 col-6">
                    <input type="text" class="form-control col-9" name="busqueda" required>
                </div>

                <button type="submit" class="btn btn-success mb-2">Buscar</button>
                |
                <a href="{{ url('cotizaciones') }}" class="btn btn-info mb-2">Limpiar</a>
            </form>
        </div>
    </div>

    @if (session()->get('alerta'))
        <div class="alert alert-danger" role="alert">{{ session()->get('alerta') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Lista de cotizaciones (Max: 10)
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. Cotización</th>
                            <th>Plan</th>
                            <th>Vendedor</th>
                            <th>Fecha</th>
                            <th>Opcion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($lista as $cotizacion)
                            <tr>
                                <td>{{ $cotizacion->getFieldValue('Quote_Number') }}</td>
                                <td>{{ $cotizacion->getFieldValue('Plan') }}</td>
                                <td>{{ $cotizacion->getFieldValue('Contact_Name')->getLookupLabel() }}</td>
                                <td>{{ date('d/m/Y', strtotime($cotizacion->getCreatedTime())) }}</td>
                                <td>
                                    <a href="{{ url('cotizacion') . '/' . $cotizacion->getEntityId() }}" title="Detalles">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    |
                                    <a href="{{ url('emitir') . '/' . $cotizacion->getEntityId() }}" title="Emitir">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    |
                                    <a href="{{ url('cotizacion/descargar') . '/' . $cotizacion->getEntityId() }}"
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
                            <a class="page-link" href="{{ url('cotizaciones') . '/' . ($pagina - 1) }}">Anterior</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="{{ url('cotizaciones') . '/' . ($pagina + 1) }}">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection
