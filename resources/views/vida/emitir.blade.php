@extends('portal')

@section('title', 'No. ' . $detalles->getFieldValue('Quote_Number'))

@section('content')

    @include('cotizaciones.menu')

    <form enctype="multipart/form-data" method="POST" action=" {{ route('polizasVida.store') }}">
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

        @include('polizas.formularioCliente')
 
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

        @include('polizas.formularioEmitir')

        <button class="btn btn-success" type="submit">Emitir</button>
    </form>

    <br>

@endsection
