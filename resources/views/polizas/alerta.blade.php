@if (date("Y-m", strtotime($detalles->getFieldValue("Vigencia_hasta"))) == date('Y-m'))
<div class="alert alert-danger text-center" role="alert">
    <h6 class="alert-heading">
        ¡Atencion, esta poliza vencera en {{ $detalles->getFieldValue('Vigencia_hasta') }}!
    </h6>
</div>
@endif
