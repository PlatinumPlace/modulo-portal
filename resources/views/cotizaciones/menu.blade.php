<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('cotizaciones.detalles', $detalles->getEntityId()) }}">No.
        {{ $detalles->getFieldValue('Quote_Number') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cotizaciones.detalles', $detalles->getEntityId()) }}">Ver
                    cotización</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('cotizaciones.descargar', $detalles->getEntityId()) }}">Descargar
                    cotización</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('cotizaciones.documentos', $detalles->getEntityId()) }}">Descargar
                    documentos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('cotizaciones.emitir', $detalles->getEntityId()) }}">Emitir
                    póliza</a>
            </li>
        </ul>
    </div>
</nav>

<br>