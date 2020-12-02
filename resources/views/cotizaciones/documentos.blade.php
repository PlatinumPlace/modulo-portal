@extends('portal')

@section('title', 'No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    @include('cotizaciones.menu')

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

@endsection
