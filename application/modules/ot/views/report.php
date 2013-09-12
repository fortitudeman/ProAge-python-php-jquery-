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
            Reporte
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
            
            	
                 <div class="span8 offset1">
                	<br /><br />
                    
				       <br /><br />  
                      <div class="row advanced">
                      		
                             <table class="table table-bordered bootstrap-datatable datatable">           	
                             	<tr>
                                  <td>Ramo:</td>
                                  <td><select id="ramo" name="query[]" class="input-xlarge" ><option value="">Seleccione</option><option value="1">Vida</option><<option value="2">GMM</option><<option value="3">Autos</option></select></td>
                                </tr>
                                <tr>
                                  <td>Rango de fechas: </td>
                                  <td>
                                  	  <input type="text" id="creation_date" name="query[]" class="input-small" readonly="readonly" placeholder="De"/><br />
                                  	  <input type="text" id="creation_date1" name="query[]" class="input-small findfilters" readonly="readonly" placeholder="A"/>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td>Tiempo de conexión: </td>
                                  <td>
                                       <input type="text" id="connection_date" name="query[]" class="input-small findfilters" readonly="readonly" placeholder=""/>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td>Gerente: </td>
                                  <td><select id="gerente" class="input-xlarge findfilters" name="query[]" ><option value="">Seleccione</option><?php echo $manager ?></select></td>
                                </tr>                                 
                                <tr>
                                  <td>Agente: </td>
                                  <td><select id="agent" name="query[]" class="input-xlarge findfilters">
                                  	  <option value="">Seleccione</option><option value="1">Vigentes</option><<option value="0">Cancelados</option></select>
                                  </select></td>
                                </tr>
                                
                                                                 
                                <tr>
                                  <td></td>
                                  <td><input type="button" value="Buscar" class="btn btn-inverse filtros" /></td>
                                </tr>                                
                             </table>
                             
                      </div>
                      
                      
                      <table class="table table-bordered bootstrap-datatable datatable" style="margin-left:-50px !important; max-width: 800px !important; overflow:auto;">           	
                             	<tr>
                                  <td style="vertical-align:middle">Cve Unica</td>
                                  <td style="vertical-align:middle">Nombre</td>
                                  <td style="vertical-align:middle">Status Nal</td>
                                  <td style="vertical-align:middle">Fecha de Conexión</td>
                                  <td style="vertical-align:middle">Gen Pai</td>
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">PAGADAS</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Negocios Pai</td>
                                            <td>Primas</td>
                                            <td>Total con Incrementos</td>
                                        </tr>
                                    </table>
                                  </td>
                                  
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">EN TRÁMITE</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Primas</td>
                                        </tr>
                                    </table>
                                  </td>
                                  
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">PENDIENTES DE PAGO</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Primas</td>
                                        </tr>
                                    </table>
                                  </td>
                                  <td>
                                  	<table class="table table-bordered">
                                    	<tr><td colspan="4" style="text-align:center">PROYECCIÓN REAL</td></tr>
                                        <tr>
                                        	<td>Negocios</td>
                                            <td>Primas</td>
                                        </tr>
                                    </table>
                                  </td>
                                </tr>
                                     
                              
                                  
                                                            
                      </table>
                                            
                                    	
                </div>
                
            </div>          
          
                           
        </div>
    </div><!--/span-->

</div><!--/row-->

