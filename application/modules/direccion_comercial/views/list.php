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
            Role
        </li>
    </ul>
</div>

<div class="row-fluid sortable">		
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Rol</h2>
            <div class="box-icon">
               <a href="<?php echo base_url() ?>roles/create.html" class="btn btn-round"><i class="icon-plus"></i></a>
            </div>
        </div>
        <div class="box-content">
        
        	
            
            <?php // Show Messages ?>
            
            <?php if( isset( $message['type'] ) ): ?>
               
               
                <?php if( $message['type'] == true ): ?>
                    <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <img src="<?php echo base_url() ?>images/true.png" width="20" height="20" />
                          <strong>Correcto: </strong> <?php  echo $message['message']; // Show Dinamical message Success ?>
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
                      <th>Role</th>
                      <th>Creado</th>
                      <th>Última modificación</th>
                      <th>Actions</th>
                  </tr>
              </thead>   
              <tbody>
                <?php  foreach( $data as $value ):  ?>
                <tr>
                    <td><?php echo $value['name'] ?></td>
                    <td class="center"><?php echo $value['created'] ?></td>
                    <td class="center"><?php echo $value['modified'] ?></td>
                    <td class="center">
                        <a class="btn btn-success" href="<?php echo base_url() ?>roles/permisions/<?php echo $value['id'] ?>.html" title="Ver y asignar permisos de este rol">
                            <i class="icon-zoom-in icon-white"></i>         
                        </a>
                        <a class="btn btn-info" href="<?php echo base_url() ?>roles/update/<?php echo $value['id'] ?>.html" title="Editar rol">
                            <i class="icon-edit icon-white"></i>            
                        </a>
                        <a class="btn btn-danger" href="<?php echo base_url() ?>roles/delete/<?php echo $value['id'] ?>.html" title="Eliminar rol">
                            <i class="icon-trash icon-white"></i> 
                        </a>
                    </td>
                </tr>
                <?php endforeach;  ?>                
              </tbody>
          </table>    
          
          
          
          
          <?php else: ?>
		  
		  	<div class="alert alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Atención: </strong> No hay registros todavía, Agrega uno <a href="<?php echo base_url() ?>roles/create.html" class="btn btn-link">aquí</a>
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