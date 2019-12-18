<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crear cotizacion</h1>
</div>
<form method="POST" action="index.php?controller=HomeController&action=crear_cotizacion">

    <div class="row">

        <div class="col-lg-6">

            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cliente</h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="Nombre_del_asegurado" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">RNC / Cedula</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="RNC_Cedula_del_asegurado">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Correo</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="Email_del_asegurado">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Telefono</label>
                        <div class="col-sm-10">
                            <input type="phone" class="form-control" name="Telefono_del_asegurado">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Direccion</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="Direcci_n_del_asegurado">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Poliza</h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Plan</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="Plan">
                                <option selected value="Mensual Full">Mensual Full</option>
                                <option value="Anual Full">Anual Full</option>
                                <option value="Mensual Ley">Mensual Ley</option>
                                <option value="Anual Ley">Anual Ley</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="Tipo_de_poliza">
                                <option selected value="Declarativa">Declarativa</option>
                                <option value="Individual">Individual</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Ramo</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="Ramo_de_la_p_liza">
                                <option selected value="Automóvil">Automóvil</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Vehiculo</h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Marca</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="Marca">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Modelo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="Modelo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Año de Fabricacion</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="A_o_de_Fabricacion" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="Tipo_de_vehiculo" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Chasis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="Chasis">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Placa</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="Placa">
                        </div>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="Es_nuevo" value="0">
                        <label class="form-check-label">Es nuevo?</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Valor Asegurado</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="Valor_Asegurado" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Enviar</button>
</form>