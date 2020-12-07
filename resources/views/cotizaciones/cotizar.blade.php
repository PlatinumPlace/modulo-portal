@extends('portal')

@section('title', 'Cotizar')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form method="POST" action="{{ route($rutapost) }}">
                @csrf

                @if ($tipo == 'auto')
                    @include('cotizaciones.auto.cotizar')
                @elseif ($tipo == 'vida')
                    @include('cotizaciones.vida.cotizar')
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        Cliente (opcional)
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Nombre</label>
                                <input type="text" class="form-control" name="nombre">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Apellido</label>
                                <input type="text" class="form-control" name="apellido">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">RNC/Cédula</label>
                                <input type="text" class="form-control" name="rnc_cedula">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Correo Electrónico</label>
                                <input type="email" class="form-control" name="correo">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Dirección</label>
                                <input type="text" class="form-control" name="direccion">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tel. Celular</label>
                                <input type="tel" class="form-control" name="telefono">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tel. Residencial</label>
                                <input type="tel" class="form-control" name="tel_residencia">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tel. Trabajo</label>
                                <input type="tel" class="form-control" name="tel_trabajo">
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Cotizar</button>
            </form>
        </div>
    </div>

    <br>

@endsection
