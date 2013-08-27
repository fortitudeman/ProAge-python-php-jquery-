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
                        
            <?php if( isset( $message ) and !empty( $message ) ): ?>
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
            
            
                    	
            <form id="form" action="<?php echo base_url() ?>ot/import_payments.html" class="form-horizontal" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="control-group error">
                  <label class="control-label" for="inputError">Archivo: </label>
                  <div class="controls">
                    <input  class="input-file uniform_on" id="fileInput" name="file" type="file"><br />
                    <small class="text">Archivo CSV o EXCEL</small>
                  </div>
                </div>
               
               
                <div id="actions-buttons-forms" class="form-actions">
                  <button type="submit" class="btn btn-primary">Cargar</button>
                  <button  type="button" class="btn" onclick="javascript: history.back()">Cancelar</button>
                </div>
              </fieldset>
            </form>
        	
            
            <?php if( isset( $tmp_file ) ): // Is is load a file?>
            
            <form action="<?php echo base_url() ?>ot/import_payments.html" id="import-form" method="post">
            
            <input type="hidden" name="tmp_file" value="<?php echo $tmp_file ?>">
            
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
								
								$i=0;
								
								foreach( $rows as $value ):
																							
								echo'<td class="column'.$i.'">
										<select class="required" id="select'.$i.'" name="'.$i.'" style="width:100px;" onchange="hide('.$i.')">
											<option value="">Seleccione</option>
											<option value="disabled">Año Inicio Prima</option>
											<option value="lastname">Es nuevo negocio</option>
											<option value="lastname_r">Fecha de pago real</option>
											<option value="password">Folio del agente</option>
											<option value="email">Nombre del agente</option>
											<option value="clave">Póliza</option>
											<option value="office_ext">Porcentaje de participación</option>
											<option value="license_expired_date">Prima</option>											
											<option value="connection_date">Ramo</option>
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
              <button type="submit" class="btn btn-primary">Importar</button>
              <button  type="button" class="btn" onclick="javascript: history.back()">Cancelar</button>
            </div>
            
            
            </form>
           
            <?php endif; ?>
            
        </div>
    </div><!--/span-->

</div><!--/row-->
			