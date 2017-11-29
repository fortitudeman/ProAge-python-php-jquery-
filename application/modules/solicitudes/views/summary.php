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
				<th>Ramo:<br />
				<?= form_dropdown('ramo', $ramos, $other_filters["ramo"], 'id="ramo" class="filter-field filter-select"') ?>
				</th>
				<th>Agentes:<br />
				<?= form_dropdown('agent', $agents, $other_filters["agent"], 'id="agent" class="filter-field filter-select" style="width:250px"') ?>
				</th>
				<th>Producto:<br />
				<?= form_dropdown('product', $products, $other_filters["product"], 'id="product" class="filter-field filter-select" style="width: 150px"') ?>
				</th>
				
				<th>Estatus:<br />
				<?= form_dropdown('status', $status, $other_filters["status"], 'id="status" class="filter-field filter-select"') ?>
				</th>
				<?php render_custom_filters() ?>
			</thead>
		</table>
	<?= form_close(); ?>
</div>

<ul class="nav nav-tabs" id="myTab">
  <li class="<?= printEquals($selected_tab, "graficos", "active") ?>"><a href="#graficos">Estadisticas</a></li>
  <li class="<?= printEquals($selected_tab, "reporte", "active") ?>"><a href="#reporte">Reporte general</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane <?= printEquals($selected_tab, "graficos", "active") ?>" id="graficos">
  	  <?php if(!empty($wo_agents) && count($wo_agents) > 1): ?>
	  	  <div class="row">
	  	  	<div class="span12 opciones" style="margin-top: 10px; margin-left: 30px;">
		  		Ordenar por: 
		  		<?= anchor('#', 'Solicitudes', "class='sorter active' style='display:inline-block; margin-right: 15px' data-sort-by='requests'"); ?>
		  		|
		  		<?= anchor('#', 'Primas', "class='sorter' style='display:inline-block; margin-left: 15px'  data-sort-by='primas'"); ?>
		  	</div>
		  </div>
	  <?php endif; ?>
	  <div class="row">
	  	<div id="AgentsSection" class=" printable" style="margin-left: 30px;">
		  	<h3 class="span12">
		  		Solicitudes
				<div class="opciones">
					<button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button>
					<a class="btn btn-primary" href="<?= base_url("solicitudes/export/agents") ?>">
						<i class="icon-download-alt"></i>
					</a>
			  	</div>
		  	</h3>
	  	  	<div class="span12 chart-container" style="height: <?= !empty($wo_agents) ? (ceil(count($wo_agents) / 10)*125)+100 : 250?>px">
		  		<canvas id="agentsContainer"></canvas>
		  	</div>
	  	</div>
	  </div>
	  <div class="row">
		  <div class="span6 printable">
		  	<h3 class="span12">
		  		OT's por Estatus
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#statusTable" data-resize="#statusCell">
						<i class="icon-list-alt"></i>
					</a>
					<button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button>
					<a class="btn btn-primary" href="<?= base_url("solicitudes/export/status") ?>">
						<i class="icon-download-alt"></i>
					</a>
			  	</div>
		  	</h3>
			<div class="span12 graph-container" id="statusCell" style="height: 450px">
				<canvas id="statusContainer"></canvas>
			</div>
			<div class="span12 table-container" id="statusTable" style="display: none">
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
		  </div>
		  <div class="span6 printable">
		  	<h3 class="span12">
		  		Productos Solicitados
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#productsTable" data-resize="#productsCell">
						<i class="icon-list-alt"></i>
					</a>
					<button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button>
					<a class="btn btn-primary" href="<?= base_url("solicitudes/export/products") ?>">
						<i class="icon-download-alt"></i>
					</a>
			  	</div>
		  	</h3>
			<div class="span12 graph-container" id="productsCell" style="height: 450px">
				<canvas id="productsContainer"></canvas>
			</div>
			<div class="span12 table-container" id="productsTable" style="display: none">
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
		 </div>
	 </div>
	 <?php  
	 	//Sorting Arrays by prima
	 	sort_object($wo_status, "prima");
	 	sort_object($wo_products, "prima");
	 ?>
	 <div class="row">
		  <div class="span6 printable">
		 	<h3 class="span12">
		  		Primas por Estatus
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#statusPrimaTable" data-resize="#statusPrimaCell">
						<i class="icon-list-alt"></i>
					</a>
					<button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button>
					<a class="btn btn-primary" href="<?= base_url("solicitudes/export/primastatus") ?>">
						<i class="icon-download-alt"></i>
					</a>
			  	</div>
		  	</h3>
			<div class="span12 graph-container" id="statusPrimaCell" style="height: 450px">
				<canvas id="statusPrimaContainer"></canvas>
			</div>
			<div class="span12 table-container" id="statusPrimaTable" style="display: none">
				<table class="table table-striped" style="margin-left: 30px">
				<thead>
					<tr>
						<th>Estatus</th>
						<th>PRIMA</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($wo_status as $order): ?>
						<tr>
							<td><?= $order["status"] ?></td>
							<td>$<?= number_format($order["prima"], 2) ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		  </div>
		  <div class="span6 printable">
		  	<h3 class="span12">
		  		Primas por Producto
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#productsPrimaTable" data-resize="#productsPrimaCell">
						<i class="icon-list-alt"></i>
					</a>
					<button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button>
					<a class="btn btn-primary" href="<?= base_url("solicitudes/export/primaproduct") ?>">
						<i class="icon-download-alt"></i>
					</a>
			  	</div>
		  	</h3>
			<div class="span12 graph-container" id="productsPrimaCell" style="height: 450px">
				<canvas id="productsPrimaContainer"></canvas>
			</div>
			<div class="span12 table-container" id="productsPrimaTable" style="display: none">
				<table class="table table-striped" style="margin-left: 30px; height: 350px; overflow-y: auto;">
					<thead>
						<tr>
							<th>PRODUCTO</th>
							<th>PRIMA</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($wo_products as $order): ?>
							<tr>
								<td><?= $order["producto"] ?></td>
								<td>$<?= number_format($order["prima"], 2) ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		 </div>
	 </div>
	 <?php 
	 	//Sorting Array by primaAvg
	 	sort_object($wo_products, "avgPrima");
	 ?>
	 <div class="row">
		  <div class="span6 printable">
		  	<h3 class="span12">
		  		P. Promedio Producto
				<div class="opciones">
					<a href="#" class="btn btn-primary toggleTable" data-target="#productsPrimaAvgTable" data-resize="#productsPrimaAvgCell">
						<i class="icon-list-alt"></i>
					</a>
					<button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button>
					<a class="btn btn-primary" href="<?= base_url("solicitudes/export/primaavgproduct") ?>">
						<i class="icon-download-alt"></i>
					</a>
			  	</div>
		  	</h3>
			<div class="span12 graph-container" id="productsPrimaAvgCell" style="height: 450px">
				<canvas id="productsPrimaAvgContainer"></canvas>
			</div>
			<div class="span12 table-container" id="productsPrimaAvgTable" style="display: none">
				<table class="table table-striped" style="margin-left: 30px; height: 350px; overflow-y: auto;">
					<thead>
						<tr>
							<th>PRODUCTO</th>
							<th>PRIMA PROMEDIO</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($wo_products as $order): ?>
							<tr>
								<td><?= $order["producto"] ?></td>
								<td>$<?= number_format($order["avgPrima"], 2) ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		 </div>
	 </div>
  </div>
  <div class="tab-pane <?= printEquals($selected_tab, "reporte", "active") ?>" id="reporte">
  	<div class="printable">
	  	<h3 class="span12">
			Reporte General
	  		<?php if($access_export_xls): ?>
				  	<div class="opciones">
				  		<button type="button" class="btn btn-primary imprimir">
							<i class="icon-print"></i>
						</button>
						<a class="btn btn-primary" href="<?= base_url("solicitudes/export/summary") ?>">
							<i class="icon-download-alt"></i>
						</a>
				  	</div>
		  	<?php endif; ?>
		</h3>
	  	<table class="table table-striped" id="tablesorted">
			<thead>
				<tr>
					<th style="width: 125px">Número de OT</th>
					<th style="width: 60px">Fecha alta</th>
					<th>Agente</th>
					<th>Ramo</th>
					<th>Asegurado</th>
					<th>Estatus</th>
					<th>Prima</th>
					<th>Poliza</th>
				</tr>
			</thead>
			<tbody>
				<?php $total_primas = 0; ?>
				<?php foreach ($wo_general as $order): ?>
					<tr>
						<td>
							<?= $order["uid"] ?>
							<a href="<?= base_url("ot/ver_ot/".$order["id"]) ?>" target="_blank">
								<i class="icon-eye-open" title="Ver OT <?= $order["uid"]  ?>"></i>
							</a>
						</td>
						<td><?= date("Y-m-d", strtotime($order["creation_date"])) ?></td>
						<td><?= $order["name"]." ".$order["lastnames"] ?></td>
						<td><?= $order["ramo"] ?></td>
						<td><?= $order["asegurado"] ?></td>
						<td><?= $order["status"] ?></td>
						<td>$<?= number_format($order["prima"], 2) ?></td>
						<td><?= $order["poliza"] ?></td>
						<?php $total_primas += $order["prima"] ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot class="tfoot">
				<tr>
					<th class="total">Total</th>
					<th></th>
					<th><?= number_format(count($wo_general), 0) ?>
						<br />
						Solicitudes
					</th>
					<th></th>
					<th></th>
					<th></th>
					<th>$<?= number_format($total_primas,2) ?> 
						<br />
						Primas
					</th>
					<th></th>
				</tr>
			</tfoot>
		</table>
	</div>
  </div>
</div>