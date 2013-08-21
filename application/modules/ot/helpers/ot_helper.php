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
			
			if( $value['status_name'] == 'en trámite' or $value['status_name'] == 'desactivada' ) {
				if( (float)$color <= 5 ) 
					$table .= '<div style="background-color:#0C0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
				else if( (float)$color > 5 and (float)$color <= 10 )	
					$table .= '<div style="background-color:#FF0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';									
				else if( (float)$color > 10 )	
					$table .= '<div style="background-color:#F30; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
			}
			
			
			if( $value['status_name'] == 'activada' )
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
			
			
			$table .=  ucwords(str_replace( 'tramite', 'en trámite', $value['status_name']));
			
			
			
			$table .= '</td>';
			
			$table .='</tr>';
    
			$table .='<tr id="menu-'. $value['id'] .'" class="popup">
                	<td colspan="8">';
                   
					
					$new = false;
												
					if( $value['parent_type_name']['name'] == 'NUEVO NEGOCIO' )
					
						$new = true;
					
					$scrips='';
					
					if( $access_activate == true and $value['status_name'] ==  'desactivada' )
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')">Activar</a>&nbsp;&nbsp;';
												
									
					else if( $access_activate == true and $value['status_name'] ==  'activada' )
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'desactivar-'.$value['id'].'\', \''.$new.'\')">Desactivar</a>&nbsp;&nbsp;';
					
					else 
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')">Activar</a>&nbsp;&nbsp;';
												
												
												
												
					if( $access_update == true ){
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'aceptar-'.$value['id'].'\', \''.$new.'\')">Marcar como aceptada</a>&nbsp;&nbsp;';
												
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'rechazar-'.$value['id'].'\', \''.$new.'\')">Marcar como rechazada</a>&nbsp;&nbsp;';
												}
					if( $access_delete == true )
												
						$scrips .= '<a href="javascript:void(0)" onclick="chooseOption(\'cancelar-'.$value['id'].'\', \''.$new.'\')">Cancelar</a>&nbsp;&nbsp;';
					
					
					$table .=  $scrips;
												
					
                    $table .= '<a href="javascript:void(0)" class="btn btn-link btn-hide">^</a>
                    </td>
                </tr>    ';
	
	}
	
	
	return $table;
}


?>