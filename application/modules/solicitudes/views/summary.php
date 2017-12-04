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
	  <div class="row">
	  	<div id="AgentsSection" class=" printable" style="margin-left: 30px;">
		  	<h3 class="span12">
		  		Solicitudes
				<div class="opciones">
					<?php if(!empty($wo_agents) && count($wo_agents) > 1): ?>
						<a href="#" class="btn btn-primary sorter" data-sort-by="<?= $orderhash ?>">
							<i class="fa fa-sort-amount-desc" aria-hidden="true"></i> 
							<span><?= $orderlabel ?></span>
						</a>
					<?php endif; ?>
					<a href="#" class="btn btn-primary toggleTable" data-target="#agentsTable" data-resize="#agentsCell">
						<i class="icon-list-alt"></i>
					</a>
					<button type="button" class="btn btn-primary imprimir">
						<i class="icon-print"></i>
					</button>
					<a class="btn btn-primary" href="<?= base_url("solicitudes/export/agents") ?>">
						<i class="icon-download-alt"></i>
					</a>
			  	</div>
		  	</h3>
	  	  	<div id="agentsCell" class="span12 chart-container" style="height: <?= !empty($wo_agents) ? (ceil(count($wo_agents) / 10)*125)+100 : 250?>px">
		  		<canvas id="agentsContainer"></canvas>
		  	</div>
		  	<div class="span12 table-container" id="agentsTable" style="display: none;">
		  		<table class="table table-striped">
					<thead>
						<tr>
							<th>Agente</th>
							<th>Primas</th>
							<th>Solicitudes</th>
						</tr>
					</thead>
					<tbody>
						<?php $total = 0; ?>
						<?php $totalaux = 0; ?>
						<?php foreach ($wo_agents as $order): ?>
							<tr>
								<td><?= $order["name"] ?></td>
								<td>
									<a href="#" class="popup" data-search="agent" data-value="<?= $order["id"] ?>">
										$<?= number_format($order["prima"],2) ?>
									</a>
								</td>
								<td>
									<a href="#" class="popup" data-search="agent" data-value="<?= $order["id"] ?>">
										<?= $order["conteo"] ?>
									</a>
								</td>
								<?php $total += $order["conteo"] ?>
								<?php $totalaux += $order["prima"] ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th>Total</th>
							<th>$<?= number_format($totalaux, 2) ?></th>
							<th><?= $total ?></th>
						</tr>
					</tfoot>
				</table>
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
					<?php $total = 0; ?>
					<?php foreach ($wo_status as $order): ?>
						<tr>
							<td><?= $order["status"] ?></td>
							<td>
								<a href="#" class="popup" data-search="status" data-value="<?= $order["status"] ?>">
									<?= $order["conteo"] ?>
								</a>	
							</td>
							<?php $total += $order["conteo"] ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th>Total</th>
						<th><?= $total ?></th>
					</tr>
				</tfoot>
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
						<?php $total = 0; ?>
						<?php foreach ($wo_products as $order): ?>
							<tr>
								<td><?= $order["producto"] ?></td>
								<td>
									<a href="#" class="popup" data-search="product" data-value="<?= $order["id"] ?>">
										<?= $order["conteo"] ?>
									</a>	
								</td>
								<?php $total += $order["conteo"] ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th>Total</th>
							<th><?= $total ?></th>
						</tr>
					</tfoot>
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
					<?php $total = 0; ?>
					<?php foreach ($wo_status as $order): ?>
						<tr>
							<td><?= $order["status"] ?></td>
							<td>
								<a href="#" class="popup" data-search="status" data-value="<?= $order["status"] ?>">
									$<?= number_format($order["prima"], 2) ?>
								</a>
							</td>
							<?php $total += $order["prima"]; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th>Total</th>
						<th>$<?= number_format($total, 2) ?></th>
					</tr>
				</tfoot>
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
						<?php $total = 0; ?>
						<?php foreach ($wo_products as $order): ?>
							<tr>
								<td><?= $order["producto"] ?></td>
								<td>
									<a href="#" class="popup" data-search="product" data-value="<?= $order["id"] ?>">
										$<?= number_format($order["prima"], 2) ?>
									</a>
								</td>
								<?php $total += $order["prima"]; ?>
							</tr>
						<?php endforeach; ?>
						<tfoot>
							<tr>
								<th>Total</th>
								<th>$<?= number_format($total, 2) ?></th>
							</tr>
						</tfoot>
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
						<?php $total = 0; ?>
						<?php foreach ($wo_products as $order): ?>
							<tr>
								<td><?= $order["producto"] ?></td>
								<td>
									<a href="#" class="popup" data-search="product" data-value="<?= $order["id"] ?>">
										$<?= number_format($order["avgPrima"], 2) ?>
									</a>
								</td>
								<?php $total += $order["avgPrima"]; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th>Promedio Total</th>
							<th>
								$<?= count($wo_products) > 0 ? number_format($total / count($wo_products), 2) : 0 ?>	
							</th>
						</tr>
					</tfoot>
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
		<?php $this->load->view('solicitudes/reporte_general_table', array("general_data" => $wo_general, "tfoot_class" => "tfoot", "show_tfoot" => 1)); ?>
	</div>
  </div>
</div>