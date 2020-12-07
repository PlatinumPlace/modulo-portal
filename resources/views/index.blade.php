@extends('portal')

@section('title', 'Panel de control')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
    </div>

    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
        <p>Desde su panel de control podrás ver la infomación necesaria para manejar sus pólizas y cotizaciones.</p>
    </div>

@endsection
