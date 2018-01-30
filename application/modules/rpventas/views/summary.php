<?= form_open('', 'id="ot-form"'); ?>
	<table class="filterstable no-more-tables" style="width: auto">
		<thead>
			<th>Período :<br />
				<?= form_dropdown('periodo', $periodos, $other_filters["periodo"], 'id="periodo" style="width: 175px" title="Período" onchange="this.form.submit();"'); ?>
			</th>
			<th>Ramo:<br />
				<?= form_dropdown('ramo', $ramos, $other_filters["ramo"], 'id="ramo" class="filter-field filter-select" onchange="this.form.submit();"') ?>
			</th>
			<th>Agentes:<br />
				<?= form_dropdown('agent', $agents, $other_filters["agent"], 'id="agent" class="filter-field filter-select" style="width:250px" onchange="this.form.submit();"') ?>
			</th>
			<th>Producto:<br />
				<?= form_dropdown('product', $products, $other_filters["product"], 'id="product" class="filter-field filter-select" style="width: 150px" onchange="this.form.submit();"') ?>
			</th>
		</thead>
	</table>
<?= form_close(); ?>
<div class="row" id="indicators">
	<?php
		$t1=0;$t2=0;$ny2=0;$py2=0;
		foreach ($months as $i => $month):
			$t1 += $y1[$i];
			$t2 += $y2[$i];
			$ny2 += $negociosy2[$i];
			$py2 += $primasy2[$i];
		endforeach;
		$tt = comparationRatio($t1, $t2);
	?>
	<div class="span3 indicator">
		<span class="title">Pagado <?= $year1 ?></span>
		$<?= number_format($t1, 2); ?>
		<span class="comparative <?= sign($tt) ?>">
			<i class="fa <?= sign($tt ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
			<?= number_format(abs($tt), 2 ) ?>%
		</span>
	</div>
	<div class="span2 indicator">
		<span class="title">Negocios <?= $year1 ?></span>
		<?= number_format($nya, 0); ?>
		<span class="comparative <?= sign($idb) ?>">
			<i class="fa <?= sign($idb ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
			<?= number_format(abs($idb), 2 ) ?>%
		</span>
	</div>
	<div class="span2 indicator">
		<span class="title">Primas <?= $year1 ?></span>
		<?= number_format($pya, 2); ?>
		<span class="comparative <?= sign($idp) ?>">
			<i class="fa <?= sign($idp ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
			<?= number_format(abs($idp), 2 ) ?>%
		</span>
	</div>
	<div class="span3 indicator">
		<span class="title">Agentes Activos <?= $year1 ?></span>
		<?= $naa; ?>
	</div>
	<div class="span2 indicator">
		<span class="title">Negocios pai <?= $year1 ?></span>
		<?= $ngp; ?>
	</div>
