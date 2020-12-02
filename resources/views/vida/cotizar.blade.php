@extends('portal')

@section('title', 'Cotizar vehiculo')

@section('content')

    <form method="POST" action=" {{ route('cotizacionesVida.store') }}">
        @csrf

        @include('cotizaciones.formularioCliente')

        <br>
        <h5>Para cotizar</h5>
        <hr>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Edad del deudor</label>
                <input type="number" class="form-control" name="edad_deudor" maxlength="2" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Edad del codeudor</label>
                <input type="number" class="form-control" name="edad_codeudor" maxlength="2">
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Plazo (meses)</label>
                <input type="number" class="form-control" name="plazo" maxlength="3" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Cuota Mensual</label>
                <input type="number" class="form-control" name="cuota">
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Plan</label>
                <select name="plan" class="form-control">
                    <option value="Vida" selected>Vida</option>
                    <option value="Vida/desempleo">Vida/Desempleo</option>
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
@endsection
