<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
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
if ( isset($_POST['query']['periodo']) &&
	($_POST['query']['periodo'] >= 1) && ($_POST['query']['periodo'] <= 4) )
{
	$selected_filter_period = array(1 => '', 2 => '', 3 => '', 4 => '');
	$selected_filter_period[$_POST['query']['periodo']] = ' selected="selected"';
}
else
	$selected_filter_period = get_selected_filter_period();
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
        <div class="box-content">
            <?php // Show Messages ?>            
            <?php if (isset($message['type'])): ?>            
                <?php if ($message['type'] == true): ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <img src="<?php echo base_url() ?>images/true.png" width="20" height="20" />
                        <strong>Listo: </strong> <?php echo $message['message']; // Show Dinamical message Success  ?>
                    </div>
                <?php endif; ?>


                <?php if ($message['type'] == false): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <img src="<?php echo base_url() ?>images/false.png" width="20" height="20" />
                        <strong>Error: </strong> <?php echo $message['message']; // Show Dinamical message error  ?>
                    </div>
                <?php endif; ?>			
            <?php endif; ?> 


            <div class="row">
                <div class="span11" style="margin-left:40px; width:95%">
                    <div class="main-container">
                        <div class="main clearfix">                               
                            <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="vida" <?php if ($other_filters['ramo'] == 1) echo 'style="color:#06F"' ?>>Vida</a>
                            <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="gmm" <?php if ($other_filters['ramo'] == 2) echo 'style="color:#06F"' ?>>GMM</a>
                            <a href="javascript:void(0);" class="links-menu btn btn-link link-ramo" id="autos" <?php if ($other_filters['ramo'] == 3) echo 'style="color:#06F"' ?>>Autos</a>

                            <p class="line">&nbsp; </p>
                            <div>&nbsp;&nbsp;<i style="cursor: pointer" class="icon-calendar" id="cust_update-period" title="Click para editar el período personalizado"></i></div>
                            <form id="form" method="post">                      	
                                <input type="hidden" name="query[ramo]" id="ramo" value="<?php echo $other_filters['ramo'] ?>" />

                                <table  class="filterstable" style="width:99%;">
                                    <thead>
                                        <tr style="vertical-align: top;">
                                            <th>
                                                <select id="periodo" name="query[periodo]" onchange="this.form.submit();">
                                                    <option value="1" <?php echo $selected_filter_period[1] ?>>Mes</option>
<?php if (($other_filters['ramo'] == 1) || ($other_filters['ramo'] == 3)): ?> 
                                                    <option value="2" <?php echo $selected_filter_period[2] ?> class="set_periodo">Trimestre</option>
<?php else: ?>
                                                    <option value="2" <?php echo $selected_filter_period[2] ?> class="set_periodo">Cuatrimestre</option>
