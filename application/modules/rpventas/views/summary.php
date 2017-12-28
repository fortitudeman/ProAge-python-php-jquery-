<?= form_open('', 'id="ot-form"'); ?>
	<table class="filterstable no-more-tables" style="width: auto">
		<thead>
			<th>Período :<br />
				<?= form_dropdown('periodo', $periodos, $other_filters["periodo"], 'id="periodo" style="width: 175px" title="Período" onchange="this.form.submit();"'); ?>
			</th>
			<th>
				Ramo:<br />
				<?= form_dropdown('ramo', $ramos, $other_filters["ramo"], 'id="ramo" class="filter-field filter-select" onchange="this.form.submit();"') ?>
			</th>
		</thead>
	</table>
<?= form_close(); ?>
<div class="row">
	<div id="AgentsSection" class="printable">
		<h3 class="span12">
			Reporte de ventas
			<div class="opciones">
				<a href="#" class="btn btn-primary toggleTable" data-target="#agentsTable" data-resize="#agentsCell">
					<i class="icon-list-alt"></i>
				</a>
				<button type="button" class="btn btn-primary imprimir">
					<i class="icon-print"></i>
				</button>
				<!-- <a class="btn btn-primary" href="<?= base_url("solicitudes/export/agents") ?>">
					<i class="icon-download-alt"></i>
				</a> -->
			</div>
		</h3>
		<div id="agentsCell" class="span12 chart-container" style="position: relative; width:75vw">
			<canvas id="ventasContainer"></canvas>
		</div>
		<div class="span12 table-container" id="agentsTable" style="display: none;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Mes</th>
						<th><?= $year1 ?></th>
						<th><?= $year2 ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $t1=0;$t2=0; ?>
					<?php foreach ($months as $i => $month): ?>
						<tr>
							<td><?= $month ?></td>
							<td>$<?= number_format($y1[$i], 2) ?></td>
							<td>$<?= number_format($y2[$i], 2) ?></td>
						</tr>
						<?php $t1 += $y1[$i] ?>
						<?php $t2 += $y2[$i] ?>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th>Total</th>
						<th>$<?= number_format($t1, 2) ?></th>
						<th>$<?= number_format($t2, 2) ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="printable">
		<h3 class="span12">
			Tabla Comparativa
			<div class="opciones">
				<button type="button" class="btn btn-primary imprimir">
					<i class="icon-print"></i>
				</button>
				<!-- <a class="btn btn-primary" href="<?= base_url("solicitudes/export/agents") ?>">
					<i class="icon-download-alt"></i>
				</a> -->
			</div>
		</h3>
		<div class="span12 table-container" style="margin-left: 10px;">
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
								<td>
									<?= number_format(($payment*100)/$y1[$i], 2) ?>%
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>