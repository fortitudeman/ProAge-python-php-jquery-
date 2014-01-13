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
           <a href="<?php echo base_url() ?>activities/activities.html">Actividades</a> <span class="divider">/</span>
        </li>
        <li>
            Overview <span class="divider">/</span>
        </li>       
        <li>
            <?php if( !empty( $usersupdate['company_name'] ) ) echo $usersupdate['company_name']; else echo $usersupdate['name'].' '.$usersupdate['lastnames']; ?>
        </li>
    </ul>
</div>

<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2></h2>
            <div class="box-icon">
                  
                   <?php if( $access_create == true ): ?>
                   		<a href="<?php echo base_url() ?>activities/create<?php if( !empty( $userid ) ) echo '/'.$userid  ?>.html" class="btn btn-link" title="Crear"><i class="icon-plus"></i></a>
				   <?php endif; ?>
                                                 
            </div>
        </div>
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
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
              <thead>
                  <tr>
                      <th>Inicio</th>
                      <th>Fin</th> 
                      <th>Citas</th>
                      <th>Entrevistas</th>
                      <th>Prospectos</th>
                      <th>Comentarios</th>
                      <th>Creado</th>
                      <th>Última modificación</th>
                  </tr>
              </thead>   
              <tbody id="data">
                <?php  foreach( $data as $value ): ?>
               <tr>
                	<td class="center"><?php echo $value['begin'] ?></td>
                    <td class="center"><?php echo $value['end'] ?></td>
                    <td class="center"><?php echo $value['cita'] ?></td>
                    <td class="center"><?php echo $value['interview'] ?></td>
                    <td class="center"><?php echo $value['prospectus'] ?></td>
                    <td class="center"><?php echo $value['comments'] ?></td>
                    <td class="center"><?php echo $value['date'] ?></td>
                    <td class="center"><?php echo $value['last_updated'] ?></td>                                            
                </tr>
                <?php endforeach;  ?>                
              </tbody>
          </table>    
          
          
          
          
          <?php else: ?>
		  
		  	<div class="alert alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Atención: </strong> No hay registro de actividades. . <a href="<?php echo base_url() ?>activities/create<?php if( !empty( $userid ) ) echo '/'.$userid  ?>.html" class="btn btn-link">Haga click aquí para capturar un nuevo registro</a>
            </div>
		  <?php endif; ?>
                           
        </div>
    </div><!--/span-->

</div><!--/row-->

<?php $pagination = $this->pagination->create_links(); // Set Pag ?>

<?php if( !empty( $pagination ) ): ?>
    
    <div class="row-fluid sortable">		
        <div class="box span12">
            <div class="box-content">
            
              <?php echo $pagination?>
                      
            </div>
        </div><!--/span-->
    
    </div><!--/row-->

<?php endif; ?>

