<?= form_open('', 'id="ot-form"'); ?>
	<table class="filterstable no-more-tables" style="width: auto">
		<thead>
			<th>Período :<br />
				<?php //echo $period_fields ?>
				<select id="periodo_form2" name="periodo2" style="width: 175px" title="Período" onchange="this.form.submit();">
					<option value="<?php echo $selected_period[0]; /*echo $selected_period*/ ?>"><?php echo $selected_period[0]; ?></option>
					<?php
						foreach ($selected_period as $period) {
							if($period == $selected_range){
								$selectag = 'selected';
							}else{
								$selectag = '';
							}
							echo '<option value="'.$period.'" '.$selectag.'>'.$period.'</option>';
						}
					?>
				</select>
				<input type="hidden" value="<?php echo $selected_range ?>" id="periodo" name="query[periodo]" />
			</th>
			<th>
				Ramo:<br />
				<?= form_dropdown('ramo', $ramos, $other_filters["ramo"], 'id="ramo" class="filter-field filter-select" onchange="this.form.submit();"') ?>
			</th>
			<!-- <th>
				Agentes:<br />
				<?php //form_dropdown('agent', $agents, $other_filters["agent"], 'id="agent" class="filter-field filter-select" style="width:250px"') ?>
			</th>
			<th>
				Producto:<br />
				<?php //form_dropdown('product', $products, $other_filters["product"], 'id="product" class="filter-field filter-select" style="width: 150px"') ?>
			</th>
			<th>
				Estatus:<br />
				<?php //form_dropdown('status', $status, $other_filters["status"], 'id="status" class="filter-field filter-select"') ?>
			</th> -->
			<?php //render_custom_filters() ?>
		</thead>
	</table>
<?= form_close(); ?>
<!--
<div class="row" id="indicators">
	<div class="span3 indicator">
		<span class="title">Solicitudes</span>
		<?= $general_indicators["solicitudes"] ?>
		<span class="comparative <?= sign($comparative_indicators["solicitudes"]) ?>">
			<i class="fa <?= sign($comparative_indicators["solicitudes"] ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
			<?= number_format(abs($comparative_indicators["solicitudes"]), 2 ) ?>%
		</span>
	</div>
	<div class="span3 indicator">
		<span class="title">Primas Solicitadas</span>
		$<?= number_format($general_indicators["primas_solicitadas"],2) ?>
		<span class="comparative <?= sign($comparative_indicators["primas_solicitadas"]) ?>">
			<i class="fa <?= sign($comparative_indicators["primas_solicitadas"] ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
			<?= number_format(abs($comparative_indicators["primas_solicitadas"]), 2 ) ?>%
		</span>
	</div>
	<div class="span3 indicator">
		<span class="title">Prima Promedio</span>
		$<?= number_format($general_indicators["prima_promedio"],2) ?>
		<span class="comparative <?= sign($comparative_indicators["prima_promedio"]) ?>">
			<i class="fa <?= sign($comparative_indicators["prima_promedio"] ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
			<?= number_format(abs($comparative_indicators["prima_promedio"]), 2 ) ?>%
		</span>
	</div>
	<div class="span3 indicator">
		<span class="title">Agentes</span>
		<?= $general_indicators["agentes"] ?>
		<span class="comparative <?= sign($comparative_indicators["agentes"]) ?>">
			<i class="fa <?= sign($comparative_indicators["agentes"] ,"fa-arrow-up", "fa-arrow-down", "") ?>"></i>
			<?= number_format(abs($comparative_indicators["agentes"]), 2 ) ?>%
		</span>
	</div>
</div>
-->
<!--
<ul class="nav nav-tabs" id="myTab">
	<li class="<?= printEquals($selected_tab, "reporte", "active") ?>"><a href="#reporte">Reporte general</a></li>
	<li class="<?= printEquals($selected_tab, "graficos", "active") ?>"><a href="#graficos">Estadisticas</a></li>
