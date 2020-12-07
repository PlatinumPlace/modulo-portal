@extends('portal')

@section('title', 'Emitir cotización No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form enctype="multipart/form-data" method="POST" action="{{ route($rutapost) }}">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">
                        Cliente
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Nombre</label>
                                <input required type="text" class="form-control" name="nombre"
                                    value="{{ $detalles->getFieldValue('Nombre') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Apellido</label>
                                <input type="text" class="form-control" name="apellido"
                                    value="{{ $detalles->getFieldValue('Apellido') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">RNC/Cédula</label>
                                <input required type="text" class="form-control" name="rnc_cedula"
                                    value="{{ $detalles->getFieldValue('RNC_C_dula') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" required
                                    value="{{ $detalles->getFieldValue('Fecha_de_nacimiento') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Correo Electrónico</label>
                                <input type="email" class="form-control" name="correo"
                                    value="{{ $detalles->getFieldValue('Correo_electr_nico') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Dirección</label>
                                <input type="text" class="form-control" name="direccion"
                                    value="{{ $detalles->getFieldValue('Direcci_n') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tel. Celular</label>
                                <input type="tel" class="form-control" name="telefono"
                                    value="{{ $detalles->getFieldValue('Tel_Celular') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tel. Residencial</label>
                                <input type="tel" class="form-control" name="tel_residencia"
                                    value="{{ $detalles->getFieldValue('Tel_Residencia') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Tel. Trabajo</label>
                                <input type="tel" class="form-control" name="tel_trabajo"
                                    value="{{ $detalles->getFieldValue('Tel_Trabajo') }}">
                            </div>
                        </div>
                    </div>
                </div>

                @if ($detalles->getFieldValue('Tipo') == 'Auto')
                    @include('cotizaciones.auto.emitir')
                @elseif ($detalles->getFieldValue('Tipo') == 'Vida')
                    @include('cotizaciones.vida.emitir')
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        Emitir con
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Aseguradora</label>
                                <select name="plan" class="form-control" required>
                                    @foreach ($planes as $plan)
                                        @if ($plan->getListPrice() > 0)
                                            @php
                                            $plandetalles= $api->getRecord("Products",$plan->getProduct()->getEntityId());

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

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Documentos</label>
                                <input required type="file" multiple class="form-control-file" name="documentos[]">
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Emitir</button>
            </form>
        </div>
    </div>

    <br>

@endsection
