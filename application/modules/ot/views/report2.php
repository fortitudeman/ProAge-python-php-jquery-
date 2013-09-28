<?php
	$iniciales=0;
	$renovacion=0;
	$total=0;
	$totalgeneral=0;
?>
	  


<table  class="sortable altrowstable tablesorter" id="sorter"  style="width:100%;">
<thead>
<tr>
	<th id="table_agents" class="header_manager">Agentes</th>
	<th id="total_negocio" class="header_manager" style="width:70px;">Iniciales </th>
	<th id="total_negocio_pai" class="header_manager" style="width:70px;">Renovación</th>
	<th id="total_primas_pagadas" class="header_manager" style="width:100px;">Totales</th>
</tr>
</thead>




<tbody class="tbody">


<?php  if( !empty( $data ) ): ?>
	<?php  foreach( $data as $value ):  ?>    
	
	<?php
		
		$iniciales += (int)$value['iniciales'];		
		$renovacion +=(int) $value['renovacion'];		
		$total =  (int)$value['iniciales']+(int)$value['renovacion'];
		$totalgeneral += (int)$total;		
	?>

																
<tr>
	<td class=""><div class="text_azulado" id="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></div> 
	
	<div class="info" id="info-<?php echo $value['id'] ?>">
	
	<?php if( !empty( $value['uids'][0]['uid'] ) )echo $value['uids'][0]['uid']. ' - '; else echo 'Sin clave asignada - '; ?>
	
	<?php echo $value['disabled'] .' - '. $value['generacion']. ' - ' ?>
	
	<?php if( $value['connection_date'] != '0000-00-00' and $value['connection_date'] != '' ): ?>
			Conectado <?php echo getFormatDate( $value['connection_date'] ) ?>
	<?php else: ?>
			En proceso de conexión
	<?php endif; ?> 
	
	</div>
	
   </td>
	<td class="celda_gris"><div class="numeros"><?php echo $value['iniciales'] ?></div></td>
	<td class="celda_gris"><div class="numeros"><?php echo $value['renovacion']; ?></div></td>
	<td class="celda_gris"><div class="numeros"><?php echo $total ?></div></td>	
</tr>


									  
	<?php endforeach; ?>                                
<?php endif; ?>  
										 
</tbody>
</table>

<div id="contentFoot" style="width:77% !important;">
<table  class="sortable altrowstable tablesorter" id="Tfoot" style="min-width:100% !important;" >


<tr>
	<td ><div class="text_total">Totales</div></td>
	<td style="width:70px;"><div class="numeros"><?php echo $iniciales?></div>Iniciales</td>
	<td style="width:70px;"><div class="numeros"><?php echo $renovacion?></div> Renovación</td>
	<td style="width:100px;"><div class="numeros"><?php echo $totalgeneral?></div> Totales</td>
</tr>
																

</table>
</div>            
