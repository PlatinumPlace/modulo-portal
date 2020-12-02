<h5>Cliente</h5>
<hr>
<div class="form-row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Nombre</label>
        <input required type="text" class="form-control" name="nombre" value="{{ $detalles->getFieldValue('Nombre') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Apellido</label>
        <input type="text" class="form-control" name="apellido" value="{{ $detalles->getFieldValue('Apellido') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">RNC/Cédula</label>
        <input required type="text" class="form-control" name="rnc_cedula" value="{{ $detalles->getFieldValue('RNC_C_dula') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Fecha de Nacimiento</label>
        <input type="date" class="form-control" name="fecha_nacimiento"
           required value="{{ $detalles->getFieldValue('Fecha_de_nacimiento') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Correo Electrónico</label>
        <input type="email" class="form-control" name="correo"
            value="{{ $detalles->getFieldValue('Correo_electr_nico') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Dirección</label>
        <input type="text" class="form-control" name="direccion" value="{{ $detalles->getFieldValue('Direcci_n') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Tel. Celular</label>
        <input type="tel" class="form-control" name="telefono" value="{{ $detalles->getFieldValue('Tel_Celular') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Tel. Residencial</label>
        <input type="tel" class="form-control" name="tel_residencia" value="{{ $detalles->getFieldValue('Tel_Residencia') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Tel. Trabajo</label>
        <input type="tel" class="form-control" name="tel_trabajo" value="{{ $detalles->getFieldValue('Tel_Trabajo') }}">
    </div>
</div>
