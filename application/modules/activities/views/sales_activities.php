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
if ( isset($_POST['periodo']) &&
	($_POST['periodo'] >= 1) && ($_POST['periodo'] <= 4) )
{
	$selected_filter_period = array(1 => '', 2 => '', 3 => '', 4 => '');
	$selected_filter_period[$_POST['periodo']] = ' selected="selected"';
}
else
	$selected_filter_period = get_selected_filter_period();
$divided_by_zero = '-99999%';
?>

<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url() ?>">Admin</a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo base_url() ?>activities.html">Actividades </a> <span class="divider">/</span>
        </li>               
        <li>
            Actividad de ventas
        </li>
        <li class="activity_results"><?php echo $report_period ?></li>
    </ul>
</div>

<div class="row-fluid sortable">
    <div class="box span12">      
        <div class="box-content">
            <?php if (isset($message['type'])): ?>            
                <?php if ($message['type'] == true): ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <img src="<?php echo base_url() ?>images/true.png" width="20" height="20" />
                        <strong>Listo: </strong> <?php echo $message['message']; // Show Dinamical message Success  ?>
                    </div>
                <?php elseif ($message['type'] == false): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <img src="<?php echo base_url() ?>images/false.png" width="20" height="20" />
                        <strong>Error: </strong> <?php echo $message['message']; // Show Dinamical message error  ?>
                    </div>
                <?php endif; ?>			
            <?php endif; ?> 

            <div class="row">
                <div class="span11" style="width:95%">
                    <div class="main-container">
                        <div class="main clearfix">

                          <form id="sales-activity-form" action="<?php echo base_url() ?>activities/sales_activities_stats.html" class="row form-horizontal" method="post">
                            <fieldset>
                                <div class="control-group">
                                  <label class="control-label text-error" for="inputError">Vista :</label>
                                  <div class="controls">
                                    <input type="radio" id="view-normal" name="activity_view" value="normal" <?php /*if ($other_filters['activity_view'] == 'normal')*/ echo 'checked="checked"'?>>&nbsp;&nbsp;Normal&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="view-efectividad" name="activity_view" value="efectividad" <?php /*if ($other_filters['activity_view'] == 'efectividad') echo 'checked="checked"' */ ?>>&nbsp;&nbsp;Efectividad					  
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="span5 offset1">
                                    <div>
                                      <select id="periodo" name="periodo" title="Período" >
                                        <option value="2" <?php echo $selected_filter_period[2] ?>>Una Semana</option>
                                        <option value="1" <?php echo $selected_filter_period[1] ?>>Mes actual</option>
                                        <option value="3" <?php echo $selected_filter_period[3] ?>>Año actual</option>
                                        <option value="4" id="period_opt4" <?php echo $selected_filter_period[4] ?>>Período personalizado</option>
                                      </select>
                                      <span>
                                          &nbsp;&nbsp;<i style="cursor: pointer; vertical-align: top" class="icon-calendar" id="cust_update-period" title="Click para editar el período personalizado"></i>
                                          &nbsp;&nbsp;<i style="cursor: pointer; vertical-align: top; color: #06be1d; display: none" class="icon-calendar" id="week_update-period" title="Click para seleccionar otra semana"></i>
                                      </span>
                                    </div>		  
                                    <div id="semana-container" <?php if (!$selected_filter_period[2]) echo 'style="display: none"' ?> title="Seleccione una Semana">
                                      <div id="week"></div>
                                      <label></label> <span id="startDate"></span>  <span id="endDate"></span>
                                       <input id="begin" name="begin" type="hidden" readonly="readonly" value="<?php echo set_value('begin', isset($other_filters['begin']) ? $other_filters['begin'] : '')  ?>">
                                       <input id="end" name="end" type="hidden" readonly="readonly" value="<?php echo set_value('end', isset($other_filters['end']) ? $other_filters['end'] : '')  ?>">
                                    </div>
                                  </div>

                                  <div class="span6">
                                    <textarea placeholder="AGENTES" id="agent-name" name="agent_name" rows="1" class="input-xlarge select4" style="min-width: 250px; max-width: 300px; height: 1.5em"><?php echo $other_filters['agent_name']; ?></textarea>
			                        <span>
                                        <i style="cursor: pointer; vertical-align: top" class="icon-filter submit-form" id="submit-form1" title="Filtrar"></i>
                                        <i style="cursor: pointer; vertical-align: top" class="icon-list-alt" id="clear-agent-filter" title="Mostrar todos los agentes"></i>
                                    </span>
                                  </div>
                                </div>
                            </fieldset>
                          </form>


