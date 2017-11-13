<div class="row">
	<?= form_open('', 'id="ot-form"'); ?>
		<table class="filterstable">
			<thead>
				<th>Período :<br />
					<?php echo $period_fields ?>
					<select id="periodo_form" name="periodo" style="width: 175px" title="Período">
						  <option value="<?php echo $selected_period ?>"></option>
					</select>
					<input type="hidden" value="<?php echo $selected_period ?>" id="periodo" name="query[periodo]" />
				</th>
				<th>Ramo: <?php echo set_value("ramo") ?><br />
				<?= form_dropdown('ramo', $ramos, $other_filters["ramo"], 'id="ramo" class="filter-field filter-select"') ?>
				</th>
				<?php render_custom_filters() ?>
			</thead>
		</table>
	<?= form_close(); ?>
</div>

<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#graficos">Estadisticas</a></li>
  <li><a href="#reporte">Reporte general</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane active" id="graficos">
  	  <div class="row">
	  	<div class="span12 chart-container" style="height: 1200px">
	  		<canvas id="agentsContainer" style="margin-left: 30px"></canvas>
	  	</div>
	  </div>
	  <div class="row">
		  <div class="span6">
			<div class="span12" id="statusCell" style="height: 450px">
				<canvas id="statusContainer"></canvas>
			</div>
			<div class="span12" id="statusTable" style="display: none">
				<table class="table table-striped" style="margin-left: 30px">
				<thead>
					<tr>
						<th>Estatus</th>
						<th>OT'S</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($wo_status as $order): ?>
						<tr>
							<td><?= $order["status"] ?></td>
							<td><?= $order["conteo"] ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
			<div class="span12" style="margin-left: 30px">
				<a href="#" class="toggleTable" data-target="#statusTable" data-resize="#statusCell">
				<i class="icon-plus"></i>
				<span>Ver tabla</span>
				</a>
			</div>
		  </div>
		  <div class="span6">
			<div class="span12" id="productsCell" style="height: 450px">
				<canvas id="productsContainer"></canvas>
			</div>
			<div class="span12" id="productsTable" style="display: none">
				<table class="table table-striped" style="margin-left: 30px; height: 350px; overflow-y: auto;">
					<thead>
						<tr>
							<th>PRODUCTO</th>
							<th>OT'S</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($wo_products as $order): ?>
							<tr>
								<td><?= $order["producto"] ?></td>
								<td><?= $order["conteo"] ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="span12" style="margin-left: 30px;">
				<a href="#" class="toggleTable" data-target="#productsTable" data-resize="#productsCell">
					<i class="icon-plus"></i>
					<span>Ver tabla</span>
				</a>
			</div>
		 </div>
	 </div>
  </div>
  <div class="tab-pane" id="reporte">
  	<table class="table table-striped" id="tablesorted">
		<thead>
			<tr>
				<th>Número de OT</th>
				<th>Fecha alta</th>
				<th>Agente</th>
				<th>Ramo</th>
				<th>Asegurado</th>
				<th>Estatus</th>
				<th>Prima</th>
				<th>Poliza</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($wo_general as $order): ?>
				<tr>
					<td><?= $order["uid"] ?></td>
					<td><?= $order["creation_date"] ?></td>
					<td><?= $order["name"]." ".$order["lastnames"] ?></td>
					<td><?= $order["ramo"] ?></td>
					<td><?= $order["asegurado"] ?></td>
					<td><?= $order["status"] ?></td>
					<td>$<?= number_format($order["prima"], 2) ?></td>
					<td><?= $order["poliza"] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
  </div>
</div>