</ul>
-->
<div class="tab-content">
	<div class="tab-pane <?= printEquals($selected_tab, "graficos", "active") ?>" id="graficos">
		<div class="row">
			<div id="AgentsSection" class=" printable" style="/*margin-left: 30px;*/">
				<h3 class="span12">
					Reporte de ventas
					<div class="opciones">
						<a href="#" class="btn btn-primary sorter" data-sort-by="<?= $orderhash ?>">
							<i class="fa fa-sort-amount-desc" aria-hidden="true"></i> 
							<span><?= $orderlabel ?></span>
						</a>
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
				<!-- <div id="agentsCell" class="span12 chart-container" style="height: <?= !empty($wo_agents) ? (ceil(count($wo_agents) / 10)*125)+100 : 250?>px"> -->
				<div id="agentsCell" class="span12 chart-container" style="position: relative; width:75vw">
					<canvas id="agentsContainer"></canvas>
				</div>
				<div class="span12 table-container" id="agentsTable" style="display: none;">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Mes</th>
								<th>Cantidad</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Enero</td>
								<td>$<?php echo number_format($month_sumarry[0], 2); ?></td>
							</tr>
							<tr>
								<td>Febrero</td>
								<td>$<?php echo number_format($month_sumarry[1], 2); ?></td>
							</tr>
							<tr>
								<td>Marzo</td>
								<td>$<?php echo number_format($month_sumarry[2], 2); ?></td>
							</tr>
							<tr>
								<td>Abril</td>
								<td>$<?php echo number_format($month_sumarry[3], 2); ?></td>
							</tr>
							<tr>
								<td>Mayo</td>
								<td>$<?php echo number_format($month_sumarry[4], 2); ?></td>
							</tr>
							<tr>
								<td>Junio</td>
								<td>$<?php echo number_format($month_sumarry[5], 2); ?></td>
							</tr>
							<tr>
								<td>Julio</td>
								<td>$<?php echo number_format($month_sumarry[6], 2); ?></td>
							</tr>
							<tr>
								<td>Agosto</td>
								<td>$<?php echo number_format($month_sumarry[7], 2); ?></td>
							</tr>
							<tr>
								<td>Septiembre</td>
								<td>$<?php echo number_format($month_sumarry[8], 2); ?></td>
							</tr>
							<tr>
								<td>Octubre</td>
								<td>$<?php echo number_format($month_sumarry[9], 2); ?></td>
							</tr>
							<tr>
								<td>Noviembre</td>
								<td>$<?php echo number_format($month_sumarry[10], 2); ?></td>
							</tr>
							<tr>
								<td>Diciembre</td>
								<td>$<?php echo number_format($month_sumarry[11], 2); ?></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th>Total</th>
								<?php
									$totla=0;
									foreach ($month_sumarry as $val) {
										$totla += $val;
									}
								?>
								<th>$ <?php echo number_format($totla,2); ?></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<?php sort_object($wo_products, "prima"); ?>
		<!--
		<div class="row">
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
		<a class="btn btn-primary" href="<?/*= base_url("solicitudes/export/primaproduct") */?>">
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
		<?php /*$total = 0; */?>
		<?php /*foreach ($wo_products as $order): */?>
		<tr>
		<td><?/*= $order["producto"] */?></td>
		<td>
		<a href="#" class="popup" data-search="product" data-value="<?/*= $order["id"] */?>">
		$<?/*= number_format($order["prima"], 2) */?>
		</a>
		</td>
		<?php /*$total += $order["prima"]; */?>
		</tr>
		<?php /*endforeach; */?>
		<tfoot>
		<tr>
		<th>Total</th>
		<th>$<?/*= number_format($total, 2) */?></th>
		</tr>
		</tfoot>
		</tbody>
		</table>
		</div>
		</div>
		<?php /*
		//Sorting Array by primaAvg
		sort_object($wo_products, "avgPrima");
		*/?>
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
		<a class="btn btn-primary" href="<?/*= base_url("solicitudes/export/primaavgproduct") */?>">
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
		<?php /*$total = 0; */?>
		<?php /*foreach ($wo_products as $order): */?>
		<tr>
		<td><?/*= $order["producto"] */?></td>
		<td>
		<a href="#" class="popup" data-search="product" data-value="<?/*= $order["id"] */?>">
		$<?/*= number_format($order["avgPrima"], 2) */?>
		</a>
		</td>
		<?php /*$total += $order["avgPrima"]; */?>
		</tr>
		<?php /*endforeach; */?>
		</tbody>
		<tfoot>
		<tr>
		<th>Promedio Total</th>
		<th>
		$<?/*= count($wo_products) > 0 ? number_format($total / count($wo_products), 2) : 0 */?>
		</th>
		</tr>
		</tfoot>
		</table>
		</div>
		</div>
		</div>
		-->
		<?php sort_object($wo_products, "conteo"); ?>
		<!--
		<div class="row">
		<div class="span6 printable">
		<h3 class="span12">
		Solicitacion por Generacion
		<div class="opciones">
		<a href="#" class="btn btn-primary toggleTable" data-target="#generationsTable" data-resize="#generationsCell">
		<i class="icon-list-alt"></i>
		</a>
		<button type="button" class="btn btn-primary imprimir">
		<i class="icon-print"></i>
		</button>
		<a class="btn btn-primary" href="<?/*= base_url("solicitudes/export/generations") */?>">
		<i class="icon-download-alt"></i>
		</a>
		</div>
		</h3>
		<div class="span12 graph-container" id="generationsCell" style="height: 450px">
		<canvas id="generationsContainer"></canvas>
		</div>
		<div class="span12 table-container" id="generationsTable" style="display: none">
		<table class="table table-striped" style="margin-left: 30px; height: 350px; overflow-y: auto;">
		<thead>
		<tr>
		<th>GENERACION</th>
		<th>SOLICITUDES</th>
		</tr>
		</thead>
		<tbody>
		<?php /*$total = 0; */?>
		<?php /*foreach ($wo_generations as $order): */?>
		<tr>
		<td><?/*= $order["title"] */?></td>
		<td>
		<?/*= $order["solicitudes"]; */?>
		</td>
		<?php /*$total += $order["solicitudes"]; */?>
		</tr>
		<?php /*endforeach; */?>
		</tbody>
		<tfoot>
		<tr>
		<th>Total</th>
		<th>
		<?/*= $total */?>
		</th>
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
		<a class="btn btn-primary" href="<?/*= base_url("solicitudes/export/products") */?>">
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
		<?php /*$total = 0; */?>
		<?php /*foreach ($wo_products as $order): */?>
		<tr>
		<td><?/*= $order["producto"] */?></td>
		<td>
		<a href="#" class="popup" data-search="product" data-value="<?/*= $order["id"] */?>">
		<?/*= $order["conteo"] */?>
		</a>	
		</td>
		<?php /*$total += $order["conteo"] */?>
		</tr>
		<?php /*endforeach; */?>
		</tbody>
		<tfoot>
		<tr>
		<th>Total</th>
		<th><?/*= $total */?></th>
		</tr>
		</tfoot>
		</table>
		</div>
		</div>
		</div>
		-->
		<?php sort_object($wo_status, "prima"); ?>
		<!--
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
		<a class="btn btn-primary" href="<?/*= base_url("solicitudes/export/primastatus") */?>">
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
		<?php /*$total = 0; */?>
		<?php /*foreach ($wo_status as $order): */?>
		<tr>
		<td><?/*= $order["status"] */?></td>
		<td>
		<a href="#" class="popup" data-search="status" data-value="<?/*= $order["status"] */?>">
		$<?/*= number_format($order["prima"], 2) */?>
		</a>
		</td>
		<?php /*$total += $order["prima"]; */?>
		</tr>
		<?php /*endforeach; */?>
		</tbody>
		<tfoot>
		<tr>
		<th>Total</th>
		<th>$<?/*= number_format($total, 2) */?></th>
		</tr>
		</tfoot>
		</table>
		</div>
		</div>
		-->
		<?php sort_object($wo_status, "conteo"); ?>
		<!--
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
		<a class="btn btn-primary" href="<?/*= base_url("solicitudes/export/status") */?>">
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
		<?php /*$total = 0; */?>
		<?php /*foreach ($wo_status as $order): */?>
		<tr>
		<td><?/*= $order["status"] */?></td>
		<td>
		<a href="#" class="popup" data-search="status" data-value="<?/*= $order["status"] */?>">
		<?/*= $order["conteo"] */?>
		</a>	
		</td>
		<?php /*$total += $order["conteo"] */?>
		</tr>
		<?php /*endforeach; */?>
		</tbody>
		<tfoot>
		<tr>
		<th>Total</th>
		<th><?/*= $total */?></th>
		</tr>
		</tfoot>
		</table>
		</div>
		</div>
		-->
	</div>
</div>
<!--
<div class="tab-pane <?/*= printEquals($selected_tab, "reporte", "active") */?>" id="reporte">
<div class="printable">
<h3 class="span12">
Reporte General
<?php /*if($access_export_xls): */?>
<div class="opciones">
<button type="button" class="btn btn-primary imprimir">
<i class="icon-print"></i>
</button>
<a class="btn btn-primary" href="<?/*= base_url("solicitudes/export/summary") */?>">
<i class="icon-download-alt"></i>
</a>
</div>
<?php /*endif; */?>
</h3>
<?php /*$this->load->view('solicitudes/reporte_general_table', array("general_data" => $wo_general, "tfoot_class" => "tfoot", "show_tfoot" => 1)); */?>
</div>
</div>
-->
</div>