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

            <div class="row">
                <div class="span6"></div>
                <div class="span4"></div>
                <div class="span1">
				   <?php if ( ( $access_export == true ) && isset($_POST['begin']) && isset($_POST['end'])) : ?>
				   <form id="form" action="<?php echo base_url() ?>activities/exportar.html" class="form-horizontal" method="post">
				      <button id="create-export" class="btn pull-right">Exportar</button>
					  <input id="begin-export" name="begin" type="hidden" readonly="readonly" value="<?php echo $_POST['begin'] ?>" />
					  <input id="end-export" name="end" type="hidden" readonly="readonly" value="<?php echo $_POST['end'] ?>" />				  
				   </form>
				   <?php endif; ?>
                </div>
            </div>
            <br /><br />

            <table class="table table-striped table-bordered bootstrap-datatable datatable tablesorter sortable altrowstable" id="sorter">
              <thead class="head">
                  <tr>
                      <th id="agente" class="header_manager">Agente</th>
                      <th id="cita" class="header_manager">Citas</th>
                      <th id="entrevista" class="header_manager">Entrevistas</th>
                      <th id="prospecto" class="header_manager">Prospectos</th>
                      <th id="vida_requests" class="header_manager" style="background-color: rgb(179, 252, 212);">Solicitudes Vida</th>
                      <th id="vida_businesses" class="header_manager" style="background-color: rgb(179, 252, 212);">Negocios Vida</th>
                      <th id="gmm_requests" class="header_manager" style="background-color: rgb(179, 212, 252);">Solicitudes GMM</th>
                      <th id="gmm_businesses" class="header_manager" style="background-color: rgb(179, 212, 252);">Negocios GMM</th>
                      <th id="autos_businesses" class="header_manager" style="background-color: rgb(252, 221, 176);">Negocios Autos</th>
                      <th id="comentario" class="header_manager">Comentarios</th>
                  </tr>
              </thead> 
              <tfoot>
                  <tr style="font-weight:bold">
                      <td>TOTALS</td>
                      <td><?php echo $data['totals']['cita'] ?></td>
                      <td><?php echo $data['totals']['interview'] ?></td>
                      <td><?php echo $data['totals']['prospectus'] ?></td>
                      <td style="background-color: rgb(179, 252, 212);"><?php echo $data['totals']['vida_requests'] ?></td>
                      <td style="background-color: rgb(179, 252, 212);"><?php echo $data['totals']['vida_businesses'] ?></td>
                      <td style="background-color: rgb(179, 212, 252);"><?php echo $data['totals']['gmm_requests'] ?></td>
                      <td style="background-color: rgb(179, 212, 252);"><?php echo $data['totals']['gmm_businesses'] ?></td>
                      <td style="background-color: rgb(252, 221, 176);"><?php echo $data['totals']['autos_businesses'] ?></td>
                      <td></td>
                  </tr>
              </tfoot> 			  
              <tbody class="tbody">
                <?php  foreach( $data['rows'] as $value ): ?>
               <tr>
                	<td class="center"><?php echo $value['name'] . " " . $value['lastnames']?></td>
                    <td class="center"><?php echo $value['cita'] ?></td>
                    <td class="center"><?php echo $value['interview'] ?></td>
                    <td class="center"><?php echo $value['prospectus'] ?></td>
                    <td class="center" style="background-color: rgb(179, 252, 212);"><?php echo $value['vida_requests'] ?></td>
                    <td class="center" style="background-color: rgb(179, 252, 212);"><?php echo $value['vida_businesses'] ?></td>
                    <td class="center" style="background-color: rgb(179, 212, 252);"><?php echo $value['gmm_requests'] ?></td>
                    <td class="center" style="background-color: rgb(179, 212, 252);"><?php echo $value['gmm_businesses'] ?></td>
                    <td class="center" style="background-color: rgb(252, 221, 176);"><?php echo $value['autos_businesses'] ?></td>
                    <td class="center"><?php echo $value['comments'] ?></td>
                </tr>
                <?php endforeach;  ?>                
              </tbody>
          </table>    
          		  
		  <?php endif; ?>
                           
        </div>
    </div><!--/span-->

</div><!--/row-->
