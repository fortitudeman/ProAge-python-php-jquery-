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
            <a href="<?php echo base_url() ?>roles.html">Role</a> <span class="divider">/</span>
        </li>
        <li>
             <a href="<?php echo base_url() ?>roles/update/<?php echo $data['id'] ?>.html"> Editar </a> <span class="divider">/</span> 
        </li>
        <li>
            <?php echo $data['name'] ?>
        </li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Eliminar rol</h2>
            <div class="box-icon">
               
            </div>
        </div>
        
        <div class="box-content">
        	
            
			<h3>Eliminar el rol <?php echo $data['name'] ?></h3>           
            
            <p>Todos los datos se eliminaran por completo.</p>
            
            <p>Esta seguro de eliminar este registro.</p>
            
        
            <form id="form" action="<?php echo base_url() ?>roles/delete/<?php echo $data['id'] ?>.html" class="form-horizontal" method="post">
                <fieldset>
                  <input type="hidden" name="delete" value="true" />
                  <div id="actions-buttons-forms" class="form-actions">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button class="btn" onclick="history.back()">Cancelar</button>
                  </div>
                </fieldset>
              </form>
        
        </div>
    </div><!--/span-->

</div><!--/row-->
			