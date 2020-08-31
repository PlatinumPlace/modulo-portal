<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2 text-uppercase">panel de control</h1>
</div>

<div class="alert alert-success" role="alert">
	<h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
	<p>Desde su panel de control podrás ver la infomación necesaria manejar
		sus pólizas y cotizaciones.</p>
</div>

<div class="card-deck">

	<div class="card text-white bg-primary mb-5" style="max-width: 18rem;">
		<div class="card-header">Cotizaciones Totales</div>
		<div class="card-body">
			<h5 class="card-title"><?= $resumen["total"] ?></h5>
			<a href="<?= constant("url") ?>?page=buscar" class="stretched-link">
			</a>
		</div>
	</div>

	<div class="card text-white bg-success mb-5" style="max-width: 18rem;">
		<div class="card-header">Emisiones del Mes</div>
		<div class="card-body">
			<h5 class="card-title"><?= $resumen["emisiones"] ?></h5>
			<a href="<?= constant("url") ?>?page=buscar&filter=emisiones_mensuales" class="stretched-link"></a>
		</div>
	</div>

	<div class="card text-white bg-danger mb-5" style="max-width: 18rem;">
		<div class="card-header">Vencimientos del Mes</div>
		<div class="card-body">
			<h5 class="card-title"><?= $resumen["vencimientos"] ?></h5>
			<a href="<?= constant("url") ?>?page=buscar&filter=vencimientos_mensuales" class="stretched-link"></a>
		</div>
	</div>

</div>

<?php if (!empty($resumen["aseguradoras"])) : ?>
	<h4>Pólizas emitidas este mes</h4>

	<table class="table">

		<thead class="thead-dark">
			<tr>
				<th scope="col">Aseguradora</th>
				<th scope="col">Cantidad</th>
			</tr>
		</thead>

		<tbody>
			<?php
			$aseguradoras = array_count_values($resumen["aseguradoras"]);
			foreach ($aseguradoras as $nombre => $cantidad_polizas) {
				echo "<tr>";
				echo "<td>$nombre</td>";
				echo "<td>$cantidad_polizas</td>";
				echo "</tr>";
			}
			?>
		</tbody>

	</table>
<?php endif ?>