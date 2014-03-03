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
                    <a href="javascript:void(0);" class="btn find btn-primary" id="mios">Mias</a>
                </div>

                <div class="span2"></div>
                <div class="span1"></div>

            </div>
            
            <div class="row"><br />
                <form id="ot-form" method="post">                      	
                  <input class="filter-field" type="hidden" name="user" id="todas-mias" value="mios" />

                  <table class="filterstable">
                    <thead>
                      <tr>
					    <th colspan="5">Número :
  					      <input class="filter-field" type="text" id="id" name="id" title="Pulse la tecla Tab para validar un número a buscar" />
					    </th>
                      </tr>
                      <tr>					  
					    <th>Período :<br />
                          <select class="filter-field" id="periodo" name="periodo">
                            <option value="1">Mes</option>
                            <option value="2" class="set_periodo">Trimestre</option>
                            <option value="3">Año</option>
                          </select>
					    </th>
					    <th>Ramo :<br />
						  <select class="filter-field" id="ramo" name="ramo">
						    <option value="" selected="selected">Seleccione</option>
						    <option value="1">Vida</option>
						    <option value="2">GMM</option>
						    <option value="3">Autos</option>
						  </select>
					    </th>
					    <th>Gerente :<br />
						  <select class="filter-field" id="gerente" name="gerente">
						  <option value="">Seleccione</option>
						  <?php echo $gerentes ?>

						  </select>
					    </th>
					    <th>Agente :<br />
						  <select class="filter-field" id="agent" name="agent">
						  <?php echo $agents ?>

						  </select>
					    </th>
					    <th>Tipo de trámite :<br />
						  <select class="filter-field" id="patent-type" name="patent_type" style="width: 10em">
						    <option value="" selected="selected">Todos</option>
						  </select>
					    </th>
					    <th>Estado :<br />
                          <select class="filter-field" id="work_order_status_id" name="work_order_status_id">
                            <option value="activadas">Activadas</option>
                            <option value="tramite">En trámite</option>
                            <option value="terminada">Terminadas</option>
                            <option value="canceladas">Canceladas</option>
                            <option value="todas" selected="selected">Todas</option>
                          </select>
					    </th>
                      </tr>
                    </thead>

                  </table>
                </form>
            </div>				

            <div id="loading"></div>

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

              </tbody>
          </table>

</div>
        </div>
    </div><!--/span-->

</div><!--/row-->
