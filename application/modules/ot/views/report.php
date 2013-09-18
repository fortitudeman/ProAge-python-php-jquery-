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
            
            	
                 <div class="span11 offset1">
                                    
                      <form id="form" method="post">                      	
                          <input type="hidden" name="query[ramo]" id="ramo" value="1" />
                           
                          <div class="row">                                 
                               
                               <?php 							   		
									if( !isset( $_POST['query']['ramo'] ) or isset( $_POST['query']['ramo'] ) and  $_POST['query']['ramo'] == 1 ):
							   ?>                               
                                   <div class="span1 vida item-active">
                                      <h3><a href="javascript:void(0)" class="btn btn-link link-ramo" id="vida">Vida</a></h3>
                                   </div>
                               <?php else: ?>                               		
                                    <div class="span1 vida item-desactive">
                                      <h3><a href="javascript:void(0)" class="btn btn-link link-ramo" id="vida">Vida</a></h3>
                                   </div>                                    
                               <?php endif; ?>
                               
                                                              
                               
                               <?php 							   		
									if( isset( $_POST['query']['ramo'] ) and  $_POST['query']['ramo'] == 2 ):
							   ?> 
                               
                               <div class="span1 gmm item-active">
                                  <h3><a href="javascript:void(0)" class="btn btn-link link-ramo" id="gmm">GMM</a></h3>
                               </div>
                               
                               <?php else: ?>     
                               <div class="span1 gmm item-desactive">
                                  <h3><a href="javascript:void(0)" class="btn btn-link link-ramo" id="gmm">GMM</a></h3>
                               </div>
                                <?php endif; ?>
                               
                               <?php 							   		
									if( isset( $_POST['query']['ramo'] ) and  $_POST['query']['ramo'] == 3 ):
							   ?> 
                               <div class="span1 autos item-active">
                                  <h3><a href="javascript:void(0)" class="btn btn-link link-ramo" id="autos">Autos</a></h3>
                               </div>
                               <?php else: ?>     
                               <div class="span1 autos item-desactive">
                                  <h3><a href="javascript:void(0)" class="btn btn-link link-ramo" id="autos">Autos</a></h3>
                               </div>
                                <?php endif; ?>
                               
                               <div class="span9"><br />
                               	<hr />
                               </div>
                               
                           </div>
                           
                           
                           <div class="row">
                           		
                                <div class="span1">
                                	 <select id="periodo" name="query[periodo]">
                                      	<option value="1" <?php if( isset( $_POST['query']['periodo'] ) and  $_POST['query']['periodo'] == 1 ) echo 'selected="selected"'?>>Mes</option>
                                        <option value="2" <?php if( isset( $_POST['query']['periodo'] ) and  $_POST['query']['periodo'] == 2 ) echo 'selected="selected"'?> class="set_periodo">Trimestre</option>
                                        <option value="3" <?php if( isset( $_POST['query']['periodo'] ) and  $_POST['query']['periodo'] == 3 ) echo 'selected="selected"'?>>Año</option>
                                      </select>
                                </div>
                                <div class="span1 offset1">
                                	<select id="gerente" name="query[gerente]" class="select">
                                      	<option value="">Todos los gerentes</option>                                        
                                        <?php echo $manager ?>
                                      </select>
                                </div>
                                
                                <div class="span1 offset1">
                                	<select id="agent" name="query[agent]" class="select2">
                                        <option value="" <?php if( isset( $_POST['query']['agent'] ) and  $_POST['query']['agent'] == 1 ) echo 'selected="selected"'?>>Todos los agentes</option>
                                        <option value="2" <?php if( isset( $_POST['query']['agent'] ) and  $_POST['query']['agent'] == 2 ) echo 'selected="selected"'?>>Vigentes</option>
                                        <option value="3" <?php if( isset( $_POST['query']['agent'] ) and  $_POST['query']['agent'] == 3 ) echo 'selected="selected"'?>>Cancelados</option>
                                      </select>
                                </div>
                                
                                <div class="span1 offset1">
                                	<select id="generarion" name="query[generacion]" class="select3">
                                        <option value="" <?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 1 ) echo 'selected="selected"'?>>Todas las Generaciónes</option>
                                        <option value="2"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 2 ) echo 'selected="selected"'?>>Consolidado</option>
                                        <option value="3"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 3 ) echo 'selected="selected"'?>>Generación 1</option>
                                        <option value="4"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 4 ) echo 'selected="selected"'?>>Generación 2</option>
                                        <option value="5"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 5 ) echo 'selected="selected"'?>>Generación 3</option>
                                        <option value="6"<?php if( isset( $_POST['query']['generacion'] ) and  $_POST['query']['generacion'] == 6 ) echo 'selected="selected"'?>>Generación 4</option>
                                      </select>
                                </div>
                                
                                
                                
                            	<div class="span1">
                                	<input type="submit" value="Filtrar" class="btn btn-inverse" />
                                </div>
                                <div class="span1 offset3">
                                	<a href=""><img src="<?php echo base_url() ?>ot/assets/images/download.png"/></a>
                                </div>
                           </div>
                           
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
                        
                                         	
                        <table class="table">          
                          
                          <thead>
                          	<tr>
                                  <th>Agente</th>
                                  <th class="small">Negocios <br />pagados</th>
                                  <th class="small">Negocios <br />pai</th>
                                  <th class="small">Prímas <br />pagadas</th>
                                  <th>Negocios en <br />trámite</th>
                                  <th>Prímas en <br />trámite</th>
                                  <th>Negocios <br />pendientes</th>
                                  <th>Prímas <br />pendientes</th>
                                  <th>Negocios <br />proyectados</th>
                                  <th>Primas <br />proyectadas</th>
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
										
										
										
										if( $value['disabled'] == 1 ) $value['disabled'] = 'Activo';
										if( $value['disabled'] == 0 ) $value['disabled'] = 'Desactivado';
											
										
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
                                      <td class="width_xlarge">
                                      	<p style="color:#4CB7DB; font-size:14px; font-weight:bold;"><?php echo $value['name'] ?></p>
                                        <?php echo $value['uids'][0]['uid'] ?> - <?php echo $value['disabled'] ?> - Generación 1<br />
                                        Conectado <?php echo getFormatDate( $value['connection_date'] ) ?>
                                      </td>
                                      <td>
									  	<h4><?php echo $value['negocio'] ?><br /></h4><br />
                                        <p><small>Negocios <br />pagados</small></p>
                                      </td>
                                      <td>
									    <h4><?php if( $value['negociopai']  != 0 ) echo count( $value['negociopai'] ); else echo $value['negociopai']; ?></h4><br />
                                        <p><small>Negocios <br />PAI</small></p></td>
                                      <td><h4>$ <?php echo $value['prima'] ?></h4><br />
                                        <p><small>Pagados</small></p></td>
                                      <td><h4><?php echo $value['tramite']['count'] ?></h4><br />
                                        <p><small>Negocios en <br /> trámite</small></p></td>
                                      <td><h4>$ <?php echo $value['tramite']['prima'] ?></h4><br />
                                        <p><small>En <br /> trámite</small></p></td>
                                      <td><h4><?php if( isset( $value['aceptadas']['count'] ) ) echo  $value['aceptadas']['count']; else  echo $value['aceptadas'] ?></h4><br />
                                        <p><small>Negocios <br /> pendientes</small></p></td>
                                      <td><h4>$ <?php if( isset( $value['aceptadas']['prima'] ) ) echo  $value['aceptadas']['prima']; else  echo $value['aceptadas'] ?></h4><br />
                                        <p><small>Prímas <br /> pendientes</small></p></td>
                                      <td><h4><?php echo $negocio ?></h4><br /><p><small>Negocios <br />proyectados</small></p></td>
                                      <td><h4>$ <?php echo $prima ?></h4><br /><p><small>Primas <br />proyectadas</small></p></td>
                                    </tr>  
                                      
                                      
                                	<?php endforeach; ?>                                
                                <?php endif; ?>  
                            
                          </tbody>
                          
                          <tfoot style="background-color:#666666; color:#FFF;">
                         	                        
                            <tr>
                              <td class="width_xlarge"><h6 style="margin-right:5px;">Totales     </h6></td>
                              <td class="small"><?php echo $total_negocio?><br />
                                        <p><small>Negocios <br />pagados</small></p></td>
                              <td class="small"><?php echo $total_negocio_pai?><br />
                                        <p><small>Negocios <br />PAI</small></p></td>
                              <td class="small">$ <?php echo $total_primas_pagadas?><br />
                                        <p><small>Pagados</small></p></td>
                              <td><?php echo $total_negocios_tramite?><br />
                                        <p><small>Negocios en <br /> trámite</small></p></td>
                              <td>$ <?php echo $total_primas_tramite?><br />
                                        <p><small>En <br /> trámite</small></p></td>
                              <td><?php echo $total_negocio_pendiente?><br />
                                        <p><small>Negocios <br /> pendientes</small></p></td></td>
                              <td>$ <?php echo $total_primas_pendientes?><br />
                                        <p><small>Prímas <br /> pendientes</small></p></td>
                              <td><?php echo $total_negocios_proyectados?><br /><p><small>Negocios <br />proyectados</small></p></td>
                              <td>$ <?php echo $total_primas_proyectados?><br /><p><small>Primas <br />proyectadas</small></p></td>
                            </tr>
                            
                          </tfoot>	
                            
                            
                          	
                        </table>
                                                                                  
                   </div>
                                    	
                </div>
                
            </div>          
          
                           
        </div>
    </div><!--/span-->

</div><!--/row-->

