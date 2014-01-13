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
            <a href="<?php echo base_url() ?>">Inicio</a> <span class="divider">/</span>
        </li>
        <li>
           <a href="<?php echo base_url() ?>activities<?php if( !empty( $userid ) ) echo '/activities'  ?>.html">Actividades</a> <span class="divider">/</span>
        </li>
        <li>
            Reporte <span class="divider">/</span>
        </li>
        <?php
        if (isset($_POST['begin'])) echo "<li>Desde ".$_POST['begin']." hasta ".$_POST['end']."</li>";
        ?>       
    </ul>
</div>
<form id="form" action="<?php echo base_url() ?>activities/report.html" class="form-horizontal" method="post">
    <fieldset>
      <div class="control-group">
        <label class="control-label text-error" for="inputError">Semana</label>
        <div class="controls">
          
          <div id="week"></div>
          <label></label> <span id="startDate"></span>  <span id="endDate"></span>
           <input id="begin" name="begin" type="hidden" readonly="readonly" value="<?php echo set_value('begin')  ?>">
           <input id="end" name="end" type="hidden" readonly="readonly" value="<?php echo set_value('end')  ?>">
        </div>
      </div>
      <div id="actions-buttons-forms" class="form-actions">
        <button type="submit" class="btn btn-primary">Ver reporte</button>
      </div>
    </fieldset>
</form>

<div class="row-fluid sortable">		
    <div class="box span12">
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
                                            
        	<?php if( !empty( $data ) ): ?>
            <table class="table table-striped table-bordered bootstrap-datatable datatable tablesorter sortable altrowstable" id="sorter">
              <thead class="head">
                  <tr>
                      <th id="agente" class="header_manager">Agente</th>
                      <th id="cita" class="header_manager">Citas</th>
                      <th id="entrevista" class="header_manager">Entrevistas</th>
                      <th id="prospecto" class="header_manager">Prospectos</th>
                      <th id="comentario" class="header_manager">Comentarios</th>
                  </tr>
              </thead>   
              <tbody class="tbody">
                <?php  foreach( $data as $value ): ?>
               <tr>
                	<td class="center"><?php echo $value['name'] . " " . $value['lastnames']?></td>
                    <td class="center"><?php echo $value['cita'] ?></td>
                    <td class="center"><?php echo $value['interview'] ?></td>
                    <td class="center"><?php echo $value['prospectus'] ?></td>
                    <td class="center"><?php echo $value['comments'] ?></td>
                </tr>
                <?php endforeach;  ?>                
              </tbody>
          </table>    
          		  
		  <?php endif; ?>
                           
        </div>
    </div><!--/span-->

</div><!--/row-->
