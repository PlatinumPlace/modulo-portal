<form method="POST" action="<?= constant('url') ?>cotizaciones/completar_auto/<?= $resumen->getEntityId() ?>">

    <div class="card">
        <div class="card-header">
            <h5>Datos del Cliente</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">RNC/Cédula</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="RNC_Cedula" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Nombre" required>
                </div>
                <label class="col-sm-2 col-form-label">Apellido</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Apellido" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Dirección</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="Direcci_n">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tel. Celular</label>
                <div class="col-sm-4">
                    <input type="tel" class="form-control" name="Telefono">
                </div>
                <label class="col-sm-2 col-form-label">Tel. Trabajo</label>
                <div class="col-sm-4">
                    <input type="tel" class="form-control" name="Tel_Residencia">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tel. Residencial</label>
                <div class="col-sm-4">
                    <input type="tel" class="form-control" name="Tel_Trabajo">
                </div>
                <label class="col-sm-2 col-form-label">Correo Electrónico</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" name="Email" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="Fecha_de_Nacimiento" required>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-header">
            <h5>Datos de Vehículo</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Chasis</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Chasis" required value="<?= $resumen->getFieldValue('Chasis') ?>">
                </div>
                <label class="col-sm-2 col-form-label">Color</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Color" value="<?= $resumen->getFieldValue('Color') ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Placa</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="Placa" value="<?= $resumen->getFieldValue('Placa') ?>">
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="row">

        <div class="col-md-8">
            &nbsp;
        </div>

        <div class="col-md-4">  
            <div class="card">
                <h5 class="card-header">Opciones</h5>
                <div class="card-body">
                    <button type="submit" name="submit" class="btn btn-success">Completar</button>
                </div>
            </div>
        </div>

    </div>
</form>