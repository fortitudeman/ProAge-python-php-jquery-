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
           <a href="<?php echo base_url() ?>usuarios.html">Users</a> <span class="divider">/</span>
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
               <a href="<?php echo base_url() ?>usuarios/create.html" class="btn btn-round"><i class="icon-plus"></i></a>
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
            
           
            
            <table class="table">
              <thead>
                  <tr>
                      <th>Search</th>
                      <th colspan="2"><input type="text" id="find"/></th> 
                      <th colspan="5"></th>
                      <th><a href="<?php echo base_url() ?>usuarios/create.html" class="btn btn-link">Create</a></th>
                      <th><a href="#" class="btn btn-link">Import XLS</a></th>
                      <th><a href="#" class="btn btn-link">Esport XLS</a></th>
                  </tr>
              </thead>   
              
            </table>  
        	
            
            
             <div id="loading"></div>
            
            
            
        
        	<?php if( !empty( $data ) ): ?>
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
              <thead>
                  <tr>
                      <th>Clave</th>
                      <th>Folio Nal</th> 
                      <th>Folio Prov</th>
                      <th>Gerente</th>
                      <th>Nombre</th>
                      <th>Apellidos</th>
                      <th>Correo</th>
                      <th>Tipo</th>
                      <th>Creado</th>
                      <th>Última modificación</th>
                  </tr>
              </thead>   
              <tbody id="data">
                <?php  foreach( $data as $value ):  ?>
                <tr>
                	<td class="center"><?php echo $value['clave'] ?></td>
                    <td class="center"><?php echo $value['national'] ?></td>
                    <td class="center"><?php echo $value['provincial'] ?></td>
                    <td class="center"><?php echo $value['manager_id'] ?></td>
                    <td class="center"><?php echo $value['name'] ?></td>
                    <td class="center"><?php echo $value['lastnames'] ?></td>
                    <td class="center"><?php echo $value['email'] ?></td>
                    <td class="center"><?php echo $value['tipo'] ?></td>
                    <td class="center"><?php echo $value['date'] ?></td>
                    <td class="center"><?php echo $value['last_updated'] ?></td>
                </tr>
                <?php endforeach;  ?>                
              </tbody>
          </table>    
          
          
          
          
          <?php else: ?>
		  
		  	<div class="alert alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Warning: </strong> No records found, Add one <a href="<?php echo base_url() ?>usuarios/create.html" class="btn btn-link">here</a>
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