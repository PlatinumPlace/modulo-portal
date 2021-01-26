@extends('layouts.app')

@section('title', 'Pólizas No.' . $bien->getFieldValue('P_liza'))

@section('content')

    <h1 class="mt-4">Pólizas No. {{ $bien->getFieldValue('P_liza') }}</h1>
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
                        <a class="nav-link active" aria-current="page"
                            href="{{ route('poliza.detalles', ['id' => $poliza->getEntityId()]) }}">Detalles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('poliza.descargar', ['id' => $poliza->getEntityId()]) }}">Descargar</a>
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
                    <label class="label-control">{{ $poliza->getFieldValue('Contact_Name')->getLookupLabel() }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Suma Asegurada</b></label>
                    <br>
                    <label class="label-control">RD$ {{ number_format($bien->getFieldValue('Suma_asegurada'), 2) }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Plan</b></label>
                    <br>
                    <label class="label-control">{{ $bien->getFieldValue('Plan') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Nombre del cliente</b></label>
                    <br>
                    <label
                        class="label-control">{{ $bien->getFieldValue('Nombre') . ' ' . $bien->getFieldValue('Apellido') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Aseguradora</b></label>
                    <br>
                    <label class="label-control">{{ $bien->getFieldValue('Aseguradora')->getLookupLabel() }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Prima</b></label>
                    <br>
                    <label class="label-control">RD$ {{ number_format($bien->getFieldValue('Prima'), 2) }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Vigencia desde</b></label>
                    <br>
                    <label class="label-control">{{ $bien->getFieldValue('Vigencia_desde') }}</label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Vigencia hasta</b></label>
                    <br>
                    <label class="label-control">{{ $bien->getFieldValue('Vigencia_hasta') }}</label>
                </div>
            </div>
        </div>
    </div>

    @if ($poliza->getFieldValue('Type') == 'Auto')
        @include('polizas.auto.detalles')
    @elseif($poliza->getFieldValue('Type') == "Vida")
        @include('polizas.vida.detalles')
    @endif

    <br>

@endsection
