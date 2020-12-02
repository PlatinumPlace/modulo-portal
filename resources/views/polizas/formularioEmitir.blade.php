<br>
<h5>Emitir con</h5>
<hr>
<div class="form-row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Aseguradora</label>
        <select name="plan" class="form-control" required>
            @foreach ($planes as $plan)
                @if ($plan->getListPrice() > 0)
                    @php
                    $plandetalles= $api->getRecord("Products",$plan->getProduct()->getEntityId());

                    $comisionnobe = $plan->getNetTotal() *(
                    $plandetalles->getFieldValue('Comisi_n_grupo_nobe') / 100);
                    $comisionintermediario =$plan->getNetTotal() *
                    ($plandetalles->getFieldValue('Comisi_n_intermediario') / 100);
                    $comisionaseguradora = $plan->getNetTotal() *
                    ($plandetalles->getFieldValue('Comisi_n_aseguradora') / 100);
                    $comisioncorredor = $plan->getNetTotal() *
                    ($plandetalles->getFieldValue('Comisi_n_corredor') / 100);

                    $detalles=
                    $plan->getProduct()->getEntityId()
                    . ',' .
                    round($plan->getListPrice(), 2)
                    . ',' .
                    round($plan->getTaxAmount(), 2)
                    . ',' .
                    round($plan->getNetTotal(), 2)
                    . ',' .
                    $plandetalles->getFieldValue('P_liza')
                    . ',' .
                    round($comisionnobe, 2)
                    . ',' .
                    round($comisionintermediario, 2)
                    . ',' .
                    round($comisionaseguradora, 2)
                    . ',' .
                    round($comisioncorredor, 2)
                    . ',' .
                    $plandetalles->getFieldValue('Vendor_Name')->getEntityId()
                    ;
                    @endphp

                    <option value="{{ $detalles }}">
                        {{ $plandetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Documentos</label>
        <input required type="file" multiple class="form-control-file" name="documentos[]">
    </div>
</div>
