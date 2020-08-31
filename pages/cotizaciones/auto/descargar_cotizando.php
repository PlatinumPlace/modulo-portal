<style>
	@media print {
		.pie_pagina {
			position: fixed;
			margin: auto;
			height: 100px;
			width: 100%;
			right: 0;
			bottom: 0;
			left: 0;
			z-index: 1030;
		}
	}
</style>

<div class="container">
	<div class="row">

		<div class="col-2">
			<img src="<?= constant("url") ?>public/icons/logo.png" width="100" height="100">
		</div>

		<div class="col-8">
			<h4 class="text-uppercase text-center">
				cotización <br> seguro vehí­culo de motor <br>
				<?= $cotizacion->getFieldValue('Subject') ?>
			</h4>
		</div>

		<div class="col-2">
			<b>Fecha</b> <br> <?= $cotizacion->getFieldValue('Fecha_emisi_n') ?> <br>
			<b>Cotización No.</b> <br> <?= $cotizacion->getFieldValue('Quote_Number') ?> <br>
		</div>

		<div class="col-12 d-flex justify-content-center bg-primary text-white">
			<h6>CLIENTE</h6>
		</div>

		<div class="col-6 border">
			<div class="row">

				<div class="col-4">
					<b>Nombre:</b><br> <b>RNC/Cédula:</b><br> <b>Email:</b><br> <b>Dirección:</b>
				</div>

				<div class="col-8">
					<?php
					echo $cotizacion->getFieldValue('Nombre');
					echo "<br>";
					echo $cotizacion->getFieldValue('RNC_C_dula');
					?>
				</div>

			</div>
		</div>

		<div class="col-6 border">
			<div class="row">

				<div class="col-4">
					<b>Tel. Residencia:</b><br> <b>Tel. Celular:</b><br> <b>Tel.
						Trabajo:</b>
				</div>

				<div class="col-8">&nbsp;</div>

			</div>
		</div>

		<div class="col-12 d-flex justify-content-center bg-primary text-white">
			<h6>VEHICULO</h6>
		</div>

		<div class="col-6 border">
			<div class="row">

				<div class="col-4">
					<b>Marca:</b><br> <b>Modelo:</b><br> <b>Año:</b><br> <b>Tipo:</b><br>
					<b>Suma Asegurada</b>
				</div>

				<div class="col-8">
					<?php
					echo strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel());
					echo "<br>";
					echo strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel());
					echo "<br>";
					echo $cotizacion->getFieldValue('A_o_Fabricaci_n');
					echo "<br>";
					echo $cotizacion->getFieldValue('Tipo_Veh_culo');
					echo "<br>";
					echo "RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2);
					?>
				</div>

			</div>
		</div>

		<div class="col-6 border">
			<div class="row">

				<div class="col-4">
					<b>Chasis:</b><br> <b>Placa:</b><br> <b>Color:</b><br> <b>Uso:</b><br>
					<b>Condicion:</b>
				</div>

				<div class="col-8">&nbsp;</div>

			</div>
		</div>

		<div class="col-12 d-flex justify-content-center bg-primary text-white">
			<h6>COBERTURAS</h6>
		</div>

		<div class="col-12 border">
			<div class="row">

				<div class="col-4">
					<div class="card border-0">

						<div class="card-body">

							<h6 class="card-title">
								<small><b>DAñOS PROPIOS</b></small>
							</h6>
							<p class="card-text">
								<small> Riesgos comprensivos<br> Riesgos comprensivos
									(Deducible)<br> Rotura de Cristales (Deducible)<br> Colisión y
									vuelco<br> Incendio y robo
								</small>
							</p>

							<h6 class="card-title">
								<small><b>RESPONSABILIDAD CIVIL</b></small>
							</h6>
							<p class="card-text">
								<small> DaÃ±os Propiedad ajena<br> Lesiones/Muerte 1 Pers<br>
									Lesiones/Muerte más de 1 Pers<br> Lesiones/Muerte 1 pasajero<br>
									Lesiones/Muerte más de 1 pasajero<br>
								</small>
							</p>

							<h6 class="card-title">
								<small><b>RIESGOS CONDUCTOR</b></small>
							</h6>
							<h6 class="card-title">
								<small><b>FIANZA JUDICIAL</b></small>
							</h6>
							<h6 class="card-title">
								<small><b>COBERTURAS ADICIONALES</b></small>
							</h6>

							<p class="card-text">
								<small> Asistencia vial<br> Renta VehÃ­culo<br> Casa del
									conductor/ <br> Centro del Automovilista
								</small>
							</p>

							<h6 class="card-title">
								<small><b>Prima Neta</b></small>
							</h6>
							<h6 class="card-title">
								<small><b>ISC</b></small>
							</h6>
							<h6 class="card-title">
								<small><b>Prima Total</b></small>
							</h6>

						</div>
					</div>
				</div>

				<?php $planes = $cotizacion->getLineItems() ?>
				<?php foreach ($planes as $plan) : ?>
					<?php if ($plan->getNetTotal() > 0) : ?>
						<?php
						$planes_detalles = detalles_registro("Products", $plan->getProduct()->getEntityId());
						$coberturas = detalles_registro("Contratos", $plan->getDescription());
						$imagen_aseguradora = obtener_imagen_registro("Vendors", $planes_detalles->getFieldValue('Vendor_Name')->getEntityId());
						?>
						<div class="col-2">

							<img height="31" width="90" src="<?= constant("url") . $imagen_aseguradora ?>">

							<div class="card border-0">
								<div class="card-body">

									<p class="card-text">
										<small>
											<?php
											$resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Riesgos_comprensivos') / 100);
											?>
											RD$<?= number_format($resultado) ?> <br>
											<?= $coberturas->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
											<?= $coberturas->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
											<?php
											$resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Colisi_n_y_vuelco') / 100);
											?>
											RD$<?= number_format($resultado) ?> <br>
											<?php
											$resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Incendio_y_robo') / 100);
											?>
											RD$<?= number_format($resultado) ?> <br>
										</small>
									</p>

									<h6 class="card-title">&nbsp;</h6>
									<p class="card-text">
										<small>
											RD$<?= number_format($coberturas->getFieldValue('Da_os_Propiedad_ajena')) ?> <br>
											RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_1_Pers')) ?> <br>
											RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers')) ?> <br>
											RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_1_pasajero')) ?> <br>
											RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero')) ?>
										</small>
									</p>

									<h6 class="card-title">
										<small>RD$ <?= number_format($coberturas->getFieldValue('Riesgos_conductor')) ?></small>
									</h6>

									<h6 class="card-title">
										<small>RD$ <?= number_format($coberturas->getFieldValue('Fianza_judicial')) ?></small>
									</h6>

									<h6 class="card-title">&nbsp;</h6>
									<p class="card-text">
										<small>
											<?= ($coberturas->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica" ?><br>
											<?= ($coberturas->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica" ?> <br>
											<?= ($coberturas->getFieldValue('Asistencia_Accidente') != null) ? "Aplica" : "No Aplica" ?> <br><br>
										</small>
									</p>

									<h6 class="card-title">
										<small>RD$<?= number_format($plan->getListPrice(), 2) ?></small>
									</h6>
									<h6 class="card-title">
										<small>RD$<?= number_format($plan->getTaxAmount(), 2) ?></small>
									</h6>
									<h6 class="card-title">
										<small>RD$<?= number_format($plan->getNetTotal(), 2) ?></small>
									</h6>

								</div>
							</div>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>

	</div>

	<div class="row pie_pagina">

		<div class="col-3">
			<p class="text-center">
				_______________________________ <br> Firma Cliente
			</p>
		</div>

		<div class="col-6">
			<p class="text-center">
				_______________________________ <br> Aseguradora Elegida
			</p>
		</div>

		<div class="col-3">
			<p class="text-center">
				_______________________________ <br> Fecha
			</p>
		</div>

	</div>
</div>

<script>
	var time = 500;
	var url = "<?= constant("url") ?>";
	var titulo = "Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?>";
	var id = "<?= $id ?>";
	setTimeout(function() {
		window.document.title = titulo;
		window.print();
		window.location = url + "?page=detalles&id=" + id;
	}, time);
</script>

</body>

</html>