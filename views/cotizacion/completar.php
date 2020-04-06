<h1 class="mt-4">Completar Cotización</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Detalles</li>
    <li class="breadcrumb-item active">Cotización No. <?= $this->trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<form method="POST" class="row" action="<?= constant('url') ?>cotizacion/completar/<?= $this->trato->getEntityId() ?>">
    <div class="col-6">
        &nbsp;
    </div>
    <div class="col-6">
        <a href="<?= constant('url') ?>cotizacion/detalles/<?= $this->trato->getEntityId() ?>" class="btn btn-primary">Detalles</a>|
        <button type="submit" name="submit" class="btn btn-success">Completar</button>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Datos del Cliente</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">RNC/Cédula</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="cedula" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <label class="col-sm-2 col-form-label">Apellido</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="apellido" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Dirección</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="direccion">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Celular</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="telefono">
                    </div>
                    <label class="col-sm-2 col-form-label">Tel. Trabajo</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" name="telefono_1">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tel. Residencial</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="telefono_2">
                    </div>
                    <label class="col-sm-2 col-form-label">Correo Electrónico</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="email">
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
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Datos de Vehículo</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Chasis</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="chasis" required value="<?= $this->trato->getFieldValue('Chasis') ?>">
                    </div>
                    <label class="col-sm-2 col-form-label">Color</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="color" value="<?= $this->trato->getFieldValue('Color') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Uso</label>
                    <div class="col-sm-4">
                        <select name="uso" class="form-control">
                            <option selected value="Privado">Privado</option>
                            <option value="Publico">Público</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Placa</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="placa" value="<?= $this->trato->getFieldValue('Placa') ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">¿Es nuevo?</div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="estado" <?php $retVal = ($this->trato->getFieldValue('Es_nuevo') == true) ? "checked" : ""; ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>