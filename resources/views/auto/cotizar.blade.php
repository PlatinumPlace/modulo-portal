@extends('portal')

@section('title', 'Cotizar vehiculo')

@section('content')

    <form method="POST" action=" {{ route('cotizacionesAuto.store') }}">
        @csrf

        @include('cotizaciones.formularioCliente')

        <br>
        <h5>Vehículo</h5>
        <hr>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Marca</label>
                <select name="marca" class="form-control" id="marca" onchange="modelosAJAX(this)" required>
                    <option value="" selected disabled>Selecciona una Marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->getEntityId() }}">
                            {{ strtoupper($marca->getFieldValue('Name')) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Modelo</label>
                <select name="modelo" class="form-control" id="modelos" required>
                    <option value="" selected disabled>Selecciona un modelo</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Año</label>
                <input type="number" class="form-control" name="a_o" maxlength="4" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Uso</label>
                <select name="uso" class="form-control">
                    <option value="Privado" selected>Privado</option>
                    <option value="Publico ">Publico</option>
                    <option value="Taxi">Taxi</option>
                    <option value="Rentado">Rentado</option>
                    <option value="Deportivo">Deportivo</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Condiciones</label>
                <select name="condiciones" class="form-control">
                    <option value="Nuevo" selected>Nuevo</option>
                    <option value="Usado ">Usado</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Plan</label>
                <select name="plan" class="form-control">
                    <option value="Mensual full" selected>Mensual Full</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Suma Asegurada</label>
                <input type="number" class="form-control" name="suma" required>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Cotizar</button>
    </form>

    <br>

    <script>
        function modelosAJAX(val) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('cotizaciones.modelos') }}",
                type: "POST",
                data: {
                    marcaid: val.value
                },
                success: function(response) {
                    document.getElementById("modelos").innerHTML = response;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

    </script>

@endsection
