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
            
            	
                 <div class="span10 offset1">
                	<br /><br />
                    
				       <br /><br />  
                      <div class="row advanced">
                      		
                             <table class="table table-bordered bootstrap-datatable datatable">           	
                             	<tr>
                                  <td>Ramo:</td>
                                  <td><select id="ramo" name="query[]" class="input-xlarge" ><option value="">Seleccione</option><option value="1">Vida</option><option value="2">GMM</option><option value="3">Autos</option></select></td>
                                </tr>
                                <tr>
                                  <td>Período: </td>
                                  <td>
                                      <select id="periodo" name="query[]" class="input-xlarge" >
                                      	<option value="">Seleccione</option>
                                        <option value="1">Mes</option>
                                        <option value="2">Trimestre (Vida) o cuatrimestre (GMM)</option>
                                        <option value="3">Año</option>
                                      </select>
                                      
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td>Generación: </td>
                                  <td>
                                  
                                  <input type="checkbox" name="query[generacion]" value="1" /> Todos<br />
                                  <input type="checkbox" name="query[generacion]" value="2" /> Consolidado<br />
                                  <input type="checkbox" name="query[generacion]" value="3" /> Generación 1<br />
                                  <input type="checkbox" name="query[generacion]" value="4" /> Generación 2<br />
                                  <input type="checkbox" name="query[generacion]" value="5" /> Generación 3<br />
                                  <input type="checkbox" name="query[generacion]" value="6" /> Generación 4<br />
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td>Gerente: </td>
                                  <td><select id="gerente" class="input-xlarge findfilters" name="query[]" ><option value="">Seleccione</option><?php echo $manager ?></select></td>
                                </tr>                                 
                                <tr>
                                  <td>Status de agentes: </td>
                                  <td><select id="agent" name="query[]" class="input-xlarge findfilters">
                                  	  <option value="">Seleccione</option>
                                      <option value="1">Todos</option>
                                      <option value="2">Vigentes</option>
                                      <option value="3">Cancelados</option>
                                      </select>
                                  </select></td>
                                </tr>
                                
                                                                 
                                <tr>
                                  <td></td>
                                  <td><input type="button" value="Buscar" class="btn btn-inverse filtros" /></td>
                                </tr>                                
                             </table>
                             
                      </div>
                      
                      <div style="width:100%; overflow:scroll;">
                      
                      <table class="table table-bordered bootstrap-datatable datatable" style="">           	
                             	<tr>
                                  <td style="vertical-align:middle">Cve Unica</td>
                                  <td style="vertical-align:middle">Nombre</td>
                                  <td style="vertical-align:middle">Status Nal</td>
                                  <td style="vertical-align:middle">Fecha de Conexión</td>
                                  <td style="vertical-align:middle">Gen Pai</td>
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">PAGADAS</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Negocios Pai</td>
                                            <td>Primas</td>
                                            <td>Total con Incrementos</td>
                                        </tr>
                                    </table>
                                  </td>
                                  
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">EN TRÁMITE</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Primas</td>
                                        </tr>
                                    </table>
                                  </td>
                                  
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">PENDIENTES DE PAGO</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Primas</td>
                                        </tr>
                                    </table>
                                  </td>
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">PROYECCIÓN REAL</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Primas</td>
                                        </tr>
                                    </table>
                                  </td>
                                </tr>
                                
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
										
										
										
										
										
										
										
									?>
                                    
                                    
                                    <tr>
                                      <td style="vertical-align:middle"><?php echo $value['uids'][0]['uid'] ?></td>
                                      <td style="vertical-align:middle"><?php echo $value['name'] ?></td>
                                      <td style="vertical-align:middle">Status Nal</td>
                                      <td style="vertical-align:middle"><?php echo $value['connection_date'] ?></td>
                                      <td style="vertical-align:middle">Gen Pai</td>
                                      <td>
                                        <table>
                                            <tr>
                                                <td style="vertical-align:middle; text-align:center;"><?php echo $value['negocio'] ?></td>
                                                <td style="vertical-align:middle; text-align:center;"><?php if( isset( $value['negociopai'][0] ) ) echo $value['negociopai'][0]; else echo $value['negociopai'];  ?></td>
                                                <td style="vertical-align:middle; text-align:center;"><?php echo $value['prima'] ?></td>
                                                <td style="vertical-align:middle; text-align:center;">$ <?php echo $value['prima'] ?></td>
                                            </tr>
                                        </table>
                                      </td>
                                      
                                      <td>
                                        <table>
                                           <tr>
                                                <td style="vertical-align:middle; text-align:center;"><?php echo $value['tramite']['count'] ?></td>
                                                <td style="vertical-align:middle; text-align:center;">$ <?php echo $value['tramite']['prima'] ?></td>
                                            </tr>
                                        </table>
                                      </td>
                                      
                                      <td>
                                        <table>
                                            <tr>
                                                <td style="vertical-align:middle; text-align:center;"><?php if( isset( $value['aceptadas']['count'] ) ) echo $value['aceptadas']['count']; else echo $value['aceptadas']; ?></td>
                                                <td style="vertical-align:middle; text-align:center;">$ <?php if( isset( $value['aceptadas']['prima'] ) ) echo $value['aceptadas']['prima']; else echo $value['aceptadas']; ?></td>
                                            </tr>
                                        </table>
                                      </td>
                                      <td>
                                        <table>
                                               <tr>
                                                <td style="vertical-align:middle; text-align:center;"><?php echo $negocio ?></td>
                                                <td style="vertical-align:middle; text-align:center;">$ <?php echo $prima ?></td>
                                            </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    
                                    
                                    
                                    
                                    
                                	<?php endforeach; ?>                                
                                <?php endif; ?>  
                                                            
                      </table>
                      
                      </div>                      
                                    	
                </div>
                
            </div>          
          
                           
        </div>
    </div><!--/span-->

</div><!--/row-->

