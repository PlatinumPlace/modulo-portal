<h1 class="mt-4 text-uppercase text-center">crear cotización vida/desempleo</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>crear/vida">Crear Vida</a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>crear/vida">

                    <h4>Deudor</h4>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">RNC/cédula</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="rnc_cedula">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Nombre</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" name="nombre">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Apellido</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="apellido">
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

                    <br>
                    <h4>Plan</h4>
                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label font-weight-bold">Desempleo</div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="desempleo">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Valor Asegurado</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" name="valor">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Plazo en meses</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" name="plazo">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Cuota Mensual</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="cuota">
                        </div>
                    </div>

                    <br>
                    <h4>Codeudor</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="fecha_codeudor">
                        </div>
                    </div>


                    <br>
                    <button type="submit" class="btn btn-primary">Crear</button>
                    |
                    <a href="<?= constant("url") ?>crear" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
</div>