<?php
	$total_negocio=0;
	$total_negocio_pai=0;
	$total_primas_pagadas=0;
	$total_negocios_tramite=0;
	$total_primas_tramite=0;
	$total_negocio_pendiente=0;
	$total_primas_pendientes=0;
	$total_negocios_proyectados=0;
	$total_primas_proyectados=0;
?>
	  


<table  class="sortable altrowstable tablesorter" id="sorter"  style="width:100%;">
<thead class="head">
<tr>
	<th id="table_agents" class="header_manager" style="width:auto;">Agentes</th>
	<th id="total_negocio" class="header_manager" style="width:70px;">Negocios Pagados</th>
	<th id="total_negocio_pai" class="header_manager" style="width:70px;">Negocios <br> Pal</th>
	<th id="total_primas_pagadas" class="header_manager" style="width:100px;">Primas Pagadas</th>
	<th id="total_negocios_tramite" class="header_manager" style="width:70px;">Negocios <br> en  Tramite</th>
	<th id="total_primas_tramite" class="header_manager" style="width:100px;">Primas <br> en Tramite</th>
	<th id="total_negocio_pendiente" class="header_manager" style="width:70px;">Negocios Pendientes</th>
	<th id="total_primas_pendientes" class="header_manager" style="width:100px;">Primas <br> Pendientes</th>
	<th id="total_negocios_proyectados" class="header_manager" style="width:70px;">Negocios Proyectados</th>
	<th id="total_primas_proyectados" class="header_manager" style="width:100px;">Primas <br> Proyectadas</th>
</tr>
</thead>




<tbody class="tbody">


<?php  if( !empty( $data ) ): ?>
	<?php  foreach( $data as $value ):  ?>    
	
	<?php
		
		$negocio = 0;
		$prima = 0;
		
		$negocio += (int)$value['negocio'];
		
		$negocio += (int)$value['tramite']['count'];
		
		if( isset( $value['aceptadas']['count'] ) ) 										
		
			$negocio += (int)$value['aceptadas']['count'];										
		
		else 
			
			$negocio += (int)$value['aceptadas'];
		
		
		$prima += (float)$value['prima'];
		$prima += (float)$value['tramite']['prima'];
		
		if( isset( $value['aceptadas']['prima'] ) ) 
			
			$prima += (float)$value['aceptadas']['prima']; 
		
		else 
			
			$prima += (float)$value['aceptadas'];
		
		
		
		if( $value['disabled'] == 1 ) $value['disabled'] = 'Vigente'; else $value['disabled'] = 'Cancelado';
		
		$total_negocio += $value['negocio'];
		
		if( $value['negociopai']  != 0 ) 
			
			$total_negocio_pai += count( $value['negociopai'] ); 
		
		else
			
			$total_negocio_pai += $value['negociopai'];
			
		
		
		$total_primas_pagadas +=$value['prima'];
		$total_negocios_tramite +=$value['tramite']['count'];
		$total_primas_tramite +=  $value['tramite']['prima'];
		
		
		if( isset( $value['aceptadas']['count'] ) ) 
			
			$total_negocio_pendiente +=  $value['aceptadas']['count']; 
		
		else  
			
			$total_negocio_pendiente += $value['aceptadas'];
		
		if( isset( $value['aceptadas']['prima'] ) ) 
			
			$total_primas_pendientes +=  $value['aceptadas']['prima']; 
		
		else  
			
			$total_primas_pendientes += $value['aceptadas'];	
		
		
		
		
		
		$total_negocios_proyectados +=$negocio;
		$total_primas_proyectados +=$prima;
		
		
		
		
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
    
     <a href="javascript:void(0)" class="btn btn-link btn-hide"><i class="icon-arrow-up"></i></a>
	
	</div>
	
   </td>
	<td class="celda_gris"><div class="numeros"><?php echo $value['negocio'] ?></div></td>
	<td class="celda_gris"><div class="numeros"><?php if( $value['negociopai']  != 0 ) echo count( $value['negociopai'] ); else echo $value['negociopai']; ?></div></td>
	<td class="celda_gris"><div class="numeros">$<?php echo $value['prima'] ?></div></td>
	<td class="celda_roja"><div class="numeros"><?php if( isset( $value['tramite']['count'] ) ) echo $value['tramite']['count']; else echo 0; ?></div></td>
	<td class="celda_roja"><div class="numeros">$<?php if( isset( $value['tramite']['prima'] ) ) echo $value['tramite']['prima']; else echo 0; ?></div></td>
	<td class="celda_amarilla"><div class="numeros"><?php if( isset( $value['aceptadas']['count'] ) ) echo  $value['aceptadas']['count']; else  echo $value['aceptadas'] ?></div></td>
	<td class="celda_amarilla"><div class="numeros">$<?php if( isset( $value['aceptadas']['prima'] ) ) echo  $value['aceptadas']['prima']; else  echo $value['aceptadas'] ?></div></td>
	<td class="celda_verde"><div class="numeros"><?php echo $negocio ?></div></td>
	<td class="celda_verde"><div class="numeros">$<?php echo $prima ?></div></td>
