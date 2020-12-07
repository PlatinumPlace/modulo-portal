@extends('portal')

@section('title', 'Cotización No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
        <a href="{{ route('cotizaciones.descargar', $detalles->getEntityId()) }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Descargar</a>

        <a href="{{ route('cotizaciones.documentos', $detalles->getEntityId()) }}"
            class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Descargar documentos</a>

        <a href="{{ route('cotizaciones.emitir', $detalles->getEntityId()) }}"
            class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Emitir</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
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
                            <label class="font-weight-bold">Nombre del cliente</label>
                            <br>
                            <label
                                class="label-control">{{ $detalles->getFieldValue('Nombre') . ' ' . $detalles->getFieldValue('Apellido') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            @if ($detalles->getFieldValue('Tipo') == 'Auto')
                @include('cotizaciones.auto.detalles')
            @elseif ($detalles->getFieldValue('Tipo') == 'Vida')
                @include('cotizaciones.vida.detalles')
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    Aseguradoras disponibles
                </div>

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
                                @foreach ($planes as $plan)
                                    <tr>
                                        @php
                                        $planDetalles = $api->getRecord("Products",$plan->getProduct()->getEntityId())
                                        @endphp

                                        <td>{{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}</td>
                                        <td>{{ $plan->getDescription() }}</td>
                                        <td>RD${{ number_format($plan->getListPrice(), 2) }}</td>
                                        <td>RD${{ number_format($plan->getTaxAmount(), 2) }}</td>
                                        <td>RD${{ number_format($plan->getNetTotal(), 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
