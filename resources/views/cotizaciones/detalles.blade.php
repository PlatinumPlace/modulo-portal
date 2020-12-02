@extends('portal')

@section('title', 'No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    @include('cotizaciones.menu')

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

        @if ($detalles->getFieldValue('Tipo') == 'Vida')
            @include('vida.detalles.cotizacion')
        @endif
    </div>

    <br>
    <h5>Cliente</h5>
    <hr>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Nombre</label>
            <br>
            <label
                class="label-control">{{ $detalles->getFieldValue('Nombre') . ' ' . $detalles->getFieldValue('Apellido') }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">RNC/Cédula</label>
            <br>
            <label class="label-control">{{ $detalles->getFieldValue('RNC_C_dula') }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Fecha de Nacimiento</label>
            <br>
            <label class="label-control">{{ $detalles->getFieldValue('Fecha_de_nacimiento') }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Correo Electrónico</label>
            <br>
            <label class="label-control">{{ $detalles->getFieldValue('Correo_electr_nico') }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Dirección</label>
            <br>
            <label class="label-control">{{ $detalles->getFieldValue('Direcci_n') }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Tel. Celular</label>
            <br>
            <label class="label-control"> {{ $detalles->getFieldValue('Tel_Celular') }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Tel. Residencial</label>
            <br>
            <label class="label-control">{{ $detalles->getFieldValue('Tel_Residencia') }}</label>
        </div>

        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Tel. Trabajo</label>
            <br>
            <label class="label-control">{{ $detalles->getFieldValue('Tel_Trabajo') }}</label>
        </div>
    </div>


    @if ($detalles->getFieldValue('Tipo') == 'Auto')
        @include('auto.detalles.cotizacion')
    @endif

    <br>
    <h5>Aseguradoras disponibles</h5>
    <hr>
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

@endsection
