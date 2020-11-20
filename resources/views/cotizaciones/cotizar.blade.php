@extends('layouts.portal')

@section('title', 'Cotizar')

@section('content')

    @if ($tipo == 'vehiculo')
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mb-4">
                    <div class="card-header">
                        Formulario para cotizar seguro de full/ley para vehículos de motor
                    </div>

                    <div class="card-body">
                        <form method="POST" action=" {{ url('cotizar/vehiculo') }}">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Marca</label>
                                <div class="col-sm-9">
                                    <select name="marca" class="form-control" id="marca" onchange="modelosAJAX(this)"
                                        required>
                                        <option value="" selected disabled>Selecciona una Marca</option>
                                        @foreach ($marcas as $marca)
                                            <option value="{{ $marca->getEntityId() }}">
                                                {{ strtoupper($marca->getFieldValue('Name')) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Modelo</label>
                                <div class="col-sm-9">
                                    <select name="modelo" class="form-control" id="modelos" required>
                                        <option value="" selected disabled>Selecciona un modelo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Año</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="a_o" maxlength="4" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Uso</label>
                                <div class="col-sm-9">
                                    <select name="uso" class="form-control">
                                        <option value="Privado" selected>Privado</option>
                                        <option value="Publico ">Publico</option>
                                        <option value="Taxi">Taxi</option>
                                        <option value="Rentado">Rentado</option>
                                        <option value="Deportivo">Deportivo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Plan</label>
                                <div class="col-sm-9">
                                    <select name="plan" class="form-control">
                                        <option value="Full" selected>Mensual Full</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Suma Asegurada</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="suma" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    &nbsp;
                                </div>

                                <div class="col-sm-6">
                                    <button class="btn btn-success btn-block" type="submit">Cotizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function modelosAJAX(val) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('ajax/modelos') }}",
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
    @elseif($tipo=="persona")
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mb-4">
                    <div class="card-header">
                        Formulario para cotizar seguro de vida/desempleo
                    </div>

                    <div class="card-body">
                        <form method="POST" action=" {{ url('cotizar/persona') }}">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Edad del deudor</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="edad_deudor" maxlength="2" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Edad del codeudor</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="edad_codeudor" maxlength="2">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Plazo (meses)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="plazo" maxlength="3" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Cuota Mensual</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="cuota">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Plan</label>
                                <div class="col-sm-9">
                                    <select name="plan" class="form-control">
                                        <option value="Vida" selected>Vida</option>
                                        <option value="Vida/desempleo">Desempleo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Suma Asegurada</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="suma" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    &nbsp;
                                </div>

                                <div class="col-sm-6">
                                    <button class="btn btn-success btn-block" type="submit">Cotizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
