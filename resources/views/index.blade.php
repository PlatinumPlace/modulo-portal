@extends('layouts.portal')

@section('title', 'Panel de control')

@section('content')

    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
        <p>Desde su panel de control podrás ver la infomación necesaria para manejar sus pólizas y cotizaciones.</p>
    </div>

    <div class="card-deck">
        <div class="card text-white bg-primary mb-5" style="max-width: 18rem;">
            <div class="card-header">Cotizaciones Totales</div>
            <div class="card-body">
                <h5 class="card-title">{{ $total }}</h5>
                <a href="#" class="stretched-link"> </a>
            </div>
        </div>

        <div class="card text-white bg-success mb-5" style="max-width: 18rem;">
            <div class="card-header">Emisiones del Mes</div>
            <div class="card-body">
                <h5 class="card-title">{{ $emisiones }}</h5>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>

        <div class="card text-white bg-danger mb-5" style="max-width: 18rem;">
            <div class="card-header">Vencimientos del Mes</div>
            <div class="card-body">
                <h5 class="card-title">{{ $vencimientos }}</h5>
                <a href="#" class="stretched-link"></a>
            </div>
        </div>
    </div>

@endsection
