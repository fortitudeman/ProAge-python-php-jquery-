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
            <a href="<?php echo base_url() ?>orden_trabajo.html">Orden de trabajo</a> <span class="divider">/</span>
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
            
             <?php // Show Messages ?>
            
            <?php if( isset( $message['type'] ) ): ?>
               
               
                <?php if( $message['type'] == true ): ?>
                    <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/true.png" width="20" height="20" />
                          <strong>Success: </strong> <?php  echo $message['message']; // Show Dinamical message Success ?>
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
            
            
        
            <form id="form" action="<?php echo base_url() ?>ot/create.html" class="form-horizontal" method="post">
                <fieldset>
                     
                  
                  
                  <div class="control-group">
                    <label class="control-label error" for="inputError">Número OT</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="ot" name="ot" type="text">
                    </div>
                  </div>
                  
                  
                   <div class="control-group">
                    <label class="control-label error" for="inputError">Fecha de tramite</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="creation_date" name="creation_date" type="text" readonly="readonly">
                    </div>
                  </div>
                                                                                      
                  
                  <div class="control-group">
                    <label class="control-label error" for="inputError">Ramo</label>
                    <div class="controls">
                      <input type="radio" value="1" name="ramo" class="ramo"/>&nbsp;&nbsp;Vida
                      <input type="radio" value="2" name="ramo" class="ramo"/>&nbsp;&nbsp;GIMM
                      <input type="radio" value="3" name="ramo" class="ramo"/>&nbsp;&nbsp;Auto
                    </div>
                  </div>
                  
                  
                  
                  <div class="control-group typtramite">
                    <label class="control-label error" for="inputError">Tipo tramite<br /><div id="loadtype"></div></label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="work_order_type_id" name="work_order_type_id">
                      	<option value="">Seleccione</option> 

                      </select>
                    </div>
                  </div>
                  
                  
                   <div class="control-group subtype">
                    <label class="control-label error" for="inputError">Sub tipo<br /><div id="loadsubtype"></div></label>
                    <div class="controls">
                      <select class="input-xlarge focused required" id="subtype" name="subtype">
                      	<option value="">Seleccione</option>

                      </select>
                    </div>
                  </div>
                  
                  
                  <div id="loadpolicies"></div>
                  
                  
                  
                   <div class="control-group poliza">
                    <label class="control-label error" for="inputError"></label>
                    <div class="controls">
                      <a href="<?php echo base_url() ?>ot/create_poliza.html" class="btn btn-link">Requerir nueva poliza</a>
                    </div>
                  </div> 
                  
                  <div class="control-group poliza">
                    <label class="control-label error" for="inputError">Poliza</label>
                    <div class="controls">
                      <select class="input-xlarge focused" id="policy_id" name="policy_id">
                      	<option value="">Seleccione</option>

                      </select>
                    </div>
                  </div>
                 
                  
                  
                  <div class="control-group">
                    <label class="control-label error" for="inputError">Comentarios</label>
                    <div class="controls">
                      <textarea class="input-xlarge focused required" id="comments" name="comments" rows="6"></textarea>
                    </div>
                  </div>
                  
                                     
                   <!-- ¨Persona Moral Settings -->
                   <fieldset class="block-privacy">
                   
                   	   <a href="javascript:void(0)" id="privacy_add" class="btn btn-link input-moral pull-right" >+</a>
                                         
                      <div id="privacy-fields" class="input-privacy"></div>
                  
                  </fieldset>
                  
                  
                   
                  
                  
                  
                  
                  
                                   
                  
                                    
                  <div id="actions-buttons-forms" class="form-actions">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button class="btn" onclick="javascript: history.back()">Cancelar</button>
                  </div>
                </fieldset>
              </form>
        
        </div>
    </div><!--/span-->

</div><!--/row-->
			