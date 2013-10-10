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
            Importar Payments
        </li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2></h2>
            <div class="box-icon">
                
            </div>
        </div>
        
        <div class="box-content">
        	
            
			
			<?php // Return Message error ?>
                        
            <?php if( isset( $message ) and !empty( $message ) and $message['type'] == false ): unset( $message['type'] );?>
            <div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Error: </strong> 
				  <?php  // Show Dinamical message error 
				  		
						foreach( $message['message'] as $raiz ):
														
							if( empty( $raiz ) ) break;
								
																						
								foreach( $raiz as $array ):
									
									if( empty( $array ) ) break;
									
										foreach( $array as $messagetext ):
											
											if( empty( $messagetext ) ) break;
													
													echo $messagetext.'<br>';
												
										endforeach;
									
									
								endforeach;
								
								
													
						endforeach;
				  
				  ?>
            </div>
            <?php endif; ?>
            
            
            
            
            <?php if( isset( $message ) and !empty( $message ) and $message['type'] == true ): unset( $message['type'] );?>
            <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Listo: </strong> 
				  <?php  // Show Dinamical message error 
				  		
						foreach( $message['message'] as $raiz ):
														
							if( empty( $raiz ) ) break;
								
																						
								foreach( $raiz as $array ):
									
									if( empty( $array ) ) break;
									
										foreach( $array as $messagetext ):
											
											if( empty( $messagetext ) ) break;
													
													echo $messagetext.'<br>';
												
										endforeach;
									
									
								endforeach;
								
								
													
						endforeach;
				  
				  ?>
            </div>
            <?php endif; ?>
            
            
                    	
            <form id="formfile" action="<?php echo base_url() ?>ot/import_payments.html" class="form-horizontal" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="control-group">
                  <label class="control-label text-error" for="inputError">Archivo: </label>
                  <div class="controls">
                    <input  class="input-file uniform_on required" id="fileInput" name="file" type="file"><br />
                    <small class="text">Archivo CSV o EXCEL</small>
                  </div>
                </div>
                
                
                <div class="control-group">
                  <label class="control-label text-error" for="inputError">Tipo de archivo: </label>
                  <div class="controls">
                    <select name="product" class="required">
                    	<?php if( isset( $products ) and !empty( $products ) ) echo $products; ?>
                    </select>
                  </div>
                </div>
               
               
                <div id="actions-buttons-forms" class="form-actions">
                  <button type="submit" class="btn btn-primary">Cargar</button>
                  <input type="button" class="btn" onclick="javascript: history.back()" value="Cancelar">
                </div>
              </fieldset>
            </form>
        	
            
            
            
            
            
            
            
            <?php 			
			/**
             *	Change Index, Selectes options fields
			 **/
            ?>
            
            
            <?php if( isset( $tmp_file ) and $process == 'change-index' ): // Is is load a file?>
            
            <form action="<?php echo base_url() ?>ot/import_payments.html" id="import-form" method="post">
            
            <input type="hidden" name="tmp_file" value="<?php echo $tmp_file ?>">
            
            <input type="hidden" name="process" value="<?php echo $process ?>">
            
            <input type="hidden" name="product" value="<?php echo $product ?>" />
            
            <div class="alert alert-info">
            	Especifique a qué campos corresponde la información que está importando en las siguientes cajas de selección
            </div>
            
            <div style="max-width:100%; overflow:scroll; max-height:400px;">
            
            <table class="table table-rounder">
             
            <?php
           		  if( !empty( $file_array ) ):  // Create select for fields
				  		
						foreach( $file_array as $rows ):
							
							if( !empty( $rows ) ):
								
								echo '<tr>';
								
								$i=1;
								
								foreach( $rows as $value ):
																							
								echo'<td class="column'.$i.'">
										<select class="required" id="select'.$i.'" name="'.$i.'" style="width:100px;" onchange="hide('.$i.')">
											<option value="">Seleccione</option>
											<option value="nonimport">No importar</option>
											<optgroup label="----------"></optgroup>
											<option value="year_prime">Año Prima</option>
											<option value="is_new">Es nuevo negocio</option>
											<option value="payment_date">Fecha de pago real</option>
											<option value="clave">Clave del agente</option>
											<option value="agent_uidsnational">Folio nacional del agente</option>
											<option value="agent_uidsprovincial">Folio provincial del agente</option>
											<!--<option value="">Nombre del agente</option>-->
											<option value="name">Nombre del Asegurado</option>
											<option value="uid">Número de póliza</option>
											<option value="percentage">Porcentaje de participación</option>
											<option value="amount">Prima</option>											
											<option value="product_id">Ramo</option>
										</select>
										
									 </td>'; 
								
								$i++;
									 
								endforeach;
            	  				break;
								echo '</tr>'; 
								
							endif;
				  
				  		endforeach;
				  
				  endif; 
			?>
            
                        
            	              
            <?php
           		  if( !empty( $file_array ) ):  // Show data
				  		
						foreach( $file_array as $rows ):
							
							if( !empty( $rows ) ): $i=0;
								
								echo '<tr>';
								
								foreach( $rows as $value ): 
								
									echo '<td class="column'.$i.'">'.$value.'</td>'; 
								$i++;
								endforeach;
            	  				
								echo '</tr>'; 
								
							endif;
				  
				  		endforeach;
				  
				  endif; 
			?>
            
            </table>
            
            </div>
            
            <div id="actions-buttons-forms-send" class="form-actions">
              <button type="submit" class="btn btn-primary">Pre Importar</button>
              <input type="button" class="btn" onclick="javascript: history.back()" value="Cancelar">
            </div>
            
            
            </form>
           
            <?php endif; ?>
            
            
            
            
            
            
            
            
            
            <?php 			
			/**
             *	Choose Agents
			 **/
            ?>
            
            
            <div id="dialog-form" title="Request new user" style="display:none">
              <iframe src="<?php echo base_url() ?>usuarios/create_request_new_user.html" width="800" height="600"></iframe>
            </div>
            
            <input type="hidden" id="control" />
            
            
            
            <?php if( isset( $tmp_file ) and $process == 'choose-agents' ): // Is is load a file?>
               
            
            <form action="<?php echo base_url() ?>ot/import_payments.html" id="import-form" method="post">
            
            <input type="hidden" name="tmp_file" value="<?php echo $tmp_file ?>">
            
            <input type="hidden" name="process" value="<?php echo $process ?>">
            
            <input type="hidden" name="product" value="<?php echo $product ?>" />
            
            <div class="alert alert-info">
            	Verifique los agentes y las OTs relacionadas
            </div>
            
            <div style="max-width:100%; overflow:scroll; max-height:400px;">
           
            <table class="table table-rounder">
            	              
            <?php 
           		  if( !empty( $file_array ) ):  // Show data
				  		
						$i=0;				
						foreach( $file_array as $rows ):
							
							if( $i > 0 ) break;
							
							if( !empty( $rows ) ): 
								
								echo '<tr>';
								
								foreach( $rows as $key => $value ): 
																		
									if( $key == 'is_new' )	$key = 'Es nuevo negocio';
									if( $key == 'year_prime' )	$key = 'Año prima';
									if( $key == 'wathdo' )	$key = '¿Que hacer con la póliza?';
									if( $key == 'payment_date' )	$key = 'Fecha de pago real';
									if( $key == 'clave' )	$key = 'Clave';
									if( $key == 'agent_uidsnational' )	$key = 'Folio national';
									if( $key == 'agent_uidsprovincial' )	$key = 'Folio provincial';
									if( $key == 'agent' )	$key = 'Agente';
									if( $key == 'uid' )	$key = 'Poliza';
									if( $key == 'amount' )	$key = 'Prima';
									if( $key == 'percentage' )	$key = 'Porcentaje';
									if( $key == 'product_id' )	$key = 'Ramo';
									if( $key == 'name' )	$key = 'Asegurado';
									
									echo '<th>'.$key.'</th>'; 
								
								endforeach;
            	  				
								echo '</tr>'; 
								
							endif;
				  			$i++;
				  		endforeach;
						
						
						
						foreach( $file_array as $rows ):
							
							if( !empty( $rows ) ):
								
								echo '<tr>';
								
								foreach( $rows as $value ): 
								
									echo '<td>'.$value.'</td>'; 
								
								endforeach;
            	  				
								echo '</tr>'; 
								
							endif;
				  
				  		endforeach;
				  
				  endif; 
			?>
            
            </table>
            
            </div>
            
            <div id="actions-buttons-forms-send" class="form-actions">
              <button type="submit" class="btn btn-primary">Vista de importación</button>
              <input type="button" class="btn" onclick="javascript: history.back()" value="Cancelar">
            </div>
            
            
            </form>
           
            <?php endif; ?>
            
            
            
            
            
            
            
            
            
            <?php 			
			/**
             *	Preview save data
			 **/
            ?>
            
            
            <?php if( isset( $tmp_file ) and $process == 'preview' ): // Is is load a file?>
               
            
            <form action="<?php echo base_url() ?>ot/import_payments.html" id="import-form" method="post">
            
            <input type="hidden" name="tmp_file" value="<?php echo $tmp_file ?>">
            
            <input type="hidden" name="process" value="<?php echo $process ?>">
            
            <input type="hidden" name="product" value="<?php echo $product ?>" />
            
            <div class="alert alert-info">
            	Revise la información.
            </div>
            
            <div style="max-width:100%; overflow:scroll; max-height:400px;">
           
            <table class="table table-rounder">
            	              
            <?php
           		  if( !empty( $file_array ) ):  // Show data
				  		
						$i=0;				
						foreach( $file_array as $rows ):
							
							if( $i > 0 ) break;
							
							if( !empty( $rows ) ): 
								
								echo '<tr>';
								
								foreach( $rows as $key => $value ): 
																		
									
									if( $key == 'is_new' )	$key = 'Es nuevo negocio';
									if( $key == 'year_prime' )	$key = 'Año prima';
									if( $key == 'wathdo' )	$key = '¿Asignar el pago a OT?';
									if( $key == 'payment_date' )	$key = 'Fecha de pago real';
									if( $key == 'clave' )	$key = 'Clave';
									if( $key == 'agent_uidsnational' )	$key = 'Folio national';
									if( $key == 'agent_uidsprovincial' )	$key = 'Folio provincial';
									if( $key == 'agent' )	$key = 'Agente';
									if( $key == 'uid' )	$key = 'Poliza';
									if( $key == 'amount' )	$key = 'Prima';
									if( $key == 'percentage' )	$key = 'Porcentaje';
									if( $key == 'product_id' )	$key = 'Ramo';
									if( $key == 'name' )	$key = 'Asegurado';
									echo '<th>'.$key.'</th>'; 
								
								endforeach;
            	  				
								echo '</tr>'; 
								
							endif;
				  			$i++;
				  		endforeach;
						
						
						
						foreach( $file_array as $rows ):
							
							if( !empty( $rows ) ):
								
								echo '<tr>';
								
								foreach( $rows as $value ): 
								
									echo '<td>'.$value.'</td>'; 
								
								endforeach;
            	  				
								echo '</tr>'; 
								
							endif;
				  
				  		endforeach;
				  
				  endif; 
			?>
            
            </table>
            
            </div>
            
            <div id="actions-buttons-forms-send" class="form-actions">
              <button type="submit" class="btn btn-primary">Importar</button>
              <input type="button" class="btn" onclick="javascript: history.back()" value="Cancelar">
            </div>
            
            
            </form>
           
            <?php endif; ?>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        </div>
    </div><!--/span-->

</div><!--/row-->
			