@extends('portal')

@section('title', 'Cotización No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
        <a href="{{ route('cotizaciones.detalles', $detalles->getEntityId()) }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Volver</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header">
                    Documentos por aseguradora
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Aseguradora</th>
                                    <th>Documentos</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($planes as $plan)
                                    @if ($plan->getListPrice() > 0)
                                        <tr>
                                            @php
                                            $planDetalles =
                                            $api->getRecord("Products",$plan->getProduct()->getEntityId())
                                            @endphp

                                            <td>{{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}</td>
                                            @php
                                            $adjuntos
                                            =$api->getAttachments("Products",$plan->getProduct()->getEntityId(),1,200);
                                            @endphp

                                            @foreach ($adjuntos as $adjunto)
                                                @if ($detalles->getFieldValue('Plan') == 'Vida' and $adjunto->getFileName() == 'vida.pdf')
                                                    <td>
                                                        <a
                                                            href="{{ route('cotizaciones.adjunto', ['planid' => $plan->getProduct()->getEntityId(), 'adjuntoid' => $adjunto->getId()]) }}">Descargar</a>

                                                    </td>
                                                @elseif ($detalles->getFieldValue('Plan') == 'Vida/desempleo' and
                                                    $adjunto->getFileName() == 'desempleo.pdf')
                                                    <td>
                                                        <a
                                                            href="{{ route('cotizaciones.adjunto', ['planid' => $plan->getProduct()->getEntityId(), 'adjuntoid' => $adjunto->getId()]) }}">Descargar</a>
                                                    </td>
                                                @elseif ($detalles->getFieldValue('Tipo') == 'Auto')
                                                    <td>
                                                        <a
                                                            href="{{ route('cotizaciones.adjunto', ['planid' => $plan->getProduct()->getEntityId(), 'adjuntoid' => $adjunto->getId()]) }}">Descargar</a>
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
