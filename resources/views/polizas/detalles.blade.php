@extends('portal')

@section('title', 'Póliza ' . $detalles->getFieldValue('P_liza'))

@section('content')

    @include('polizas.menu')

    <h5>Detalles</h5>
    <hr>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Vendedor</label>
            <br>
            <label class="label-control">{{ $detalles->getFieldValue('Contact_Name')->getLookupLabel() }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Suma Asegurada</label>
            <br>
            <label class="label-control">RD${{ number_format($detalles->getFieldValue('Suma_asegurada'), 2) }}</label>
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
            <label class="label-control">{{ $detalles->getFieldValue('Aseguradora')->getLookupLabel() }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Prima Neta</label>
            <br>
            <label class="label-control"> RD${{ number_format($detalles->getFieldValue('Prima_neta'), 2) }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">ISC</label>
            <br>
            <label class="label-control"> RD${{ number_format($detalles->getFieldValue('ISC'), 2) }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Prima Total</label>
            <br>
            <label class="label-control"> RD${{ number_format($detalles->getFieldValue('Prima_total'), 2) }}</label>
        </div>
    </div>

    @if ($detalles->getFieldValue('Type') == 'Auto')
        @include('auto.detalles.poliza')
    @endif

@endsection
