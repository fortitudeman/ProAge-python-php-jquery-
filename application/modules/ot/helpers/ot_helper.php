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



// Render table for user
function renderTable( $data = array(), $access_activate = false, $access_update = false, $access_delete = false ){

	if( empty( $data ) ) return false;
	
	
	
	
	
	
	
	
	$table = null;
	
	foreach( $data as $value ){ 
	
    		if( $value['creation_date'] == '0000-00-00 00:00:00' ) $value['creation_date'] = '';
    
    		$table .= '<tr onclick="menu(\'menu-'. $value['id'] .'\');">';
			
			
			
			
			$color = diferenciaEntreFechas( date('Y-m-d H:i:s'), $value['creation_date'], "DIAS", FALSE );
					
						
			$table .='				<td class="center">';
			
			if( $value['work_order_status_id'] == 5 or $value['work_order_status_id'] == 9 ) {
				if( (float)$color <= 5 ) 
					$table .= '<div style="background-color:#0C0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
				else if( (float)$color > 5 and (float)$color <= 10 )	
					$table .= '<div style="background-color:#FF0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';									
				else if( (float)$color > 10 )	
					$table .= '<div style="background-color:#F30; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
			}
			
			
			if( $value['work_order_status_id'] == 6 )
				$table .= '<div style="background-color:#000; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
							
							
			$table .= $value['uid'];
			
			$table .='</td>';				
			
			
			$table .='		<td class="center">'. $value['creation_date'] .'</td>';
			
			
			
			if( !empty( $value['agents'] ) ){
					
					$table .='		<td class="center">';
					
					foreach( $value['agents'] as $agent ) 
							
							if( !empty( $agent['company_name'] ) )
								$table .=  $agent['company_name'] . ' '. $agent['percentage'] . '% <br>';
							else
								$table .= $agent['name']. ' '. $agent['lastnames']. ' '. $agent['percentage'] . '% <br>';
					
					$table .='		</td>';
					
			}
			
			else
					$table .='		<td class="center"></td>';
			
			$table .= '<td class="center">'.$value['group_name'] .'</td>';
			$table .= '<td class="center">'.$value['parent_type_name']['name'] .'</td>';
			
			$table .='<td class="center">'.  $value['policy'][0]['name'] .'</td>';
						
													
			
			$table .= '<td class="center"> ';
			
			
			$table .=  ucwords(str_replace( 'desactivada', 'en trámite', $value['status_name']));
			
			
			
			$table .= '</td>';
			
			$table .='</tr>';
    		
			
			
			if( $value['work_order_status_id'] != 2 and $value['work_order_status_id'] != 7 and $value['work_order_status_id'] != 8 )
				$table .='<tr id="menu-'. $value['id'] .'" class="popup">';
			else
				$table .='<tr class="popup">';	
			
			
			
			
			
			
            $table .='    	<td colspan="8">';
                   
   				    $table .= '<a href="javascript:void(0)" class="btn btn-link btn-hide"><i class="icon-arrow-up"></i></a>';
					
					$new = false;
												
					if( $value['parent_type_name']['name'] == 'NUEVO NEGOCIO' )
					
						$new = true;
					
					$scrips='';
					
					if( $access_activate == true and $value['work_order_status_id'] ==  9 )
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')">Activar</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
												
									
					else if( $access_activate == true and $value['work_order_status_id'] ==  6 )
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'desactivar-'.$value['id'].'\', \''.$new.'\')">Desactivar</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
					
					else 
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')">Activar</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
												
												
												
												
					if( $access_update == true ){
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'aceptar-'.$value['id'].'\', \''.$new.'\')">Marcar como aceptada</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
												
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'rechazar-'.$value['id'].'\', \''.$new.'\')">Marcar como rechazada</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
												}
					if( $access_delete == true )
												
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'cancelar-'.$value['id'].'\', \''.$new.'\')">Cancelar</a>&nbsp;&nbsp;';
					
					if( $value['work_order_status_id'] != 2 and $value['work_order_status_id'] != 7 and $value['work_order_status_id'] != 8 )
					$table .=  $scrips;
												
					
                    $table .= '
                    </td>
                </tr>    ';
	
	}
	
	
	return $table;
}


// Getting format date
function getFormatDate( $date = null ){
		
	 if( empty( $date ) or $date == '0000-00-00' ) return false;
	 
	 	 
	 $date = explode( '-', $date );
	 
	 
	 $meses= array('01'=>"Enero",'02'=>"Febrero",'03'=>"Marzo",'04'=>"Abril",'05'=>"Mayo",'06'=>"Junio",'07'=>"Julio",'08'=>"Agosto",'09'=>"Septiembre",'10'=>"Octubre",'11'=>"Noviembre",'12'=>"Diciembre");
	 
	 return 'el '.$date[2].' de '.$meses[$date[1]].' del '.$date[0];
	 
	 
			 
}	
/*
	Prepare form fields for ot.html page
*/
if ( ! function_exists('prepare_ot_form'))
{
	function prepare_ot_form($other_filters, &$gerente_str, &$agente_str, &$ramo_tramite_types, &$patent_type_ramo)
	{
		$CI =& get_instance();
		$gerente_str = '';
		$gerentes_array = $CI->user->getSelectsGerentes2();
		if ($gerentes_array)
		{
			foreach ($gerentes_array as $key => $gerente)
			{
				$selected = '';
				if (isset($other_filters['gerente']) && ($gerente['id'] == $other_filters['gerente']))
					$selected = ' selected="selected"';
				$gerentes_array[$key] = '<option value="' . $gerente['id'] . '"' . $selected . '>' . $gerente['name'] . '</option>';
			}
			$gerente_str .= implode("\n", $gerentes_array);
		}

		$agente_str = '<option value="">Todos</option>';
		$agent_array = $CI->user->getAgents( FALSE );
		if ($agent_array)
		{
			foreach ($agent_array as $key => $value)
			{
				$selected = '';
				if (isset($other_filters['agent']) && ($key == $other_filters['agent']))
					$selected = ' selected="selected"';
				$agent_array[$key] = '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
			}
			$agente_str .= implode("\n", $agent_array);
		}
		if (isset($other_filters['patent_type']))
			$ramo_tramite_types = $CI->work_order->get_tramite_types_select_arr($other_filters['patent_type']);
		else 
			$ramo_tramite_types = $CI->work_order->get_tramite_types_select_arr();
		$patent_type_ramo = 0;
		if (isset($other_filters['ramo']) && isset($ramo_tramite_types[$other_filters['ramo']]))
			$patent_type_ramo = $other_filters['ramo'];
	}
}
?>