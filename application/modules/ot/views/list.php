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
            Overview
        </li>
    </ul>
</div>

<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2></h2>
            <div class="box-icon">
               <a href="<?php echo base_url() ?>ot/create.html" class="btn btn-round"><i class="icon-plus"></i></a>
            </div>
        </div>
        <div class="box-content">
        
        	
            
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
            
                                   
            <div class="row">
            	<div class="span1"></div>
            	<div class="span6">
                	<a href="javascript:void(0);" class="btn btn-link">Todas</a>
                    <a href="javascript:void(0);" class="btn btn-link">Tramite</a>
                    <a href="javascript:void(0);" class="btn btn-link">Canceladas</a>
                    <a href="javascript:void(0);" class="btn btn-link">Pagadas</a>
                    <a href="javascript:void(0);" class="btn btn-link">Excedido</a>
                </div>
                
                <div class="span3"></div>
                <div class="span1"><a href="<?php echo base_url() ?>ot/create.html" class="btn btn-link">Agregar</a></div>
                
            </div>
            
            <div id="loading"></div>
            
        
        	<?php if( !empty( $data ) ): ?>
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Fecha de creación</th> 
                      <th>Agente</th>
                      <th>Ramo</th>
                      <th>Nombre del asegurado</th>
                      <th>Estado</th>
                      <th>Tiempo</th>
                  </tr>
              </thead>   
              <tbody id="data">
                <?php  foreach( $data as $value ):  ?>
                <tr>
                	<td class="center"><?php if( $value['product_group_id'] == 1 ) echo '0725V'; 
											 if( $value['product_group_id'] == 2 ) echo '0725G';
											 if( $value['product_group_id'] == 3 ) echo '0725A'; ?></td>
                    <td class="center"><?php echo $value['creation_date'] ?></td>
                    <td class="center">
						<?php 
							if( !empty( $value['agents'] ) )
								foreach( $value['agents'] as $agent ) 
									echo $agent['name']. ' '. $agent['lastnames']. ' '. $agent['percentage'] . '% <br>'
						?>
                    </td>
                    <td class="center"><?php echo $value['group_name'] ?></td>
                    <td class="center"><?php if( !empty( $value['policy'] ) )echo $value['policy'][0]['name']. ' '. $value['policy'][0]['lastname_father']. ' '. $value['policy'][0]['lastname_mother'] ?></td>
                    
                    <?php
						$color = diferenciaEntreFechas( date('Y-m-d H:i:s'), $value['creation_date'], "DIAS", FALSE );
						//$color = $color*.100;
						$style = '';
						
						if( $color == 50 ) 
							$style = 'style="background-color:#489133"';
						if( $color > 50 )	
							$style = 'style="background-color:#FF0"';
						if( $color > 100 )	
							$style = 'style="background-color:#FF0"';
						
							
					?>	
                    
                    <td class="center" <?php echo $style ?>><?php echo ucwords($value['status_name']) ?></td>
                    <td class="center"><?php echo tiempo_transcurrido($value['creation_date']) ?></td>
                </tr>
                <?php endforeach;  ?>                
              </tbody>
          </table>    
          
          
          
          
          <?php else: ?>
		  
		  	<div class="alert alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Atención: </strong> No se encontrarón registros, agregar uno <a href="<?php echo base_url() ?>ot/create.html" class="btn btn-link">Aquí</a>
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