<?php
	if (isset($data['rows']) && count($data['rows']))
	{
		echo '
<table class="sortable altrowstable tablesorter sales-activity-results" id="sales-activity-normal">
<thead class="head">
<tr>
<th rowspan="2" class="medium-grey">AGENTE</th>
<th rowspan="2" class="medium-grey">N° DE SEMANAS REPORTADAS</th>
<th colspan="2" class="light-grey">CITAS</th><th colspan="2" class="light-grey">ENTREVISTAS</th>
<th colspan="2" class="light-grey">PROSPECTOS</th><th colspan="2" class="light-grey">VIDA</th>
<th colspan="2" class="light-grey">GMM</th>
</tr>
<tr>
<th class="medium-red">TOTALES</th><th class="medium-red">PROM</th>
<th>TOTALES</th><th>PROM</th>
<th class="medium-red">TOTALES</th><th class="medium-red">PROM</th>
<th>SOLICITUDES</th><th>NEGOCIOS</th>
<th class="medium-red">SOLICITUDES</th><th class="medium-red">NEGOCIOS</th>
</tr></thead>
<tbody class="tbody">';

		foreach ($data['rows'] as $key => $value)
		{
			echo '
<tr id="normal-agent-id-' . $key . '_' . $value['user_id'] . '">
	<td rowspan="2"><a href="#" class="toggle">' . $value['name'] . '</a></td>
	<td class="sales-activity-numeric">' . $value['weeks_reported'] . '</td>
	<td class="medium-grey-body sales-activity-numeric">' . $value['citaT'] . '</td>
	<td class="medium-grey-body sales-activity-numeric">' . number_format($value['citaP'], 2) . '</td>
	<td class="light-grey-body sales-activity-numeric">' . $value['interviewT'] . '</td>
	<td class="light-grey-body sales-activity-numeric">' . number_format($value['interviewP'], 2) . '</td>	
	<td class="light-red-body sales-activity-numeric">' . $value['prospectusT'] . '</td>
	<td class="light-red-body sales-activity-numeric">' . number_format($value['prospectusP'], 2) . '</td>		
	<td class="light-green-body sales-activity-numeric">
		<a class="vida-solicitudes solicitudes-negocios" href="#">' . $value['vida_solicitudes'] . '</a>
	</td>
	<td class="light-green-body sales-activity-numeric">
		<a class="vida-negocios solicitudes-negocios" href="#">' . $value['vida_negocios'] . '</a>
	</td>
	<td class="light-blue-body sales-activity-numeric">
		<a class="gmm-solicitudes solicitudes-negocios" href="#">' . $value['gmm_solicitudes'] . '</a>
	</td>
	<td class="light-blue-body sales-activity-numeric">
		<a class="gmm-negocios solicitudes-negocios" href="#">' . $value['gmm_negocios'] . '</a>
	</td>
</tr>
<tr class="tablesorter-childRow">
<td colspan="11">
	<a href="' . $value['activities_url'] . '" class="btn btn-link">Ver actividad de ventas</a> |
	<a href="' . $value['simulator_url'] . '" class="btn btn-link">Simular resultado y definir meta</a> |
	<a href="' . $value['perfil_url'] . '" class="btn btn-link">Vision general</a>
</td>
</tr>
';
		}

		echo '
</tbody>
</table>
<br />
<table class="sortable altrowstable tablesorter sales-activity-results" id="sales-activity-efectividad">
<thead class="head">
<tr>
<th rowspan="2" class="medium-grey">AGENTE</th>
<th rowspan="2" class="medium-grey">N° DE SEMANAS REPORTADAS</th>
<th colspan="3" class="light-grey">CITAS - ENTREVISTAS</th>
<th colspan="2" class="light-grey">PROSPECTOS POR ENTREVISTA</th>
<th colspan="3" class="light-grey">VIDA</th>
<th colspan="3" class="light-grey">GMM</th>
</tr>
<tr>
<th>CITAS</th><th>ENTREVISTAS</th><th>EFECTIVIDAD</th>
<th class="medium-red">TOTALES</th><th class="medium-red">PROM</th>
<th>SOLICITUDES</th><th>NEGOCIOS</th><th>EFECTIVIDAD</th>
<th class="medium-red">SOLICITUDES</th><th class="medium-red">NEGOCIOS</th><th class="medium-red">EFECTIVIDAD</th>
</tr></thead>
<tbody class="tbody">';

		foreach ($data['rows'] as $key => $value)
		{
			if ($value['citaT'])
				$efectividad_1 = number_format(100 * $value['interviewT'] / $value['citaT'] , 0) . '%';
			else
				$efectividad_1 = $divided_by_zero;
			if ($value['vida_solicitudes'])
				$efectividad_2 = number_format(100 * $value['vida_negocios'] / $value['vida_solicitudes'], 0) . '%';
			else
				$efectividad_2 = $divided_by_zero;
			if ($value['gmm_solicitudes'])
				$efectividad_3 = number_format(100 * $value['gmm_negocios'] / $value['gmm_solicitudes'], 0) . '%';
			else
				$efectividad_3 = $divided_by_zero;
				
			echo '
<tr id="efectividad-agent-id-' . $key . '_' . $value['user_id'] . '">
	<td rowspan="2"><a href="#" class="toggle">' . $value['name'] . '</a></td>
	<td class="sales-activity-numeric">' . $value['weeks_reported'] . '</td>
	<td class="medium-grey-body sales-activity-numeric">' . $value['citaT'] . '</td>
	<td class="light-grey-body sales-activity-numeric">' . $value['interviewT'] . '</td>
	<td class="sales-activity-numeric">' . $efectividad_1 . '</td>	
	<td class="light-red-body sales-activity-numeric">' . $value['prospectusT'] . '</td>
	<td class="light-red-body sales-activity-numeric">' . number_format($value['prospectusP'], 2) . '</td>		
	<td class="light-green-body sales-activity-numeric">
		<a class="vida-solicitudes solicitudes-negocios" href="#">' . $value['vida_solicitudes'] . '</a>
	</td>
	<td class="light-green-body sales-activity-numeric">
		<a class="vida-negocios solicitudes-negocios" href="#">' . $value['vida_negocios'] . '</a>
	</td>
	<td class="sales-activity-numeric">' . $efectividad_2 . '</td>
	<td class="light-blue-body sales-activity-numeric">
		<a class="gmm-solicitudes solicitudes-negocios" href="#">' . $value['gmm_solicitudes'] . '</a>
	</td>
	<td class="light-blue-body sales-activity-numeric">
		<a class="gmm-negocios solicitudes-negocios" href="#">' . $value['gmm_negocios'] . '</a>
	</td>
	<td class="sales-activity-numeric">' . $efectividad_3 . '</td>
</tr>
<tr class="tablesorter-childRow">
<td colspan="12">
	<a href="' . $value['activities_url'] . '" class="btn btn-link">Ver actividad de ventas</a> |
	<a href="' . $value['simulator_url'] . '" class="btn btn-link">Simular resultado y definir meta</a> |
	<a href="' . $value['perfil_url'] . '" class="btn btn-link">Vision general</a>
</td>
</tr>
';
		}

		echo '
</tbody>
</table>';

	}
	else
	{
echo '<p class="sales-activity-results">No hay datos</p>';
	}
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