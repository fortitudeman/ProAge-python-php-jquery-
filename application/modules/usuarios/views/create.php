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
            <a href="<?php echo base_url() ?>roles.html">Usuarios</a> <span class="divider">/</span>
        </li>
        <li>
            Crear
        </li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Agregar nuevo usuario</h2>
            <div class="box-icon">
                
            </div>
        </div>
        
        <div class="box-content">
        	
            
			
			<?php // Return Message error ?>
            
            <?php $validation = validation_errors(); ?>
            
            <?php if( !empty( $message ) ): ?>
            <div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Error: </strong> <?php  echo $validation; // Show Dinamical message error ?>
            </div>
            <?php endif; ?>
            
            
            
        
            <form id="form" action="<?php echo base_url() ?>roles/create.html" class="form-horizontal" method="post">
                <fieldset>
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Persona</label>
                    <div class="controls">
                      <input type="radio" value="fisica" name="persona" checked="checked" />&nbsp;&nbsp;Física
                      <input type="radio" value="moral" name="persona" />&nbsp;&nbsp;Moral
                    </div>
                  </div>
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Tipo</label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="tipo" name="tipo">
                      	<option value="">Seleccione</option>
                        
                        <option value="administrador">Administrador</option>
                        <option value="gerente">Gerente</option>
                        <option value="agente">Agente</option>
                        <option value="coordinador">Coordinador</option>
                        <option value="director">Director</option>
                        
                      </select>
                    </div>
                  </div>
                  <!--
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Clave</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="clave" name="clave" type="text">
                    </div>
                  </div>
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Folio Nacional</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="folio_nacional" name="folio_nacional" type="text">
                    </div>
                  </div>
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Folio Provicional</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="folio_provincial" name="folio_provincial" type="text">
                    </div>
                  </div>
                  
                                    
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Nombre</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="nombre" name="nombre" type="text">
                    </div>
                  </div>
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Apellidos</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="apellidos" name="apellidos" type="text">
                    </div>
                  </div>
                                    
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Correo</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="email" name="email" type="text">
                    </div>
                  </div>
                  
                                 
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Usuario</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="usuario" name="usuario" type="text" placeholder="El nombre de rol">
                    </div>
                  </div>
                 
                 
                 <div class="control-group error">
                    <label class="control-label" for="inputError">Contraseña</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="password" name="password" type="text">
                    </div>
                  </div>
                 
                 
                 
                 
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Estatus</label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="estatus" name="estatus">
                      	<option value="">Seleccione</option>
                        <option value="1">Agente vigente</option>
                        <option value="2">Agente cancelado</option>
                      </select>
                    </div>
                  </div>
                 
                 
                 <div class="control-group error">
                    <label class="control-label" for="inputError">Tipo de Persona</label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="persona" name="persona">
                      	<option value="">Seleccione</option>
                        <option value="1">Persona Fisica</option>
                        <option value="2">Persona Moral</option>
                      </select>
                    </div>
                  </div>
                 
                 
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Fecha nacimiento</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="fecha_nacimiento" name="fecha_nacimiento" type="text">
                    </div>
                  </div>
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Fecha vencimiento cédula</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="fecha_vencimiento" name="fecha_vencimiento" type="text">
                    </div>
                  </div>
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Representante</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="representante" name="representante" type="text">
                    </div>
                  </div>
                 
                 
                 
                 <div class="control-group error">
                    <label class="control-label" for="inputError">Teléfono oficina</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="telefono_oficina" name="telefono_oficina" type="text">
                    </div>
                  </div>
                  
                  
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Teléfono movil</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="telefono_movil" name="telefono_movil" type="text">
                    </div>
                  </div>
                 -->
                 
                 
                  <div id="actions-buttons-forms" class="form-actions">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button class="btn" onclick="history.back()">Cancelar</button>
                  </div>
                </fieldset>
              </form>
        
        </div>
    </div><!--/span-->

</div><!--/row-->
			