</div>
<div class="row">
	<div id="AgentsSection" class="printable">
		<h3 class="span12">
			Reporte de ventas
			<div class="opciones">
				<a href="#" class="btn btn-primary toggleTable" data-target="#agentsTable" data-resize="#agentsCell">
					<i class="icon-list-alt"></i>
				</a>
				<!-- <button type="button" class="btn btn-primary imprimir">
					<i class="icon-print"></i>
				</button> -->
		<?php
			if($access_export_xls):
		?>
				<a class="btn btn-primary" href="<?= base_url("rpventas/exportar/general") ?>">
					<i class="icon-download-alt"></i>
				</a>
		<?php
			endif;
		?>
			</div>
		</h3>
		<div id="agentsCell" class="span12 chart-container" style="position: relative; width:100%; margin-left: 10px">
			<canvas id="ventasContainer"></canvas>
		</div>
		<div class="span12 table-container" id="agentsTable" style="display: none; margin-left: 10px;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Mes</th>
						<th><?= $year1 ?></th>
						<th>Participación sobre la venta anual</th>
						<th>Primas</th>
						<th>Negocios</th>
						<th><?= $year2 ?></th>
						<th>Porcentaje</th>
						<th>Primas</th>
						<th>Negocios</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($months as $i => $month): ?>
						<tr>
							<td><?= $month ?></td>
							<td>$<?= number_format($y1[$i], 2) ?></td>
							<td>
								<?php $tid = comparationRatio($y1[$i], $y2[$i]); ?>
								<span class="comparative <?= sign($tid) ?>">
									<i class="fa <?= sign($tid ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
									<?= number_format(percentageRatio($y1[$i], $t1), 2) ?>%
								</span>
							</td>
							<td>$<?= number_format($primasy1[$i]) ?></td>
							<td><?= $negociosy1[$i] ?></td>
							<td>$<?= number_format($y2[$i], 2) ?></td>
							<td><?= number_format(percentageRatio($y2[$i], $t2), 2) ?>%</td>
							<td>$<?= number_format($primasy2[$i]) ?></td>
							<td><?= $negociosy2[$i] ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th style="text-align: right;">Total: </th>
						<th colspan="2">$<?= number_format($t1, 2) ?></th>
						<th><?= number_format($pya, 2) ?></th>
						<th><?= $nya ?></th>
						<th>$<?= number_format($t2, 2) ?></th>
						<th></th>
						<th><?= number_format($py2, 2) ?></th>
						<th><?= $ny2 ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="span4">
		<div class="printable">
			<h3 class="span12">
				Venta anual por productos
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#productsTableAnual" data-resize="#productsCellAnual">
						<i class="icon-list-alt"></i>
					</a>
					<!-- <button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button> -->
			<?php
				if($access_export_xls):
			?>
					<a class="btn btn-primary" href="<?= base_url("rpventas/exportar/ventasp") ?>">
						<i class="icon-download-alt"></i>
					</a>
			<?php
				endif;
			?>
				</div>
			</h3>
			<div id="productsCellAnual" class="span12 graph-container" style="position: relative; height: 450px;">
				<canvas id="productosContainerAnual"></canvas>
			</div>
			<div id="productsTableAnual" class="span12 table-container" style="margin-left: 10px; display: none">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Producto</th>
							<th>Pagado <?= $year1 ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $total = 0; foreach ($productosAnual as $producto => $cantidad): $total = $total + $cantidad; ?>
							<tr>
								<td><?= $producto ?></td>
								<td style="font-size: 11px;">
									<b>$<?= number_format($cantidad, 2); ?></b>
								</td>
							</tr>
						<?php endforeach; ?>
							<tr>
								<td>Total</td>
								<td style="font-size: 11px;">
									<b>$<?= number_format($total, 2); ?></b>
								</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="printable">
			<h3 class="span12">
				Negocios por producto
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#businessTableAnual" data-resize="#businessCellAnual">
						<i class="icon-list-alt"></i>
					</a>
					<!-- <button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button> -->
			<?php
				if($access_export_xls):
			?>
					<a class="btn btn-primary" href="<?= base_url("rpventas/exportar/negociosp") ?>">
						<i class="icon-download-alt"></i>
					</a>
			<?php
				endif;
			?>
				</div>
			</h3>
			<div id="businessCellAnual" class="span12 graph-container" style="position: relative; height: 450px;">
				<canvas id="businessContainerAnual"></canvas>
			</div>
			<div id="businessTableAnual" class="span12 table-container" style="margin-left: 10px; display: none">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Producto</th>
							<th>Negocios <?= $year1 ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $total = 0; foreach ($negociosp as $key => $negocio): $total = $total + $negocio["cantidad"]; ?>
							<tr>
								<td><?= $negocio["name"] ?></td>
								<td style="font-size: 11px;">
									<b><?= $negocio["cantidad"]; ?></b>
								</td>
							</tr>
						<?php endforeach; ?>
							<tr>
								<td>Total</td>
								<td style="font-size: 11px;">
									<b><?= $total; ?></b>
								</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="printable">
			<h3 class="span12">
				Prima promedio por producto
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#primaTableAnual" data-resize="#primaCellAnual">
						<i class="icon-list-alt"></i>
					</a>
					<!-- <button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button> -->
			<?php
				if($access_export_xls):
			?>
					<a class="btn btn-primary" href="<?= base_url("rpventas/exportar/primapromediop") ?>">
						<i class="icon-download-alt"></i>
					</a>
			<?php
				endif;
			?>
				</div>
			</h3>
			<div id="primaCellAnual" class="span12 graph-container" style="position: relative; height: 450px;">
				<canvas id="primapromedioContainerAnual"></canvas>
			</div>
			<div id="primaTableAnual" class="span12 table-container" style="margin-left: 10px; display: none">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Producto</th>
							<th>Prima promedio <?= $year1 ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($primasp as $key => $prima): ?>
							<tr>
								<td><?= $prima["name"] ?></td>
								<td style="font-size: 11px;">
									<b>$<?= number_format(($prima["prima"]/$prima["negocios"]), 2); ?></b>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="span6">
		<div class="printable">
			<h3 class="span12">
				Ventas de agentes por mes
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#paymentsTableAgents" data-resize="#paymentsCellAgents">
						<i class="icon-list-alt"></i>
					</a>
					<!-- <button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button> -->
			<?php
				if($access_export_xls):
			?>
					<a class="btn btn-primary" href="<?= base_url("rpventas/exportar/ventasam") ?>">
						<i class="icon-download-alt"></i>
					</a>
			<?php
				endif;
			?>
				</div>
			</h3>
			<div id="paymentsCellAgents" class="span12 graph-container" style="position: relative; height: 450px;">
				<canvas id="paymentsContainerAgents"></canvas>
			</div>
			<div id="paymentsTableAgents" class="span12 table-container" style="margin-left: 10px; display: none">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Mes</th>
							<th>Agentes <?= $year1 ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($agentsm as $key => $agent): ?>
							<tr>
								<td><?= $months[$agent["month"]] ?></td>
								<td style="font-size: 11px;">
									<b><?= $agent["agents"]; ?></b>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="printable">
			<h3 class="span12">
				Ventas de agentes por producto
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#paymentsTableAgentsP" data-resize="#paymentsCellAgentsP">
						<i class="icon-list-alt"></i>
					</a>
					<!-- <button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button> -->
			<?php
				if($access_export_xls):
			?>
					<a class="btn btn-primary" href="<?= base_url("rpventas/exportar/ventasap") ?>">
						<i class="icon-download-alt"></i>
					</a>
			<?php
				endif;
			?>
				</div>
			</h3>
			<div id="paymentsCellAgentsP" class="span12 graph-container" style="position: relative; height: 450px;">
				<canvas id="paymentsContainerAgentsP"></canvas>
			</div>
			<div id="paymentsTableAgentsP" class="span12 table-container" style="margin-left: 10px; display: none">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Producto</th>
							<th>Agentes <?= $year1 ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($agentsp as $key => $agent): ?>
							<tr>
								<td><?= $agent["name"] ?></td>
								<td style="font-size: 11px;">
									<b><?= $agent["agents"]; ?></b>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="printable">
		<h3 class="span12">
			Distribución de Ventas por Producto
			<div class="opciones">
				<a href="#" class="btn btn-primary toggleTable" data-target="#productsTable" data-resize="#productsCell">
					<i class="icon-list-alt"></i>
				</a>
				<!-- <button type="button" class="btn btn-primary imprimir">
					<i class="icon-print"></i>
				</button> -->
			<?php
				if($access_export_xls):
			?>
					<a class="btn btn-primary" href="<?= base_url("rpventas/exportar/distribucionmensualp") ?>">
						<i class="icon-download-alt"></i>
					</a>
			<?php
				endif;
			?>
			</div>
		</h3>
		<div id="productsCell" class="span12 chart-container" style="position: relative; width:100%; margin-left: 10px;">
			<canvas id="productsContainer"></canvas>
		</div>
		<div id="productsTable" class="span12 table-container" style="margin-left: 10px; display: none">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Producto</th>
						<?php foreach ($months as $month): ?>
							<th><?= substr($month, 0, 3) ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($productos as $producto): ?>
						<tr>
							<td>
								<?= $producto["name"] ?>
							</td>
							<?php foreach ($producto["payments"] as $i => $payment): ?>
								<td style="font-size: 11px;">
									$<?= number_format($payment, 2) ?> 
									(<?= number_format(percentageRatio($payment, $y1[$i]), 2) ?>%)
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>