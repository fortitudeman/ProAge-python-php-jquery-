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
           <a href="<?php echo base_url() ?>usuarios.html">Usuarios</a> <span class="divider">/</span>
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
               <?php if( $access_create == true ): ?><a href="<?php echo base_url() ?>usuarios/create.html" class="btn btn-round"><i class="icon-plus"></i></a><?php endif; ?>
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
                      <td>Buscar</td>
                      <td colspan="2"><form id="search" method="post"><input type="text" id="find" name="find"/><input type="hidden" id="pag" name="pag" value="<?php echo base_url() . $pag ?>" /><input type="hidden" id="typeexport" /><input type="button" id="searchfind" value="Filtrar"  class="btn btn-link"/>
                      
                      <br />
                      
                      <a href="javascript:void(0)" id="showadvanced" class="btn- btn-link link-advanced">Avanzadas</a> 
                      
                      <div class="row advanced">
                      	
                                                	
                             <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="clave" /> Clave  <input type="text" id="clave" class="hide input-small" /><br />
                             <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="birthdate" /> Fecha nac. <input type="text" id="birthdate" class="hide input-small" readonly="readonly"/><br />
                            
                                              
                      
                      </div>
                      
                      
                      <div class="row advanced">
                      	                        	
                              <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="national" /> Folio Nac. <input type="text" id="national" class="hide input-small" /><br />
                              <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="provincial" /> Folio prov. <input type="text" id="provincial" class="hide input-small" /><br />
                              <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="manager_id" /> Gerente <select id="manager_id" class="hide input-small" ><option value="">Seleccione</option><?php echo $gerentes ?></select><br />
                                                
                      </div>
                      
                      
                      <div class="row advanced">
                      	                        	
                              <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="name" /> Nombre. <input type="text" id="name" class="hide input-small" /><br />
                              <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="lastname" /> Apellido. <input type="text" id="lastname" class="hide input-small" /><br />
                              <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="email" /> Correo. <input type="text" id="email" class="hide input-small" /><br />
                                                
                      </div>
                      
                      <div class="row advanced">
                      	                        	
                               <input type="checkbox" name="advanced[]" class="checkboxadvance"  value="license_expired_date" /> Fecha de ven. <input type="text" id="license_expired_date" class="hide input-small"  readonly="readonly"/><br />
                                                
                      </div>
                      
                     			<input type="hidden" name="rol" id="rolsearch" />
                      
                      
                     
                      
                      </form></td> 
                      <th colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      <td><?php if( $access_create == true ): ?><a href="<?php echo base_url() ?>usuarios/create.html" class="btn btn-link">Crear</a><?php endif; ?></td>
                      <td><?php if( $access_request_new_user == true ): ?><a href="<?php echo base_url() ?>usuarios/create_request_new_user.html" class="btn btn-link">Crear Petición nuevo usuario</a><?php endif; ?></td>
                      <td><?php if( $access_import == true ): ?><a href="<?php echo base_url() ?>usuarios/importar.html" class="btn">Importar</a><?php endif; ?></td>
                      <td><?php if( $access_export == true ): ?><button id="create-export" class="btn">Exportar</button><?php endif; ?></td>
                  </tr>
              </thead>   
              
            </table>  
            <br />
            <div class="row">
            	<div class="span7 pull-right">
					<?php if( !empty( $rol ) ): foreach(  $rol  as $value ): ?>
						
                        <a href="javascript:void(0)" id="<?php echo $value['id'] ?>" class="btn btn-link rol-search"><?php echo $value['name'] ?></a>
                    
					<?php endforeach; endif; ?>
                    
                    <a href="javascript:void(0)" id="" class="btn btn-link rol-search">Todos</a>
                    
                </div>
            </div>
        	
            <div id="dialog-form" title="">
  				Que quiere exportar?
                <br /><br />
                <a href="javascript:void(0)" class="btn btn-link" id="pagactual">Página Actual</a>
                <a href="javascript:void(0)" class="btn btn-link" id="busactual">Resultado Actual</a>
			</div>
			
            
            
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
                      <th>Acciones</th>
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
                    <td>
                    	
                                                                        
                         <?php if( $access_update == true ): ?>
                        <a class="btn btn-info" href="<?php echo base_url() ?>usuarios/update/<?php echo $value['id'] ?>.html" title="Editar Usuario">
                            <i class="icon-edit icon-white"></i>            
                        </a>
                        <?php endif; ?>
                        <?php if( $access_delete == true ): ?>
                        <a class="btn btn-danger" href="<?php echo base_url() ?>usuarios/delete/<?php echo $value['id'] ?>.html" title="Eliminar Usuario">
                            <i class="icon-trash icon-white"></i> 
                        </a>
                        <?php endif; ?>
                    </td>
                        
                    </td>
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

