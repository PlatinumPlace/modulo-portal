<?php
$cotizaciones = new cotizaciones;

if ($_POST) {
	if (empty($_POST["marca"]) or empty($_POST["modelo"]) or empty($_POST["fabricacion"]) or empty($_POST["valor"])) {
		$alerta = "Debes completar los campos: valor asegurado, marca, modelo y año de fabricación.";
	} else {
		$nuevo_resumen["Deal_Name"] = "Cotización";
		$nuevo_resumen["Stage"] = "Cotizando";
		$nuevo_resumen["Lead_Source"] = "Portal GNB";
		$nuevo_resumen["Tipo_de_poliza"] = $_POST["tipo_poliza"];
		$nuevo_resumen["Plan"] = $_POST["tipo_plan"];
		$nuevo_resumen["Contact_Name"] = $_SESSION["usuario"]['id'];
		$nuevo_resumen["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
		$nuevo_resumen["Fecha_de_emisi_n"] =  date("Y-m-d");
		$nuevo_resumen["Closing_Date"] = date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
		$nuevo_resumen["Type"] = "Auto";
		$nuevo_resumen["Marca"] = $_POST["marca"];
		$nuevo_resumen["Modelo"] = $_POST["modelo"];
		$nuevo_resumen["Valor_Asegurado"] = $_POST["valor"];
		$nuevo_resumen["A_o_de_Fabricacion"] = $_POST["fabricacion"];
		$nuevo_resumen["Uso"] =  $_POST["uso"];
		$nuevo_resumen["Es_nuevo"] = (isset($_POST["nuevo"])) ? true : false;

		$detalles_modelo = $cotizaciones->detalles_modelo($_POST["modelo"]);
		$nuevo_resumen["Tipo_de_Veh_culo"] =  $detalles_modelo->getFieldValue("Tipo");

		$nuevo_resumen_id = $cotizaciones->crear_resumen($nuevo_resumen);

		$contratos = $cotizaciones->lista_contratos();
		foreach ($contratos as $contrato) {
			$prima = 0;

			$plan = $cotizaciones->obtener_plan_ley_full($contrato->getFieldValue('Aseguradora')->getEntityId());
			if (count($plan) > 1) {
				$plan_id = $plan["plan_id"];
				$prima = $plan["prima"];
			} else {
				$plan_id = $plan["plan_id"];
			}

			if (!empty($plan_id)) {
				$tasa = $cotizaciones->obtener_tasa($contrato->getEntityId(), $nuevo_resumen["Tipo_de_Veh_culo"]);
				$recargo = $cotizaciones->obtener_recargo($contrato->getEntityId(), $nuevo_resumen["Tipo_de_Veh_culo"], $tasa);
				$tasa = $tasa + $recargo;

				$prima = $_POST["valor"] * $tasa / 100;
				if ($prima < $contrato->getFieldValue('Prima_M_nima')) {
					$prima = $contrato->getFieldValue('Prima_M_nima');
				}
			}

			$pos = strpos($_POST["tipo_plan"], "Mensual");
			if ($pos !== false and !empty($prima)) {
				$prima = $prima / 12;
			}

			$retringido = $cotizaciones->verificar_vehiculo_retringido($contrato->getEntityId());
			$prima = $prima * $retringido;

			if (in_array($_POST["uso"], $contrato->getFieldValue('Veh_culos_de_uso'))) {
				$prima = 0;
			}

			$comision_aseguradora = $prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100;
			$comision_socio = $prima * $contrato->getFieldValue('Comisi_n_Socio') / 100;

			$nueva_cotizacion["Subject"] = "Plan " . $_POST["tipo_plan"] . " Auto";
			$nueva_cotizacion["Contact_Name"] = $_SESSION["usuario"]['id'];
			$nueva_cotizacion["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
			$nueva_cotizacion["Deal_Name"] = $nuevo_resumen_id;
			$nueva_cotizacion["Aseguradora"] = $contrato->getFieldValue('Aseguradora')->getEntityId();
			$nueva_cotizacion["Contrato"] = $contrato->getEntityId();
			$nueva_cotizacion["Quote_Stage"] = "En espera";
			$nueva_cotizacion["Comisi_n_Aseguradora"] = round($prima * $contrato->getFieldValue('Comisi_n_Aseguradora') / 100, 2);
			$nueva_cotizacion["Comisi_n_Socio"] = round($prima * $contrato->getFieldValue('Comisi_n_Socio') / 100, 2);
			$nueva_cotizacion["Fecha_de_emisi_n"] = date("Y-m-d");
			$nueva_cotizacion["Valid_Till"] =  date("Y-m-d", strtotime(date("Y-m-d") . "+ 10 days"));
			$nueva_cotizacion["Valor_Asegurado"] = $_POST["valor"];
			$nueva_cotizacion_id = $cotizaciones->crear_cotizacion($nueva_cotizacion, $plan_id, $prima);
		}

		header("Location:" . constant("url") . "auto/detalles/$nuevo_resumen_id");
		exit();
	}
}

require_once 'pages/layout/header_main.php';
?>
<h1 class="mt-4 text-uppercase">crear cotización</h1>
<ol class="breadcrumb mb-4">
	<li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
	<li class="breadcrumb-item active">Crear</li>
</ol>
<div class="row justify-content-center">
	<div class="col-lg-10">
		<?php if (isset($alerta)) : ?>
			<div class="alert alert-primary" role="alert">
				<?= $alerta ?>
			</div>
		<?php endif ?>
		<div class="card mb-4">
			<div class="card-body">
				<button onclick="auto()" class="btn btn-primary">Para Auto</button>
			</div>
		</div>
		<div class="card mb-4">
			<div class="card-body">
				<form method="POST" action="<?= constant("url") ?>cotizaciones/crear">
					<div id="auto" style="display: none;">
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-groups">
									<label class="font-weight-bold">Marca</label> <select class="form-control" name="marca" id="marca" onchange="obtener_modelos(this)">
										<option value="" selected disabled>Selecciona una Marca</option>
										<?php
										$num_pagina = 1;
										do {
											$lista_marcas = $cotizaciones->lista_marcas($num_pagina);
											if (!empty($lista_marcas)) {
												$num_pagina++;
												sort($lista_marcas);
												foreach ($lista_marcas as $marca) {
													echo '<option value="' . $marca->getEntityId() . '">' . strtoupper($marca->getFieldValue("Name")) . '</option>';
												}
											} else {
												$num_pagina = 0;
											}
										} while ($num_pagina > 0);
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-groups">
									<label class="font-weight-bold">Modelo</label> <select class="form-control" name="modelo" id="modelo">
										<option value="" selected disabled>Selecciona un Modelo</option>
										<div id="modelo"></div>
									</select>
								</div>
							</div>
						</div>
						<br>
						<div class="form-row">
							<div class="col-md-6">
								<label class="font-weight-bold">Uso</label> <select name="uso" class="form-control">
									<option value="Privado" selected>Privado</option>
									<option value="Publico">Publico</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="font-weight-bold">&nbsp;</label>
								<div class="form-group form-check">
									<input class="form-check-input" type="checkbox" name="nuevo">
									¿Es nuevo?
								</div>
							</div>
						</div>
						<br>
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-groups">
									<label class="font-weight-bold">Año de fabricación</label> <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" class="form-control" name="fabricacion" value="<?= (isset($_POST["fabricacion"])) ? $_POST["fabricacion"] : null ?>" />
								</div>
							</div>
						</div>
						<br>
					</div>
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-groups">
								<label class="font-weight-bold">Tipo de póliza</label> <select name="tipo_poliza" class="form-control">
									<option selected value="Declarativa">Declarativa</option>
									<option value="Individual">Individual</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-groups">
								<label class="font-weight-bold">Tipo de plan</label> <select name="tipo_plan" class="form-control">
									<option value="Mensual Full" selected>Mensual Full</option>
									<option value="Anual Full">Anual Full</option>
									<option value="Ley">Ley</option>
								</select>
							</div>
						</div>
					</div>
					<br>
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-groups">
								<label class="font-weight-bold">Valor Asegurado</label> <input class="form-control" type="number" name="valor" value="<?= (isset($_POST["valor"])) ? $_POST["valor"] : null ?>" />
							</div>
						</div>
					</div>
					<br>
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-groups">
								<button type="submit" class="btn btn-success">Cotizar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	function auto() {
		if (document.getElementById("auto").style.display == "none") {
			document.getElementById("auto").style.display = "block";
		}
	}

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
<?php require_once 'pages/layout/footer_main.php'; ?>