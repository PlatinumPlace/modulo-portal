@extends('layouts.portal')

@section('title', 'Pólizas emitidas este mes')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Pólizas emitidas este mes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>RNC/Cédula</th>
                            <th>Plan</th>
                            <th>Vigencia desde</th>
                            <th>Opcion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($polizas as $poliza)
                            <tr>
                                <td>{{ $poliza->getFieldValue('Nombre') . ' ' . $poliza->getFieldValue('Apellido') }}</td>
                                <td>{{ $poliza->getFieldValue('RNC_C_dula') }}</td>
                                <td>{{ $poliza->getFieldValue('Plan') }}</td>
                                <td>{{ date('d/m/Y', strtotime($poliza->getFieldValue('Vigencia_desde'))) }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
