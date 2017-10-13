<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url("groups.html") ?>">Grupos</a> <span class="divider">/</span>
        </li>
        <li>
            Crear
        </li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Agregar nuevo grupo</h2>
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
            
            
            
            <?= form_open('', 'id="form" class="form-horizontal"'); ?>
                <fieldset>
                  <div class="control-group error">
                    <label class="control-label" for="inputError">Nombre</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="name" name="name" type="text" placeholder="El nombre del nuevo grupo" value="<?= set_value("name")  ?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="inputError">Filtro en Ramo</label>
                    <div class="controls">
                      <?= form_dropdown('ramo', $ramos, set_value("ramo"), "class='form-control required'"); ?>
                    </div>
                  </div>
                 
                  <div id="actions-buttons-forms" class="form-actions">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button class="btn" onclick="history.back()">Cancelar</button>
                  </div>
                </fieldset>
              </form>
        
        </div>
    </div><!--/span-->

</div><!--/row-->
			