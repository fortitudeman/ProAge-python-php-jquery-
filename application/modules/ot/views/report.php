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
?>


<div>
    <ul class="breadcrumb">
       
		
        <li>
            <a href="<?php echo base_url() ?>">Admin</a> <span class="divider">/</span>
        </li>
        <li>
           <a href="<?php echo base_url() ?>ot.html">Orden de trabajo</a> <span class="divider">/</span>
        </li>
               
        <li>
            Reporte
        </li>
    </ul>
</div>

<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2></h2>
            <div class="box-icon">
               <a href="<?php echo base_url() ?>ot/create.html" class="btn btn-round"><i class="icon-plus"></i></a>
            </div>
        </div>
        <div class="box-content">
        
        	
            
            <?php // Show Messages ?>
            
            <?php if( isset( $message['type'] ) ): ?>
               
               
                <?php if( $message['type'] == true ): ?>
                    <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/true.png" width="20" height="20" />
                          <strong>Listo: </strong> <?php  echo $message['message']; // Show Dinamical message Success ?>
                    </div>
                <?php endif; ?>
               
                
                <?php if( $message['type'] == false ): ?>
                    <div class="alert alert-error">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/false.png" width="20" height="20" />
                          <strong>Error: </strong> <?php  echo $message['message']; // Show Dinamical message error ?>
                    </div>
                <?php endif; ?>
            
			
			
			<?php endif; ?>
            
                      
            <div class="row">
            
            	
                 <div class="span11" style="margin-left:40px; width:95%">
                       
                       <!--<div class="main-container" style="overflow:scroll; max-width:100%">-->
                       
                       <div class="main-container">

                                <div class="main  clearfix">
                                        			                                
                                <?php if( !isset( $_POST['query']['ramo'] ) or isset( $_POST['query']['ramo'] ) and  $_POST['query']['ramo'] == 1 ): ?>  
                                 	<a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="vida" style="color:#06F">Vida</a>
                                <?php else: ?>   
                                	<a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="vida">Vida</a>
                                <?php endif; ?>              
                                
                                <?php 	if( isset( $_POST['query']['ramo'] ) and  $_POST['query']['ramo'] == 2 ): ?> 
                                 	<a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="gmm" style="color:#06F">GMM</a>
                                <?php else: ?>   
                               		<a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="gmm">GMM</a>
                                <?php endif; ?>     
                                
                                
                                <?php if( isset( $_POST['query']['ramo'] ) and  $_POST['query']['ramo'] == 3 ): ?> 
                                    <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="autos" style="color:#06F">Autos</a>
                    			<?php else: ?>   
                                	<a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="autos">Autos</a>
                                <?php endif; ?>     
                                
                                
                                <p class="line">&nbsp; </p>
                    			<form id="form" method="post">                      	
                         		 <input type="hidden" name="query[ramo]" id="ramo" value="<?php if( isset( $_POST['query']['ramo'] ) ) echo $_POST['query']['ramo']; else echo 1;  ?>" />
                    
                                <table  class="filterstable" style="width:99%;">
                                <thead>
                                <tr>
                                    <th>
                                            
                                            
                                            <select id="periodo" name="query[periodo]" onchange="this.form.submit();">
                                                <option value="1" <?php if( isset( $_POST['query']['periodo'] ) and  $_POST['query']['periodo'] == 1 ) echo 'selected="selected"'?>>Mes</option>
                                                <?php if( !isset( $_POST['query']['ramo'] ) or isset( $_POST['query']['ramo'] ) and  $_POST['query']['ramo'] == 1 ): ?> 
                                                <option value="2" <?php if( isset( $_POST['query']['periodo'] ) and  $_POST['query']['periodo'] == 2 ) echo 'selected="selected"'?> class="set_periodo">Trimestre</option>
                                                <?php else: ?>
                                                	 <option value="2" <?php if( isset( $_POST['query']['periodo'] ) and  $_POST['query']['periodo'] == 2 ) echo 'selected="selected"'?> class="set_periodo">Cuatrimestre</option>
                                                <?php endif; ?>
                                                <option value="3" <?php if( isset( $_POST['query']['periodo'] ) and  $_POST['query']['periodo'] == 3 ) echo 'selected="selected"'?>>Año</option>
                                              </select>
                                            
                                                                                                                                    
                                            
                                           
                                    </th>
                                    <th>
                                            <input type="hidden" id="gerente_value" value="<?php if( isset( $_POST['query']['gerente'] ) ) echo $_POST['query']['gerente'];  ?>" />
                                            <select id="gerente" name="query[gerente]" class="select" style="width:145px;" onchange="this.form.submit();">
                                                <option value="">Todos los gerentes</option>                                        
                                                <?php if( !empty( $manager ) ): foreach( $manager as $value ): ?>
                                                	
                                                    <?php if( isset( $_POST['query']['gerente'] ) and $_POST['query']['gerente'] == $value['id']  ): ?>
                                                    
                                                    <option selected="selected" value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                    
                                                    <?php else: ?>
                                                    
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                    
                                                    <?php endif; ?>
                                                    
                                                    
                                                <?php endforeach; endif; ?>
                                              </select>
                                           
                                    </th>
                                    <th>
                                            
                                       <select id="agent" name="query[agent]" class="select2"  style="width:140px;" onchange="this.form.submit();">
                                        <option value="" <?php if( isset( $_POST['query']['agent'] ) and  $_POST['query']['agent'] == 1 ) echo 'selected="selected"'?>>Todos los agentes</option>
                                        <option value="2" <?php if( isset( $_POST['query']['agent'] ) and  $_POST['query']['agent'] == 2 ) echo 'selected="selected"'?>>Cancelados</option>
                                        <option value="3" <?php if( isset( $_POST['query']['agent'] ) and  $_POST['query']['agent'] == 3 ) echo 'selected="selected"'?>>Vigentes</option>
                                      </select>
                                           
                                    </th>
                                    <th>
                                        
                                            
                                       <select id="generarion" name="query[generacion]" class="select3" style="width:180px;" onchange="this.form.submit();">
                                        <option value="" <?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 1 ) echo 'selected="selected"'?>>Todas las Generaciónes</option>
                                        <option value="2"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 2 ) echo 'selected="selected"'?>>Consolidado</option>
                                        <option value="3"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 3 ) echo 'selected="selected"'?>>Generación 1</option>
                                        <option value="4"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 4 ) echo 'selected="selected"'?>>Generación 2</option>
                                        <option value="5"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 5 ) echo 'selected="selected"'?>>Generación 3</option>
                                       
                                      </select>
                                            
                                       
                                    </th>
                                    <th>&nbsp; </th>
                                    <th>&nbsp; </th>
                                    <th>&nbsp; </th>
                                    <th>&nbsp; </th>
                                    <th></th>
                                    <th width="50%" align="right" > <a href="javascript:void(0);" class="download">
                                        <img src="<?php echo base_url() ?>ot/assets/images/down.png"></a></th>
                                </tr>
                              </thead>
                            </table>
                               </form>
                    
                        
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
                                <thead>
                                <tr>
                                    <th id="table_agents" class="header_manager">Agentes</th>
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
                    
                               
                    
                    
                            <tbody>
                              
                                
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
                                    <td class=""><div class="text_azulado"><?php echo $value['name'] ?></div> 
									
									<?php if( !empty( $value['uids'][0]['uid'] ) )echo $value['uids'][0]['uid']. ' - '; else echo 'Sin clave asignada - '; ?>
									
									<?php echo $value['disabled'] .' - '. $value['generacion']. ' - ' ?>
                                    
                                    <?php if( $value['connection_date'] != '0000-00-00' ): ?>
                                    		Conectado <?php echo getFormatDate( $value['connection_date'] ) ?>
                                    <?php else: ?>
                                    		No Conectado
                                    <?php endif; ?> 
                                   </td>
                                    <td class="celda_gris"><div class="numeros"><?php echo $value['negocio'] ?></div> Negocios Pagados</td>
                                    <td class="celda_gris"><div class="numeros"><?php if( $value['negociopai']  != 0 ) echo count( $value['negociopai'] ); else echo $value['negociopai']; ?></div> Negocios Pal</td>
                                    <td class="celda_gris"><div class="numeros">$<?php echo $value['prima'] ?></div> Pagados</td>
                                    <td class="celda_roja"><div class="numeros"><?php if( isset( $value['tramite']['count'] ) ) echo $value['tramite']['count']; else echo 0; ?></div> Negocios en <br> Tramite</td>
                                    <td class="celda_roja"><div class="numeros">$<?php if( isset( $value['tramite']['prima'] ) ) echo $value['tramite']['prima']; else echo 0; ?></div> en Tramite</td>
                                    <td class="celda_amarilla"><div class="numeros"><?php if( isset( $value['aceptadas']['count'] ) ) echo  $value['aceptadas']['count']; else  echo $value['aceptadas'] ?></div> Negocios Pendientes</td>
                                    <td class="celda_amarilla"><div class="numeros">$<?php if( isset( $value['aceptadas']['prima'] ) ) echo  $value['aceptadas']['prima']; else  echo $value['aceptadas'] ?></div> Pendientes</td>
                                    <td class="celda_verde"><div class="numeros"><?php echo $negocio ?></div> Negocios Proyectados</td>
                                    <td class="celda_verde"><div class="numeros">$<?php echo $prima ?></div> Proyectadas</td>
                                </tr>
                    			
                                
                                                                      
                                	<?php endforeach; ?>                                
                                <?php endif; ?>  
                                
                                
                                
                            </tbody>
                         </table>
                    
                    <div id="contentFoot" style="width:77% !important;">
                        <table  class="sortable altrowstable tablesorter" id="Tfoot" style="min-width:100% !important;" >
                    
                        
                               <tr>
                                    <td ><div class="text_total">Totales</div></td>
                                    <td style="width:70px;"><div class="numeros"><?php echo $total_negocio?></div>Negocios Pagados</td>
                                    <td style="width:70px;"><div class="numeros"><?php echo $total_negocio_pai?></div> Negocios Pal</td>
                                    <td style="width:100px;"><div class="numeros">$<?php echo $total_primas_pagadas?></div> Pagados</td>
                                    <td style="width:70px;" class="celda_gris_roja"><div class="numeros"><?php echo $total_negocios_tramite?></div> Negocios en <br>  Tramite</td>
                                    <td style="width:100px;" class="celda_gris_roja"><div class="numeros">$<?php echo $total_primas_tramite?></div> en Tramite</td>
                                    <td style="width:70px;" class="celda_gris_amarilla"><div class="numeros"><?php echo $total_negocio_pendiente?></div> Negocios Pendientes</td>
                                    <td style="width:100px;" class="celda_gris_amarilla"><div class="numeros">$<?php echo $total_primas_pendientes?></div> Pendientes</td>
                                    <td  style="width:70px;"class="celda_gris_verde"><div class="numeros"><?php echo $total_negocios_proyectados?></div> Negocios Proyectados</td>
                                    <td  style="width:100px;"class="celda_gris_verde"><div class="numeros">$<?php echo $total_primas_proyectados?></div> Proyectadas</td>
                                </tr>
                                                                                                
                         
                         </table>
                    </div>            
                    </div> <!-- #main -->
                </div> <!-- #main-container -->
                    </div>   
                                                                                                                    	
                </div>
                
            </div>          
          
                           
        </div>
    </div><!--/span-->
	
</div><!--/row-->

