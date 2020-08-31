<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización vida</h1>
</div>

<form method="POST" action="<?= constant("url") ?>?page=crear&type=vida">

    <input type="text" value="Plan Vida" hidden name="tipo_plan">

    <h4>Deudor</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-3">
            <label><strong>Nombre</strong></label>

            <input required type="text" class="form-control" name="nombre">
        </div>

        <div class="form-group col-md-3">
            <label><strong>RNC/Cédula</strong></label>

            <input type="text" class="form-control" name="rnc_cedula">
        </div>

        <div class="form-group col-md-3">
            <label><strong>Fecha de Nacimiento</strong></label>

            <input required type="date" class="form-control" name="fecha_nacimiento">
        </div>

        <div class="form-group col-md-3">
            <label><strong>Desempleo</strong></label>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="desempleo">
            </div>
        </div>
    </div>

    <br>
    <h4>Codeudor</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label><strong>Fecha de Nacimiento Codeudor</strong></label>

            <input type="date" class="form-control" name="fecha_codeudor">
        </div>

    </div>

    <br>
    <h4>Plan</h4>
    <hr>
    <div class="form-row">

        <div class="form-group col-md-4">
            <label><strong>Valor Asegurado</strong></label>

            <input required type="number" class="form-control" name="valor">
        </div>

        <div class="form-group col-md-4">
            <label><strong>Plazo en meses</strong></label>

            <input required type="number" class="form-control" name="plazo">
        </div>

        <div class="form-group col-md-4">
            <label><strong>Cuota Mensual</strong></label>

            <input type="number" class="form-control" name="cuota">
        </div>

    </div>

    <br>
    <button type="submit" class="btn btn-success">Crear</button>
    |
    <a href="<?= constant("url") ?>?page=crear" class="btn btn-info">Cancelar</a>

</form>