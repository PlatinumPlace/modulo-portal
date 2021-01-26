@extends('layouts.app')

@section('title', 'Ingresar')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            @if (session()->has('alerta'))
                <div class="alert alert-danger" role="alert">{{ session('alerta') }} </div>
            @endif

            <div class="text-center">
                <img src="{{ asset('img/logo.png') }}" alt="" width="200" height="200">
            </div>

            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-body">
                    <form action="{{ route('ingresar') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label class="small mb-1">Correo electrónico</label>
                            <input class="form-control py-4" type="email" name="email" required autofocus />
                        </div>

                        <div class="form-group">
                            <label class="small mb-1">Contraseña</label>
                            <input class="form-control py-4" type="password" name="contrase_a" required />
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button class="w-100 btn btn-primary" type="submit">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
