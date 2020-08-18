<?php
if ($_POST) {
    $marca = $api->getRecord("Marcas", $_POST["marca"]);
    $modelo = $api->getRecord("Modelos", $_POST["modelo"]);
    $criterio = "((Socio:equals:" . $_SESSION["usuario"]['empresa_id'] . ") and (Tipo:equals:Auto))";
    $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
    foreach ($contratos as $contrato) {
        $prima = 0;

        if ($_POST["tipo_plan"] == "Ley") {
            $plan = $api->getRecord("Products", $contrato->getFieldValue('Plan')->getEntityId());
            $prima = $plan->getFieldValue('Unit_Price');
        } else {
            $prima = calcular_prima($api, $contrato, $modelo->getFieldValue("Tipo"));
        }

        if ($_POST["facturacion"] == "Mensual") {
            $prima = $prima / 12;
        }

        $prima = verificar_restringido($prima, $plan, $marca, $modelo);

        $plan_seleccionado[] = array(
            "id" => $contrato->getFieldValue('Plan')->getEntityId(),
            "prima" => $prima,
            "cantidad" => 1,
            "descripcion" => $contrato->getFieldValue('Aseguradora')->getLookupLabel(),
            "impuesto" => "ITBIS 16",
            "impuesto_valor" => 16
        );
    }

    $cotizacion["Subject"] = "Plan " . $_POST["facturacion"] . " " . $_POST["tipo_plan"];
    $cotizacion["Quote_Stage"] = "Cotizando";
    $cotizacion["Plan"] = $_POST["tipo_plan"];
    $cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
    $cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
    $cotizacion["Fecha_emisi_n"] = date("Y-m-d");
    $cotizacion["Valid_Till"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
    $cotizacion["Tipo_P_liza"] = "Declarativa";
    $cotizacion["Plan"] = $_POST["tipo_plan"];
    $cotizacion["Valor_Asegurado"] = $_POST["valor"];

    $cotizacion["RNC_C_dula"] = $_POST["rnc_cedula"];
    $cotizacion["Nombre"] = $_POST["nombre"];
    $cotizacion["Apellido"] = $_POST["apellido"];
    $cotizacion["Direcci_n"] = $_POST["direccion"];
    $cotizacion["Tel_Celular"] = $_POST["telefono"];
    $cotizacion["Tel_Residencial"] = $_POST["tel_residencia"];
    $cotizacion["Tel_Trabajo"] = $_POST["tel_trabajo"];
    $cotizacion["Fecha_Nacimiento"] = $_POST["fecha_nacimiento"];
    $cotizacion["Correo"] = $_POST["correo"];

    $cotizacion["A_o_Fabricaci_n"] = $_POST["fabricacion"];
    $cotizacion["Marca"] = $_POST["marca"];
    $cotizacion["Modelo"] = $_POST["modelo"];
    $cotizacion["Uso_Veh_culo"] = $_POST["uso"];
    $cotizacion["Estado_Veh_culo"] = (!empty($_POST["estado"])) ? true : false;
    $cotizacion["Tipo_Veh_culo"] = $modelo->getFieldValue('Tipo');

    $id = $api->createRecords("Quotes", $cotizacion, $plan_seleccionado);
    header("Location:" . constant("url") . "detalles/$id");
    exit();
}
require_once 'views/layout/header.php';
?>
<h1 class="mt-4 text-uppercase text-center">crear cotización auto</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>crear/auto">Crear Auto</a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>crear/auto">

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
                            <input type="date" class="form-control" name="fecha_nacimiento">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Correo Electrónico</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="correo">
                        </div>
                    </div>

                    <br>
                    <h4>Vehículo</h4>
                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Marca</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)" required>
                                <option value="" selected disabled>Selecciona una Marca</option>
                                <?php
                                $marcas = $api->getRecords("Marcas");
                                sort($marcas);
                                foreach ($marcas as $marca) {
                                    echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Modelo</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="modelo" id="modelo" required>
                                <option value="" selected disabled>Selecciona un Modelo</option>
                                <div id="modelo"></div>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Uso</label>
                        <div class="col-sm-9">
                            <select name="uso" class="form-control">
                                <option value="Privado" selected>Privado</option>
                                <option value="Publico">Publico</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Año de fabricación</label>
                        <div class="col-sm-9">
                            <input required type="number" class="form-control" name="fabricacion" maxlength="4">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label font-weight-bold">Estado</div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="estado"> <label class="form-check-label" for="gridCheck1"> Nuevo </label>
                            </div>
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
                        <label class="col-sm-3 col-form-label font-weight-bold">Tipo</label>
                        <div class="col-sm-9">
                            <select name="tipo_plan" class="form-control">
                                <option value="Full" selected>Full</option>
                                <option value="Ley">Ley</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Facturación</label>
                        <div class="col-sm-9">
                            <select name="facturacion" class="form-control">
                                <option value="Mensual" selected>Mensual</option>
                                <option value="Anual">Anual</option>
                            </select>
                        </div>
                    </div>


                    <br>
                    <button type="submit" class="btn btn-primary">Crear</button>
                    | <a href="<?= constant("url") ?>crear" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtener_modelos(val) {
        var url = "<?= constant("url") ?>";
        $.ajax({
            url: url + "helpers/lista_modelos.php",
            type: "POST",
            data: {
                marcas_id: val.value
            },
            success: function(response) {
                document.getElementById("modelo").innerHTML = response;
            }
        });
    }
</script>

<?php require_once 'views/layout/footer.php'; ?>