<?php endif; ?>
                                                    <option value="3" <?php echo $selected_filter_period[3] ?>>Año</option>
                                                    <option value="4" id="period_opt4" <?php echo $selected_filter_period[4] ?>>Período personalizado</option>
                                                </select>
                                            </th>
                                            <th>
                                                <input type="hidden" id="gerente_value" value="<?php echo $other_filters['gerente']; ?>" />
                                                <select id="gerente" name="query[gerente]" class="select" style="width:145px;" onchange="this.form.submit();">
                                                    <option value="">Todos los gerentes</option>                                        
                                                    <?php if (!empty($manager)): foreach ($manager as $value): ?>

                                                    <option <?php if ($other_filters['gerente'] == $value['id']) echo 'selected="selected"' ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </th>
                                            <th>
                                                <select id="agent" name="query[agent]" class="select2" style="width:140px;" onchange="this.form.submit();">
                                                    <option value="" <?php if (!$other_filters['agent'] || ($other_filters['agent'] == 1)) echo 'selected="selected"' ?>>Todos los agentes</option>
                                                    <option value="2" <?php if ($other_filters['agent'] == 2) echo 'selected="selected"' ?>>Cancelados</option>
                                                    <option value="3" <?php if ($other_filters['agent'] == 3) echo 'selected="selected"' ?>>Vigentes</option>
                                                </select>
                                            </th>
                                            <th>
                                                <select id="generarion" name="query[generacion]" class="select3" style="width:180px;" onchange="this.form.submit();">
                                                    <option value="" <?php if (!$other_filters['generacion'] || ($other_filters['generacion'] == 1)) echo 'selected="selected"' ?>>Todas las Generaciónes</option>
                                                    <option value="3" <?php if ($other_filters['generacion'] == 3) echo 'selected="selected"' ?>>Generación 1</option>
                                                    <option value="4" <?php if ($other_filters['generacion'] == 4) echo 'selected="selected"' ?>>Generación 2</option>
                                                    <option value="5" <?php if ($other_filters['generacion'] == 5) echo 'selected="selected"' ?>>Generación 3</option>
                                                    <option value="2" <?php if ($other_filters['generacion'] == 2) echo 'selected="selected"' ?>>Consolidado</option>
                                                </select>
                                            </th>
                                            <th style="white-space:nowrap;" title="Escriba algo para ver sugerencias por el nombre del agente. Seleccione un agente. Luego, puede continuar a escribir para añadir otro nombre. Despues, click el icono 'filtrar' para actualizar la página web.">
                                                <textarea placeholder="ESCRIBA LOS NOMBRES DE LOS AGENTES" id="agent-name" name="query[agent_name]" rows="1" class="input-xlarge select4" style="min-width: 250px; height: 2.2em"><?php echo $other_filters['agent_name']; ?></textarea>
                                            </th>
                                            <th>
                                                <i style="cursor: pointer; vertical-align: top" class="icon-filter submit-form" id="submit-form1" title="Filtrar"></i>
                                                <br />
                                                <i style="cursor: pointer;" class="icon-list-alt" id="clear-agent-filter" title="Mostrar todos los agentes"></i>
                                            </th>
                                            <th style="white-space:nowrap;" title="Escriba algo para ver sugerencias por el número de póliza. Seleccione un número. Luego, puede continuar a escribir para añadir otro número. Despues, click el icono 'filtrar' para actualizar la página web.">
                                                <textarea placeholder="ESCRIBA NUMEROS DE POLIZA" id="policy-num" name="query[policy_num]" rows="1" class="input-small select4" style="min-width: 8em; height: 2.2em"><?php echo $other_filters['policy_num']; ?></textarea>
                                            </th>
                                            <th>
                                                <i style="cursor: pointer; vertical-align: top" class="icon-filter submit-form" id="submit-form2" title="Filtrar"></i>
                                                <br />
                                                <i style="cursor: pointer;" class="icon-list-alt" id="clear-policy-filter" title="Ningun filtro por el número de póliza"></i></th>
											</th>
                                            <th>&nbsp; </th>
                                            <th></th>
                                            <th width="50%" align="right" ><?php if ($export_xls == true): ?><a href="javascript:void(0);" class="download">
                                                        <img src="<?php echo base_url() ?>ot/assets/images/down.png"></a><?php endif; ?>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </form>

                            <?php
                            if (empty($_POST) or isset($_POST['query']['ramo']) and $_POST['query']['ramo'] != 3) { 
                                
                                if(!empty($_POST) and $_POST['query']['ramo']==1) {
                                
                                 	$this->load->view('report1', array('data' => $data, 'tata'=>$tata['query']['ramo']));
                                
                                }
                                elseif(!empty($_POST) and $_POST['query']['ramo']==2) {

                                 	$this->load->view('report2', array('data' => $data, 'tata'=>$tata['query']['ramo']));
                                     
                                }
                                else
                                   	$this->load->view('report1', array('data' => $data)) ; 
                             }
                             else
                                 	$this->load->view('report3', array('data' => $data));
                             ?>
                                                          

                        </div> <!-- #main -->

<?php echo $period_form ?>

                    </div> <!-- #main-container -->
                </div>                                                                                                 	
            </div>
        </div>               
    </div>
    
</div><!--/span-->
</div><!--/row-->