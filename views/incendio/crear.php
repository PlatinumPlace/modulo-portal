<h1 class="mt-4 text-uppercase">crear cotización Incendio</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>cotizaciones/crear">Crear</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>incendio/crear">Incendio</a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>incendio/crear">

                    <h4>Deudor</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Fecha de Nacimiento Deudor</label>
                        <div class="col-sm-9">
                            <input required type="date" class="form-control" name="fecha_deudor">
                        </div>
                    </div>

                    <br>
                    <h4>Plan</h4>
                    <hr>

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

                    <br>
                    <button type="submit" class="btn btn-primary">Crear</button>
                    |
                    <a href="<?= constant("url") ?>cotizaciones/crear" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
</div>