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
                    <a href="javascript:void(0);" class="btn find btn-primary" id="mios">Mias</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0)" id="showadvanced" class="btn- btn-link link-advanced">Mostrar Filtros</a> 
                </div>
                
                <div class="span2"></div>
                <div class="span1"></div>
                
            </div>
            
            
            <div class="row">
            
            	
                <div class="span1"></div>
                <div class="span7" id="ot-filter">
                	<br /><br />
                    

                    <input type="hidden" id="findvalue" value="mios" />
                    <input type="hidden" id="findsubvalue" value="todas" />
                    
                    <br /><br />  
                      <div class="row advanced">
                      		
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="activadas">Activadas</a>
                            <a href="javascript:void(0);" class="btn btn-primary findsub" id="tramite">En trámite</a>
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="terminada"> Terminadas</a>
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="canceladas">Canceladas</a>
                          <!--  <a href="javascript:void(0);" class="btn btn-link findsub" id="pagadas">Pagadas</a>
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="excedido">Excedido</a>-->
                            <a href="javascript:void(0);" class="btn btn-link findsub" id="todas">Todas</a>
                            <br /><br />
                             <table class="table table-bordered bootstrap-datatable datatable">           	
                             	<tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="id" /> Número</td>
                                  <td><input type="text" id="id" class="hide input findfilters" /></td>
                                </tr>
                                
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="creation_date" /> Fecha. </td>
                                  <td>
                                  	  <input type="text" id="creation_date" class="hide input-small" readonly="readonly" placeholder="De"/><br />
                                  	  <input type="text" id="creation_date1" class="hide input-small findfilters" readonly="readonly" placeholder="A"/>
                                  </td>
                                </tr>
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="agent" /> Agente</td>
                                  <td><select id="agent" class="hide input-small findfilters" ><?php echo $agents ?></select></td>
                                </tr>
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="ramo" /> Ramo</td>
                                  <td><select id="ramo" class="hide input-small findfilters" ><option value="">Seleccione</option><option value="1">Vida</option><option value="2">GMM</option><option value="3">Autos</option></select></td>
                                </tr>
                                <tr>
                                  <td><input type="checkbox" name="advanced[]" class="checkboxadvance"  value="gerente" /> Gerente</td>
                                  <td><select id="gerente" class="hide input-small findfilters" ><option value="">Seleccione</option><?php echo $gerentes ?></select></td>
                                </tr>                                  
                                <tr>
                                  <td></td>
                                  <td><input type="button" value="Filtrar" class="btn btn-inverse filtros" /></td>
                                </tr>                                
                             </table>
                             
                      </div>
                                            
                                    	
                </div>
                
            </div>
            
            
            
            
            
            
            
            
            
            <div id="loading"></div>
<a href="javascript:void(0);" class="btn find btn-primary" id="toggle-menus">Mostrar/Ocultar menus</a>
<div id="ot-list">
            <table class="sortable altrowstable tablesorter" id="sorter" style="width:100%;">
              <colgroup>
				<col width="5%" />
				<col width="20%" />
				<col width="15%" />
				<col width="10%" />
				<col width="20%" />
				<col width="15%" />
				<col width="15%" />
              </colgroup>
              <thead class="head">
				<tr>
                      <th>Número de OT&nbsp;</th>
                      <th>Fecha de alta de la OT&nbsp;</th> 
                      <th>Agente - %&nbsp;</th>
                      <th>Ramo&nbsp;</th>
                      <th>Tipo de trámite&nbsp;</th>
                      <th>Nombre del asegurado&nbsp;</th>
                      <th>Estado&nbsp;</th>
                  </tr>
              </thead>   
              <tbody class="tbody" id="data">
<?php echo $render_rows ?>
              </tbody>
          </table>

</div>
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

