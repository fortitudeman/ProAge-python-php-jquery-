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
            
                                   
            <div class="row">
            	<div class="span1"></div>
            	<div class="span7">
                	<?php if( $access_all == true ): ?>
                    <a href="javascript:void(0);" class="btn btn-link find" id="todas">Todas</a>
                    <?php endif; ?>
                    <a href="javascript:void(0);" class="btn find btn-primary" id="mios">Mios</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0)" id="showadvanced" class="btn- btn-link link-advanced">Mostrar Avanzadas</a> 
                </div>
                
                <div class="span2"></div>
                <div class="span1"></div>
                
            </div>
            
            
            <div class="row">
            
            	
                <div class="span1"></div>
                <div class="span7">
                	<br /><br />
                    

                    <input type="hidden" id="findvalue" value="mios" />
                    <input type="hidden" id="findsubvalue" value="activadas" />
                    
                    <br /><br />  
                      <div class="row advanced">
                      		
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="activadas">Activadas</a>
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="tramite">Pendientes</a>
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="canceladas">Canceladas</a>
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="pagadas">Pagadas</a>
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="excedido">Excedido</a>
                            <br /><br />
                             <table class="table table-bordered bootstrap-datatable datatable">           	
                             	<tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="id" /> Número</td>
                                  <td><input type="text" id="id" class="hide input findfilters" /></td>
                                </tr>
                                
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="creation_date" /> Fecha. </td>
                                  <td><input type="text" id="creation_date" class="hide input findfilters" readonly="readonly"/></td>
                                </tr>
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="agent" /> Agente</td>
                                  <td><select id="agent" class="hide input-small findfilters" ><?php echo $agents ?></select></td>
                                </tr>
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="ramo" /> Ramo</td>
                                  <td><select id="ramo" class="hide input-small findfilters" ><option value="">Seleccione</option><option value="1">Vida</option><<option value="2">GMM</option><<option value="3">Autos</option></select></td>
                                </tr>
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="gerente" /> Gerente</td>
                                  <td><select id="gerente" class="hide input-small findfilters" ><option value="">Seleccione</option><?php echo $gerentes ?></select></td>
                                </tr>                                
                             </table>
                             
                      </div>
                                            
                                    	
                </div>
                
            </div>
            
            
            
            
            
            
            
            
            
            <div id="loading"></div>
            
        
        	<?php  if( !empty( $data ) ): ?>
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
              <thead>
                  <tr>
                      <th>Número de OT</th>
                      <th>Fecha de alta de la OT</th> 
                      <th>Agente - %</th>
                      <th>Ramo</th>
                      <th>Tipo de trámite</th>
                      <th>Nombre del asegurado</th>
                      <th>Estado</th>
                  </tr>
              </thead>   
              <tbody id="data">
                <?php  foreach( $data as $value ):  ?>
                <tr id="<?php echo $value['id'] ?>">
                	<td class="center"><?php echo $value['id'];
											 if( $value['product_group_id'] == 1 ) echo '0725V'; 
											 if( $value['product_group_id'] == 2 ) echo '0725G';
											 if( $value['product_group_id'] == 3 ) echo '0725A'; ?></td>
                    <td class="center"><?php if( $value['creation_date'] != '0000-00-00 00:00:00' ) echo $value['creation_date'] ?></td>
                    <td class="center">
						<?php 
							if( !empty( $value['agents'] ) )
								foreach( $value['agents'] as $agent ) 
									echo $agent['name']. ' '. $agent['lastnames']. ' '. $agent['percentage'] . '% <br>'
						?>
                    </td>
                    <td class="center"><?php echo $value['group_name'] ?></td>
                    <td class="center"><?php echo $value['parent_type_name']['name'] ?></td>
                    <td class="center"><?php if( !empty( $value['policy'] ) )echo $value['policy'][0]['name']. ' '. $value['policy'][0]['lastname_father']. ' '. $value['policy'][0]['lastname_mother'] ?></td>
                    
                    <?php
						$color = diferenciaEntreFechas( date('Y-m-d H:i:s'), $value['creation_date'], "DIAS", FALSE );
						
						$color = $color/strtotime( date('Y-m-d H:i:s') );
						
						$color = $color * 100;							
					?>	
                    
                    
                    
                    
                    <td class="center" >
						<?php 
							if( $value['status_name'] != 'activacion' ) {
								if( (float)$color <= 5 ) 
									echo '<div style="background-color:#0C0; width: 10px;  height: 10px; border-radius: 50%;"></div>';
								else if( (float)$color > 5 )	
									echo '<div style="background-color:#FF0; width: 10px;  height: 10px; border-radius: 50%;"></div>';									
								else if( (float)$color > 10 )	
									echo '<div style="background-color:#F30; width: 10px;  height: 10px; border-radius: 50%;"></div>';
							}
						?>
                    </td>
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

