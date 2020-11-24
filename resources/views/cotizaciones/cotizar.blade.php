@extends('layouts.portal')

@section('title', 'Cotizar')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                @if ($tipo == 'vehiculo')
                    <div class="card-header">
                        Formulario para cotizar seguros para vehículos
                    </div>

                    <div class="card-body">
                        <form method="POST" action=" {{ url('cotizar/vehiculo') }}">
                            @csrf

                            <h5>Cliente (opcional)</h5>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nombre">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="apellido">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="rnc_cedula">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="fecha_nacimiento">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="correo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="direccion">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="telefono">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="tel_residencia">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="tel_trabajo">
                                </div>
                            </div>

                            <br>
                            <h5>Vehículo</h5>
                            <hr>
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
                                <label class="col-sm-3 col-form-label font-weight-bold">Condiciones</label>
                                <div class="col-sm-9">
                                    <select name="condiciones" class="form-control">
                                        <option value="Nuevo" selected>Nuevo</option>
                                        <option value="Usado ">Usado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Plan</label>
                                <div class="col-sm-9">
                                    <select name="plan" class="form-control">
                                        <option value="Mensual full" selected>Mensual Full</option>
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
                @elseif($tipo=="persona")
                    <div class="card-header">
                        Formulario para cotizar seguro de vida/desempleo
                    </div>

                    <div class="card-body">
                        <form method="POST" action=" {{ url('cotizar/persona') }}">
                            @csrf

                            <h5>Cliente (opcional)</h5>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nombre">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="apellido">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="rnc_cedula">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="correo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="direccion">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="telefono">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="tel_residencia">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="tel_trabajo">
                                </div>
                            </div>


                            <br>
                            <h5>Para cotizar</h5>
                            <hr>
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
                                        <option value="Vida/desempleo">Vida/Desempleo</option>
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
                @endif
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

@endsection