</tr>


									  
	<?php endforeach; ?>                                
<?php endif; ?>  
           							 
</tbody>
</table>

<div id="contentFoot" style="width:77% !important;" class="theader">
<table  class="sortable altrowstable tablesorter" id="Tfoot" style="min-width:100% !important;" >
<thead>
<tr>
	<td><div class="text_total">Agentes</div></td>
	<td style="width:70px;"><div class="numeros"></div>Negocios Pagados</td>
	<td style="width:70px;"><div class="numeros"></div>Negocios Pal</td>
	<td style="width:100px;"><div class="numeros"></div>Primas Pagadas</td>
	<td style="width:70px;" class="celda_gris_roja"><div class="numeros"></div> Negocios en <br>  Tramite</td>
	<td style="width:100px;" class="celda_gris_roja"><div class="numeros"></div> En Tramite</td>
	<td style="width:70px;" class="celda_gris_amarilla"><div class="numeros"></div> Negocios Pendientes</td>
	<td style="width:100px;" class="celda_gris_amarilla"><div class="numeros"></div> Pendientes</td>
	<td  style="width:70px;"class="celda_gris_verde"><div class="numeros"></div> Negocios Proyectados</td>
	<td  style="width:100px;"class="celda_gris_verde"><div class="numeros"></div> Proyectadas</td>
</tr>
																
</thead>
</table>
</div>     



<div id="contentFoot" style="width:77% !important;">
<table  class="sortable altrowstable tablesorter" id="Tfoot" style="min-width:100% !important;" >


<tr>
	<td ><div class="text_total">Totales</div></td>
	<td style="width:70px;"><div class="numeros"><?php echo $total_negocio?></div>Negocios Pagados</td>
	<td style="width:70px;"><div class="numeros"><?php echo $total_negocio_pai?></div> Negocios Pal</td>
	<td style="width:100px;"><div class="numeros">$<?php echo $total_primas_pagadas?></div> Pagados</td>
	<td style="width:70px;" class="celda_gris_roja"><div class="numeros"><?php echo $total_negocios_tramite?></div> Negocios en <br>  Tramite</td>
	<td style="width:100px;" class="celda_gris_roja"><div class="numeros">$<?php echo $total_primas_tramite?></div> En Tramite</td>
	<td style="width:70px;" class="celda_gris_amarilla"><div class="numeros"><?php echo $total_negocio_pendiente?></div> Negocios Pendientes</td>
	<td style="width:100px;" class="celda_gris_amarilla"><div class="numeros">$<?php echo $total_primas_pendientes?></div> Pendientes</td>
	<td  style="width:70px;"class="celda_gris_verde"><div class="numeros"><?php echo $total_negocios_proyectados?></div> Negocios Proyectados</td>
	<td  style="width:100px;"class="celda_gris_verde"><div class="numeros">$<?php echo $total_primas_proyectados?></div> Proyectadas</td>
</tr>
																

</table>
</div>            
