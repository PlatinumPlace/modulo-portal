@extends('layouts.portal')

@section('title', 'No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                @if ($detalles->getFieldValue('Tipo') == 'Vehículo')
                    <div class="card-header">
                        Formulario para emitir seguro de vehículos
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST" action=" {{ url('emitir/vehiculo') }}">
                            @csrf

                            <input type="text" value="{{ $detalles->getEntityId() }}" name="id" hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('Plan') }}" name="plantipo" hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('Marca')->getLookupLabel() }}"
                                name="marca" hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('Modelo')->getLookupLabel() }}"
                                name="modelo" hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('A_o') }}" name="a_o" hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('Tipo_veh_culo') }}" name="modelotipo"
                                hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('Condiciones') }}" name="condiciones"
                                hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('Suma_Asegurada') }}" name="suma" hidden>
                            <input type="text" value="{{ $detalles->getFieldValue('Uso') }}" name="uso" hidden>

                            <h5>Cliente</h5>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                                <div class="col-sm-9">
                                    <input required type="text" class="form-control" name="nombre"
                                        value="{{ $detalles->getFieldValue('Nombre_cliente') }}">
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

                            <br>
                            <h5>Emitir con</h5>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Aseguradora</label>
                                <div class="col-sm-9">
                                    <select name="plan" class="form-control" required>
                                        @foreach ($planes as $plan)
                                            @if ($plan->getListPrice() > 0)
                                                @php
                                                $plandetalles=
                                                $api->getRecord("Products",$plan->getProduct()->getEntityId());

                                                $comisionnobe = $plan->getNetTotal() *(
                                                $plandetalles->getFieldValue('Comisi_n_grupo_nobe') / 100);
                                                $comisionintermediario =$plan->getNetTotal() *
                                                ($plandetalles->getFieldValue('Comisi_n_intermediario') / 100);
                                                $comisionaseguradora = $plan->getNetTotal() *
                                                ($plandetalles->getFieldValue('Comisi_n_aseguradora') / 100);
                                                $comisioncorredor = $plan->getNetTotal() *
                                                ($plandetalles->getFieldValue('Comisi_n_corredor') / 100);

                                                $detalles=
                                                $plan->getProduct()->getEntityId()
                                                . ',' .
                                                round($plan->getListPrice(), 2)
                                                . ',' .
                                                round($plan->getTaxAmount(), 2)
                                                . ',' .
                                                round($plan->getNetTotal(), 2)
                                                . ',' .
                                                $plandetalles->getFieldValue('P_liza')
                                                . ',' .
                                                round($comisionnobe, 2)
                                                . ',' .
                                                round($comisionintermediario, 2)
                                                . ',' .
                                                round($comisionaseguradora, 2)
                                                . ',' .
                                                round($comisioncorredor, 2)
                                                . ',' .
                                                $plandetalles->getFieldValue('Vendor_Name')->getEntityId()
                                                ;
                                                @endphp

                                                <option value="{{ $detalles }}">
                                                    {{ $plandetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Cotización Firmada</label>
                                <div class="col-sm-9">
                                    <input required type="file" class="form-control-file" name="cotizacion">
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
                @elseif ($detalles->getFieldValue('Tipo') == 'Persona')
                    <div class="card-header">
                        Formulario para emitir seguro de vida/desempleo
                    </div>

                    <div class="card-body">
                        <form method="POST" action=" {{ url('emitir') . '/' . $detalles->getEntityId() }}">
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
                @endif
            </div>
        </div>
    </div>

@endsection
