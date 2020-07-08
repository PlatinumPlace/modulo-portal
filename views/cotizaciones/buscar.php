<h1 class="mt-4 text-uppercase">
    <?php
    if ($filtro == "pendientes") {
        echo "cotizaciones pendientes";
    } elseif ($filtro == "emisiones_mensuales") {
        echo "emisiones del mes";
    } elseif ($filtro == "vencimientos_mensuales") {
        echo "vencimientos del mes";
    } else {
        echo "buscar cotizaciones";
    }
    ?>
</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item active">Cotizaciones</li>
</ol>
<div class="card mb-4 col-xl-8">
    <div class="card-body">
        <form class="form-inline" method="post" action="<?= constant("url") ?>cotizaciones/buscar">
            <div class="form-group mb-2 mr-sm-2">
                <select class="form-control" name="parametro" required>
                    <option value="No_Cotizaci_n" selected>No. de cotización</option>
                    <option value="RNC_Cedula">RNC/Cédula</option>
                    <option value="Nombre">Nombre</option>
                    <option value="Apellidos">Apellidos</option>
                    <option value="Chasis">Chasis</option>
                </select>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <input type="text" class="form-control" name="busqueda" required>
            </div>
            <div class="form-group mb-2 mr-sm-2">
                <button type="submit" class="btn btn-primary">Buscar</button>
                |
                <a href="<?= constant("url") ?>cotizaciones/buscar/<?= $filtro ?>" class="btn btn-info">Limpiar</a>
            </div>
        </form>
    </div>
</div>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. <br> Cotización</th>
                        <th>Nombre <br> Asegurado</th>
                        <th>Bien <br> Asegurado</th>
                        <th>Suma <br> Asegurada</th>
                        <th>Estado</th>
                        <th>Fecha <br> Cierre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>