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
            <a href="<?php echo base_url() ?>usuarios.html">Usuarios</a> <span class="divider">/</span>
        </li>
        <li>
            Importar
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
				  		
						foreach( $message as $raiz ):
							
							foreach( $raiz as $array ):
								
								foreach( $array as $mes ):
								
									echo '<pre>';
									print_r(  $mes ); 
									echo '</pre>';
								endforeach;
							endforeach;
						endforeach;
				  
				  ?>
            </div>
            <?php endif; ?>
            
            
                    	
            <form id="form" action="<?php echo base_url() ?>usuarios/importar.html" class="form-horizontal" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="control-group error">
                  <label class="control-label" for="inputError">Archivo de usuario: </label>
                  <div class="controls">
                    <input  class="input-file uniform_on" id="fileInput" name="file" type="file"><br />
                    <small class="text">Archivo CSV</small>
                  </div>
                </div>
               
               
                <div id="actions-buttons-forms" class="form-actions">
                  <button type="submit" class="btn btn-primary">Cargar</button>
                  <button  type="button" class="btn" onclick="javascript: history.back()">Cancelar</button>
                </div>
              </fieldset>
            </form>
        	
            
            <?php if( isset( $tmp_file ) ): // Is is load a file?>
            
            <form action="<?php echo base_url() ?>usuarios/importar.html" id="create-users-form-csv" method="post">
            
            <input type="hidden" name="tmp_file" value="<?php echo $tmp_file ?>">
            
            <span class="small"></span>
            
            <table class="table table-rounder">
            
            
            <?php
           		  if( !empty( $file_array ) ):  // Create select for fields
				  		
						foreach( $file_array as $rows ):
							
							if( !empty( $rows ) ):
								
								echo '<tr>';
								
								$i=0;
								
								foreach( $rows as $value ):
																							
								echo'<td class="column'.$i.'">
										<select id="select'.$i.'" name="'.$i.'" style="width:100px;" onchange="hide('.$i.')">
											<option value="">Seleccione</option>
											<option value="office_id">Oficina</option>
											<option value="group">Rol</option>
											<option value="persona">Persona</option>
											<option value="clave">Clave</option>
											<option value="folio_nacional"">Folio nacional</option>
											<option value="folio_provincial">Folio Provicional</option>
											<option value="type">En proceso de conexión</option>
											<option value="connection_date">Fecha de conexión</option>
											<option value="license_expired_date">Expiración de licencia</option>
											<option value="manager_id">Gerente</option>
											<option value="company_name">Nombre de compania</option>
											<option value="name">Nombre</option>
											<option value="lastname">Apellidos</option>
											<option value="birthdate">Fecha de nacimiento</option>
											<option value="name_r">Nombre Persona Moral</option>
											<option value="lastname_r">Apellidos Persona Moral</option>
											<option value="office_phone">Teléfono oficina</option>
											<option value="office_ext">Extensión</option>
											<option value="mobile">Teléfono movil</option>
											<option value="username">Usuario</option>
											<option value="password">Contraseña</option>
											<option value="email">Correo</option>
											<option value="disabled">Activar</option>
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
            
            <div id="actions-buttons-forms-send" class="form-actions">
              <button type="submit" class="btn btn-primary">Importar</button>
              <button  type="button" class="btn" onclick="javascript: history.back()">Cancelar</button>
            </div>
            
            
            </form>
           
            <?php endif; ?>
            
        </div>
    </div><!--/span-->

</div><!--/row-->
			