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
            Crear
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
            
            <?php $validation = validation_errors(); ?>
            
            <?php if( !empty( $validation ) ): ?>
            <div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Error: </strong> <?php  echo $validation; // Show Dinamical message error ?>
            </div>
            <?php endif; ?>
            
            
            
        
            <form id="form" action="<?php echo base_url() ?>usuarios/create.html" class="form-horizontal" method="post">
                <fieldset>
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Rol</label>
                    <div class="controls">
                      
                      <?php echo $group ?>
                      
                    </div>
                  </div>
                                                      
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Persona</label>
                    <div class="controls">
                      <input type="radio" value="fisica" name="persona" class="persona" />&nbsp;&nbsp;Física
                      <input type="radio" value="moral" name="persona"  class="persona" />&nbsp;&nbsp;Moral
                    </div>
                  </div>
                  
                  
                  
                  
                  <div class="control-group error input-agente">
                    <label class="control-label" for="inputError">En proceso de conexión</label>
                    <div class="controls">
                      <input type="radio" value="1" name="type" class="agente" checked="checked"/>&nbsp;&nbsp;Si
                      <input type="radio" value="2" name="type" class="agente"  />&nbsp;&nbsp;No
                    </div>
                  </div>
                  
                  
                  
                  
                  <div class="control-group error input-novel-agente">
                    <label class="control-label" for="inputError">Clave</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="clave" name="clave" type="text">
                    </div>
                  </div>
                  
                  <div class="control-group error input-novel-agente">
                    <label class="control-label" for="inputError">Folio Nacional</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" name="folio_nacional[]" type="text"> 
                       <a href="javascript:void(0)" id="folio_nacional_add" class="btn btn-link" >+</a>
                      <div id="folio_nacional_fields"></div>
                    </div>
                  </div>
                  
                  
                  <div class="control-group error input-novel-agente">
                    <label class="control-label" for="inputError">Folio Provicional</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" name="folio_provincial[]" type="text">
                       <a href="javascript:void(0)" id="folio_provicional_add" class="btn btn-link" >+</a>
                      <div id="folio_provicional_fields"></div>
                    </div>
                  </div>
                  
                  
                  
                  
                 <div class="control-group error input-agente">
                    <label class="control-label" for="inputError">Fecha de conexión</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="connection_date" name="connection_date" type="text" readonly="readonly">
                    </div>
                  </div>
                  
                  
                  <div class="control-group error input-agente">
                    <label class="control-label" for="inputError">Expiración de licencia</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="license_expired_date" name="license_expired_date" type="text" readonly="readonly">
                    </div>
                  </div>
                 
                 
                 
                 
                 
                 
                 <div class="control-group error input-agente">
                    <label class="control-label" for="inputError">Gerente</label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="manager_id" name="manager_id">
                      	<option value="">Seleccione</option>
                        <?php echo $gerentes ?>
                      </select>
                    </div>
                  </div>
                 
                 
                 
                 <div class="control-group error input-fisica input-moral">
                    <label class="control-label" for="inputError"> Nombre de compania:</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="company_name" name="company_name" type="text">
                    </div>
                  </div>
                
                 
                 
                 
                 <div class="control-group error input-fisica">
                    <label class="control-label" for="inputError">Nombre</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="name" name="name" type="text">
                    </div>
                  </div>
                  
                  
                  <div class="control-group error input-fisica">
                    <label class="control-label" for="inputError">Apellidos</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="lastname" name="lastname" type="text">
                    </div>
                  </div>
                 
                  
                  <div class="control-group error input-fisica">
                    <label class="control-label" for="inputError">Fecha de nacimiento</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="birthdate" name="birthdate" type="text" readonly="readonly">
                    </div>
                  </div>
                	
                   
                   <!-- ¨Persona Moral Settings -->
                   <fieldset class="block-moral">
                   
                   	   <a href="javascript:void(0)" id="moral_add" class="btn btn-link input-moral pull-right" >+</a>
                       
                       <div class="control-group error input-moral">
                        <label class="control-label" for="inputError">Nombre</label>
                        <div class="controls">
                          <input class="input-xlarge focused required" name="name_r[]" type="text">
                        </div>
                      </div>
                      
                      
                      <div class="control-group error input-moral">
                        <label class="control-label" for="inputError">Apellidos</label>
                        <div class="controls">
                          <input class="input-xlarge focused required" name="lastname_r[]" type="text">
                        </div>
                      </div>
                       
                       
                     
                       <div class="control-group error input-moral">
                        <label class="control-label" for="inputError">Teléfono oficina</label>
                        <div class="controls">
                          <input class="input-xlarge focused required" name="office_phone[]" type="text">
                        </div>
                      </div>
                      
                       <div class="control-group error input-moral">
                        <label class="control-label" for="inputError">Extensión</label>
                        <div class="controls">
                          <input class="input-xlarge focused required" name="office_ext[]" type="text">
                        </div>
                      </div>
                      
                      <div class="control-group error input-moral">
                        <label class="control-label" for="inputError">Teléfono movil</label>
                        <div class="controls">
                          <input class="input-xlarge focused required" name="mobile[]" type="text">
                        </div>
                      </div>
                  
                      <div id="moral-fields" class="input-moral"></div>
                  
                  </fieldset>
                  
                  
                   
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                 
                  
                                 
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Usuario</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="username" name="username" type="text">
                    </div>
                  </div>
                 
                 
                 <div class="control-group error">
                    <label class="control-label" for="inputError">Contraseña</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="password" name="password" type="password">
                    </div>
                  </div>
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Correo</label>
                    <div class="controls">
                      <input class="input-xlarge focused required email" id="email" name="email" type="text">
                    </div>
                  </div>
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Activar</label>
                    <div class="controls">
                      <input type="radio" value="1" name="disabled" checked="checked"/>&nbsp;&nbsp;Si
                      <input type="radio" value="2" name="disabled" />&nbsp;&nbsp;No
                    </div>
                  </div>
                  
                  
                  
                  
                  
                  
                                    
                  <div id="actions-buttons-forms" class="form-actions">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button class="btn" onclick="javascript: history.back()">Cancelar</button>
                  </div>
                </fieldset>
              </form>
        
        </div>
    </div><!--/span-->

</div><!--/row-->
			