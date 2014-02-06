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

<?php if (!$for_print): ?>
<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <p><?php if( isset( $agent ) ) echo $agent ?></p>
            <div class="box-icon">
                                                       
                   <?php if( $access_create == true ): ?>
                   		<!--<a href="<?php echo base_url() ?>simulator/create.html" class="btn btn-link" title="Crear"><i class="icon-plus"></i></a>-->
				   <?php endif; ?>
                                                 
            </div>
        </div>
        <div class="box-content">
<?php endif; ?>
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

          <?php
			$uri_segments = $this->uri->rsegment_array();
			$uri_segments[2] = 'print_index';
			$link_attributes = 'class="btn btn-primary" id="print-button"';
			if (!$for_print) {
				$link_attributes .= ' target="_blank"';
				$link_text = 'Vista previa de impresión';
			}
			else
				$link_text = 'Imprimir';
		  ?> 
          <p style="float: right; padding-top: 10px; margin-right: 3em"><?php echo anchor(implode('/', $uri_segments), $link_text, $link_attributes); ?></p>
          <h3>Simulador de metas para <?php echo $users[0]['name'] . " " . $users[0]['lastnames']?></h3>

          <?php if( isset( $data[0]['product_group_id'] ) and $data[0]['product_group_id'] == 1 or isset( $ramo ) and $ramo == 'vida' ): $ramoID = 1; ?>  
              <a href="../<?php echo $userid; ?>/1.html" class="links-menu btn btn-link" id="vida" style="color:#06F">Vida</a>
          <?php else: ?>   
              <a href="../<?php echo $userid; ?>/1.html" class="links-menu btn btn-link" id="vida" style="color:#000">Vida</a>
          <?php endif; ?>              
                              
          <?php if( isset( $data[0]['product_group_id'] ) and $data[0]['product_group_id'] == 2 or isset( $ramo ) and $ramo == 'gmm' ): $ramoID = 2; ?> 
              <a href="../<?php echo $userid; ?>/2.html" class="links-menu btn btn-link" id="gmm" style="color:#06F">GMM</a>
          <?php else: ?>   
              <a href="../<?php echo $userid; ?>/2.html" class="links-menu btn btn-link" id="gmm" style="color:#000">GMM</a>
          <?php endif; ?>     
          
          
          <?php /* if( isset( $data[0]['product_group_id'] ) and $data[0]['product_group_id'] == 3 or isset( $ramo ) and $ramo == 'autos' ): $ramoID = 3; ?> 
              <a href="../<?php echo $userid; ?>/3.html" class="links-menu btn btn-link" id="autos" style="color:#06F">Autos</a>
          <?php else: ?>   
              <a href="../<?php echo $userid; ?>/3.html" class="links-menu btn btn-link" id="autos" style="color:#000">Autos</a>
          <?php endif; */ ?>        
          
          <form action="" method="post" id="form">
          
          <input type="hidden" id="ramo" name="ramo" value="<?php if( isset( $ramoID ) ) echo $ramoID; else echo 1; ?>" />    
          
          <input type="hidden" id="userid" name="userid" value="<?php echo $userid ?>" />    
          
          <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agentid ?>" />  
                   
          <input type="hidden" id="id" name="id" value="<?php if( isset( $data[0]['id'] ) ) echo $data[0]['id']; else echo 0; ?>" />    
         
        <!-- <img src="<?php echo base_url() ?>images/distribucion.png" /> -->
         
         <div class="row" style="margin-right: 3em">
         
         <div class="span11 simulator" style="margin-left:40px;">
         	<?php $data[0]['data'] ?>
            <?php if( isset( $data[0]['data'] ) )
					 $dataview = array( 'data' => $data[0]['data'] );
				   else $dataview = array();  
				  
				  
				  $this->load->view( 'simulator_'.$ramo, $dataview ) ?>
            
         </div>
          <div class="span12 metas" >
                    
            <?php if( isset( $config ) ){
					 $dataview = array( 'config' => $config );
				  } else $dataview = array();  
				  				  
				  $this->load->view( 'metas', array( $dataview ) ) ?>
            
         </div>
           
         </div>  
           
           </form>                                 
 <?php if (!$for_print): ?>        	                           
        </div><!-- /.box-content -->
    </div><!--/span-->

</div><!--/row-->
<?php endif; ?>