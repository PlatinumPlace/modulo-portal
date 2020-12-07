@extends('portal')

@section('title', 'Cotizar')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card-deck">
                <div class="card col-3">
                    <img src="{{ asset('img/auto.png') }}" class="card-img-top">
                    <a class="small text-white  stretched-link" href="{{ route('cotizaciones.cotizar', 'auto') }}"></a>
                    <div class="card-body">
                        <h5 class="card-title text-center">AUTO</h5>
                    </div>
                </div>

                <div class="card col-3">
                    <img src="{{ asset('img/vida.png') }}" class="card-img-top">
                    <a class="small text-white  stretched-link" href="{{ route('cotizaciones.cotizar', 'vida') }}"></a>
                    <div class="card-body">
                        <h5 class="card-title text-center">VIDA/DESEMPLEO</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
