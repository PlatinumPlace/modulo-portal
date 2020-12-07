<input type="text" value="{{ $detalles->getEntityId() }}" name="id" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Plan') }}" name="plantipo" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Edad_codeudor') }}" name="edad_deudor" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Edad_deudor') }}" name="edad_codeudor" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Cuota') }}" name="cuota" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Plazo') }}" name="plazo" hidden>
<input type="text" value="{{ $detalles->getFieldValue('Suma_asegurada') }}" name="suma" hidden>

@if ($detalles->getFieldValue('Edad_codeudor'))
    <div class="card mb-4">
        <div class="card-header">
            Codeudor
        </div>

        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Nombre</label>
                    <input required type="text" class="form-control" name="nombre_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Apellido</label>
                    <input required type="text" class="form-control" name="apellido_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">RNC/Cédula</label>
                    <input required type="text" class="form-control" name="rnc_cedula_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Fecha de Nacimiento</label>
                    <input required type="date" class="form-control" name="fecha_nacimiento_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correo_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Dirección</label>
                    <input type="text" class="form-control" name="direccion_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Celular</label>
                    <input type="tel" class="form-control" name="telefono_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Residencial</label>
                    <input type="tel" class="form-control" name="tel_residencia_codeudor">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Tel. Trabajo</label>
                    <input type="tel" class="form-control" name="tel_trabajo_codeudor">
                </div>
            </div>
        </div>
    </div>
@endif
