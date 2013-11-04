<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/*

  Author		Ulises Rodríguez
  Site:			http://www.ulisesrodriguez.com	
  Twitter:		https://twitter.com/#!/isc_ulises
  Facebook:		http://www.facebook.com/ISC.Ulises
  Github:		https://github.com/ulisesrodriguez
  Email:		ing.ulisesrodriguez@gmail.com
  Skype:		systemonlinesoftware
  Location:		Guadalajara Jalisco Mexíco

  	
*/
	
  $field = 'vida';
  
  if( isset( $ramo ) ) $field = $ramo;
  	
?>


<div style="overflow:scroll; width:98%;">
<div class="box">

 <div class="box-content">
	
     <div class="row">     	
        <div class="span1 offset1"><h6>Efectividad</h6></div>
        <div class="span2"><input type="text" style="width:30px;" value="75%" /></div>
        <div class="span2"><h6>Primas promedio</h6></div>
        <div class="span2"><input type="text" id="metas-prima-promedio" value="0" /></div> 
        
        <div class="span2"><input type="button"  id="open_simulator"value="Abrir simulador" class="pull-right btn-save-meta"  /></div>
        <div class="span2"><input type="button" value="Guardar Meta" class="pull-right btn-save-meta"  /></div>        
     </div>
    
     <table class="table table-bordered" style="width:1200px; padding:0px;">
		
        <thead>
        	
            <tr>
            	<th class="bgblank">Mes</th>
                <th class="bglight">Estacionalidad</th>
                <th class="bglight">Solicitudes Meta</th>
                <th class="bglight">Solicitudes Logradas</th>
                <th class="bglight">Negocios Meta</th>
                <th class="bglight">Negocios Logrados</th>
                <th class="bglight">Primas Meta</th>
                <th class="bglight">Primas Logradas</th>
            </tr>
         
         </thead>
            
          <tbody>
             
             <?php 
			 	
				$i=1; $total=0;
				
				$totalgeneral=0;
			 	
				$SolicitudesLogradasTotalTrimestre=0;
				
				$SolicitudesLogradasTotal=0;
				
				$NegociosLogradosTotalTrimestre=0;
			
				$NegociosLogradosTotal=0;
				
				$PrimasLogradosTotalTrimestre=0;
			
				$PrimasLogradosTotal=0;
			
			 ?> 
              
             <?php  if( !empty( $config ) ): foreach( $config as $configs ):?> 
             
             
             <?php 
			 			 
			 if( $field == 'vida' ): 
			 			 	
			 	if( isset( $trimestre ) ):
			 	
					if( $trimestre == 1 ):
						
						if( $configs['id'] >= 1 and $configs['id'] <= 3 );
						
						$total += (int)$configs[$field]; 
						
					endif;	
				
					if( $trimestre == 2 ):
						
						if( $configs['id'] >= 4 and $configs['id'] <= 6 );
						
						$total += (int)$configs[$field]; 
					
					endif;	
					
					if( $trimestre == 3 ):
						
						if( $configs['id'] >= 7 and $configs['id'] <= 9 );
						
						$total += (int)$configs[$field]; 
					
					endif;	
					
					if( $trimestre == 4 ):
						
						if( $configs['id'] >= 10 and $configs['id'] <= 12 );
						
						$total += (int)$configs[$field]; 
					
					endif;	
				
				
				else:
					
					$total += (int)$configs[$field]; 
				
				
			 	endif;
				
											 
			 endif;
			 
			 if( $field == 'gmm' or $field == 'autos' ): 
				
				 if( isset( $cuatrimestre ) ):
					
					
						if( $cuatrimestre == 1 ):
						
							if( $configs['id'] >= 1 and $configs['id'] <= 4 );
							
							$total += (int)$configs[$field]; 
						
						endif;	
					
						if( $cuatrimestre == 2 ):
							
							if( $configs['id'] >= 5 and $configs['id'] <= 8 );
							
							$total += (int)$configs[$field]; 
						
						endif;	
						
						if( $cuatrimestre == 3 ):
							
							if( $configs['id'] >= 9 and $configs['id'] <= 12 );
							
							$total += (int)$configs[$field]; 
							
						endif;	
					
					else:
						
						$total += (int)$configs[$field]; 
								 
					endif;
				
				endif;	
			 
			 ?> 
             
              <tr>
            	<td><?php echo $configs['month']; ?></td>
                <td class="bgestacionalidadlight">
					<?php echo $configs[$field] ?> %
                	<input type="hidden" id="mes-<?php echo $i ?>" name="mes-<?php echo $i ?>" value="<?php echo $configs[$field] ?>" />
                </td>
                <td class="bgyelowlight">
                	
                   <div id="primas-solicitud-meta-text-<?php echo $i ?>" style="text-align: center !important"></div>  
                   <input type="hidden" name="primas-solicitud-meta-<?php echo $i ?>" id="primas-solicitud-meta-<?php echo $i ?>" value="0" />
                
                </td>
                <td class="bgyelowlight">
                	
                   <?php if( $i < 10 ) {
					   		echo $SolicitudesLogradas['0'.$i]; 
							$SolicitudesLogradasTotalTrimestre+=$SolicitudesLogradas['0'.$i]; 
						}else{ 
							echo $SolicitudesLogradas[$i];
							$SolicitudesLogradasTotalTrimestre+=$SolicitudesLogradas[$i]; 
						} ?> 
                    
                </td>
                <td class="bgorangelight">
                	
                   <div id="primas-negocios-meta-text-<?php echo $i ?>" style="text-align: center !important"></div>  
                   <input type="hidden" name="primas-negocios-meta-<?php echo $i ?>" id="primas-negocios-meta-<?php echo $i ?>" value="0" />
                    
                
                </td>
                <td class="bgorangelight">
                	
                    <?php if( $i < 10 ){
							 echo $NegociosLogrados['0'.$i]; 
						  	 $NegociosLogradosTotalTrimestre+=$NegociosLogrados['0'.$i]; 
						  }else{
							  echo $NegociosLogrados[$i]; 
							  $NegociosLogradosTotalTrimestre+=$NegociosLogrados[$i]; 
						  }
					?> 
                    
                </td>
                <td class="bggreenlight">
                	
                    
                    <div id="primas-meta-text-<?php echo $i ?>" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-meta-<?php echo $i ?>" id="primas-meta-<?php echo $i ?>" value="0" />
                
                    
                </td>
                <td class="bggreenlight">
                	
                    <?php if( $i < 10 ){ 
						  	echo $PrimasLogradas['0'.$i]; 
						  	 $PrimasLogradosTotalTrimestre+=$PrimasLogradas['0'.$i]; 
						  }else{ 
						  	echo $PrimasLogradas[$i]; 
						  	 $PrimasLogradosTotalTrimestre+=$PrimasLogradas[$i]; 
						  }?> 
                    
                </td>
                               
            </tr> 
           
           <?php if( $i==3 ): ?>
                
            <tr>
            	<td><b>TOTAL 1er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-primer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-primer" id="primas-solicitud-meta-primer" value="0" />
                    
                </td>
                <td class="bgyelowbold">
                	<?php 
						echo $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotal += $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotalTrimestre=0; 
					?>
                </td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-primer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-primer" id="primas-negocio-meta-primer" value="0" />
                    
                </td>
                <td class="bgorangebold">
                	
                    <?php 
						echo $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotal += $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotalTrimestre=0; 
					?>
                    
                </td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-primer-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-meta-primer" id="primas-meta-primer" value="0" />
                
                </td>
                <td class="bggreenbold">
                	
                    <?php 
						echo $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotal += $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotalTrimestre=0; 
					?>
                    
                </td>                               
            </tr> 
                
           <?php endif; ?>   
           
           <?php if( $i==6 ): ?>
                
            <tr>
            	<td><b>TOTAL 2do <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-segund-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-segund" id="primas-solicitud-meta-segund" value="0" />
                    
                </td>
                <td class="bgyelowbold">
                	
                    <?php 
						echo $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotal += $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotalTrimestre=0; 
					?>
                    
                </td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-segund-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-segund" id="primas-negocio-meta-segund" value="0" />
                    
                </td>
                <td class="bgorangebold">
                	
                    <?php 
						echo $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotal += $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotalTrimestre=0; 
					?>
                    
                </td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-segund-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-segund-primer" id="primas-segund-primer" value="0" />
                
                </td>
                <td class="bggreenbold">
                	
                    <?php 
						echo $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotal += $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotalTrimestre=0; 
					?>
                    
                </td>                              
            </tr> 
                
           <?php endif; ?>    
           
           
           <?php if( $i==9 ): ?>
                
              <tr>
            	<td><b>TOTAL 3er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-tercer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-tercer" id="primas-solicitud-meta-tercer" value="0" />
                    
                </td>
                <td class="bgyelowbold">
                	
                    <?php 
						echo $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotal += $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotalTrimestre=0; 
					?>
                    
                </td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-tercer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-tercer" id="primas-negocio-meta-tercer" value="0" />
                    
                </td>
                <td class="bgorangebold">
                	
                    <?php 
						echo $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotal += $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotalTrimestre=0; 
					?>
                    
                </td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-tercer-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-tercer-primer" id="primas-tercer-primer" value="0" />
                    
                </td>
                <td class="bggreenbold">
                	
                    <?php 
						echo $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotal += $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotalTrimestre=0; 
					?>
                    
                </td>                               
            </tr> 
                
           <?php endif; ?> 
           
           
           <?php if( $i==12 ): ?>
                                
               <tr>
            	<td><b>TOTAL 4to <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-cuarto-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-cuarto" id="primas-solicitud-meta-cuarto" value="0" />
                    
                </td>
                <td class="bgyelowbold">
                	
                    <?php 
						echo $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotal += $SolicitudesLogradasTotalTrimestre; 
						$SolicitudesLogradasTotalTrimestre=0; 
					?>
                    
                </td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocio-meta-cuarto-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocio-meta-cuarto" id="primas-negocio-meta-cuarto" value="0" />
                    
                </td>
                <td class="bgorangebold">
                	
                    <?php 
						echo $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotal += $NegociosLogradosTotalTrimestre; 
						$NegociosLogradosTotalTrimestre=0; 
					?>
                    
                </td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-cuarto-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-cuarto-primer" id="primas-cuarto-primer" value="0" />
                    
                </td>
                <td class="bggreenbold">
                	
                    <?php 
						echo $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotal += $PrimasLogradosTotalTrimestre; 
						$PrimasLogradosTotalTrimestre=0; 
					?>
                    
                </td>                               
            </tr>         
                
           <?php endif; ?>    
             
           <?php $i++; endforeach; endif; ?> 
              
          </tbody>
          
          
           <tr>
            	<td>&nbsp;</td>
                <td class="" style="font-size:18px;">&nbsp;</td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>                               
            </tr>   
        
          <tr>
            	<td><b>TOTAL</b></td>
                <td class="bgestacionalidadbold" style="font-size:18px;"><?php echo $totalgeneral; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-total-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-solicitud-meta-total" id="primas-solicitud-meta-total" value="0" />
                    
                </td>
                <td class="bgyelowbold">
                	<?php echo $SolicitudesLogradasTotal ?>
                </td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocios-meta-total-text" style="text-align: center !important"></div>  
                    <input type="hidden" name="primas-negocios-meta-total" id="primas-negocios-meta-total" value="0" />
                    
                </td>
                <td class="bgorangebold">
                	<?php echo $NegociosLogradosTotal ?>
                </td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-total-text" style="text-align: right !important"></div>  
                    <input type="hidden" name="primas-meta-total" id="primas-meta-total" value="0" />
                    
                </td>
                <td class="bggreenbold">
                	<?php echo $PrimasLogradosTotal ?>
                </td>                               
            </tr> 
        
        
    </table>
</div>
</div>