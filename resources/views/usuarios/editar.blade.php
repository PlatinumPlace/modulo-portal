@extends('portal')

@section('title', 'Cambiar contraseña')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if (session()->get('alerta'))
                <div class="alert alert-info" role="alert">{{ session()->get('alerta') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('usuario.update', session('id')) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Contraseña actual</label>
                            <label class="col-sm-9 col-form-label">
                                <input required type="password" class="form-control" name="contrase_a_vieja">
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Contraseña nueva</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="contrase_a_nueva">
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
