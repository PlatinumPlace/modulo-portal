@extends('layouts.portal')

@section('title', 'Emitir No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header">
                    Formulario para emitir
                </div>

                <div class="card-body">
                    <form method="POST" action=" {{ url('cotizar/emitir') . '/' . $detalles->getEntityId() }}">
                        @csrf

                        <h5>Cliente</h5>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="nombre">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="apellido">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="rnc_cedula">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                            <div class="col-sm-9">
                                <input required type="date" class="form-control" name="fecha_nacimiento">
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
                                <input type="tel" class="form-control" name="tel_residencia">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="telefono">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="tel_trabajo">
                            </div>
                        </div>

                        <br>
                        @if ($detalles->getFieldValue('Plan') == 'Full')
                            <h5>Vehículo</h5>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Chasis</label>
                                <div class="col-sm-9">
                                    <input required type="text" class="form-control" name="chasis">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Placa</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="placa">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Color</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="color">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Estado</label>
                                <div class="col-sm-9">
                                    <select name="estado" class="form-control">
                                        <option value="Nuevo" selected>Nuevo</option>
                                        <option value="Usado">Usado</option>
                                    </select>
                                </div>
                            </div>

                        @else

                        @endif

                        <br>
                        <h5>Emitir con</h5>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Aseguradora</label>
                            <div class="col-sm-9">
                                <select name="aseguradoraid" class="form-control" required>
                                    @foreach ($planes as $plan)
                                        @if ($plan->getListPrice() > 0)
                                            @php
                                            $aseguradora= $api->getRecord("Products",$plan->getProduct()->getEntityId())
                                            @endphp

                                            <option value="{{ $aseguradora->getFieldValue('Vendor_Name')->getEntityId() }}">
                                                {{ $aseguradora->getFieldValue('Vendor_Name')->getLookupLabel() }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Cotización Firmada</label>
                            <div class="col-sm-9">
                                <input required type="file" class="form-control-file" name="cotizacion_firmada">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                &nbsp;
                            </div>

                            <div class="col-sm-6">
                                <button class="btn btn-success btn-block" type="submit">Emitir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
