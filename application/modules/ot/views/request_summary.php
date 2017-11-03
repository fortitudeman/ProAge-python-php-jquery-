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
  	<div class="span8">
  		<div id="agentsContainer" style="width: 100%; height: 300px"></div>
  	</div>
  </div>
  <div class="tab-pane" id="reporte">
  	<table class="table table-striped">
		<thead>
			<tr>
				<th>Número de OT</th>
				<th>Fecha alta</th>
				<th>Agente</th>
				<th>Ramo</th>
				<th>Tipo</th>
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
					<td><?= $order["tipo_tramite"] ?></td>
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