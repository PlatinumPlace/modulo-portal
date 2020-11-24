@extends('layouts.portal')

@section('title', 'Cambiar contraseña')

@section('content')

    @if (session()->get('alerta'))
        <div class="alert alert-info" role="alert">{{ session()->get('alerta') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header">
                    Formulario para cambiar de contraseña
                </div>

                <div class="card-body">
                    <form method="POST" action=" {{ url('cambiar') }}">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                            <label class="col-sm-9 col-form-label">
                                {{ session('nombre') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Usuario</label>
                            <label class="col-sm-9 col-form-label">
                                {{ session('usuario') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Contraseña actual</label>
                            <label class="col-sm-9 col-form-label">
                                {{ session('contrase_a') }}
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Nueva contraseña</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="contrase_a">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                &nbsp;
                            </div>

                            <div class="col-sm-6">
                                <button class="btn btn-success btn-block" type="submit">cambiar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
