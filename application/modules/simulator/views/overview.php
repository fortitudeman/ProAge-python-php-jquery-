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
           <a href="<?php echo base_url() ?>simulator.html">Simulador</a> <span class="divider">/</span>
        </li>
               
        <li>
            Overview
        </li>
    </ul>
</div>

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
          
          <?php if( isset(  $data[0]['product_group_id'] ) and   $data[0]['product_group_id'] == 1 ): ?>  
              <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="vida">Vida</a>
          <?php else: ?>   
              <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="vida">Vida</a>
          <?php endif; ?>              
          
          <?php 	if( isset(  $data[0]['product_group_id'] ) and  $data[0]['product_group_id'] == 2 ): ?> 
              <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="gmm" style="color:#06F">GMM</a>
          <?php else: ?>   
              <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="gmm" style="color:#000">GMM</a>
          <?php endif; ?>     
          
          
          <?php if( isset(  $data[0]['product_group_id'] ) and   $data[0]['product_group_id'] == 3 ): ?> 
              <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="autos" style="color:#06F">Autos</a>
          <?php else: ?>   
              <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="autos" style="color:#000">Autos</a>
          <?php endif; ?>        
          
          <form action="" method="post" id="form">
          
          <input type="hidden" id="ramo" name="ramo" value="<?php if( isset( $data[0]['product_group_id'] ) ) echo $data[0]['product_group_id']; else echo 1; ?>" />    
          
          <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agentid ?>" />    
          
          <input type="hidden" id="id" name="id" value="<?php if( isset( $data[0]['id'] ) ) echo $data[0]['id']; else echo 0; ?>" />    
         
         <div class="row">
         
         <div class="span5" style="margin-left:40px;">
         	
            <?php if( isset( $data[0]['data'] ) )
					 $dataview = array( 'data' => $data[0]['data'] );
				   else $dataview = array();  
				  
				  
				  $this->load->view( 'simulador', $dataview ) ?>
            
         </div>
         
         <div class="span6" >
         	
            <?php $this->load->view( 'metas' ) ?>
            
         </div>
           
         </div>  
           
           </form>                                 
        	                           
        </div>
    </div><!--/span-->

</div><!--/row-->
