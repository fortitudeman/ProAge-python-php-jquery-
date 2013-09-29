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
            <a href="<?php echo base_url() ?>activities.html">Actividad</a> <span class="divider">/</span>
        </li>
        <li>
            Crear
        </li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
           
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
            
            
            
        
            <form id="form" action="<?php echo base_url() ?>activities/create.html" class="form-horizontal" method="post">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Semana</label>
                    <div class="controls">
                      
                      <div id="week"></div>
                      <label></label> <span id="startDate"></span> - <span id="endDate"></span>
                       <input id="begin" name="begin" type="hidden" readonly="readonly" value="<?php echo set_value('begin')  ?>">
                       <input id="end" name="end" type="hidden" readonly="readonly" value="<?php echo set_value('end')  ?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Cita</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="cita" name="cita" type="text" value="<?php echo set_value('cita')  ?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Prospecto</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="prospectus" name="prospectus" type="text" value="<?php echo set_value('prospectus')  ?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label text-error" for="inputError">Entrevista</label>
                    <div class="controls">
                      <input class="input-xlarge focused required" id="interview" name="interview" type="text" value="<?php echo set_value('interview')  ?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="inputError">Comentarios</label>
                    <div class="controls">
                     <textarea name="comments" class="input-xlarge" rows="10"><?php echo set_value('comments')  ?></textarea>
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
			