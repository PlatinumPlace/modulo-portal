@extends('portal')

@section('title', 'No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action=" {{ route('polizaVida.store') }}">
                        @csrf

                        <input type="text" value="{{ $detalles->getEntityId() }}" name="id" hidden>
                        <input type="text" value="{{ $detalles->getFieldValue('Plan') }}" name="plantipo" hidden>
                        <input type="text" value="{{ $detalles->getFieldValue('Edad_codeudor') }}" name="edad_deudor"
                            hidden>
                        <input type="text" value="{{ $detalles->getFieldValue('Edad_deudor') }}" name="edad_codeudor"
                            hidden>
                        <input type="text" value="{{ $detalles->getFieldValue('Cuota') }}" name="cuota" hidden>
                        <input type="text" value="{{ $detalles->getFieldValue('Plazo') }}" name="plazo" hidden>
                        <input type="text" value="{{ $detalles->getFieldValue('Suma_asegurada') }}" name="suma" hidden>

                        <h5>Deudor</h5>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="nombre"
                                    value="{{ $detalles->getFieldValue('Nombre') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="apellido"
                                    value="{{ $detalles->getFieldValue('Apellido') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" name="rnc_cedula"
                                    value="{{ $detalles->getFieldValue('RNC_C_dula') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                            <div class="col-sm-9">
                                <input required type="date" class="form-control" name="fecha_nacimiento"
                                    value="{{ $detalles->getFieldValue('Fecha_de_nacimiento') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="correo"
                                    value="{{ $detalles->getFieldValue('Correo_electr_nico') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="direccion"
                                    value="{{ $detalles->getFieldValue('Direcci_n') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="telefono"
                                    value="{{ $detalles->getFieldValue('Tel_Celular') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="tel_residencia"
                                    value="{{ $detalles->getFieldValue('Tel_Residencia') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="tel_trabajo"
                                    value="{{ $detalles->getFieldValue('Tel_Trabajo') }}">
                            </div>
                        </div>

                        @if ($detalles->getFieldValue('Edad_codeudor'))
                            <h5>Codeudor</h5>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                                <div class="col-sm-9">
                                    <input required type="text" class="form-control" name="nombre_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                                <div class="col-sm-9">
                                    <input required type="text" class="form-control" name="apellido_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">RNC/Cédula</label>
                                <div class="col-sm-9">
                                    <input required type="text" class="form-control" name="rnc_cedula_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                                <div class="col-sm-9">
                                    <input required type="date" class="form-control" name="fecha_nacimiento_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="correo_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Dirección</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="direccion_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Celular</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="telefono_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Residencial</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="tel_residencia_codeudor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Tel. Trabajo</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control" name="tel_trabajo_codeudor">
                                </div>
                            </div>
                        @endif

                        <br>
                        <h5>Emitir con</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documentos</th>
                                        <th>Elegir</th>
                                    </tr>
                                </thead>

                                <tbody>
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

                                            $info=
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

                                            <tr>
                                                @php
                                                $planDetalles =
                                                $api->getRecord("Products",$plan->getProduct()->getEntityId())
                                                @endphp

                                                <td>{{ $planDetalles->getFieldValue('Vendor_Name')->getLookupLabel() }}</td>
                                                @php
                                                $adjuntos
                                                =$api->getAttachments("Products",$plan->getProduct()->getEntityId(),1,1);
                                                @endphp

                                                @foreach ($adjuntos as $adjunto)
                                                    <td>
                                                        <a
                                                            href="{{ route('poliza.adjunto', ['planid' => $plan->getProduct()->getEntityId(), 'adjuntoid' => $adjunto->getId()]) }}">Descargar</a>
                                                    </td>
                                                @endforeach

                                                <td>
                                                    <div class="form-check">
                                                        <input type="radio" name="plan" value="{{ $info }}" required>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <br>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label font-weight-bold">Documentos</label>
                            <div class="col-sm-9">
                                <input required type="file" multiple class="form-control-file" name="documentos[]">
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
