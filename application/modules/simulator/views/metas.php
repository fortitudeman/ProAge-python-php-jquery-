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
        <div class="span2"><input id="efectividad" type="text" style="width:30px;" value="75%" /></div>
        <div class="span2"><h6>Prima promedio</h6></div>
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
			 	
				if( !empty( $trimestre ) and $cuatrimestre == null ){
					
					if( $trimestre == 1 ) $i=1; 
					if( $trimestre == 2 ) $i=4; 
					if( $trimestre == 3 ) $i=7; 
					if( $trimestre == 4 ) $i=10; 
					
				}
				
				
				if( !empty( $cuatrimestre ) and $trimestre == null ){
					
					if( $cuatrimestre == 1 ) $i=1; 
					if( $cuatrimestre == 2 ) $i=5; 
					if( $cuatrimestre == 3 ) $i=9; 
					
				}
				
				if( $trimestre == null and $cuatrimestre == null ) $i=1;
								
				$total=0;
				
				$totalgeneral=0;
			 	
				$SolicitudesLogradasTotalTrimestre=0;
				
				$SolicitudesLogradasTotal=0;
				
				$NegociosLogradosTotalTrimestre=0;
			
				$NegociosLogradosTotal=0;
				
				$PrimasLogradosTotalTrimestre=0;
			
				$PrimasLogradosTotal=0;
			
			 ?> 
              
             <?php  if( !empty( $config ) ): foreach( $config as $configs ):?> 
             
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
                	
                    
                    <div id="primas-meta-text-<?php echo $i ?>" style="text-align: right !important" class="primas-meta-selector"></div> 
                    
                    <div id="primas-meta-text-<?php echo $i ?>-field" class="primas-meta"> 
                    	<input type="text" name="primas-meta-<?php echo $i ?>" id="primas-meta-<?php echo $i ?>" value="0" class="primas-meta-field"  />
                	</div>
                    
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
           
           <?php $total += (int)$configs[$field] ?>
           
           
           
           <?php // Space Frst Trimestre and Cuatrimestre ?>
           
           <?php if( $trimestre != null and $periodo == 3 and $i==3 ): ?>
                
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
                    
		   <?php if( $ramo == 'vida' and $periodo == 12 and $i==3 ): ?>
           
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
         	
             <?php if( $cuatrimestre != null and $periodo == 4 and $i==4 ): ?>
                
                <tr>
                    <td><b>TOTAL 1er <br />cuatrimestre</b></td>
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
           
           <?php if( ( $ramo == 'gmm' or $ramo == 'autos' ) and $periodo == 12 and $i==4 ): ?>
           
                <tr>
                    <td><b>TOTAL 1er <br />cuatrimestre</b></td>
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
           
           
           
           
           
           
           
           <?php // Space Second Trimestre and Cuatrimestre ?>
           
           <?php if( $trimestre != null and $periodo == 3 and $i==6 ): ?>
           		
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
           
           <?php if( $ramo == 'vida' and $periodo == 12 and $i==6 ): ?>
           
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
         	
           <?php if( $cuatrimestre != null and $periodo == 4 and $i==8 ): ?>
                
                <tr>
                    <td><b>TOTAL 2do <br />cuatrimestre</b></td>
                    <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                    <td class="bgyelowbold">
                        
                        <div id="primas-solicitud-meta-second-text" style="text-align: center !important"></div>  
                        <input type="hidden" name="primas-solicitud-meta-second" id="primas-solicitud-meta-second" value="0" />
                        
                    </td>
                    <td class="bgyelowbold">
                        <?php 
                            echo $SolicitudesLogradasTotalTrimestre; 
                            $SolicitudesLogradasTotal += $SolicitudesLogradasTotalTrimestre; 
                            $SolicitudesLogradasTotalTrimestre=0; 
                        ?>
                    </td>
                    <td class="bgorangebold">
                        
                        <div id="primas-negocio-meta-second-text" style="text-align: center !important"></div>  
                        <input type="hidden" name="primas-negocio-meta-second" id="primas-negocio-meta-second" value="0" />
                        
                    </td>
                    <td class="bgorangebold">
                        
                        <?php 
                            echo $NegociosLogradosTotalTrimestre; 
                            $NegociosLogradosTotal += $NegociosLogradosTotalTrimestre; 
                            $NegociosLogradosTotalTrimestre=0; 
                        ?>
                        
                    </td>
                    <td class="bggreenbold">
                        
                        <div id="primas-meta-second-text" style="text-align: right !important"></div>  
                        <input type="hidden" name="primas-meta-second" id="primas-meta-second" value="0" />
                    
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
           
           <?php if( ( $ramo == 'gmm' or $ramo == 'autos' ) and $periodo == 12 and $i==8 ): ?>
           
                <tr>
                    <td><b>TOTAL 2do <br />cuatrimestre</b></td>
                    <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                    <td class="bgyelowbold">
                        
                        <div id="primas-solicitud-meta-second-text" style="text-align: center !important"></div>  
                        <input type="hidden" name="primas-solicitud-meta-second" id="primas-solicitud-meta-second" value="0" />
                        
                    </td>
                    <td class="bgyelowbold">
                        <?php 
                            echo $SolicitudesLogradasTotalTrimestre; 
                            $SolicitudesLogradasTotal += $SolicitudesLogradasTotalTrimestre; 
                            $SolicitudesLogradasTotalTrimestre=0; 
                        ?>
                    </td>
                    <td class="bgorangebold">
                        
                        <div id="primas-negocio-meta-second-text" style="text-align: center !important"></div>  
                        <input type="hidden" name="primas-negocio-meta-second" id="primas-negocio-meta-second" value="0" />
                        
                    </td>
                    <td class="bgorangebold">
                        
                        <?php 
                            echo $NegociosLogradosTotalTrimestre; 
                            $NegociosLogradosTotal += $NegociosLogradosTotalTrimestre; 
                            $NegociosLogradosTotalTrimestre=0; 
                        ?>
                        
                    </td>
                    <td class="bggreenbold">
                        
                        <div id="primas-meta-second-text" style="text-align: right !important"></div>  
                        <input type="hidden" name="primas-meta-second" id="primas-meta-second" value="0" />
                    
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
           
           
           
           
           
           
           
           <?php // Space Three Trimestre ?>
                      
           <?php if( $trimestre != null and $i==9 ): ?>
                
              <tr>
            	<td><b>TOTAL 3er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-tercer-text" style="text-align: right !important"></div>  
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
                	
                    <div id="primas-negocio-meta-tercer-text" style="text-align: right !important"></div>  
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
                	
                    <div id="primas-meta-tercer-text" style="text-align: right !important"></div>  
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
           
           <?php if( $ramo == 'vida' and $periodo == 12 and $i==9 ): ?>
                
              <tr>
            	<td><b>TOTAL 3er <br />trimestre</b></td>
                <td class="bgestacionalidadbold"><?php echo $total; $totalgeneral+=$total; $total=0; ?> %</td>
                <td class="bgyelowbold">
                	
                    <div id="primas-solicitud-meta-tercer-text" style="text-align: right !important"></div>  
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
                	
                    <div id="primas-negocio-meta-tercer-text" style="text-align: right !important"></div>  
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
                	
                    <div id="primas-meta-tercer-text" style="text-align: right !important"></div>  
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
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           <?php // Space four Trimestre and three Cuatimestre ?>
                      
           
           <?php if( $trimestre != null and $periodo == 3 and $i==12 ): ?>
                                
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
           
           <?php if( $ramo == 'vida' and $periodo == 12 and $i==12 ): ?>
           
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
           
           
           <?php if( $cuatrimestre != null and $periodo == 4 and $i==12 ): ?>
                
                <tr>
                    <td><b>TOTAL 4to <br />cuatrimestre</b></td>
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
                        
                        <div id="primas-meta-tercer-text" style="text-align: right !important"></div>  
                        <input type="hidden" name="primas-meta-tercer" id="primas-meta-tercer" value="0" />
                    
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
           
           <?php if( ( $ramo == 'gmm' or $ramo == 'autos' ) and $periodo == 12 and $i==12 ): ?>
           
                <tr>
                    <td><b>TOTAL 4to <br />cuatrimestre</b></td>
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
                        
                        <div id="primas-meta-tercer-text" style="text-align: right !important"></div>  
                        <input type="hidden" name="primas-meta-tercer" id="primas-meta-tercer" value="0" />
                    
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
                	
                    <div id="primas-solicitud-meta-total-text" style="text-align: center !important; font-size:18px;"></div>  
                    <input type="hidden" name="primas-solicitud-meta-total" id="primas-solicitud-meta-total" value="0" />
                    
                </td>
                <td class="bgyelowbold">
                	<?php echo $SolicitudesLogradasTotal ?>
                </td>
                <td class="bgorangebold">
                	
                    <div id="primas-negocios-meta-total-text" style="text-align: center !important; font-size:18px;"></div>  
                    <input type="hidden" name="primas-negocios-meta-total" id="primas-negocios-meta-total" value="0" />
                    
                </td>
                <td class="bgorangebold">
                	<?php echo $NegociosLogradosTotal ?>
                </td>
                <td class="bggreenbold">
                	
                    <div id="primas-meta-total-text" style="text-align: right !important; font-size:18px;"></div>  
                    <input type="hidden" name="primas-meta-total" id="primas-meta-total" value="0" />
                    
                </td>
                <td class="bggreenbold">
                	<?php echo $PrimasLogradosTotal ?>
                </td>                               
            </tr> 
        
        
    </table>
</div>
</div>