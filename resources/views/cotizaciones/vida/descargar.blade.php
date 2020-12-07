<div class="col-12">
    &nbsp;
</div>

<div class="col-12 d-flex justify-content-center bg-primary text-white">
    <h6>COBERTURAS/PRIMA MENSUAL</h6>
</div>

<div class="col-12 border">
    <div class="row">
        <div class="col-3">
            <div class="card border-0">
                <br>

                <div class="card-body small">
                    <p>
                        <b>Suma Asegurada Vida</b> <br>

                        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
                            <b>Cuota Mensual de Prestamo</b><br>
                        @endif

                        <br> <br>
                        <b>Prima Neta</b> <br>
                        <b>ISC</b> <br>
                        <b>Prima Total</b>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card border-0">
                <br>

                <div class="card-body small">
                    <p>
                        RD${{ number_format($detalles->getFieldValue('Suma_asegurada'), 2) }}<br>

                        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
                            RD${{ number_format($detalles->getFieldValue('Cuota'), 2) }} <br>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @foreach ($planes as $plan)
            @php
            $planDetalles = $api->getRecord("Products",$plan->getProduct()->getEntityId())
            @endphp

            @if ($plan->getListPrice() > 0)
                <div class="col-2">
                    <div class="card border-0">
                        @php
                        $imagen
                        =$api->downloadPhoto("Vendors",$planDetalles->getFieldValue('Vendor_Name')->getEntityId())
                        @endphp

                        <img src="{{ asset('img') . '/' . $imagen }}" height="43" width="90"
                            class="card-img-top">

                        <div class="card-body small">
                            <p>
                                @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
                                    <br>
                                @endif

                                <br> <br>
                                RD$ {{ number_format($plan->getListPrice(), 2) }}<br>
                                RD$ {{ number_format($plan->getTaxAmount(), 2) }} <br>
                                RD$ {{ number_format($plan->getNetTotal(), 2) }} <br>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="col-12">
    &nbsp;
</div>

<div class="col-6 border">
    <h6 class="text-center">Observaciones</h6>
    <ul>
        @if ($detalles->getFieldValue('Cuota') and $detalles->getFieldValue('Plan') == 'Vida/desempleo')
            <li>Pago de desempleo hasta por 6 meses.</li>
        @endif
    </ul>
</div>

<div class="col-6 border">
    <h6 class="text-center">Requisitos del deudor</h6>
    <ul>
        @foreach ($planes as $plan)
            @php
            $planDetalles = $api->getRecord('Products',$plan->getProduct()->getEntityId());
            $lista = $planDetalles->getFieldValue('Requisitos_deudor');
            @endphp

            @if ($plan->getListPrice() > 0)
                <li>
                    <b> {{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}:</b>

                    @foreach ($planDetalles->getFieldValue('Requisitos_deudor') as $requisito)
                        {{ $requisito }}

                        @if ($requisito === end($lista))
                            .
                        @else
                            ,
                        @endif

                    @endforeach
                </li>
            @endif
        @endforeach
    </ul>

    @if ($detalles->getFieldValue('Edad_codeudor'))
        <h6 class="text-center">Requisitos del codeudor</h6>
        <ul>
            @foreach ($planes as $plan)
                @php
                $planDetalles = $api->getRecord('Products',$plan->getProduct()->getEntityId());
                $lista = $planDetalles->getFieldValue('Requisitos_codeudor');
                @endphp

                @if ($plan->getListPrice() > 0)
                    <li>
                        <b> {{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}:</b>

                        @foreach ($planDetalles->getFieldValue('Requisitos_codeudor') as $requisito)
                            {{ $requisito }}

                            @if ($requisito === end($lista))
                                .
                            @else
                                ,
                            @endif

                        @endforeach
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</div>