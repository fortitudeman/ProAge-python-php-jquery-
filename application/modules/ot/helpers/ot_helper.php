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
function renderTable( $data = array() ){

	if( empty( $data ) ) return false;
	
	
	
	
	
	
	
	
	$table = null;
	
	foreach( $data as $value ){ 
	
    		if( $value['creation_date'] == '0000-00-00 00:00:00' ) $value['creation_date'] = '';
    
    		$table .= '<tr id="'.$value['id'].'">';
			
			
			
			
			$color = diferenciaEntreFechas( date('Y-m-d H:i:s'), $value['creation_date'], "DIAS", FALSE );
						
			$color = $color/strtotime( date('Y-m-d H:i:s') );
			  
			$color = $color * 100;
			
			$table .='				<td class="center">';
			
			if( $value['status_name'] == 'tramite' ) {
				if( (float)$color <= 5 ) 
					$table .= '<div style="background-color:#0C0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
				else if( (float)$color > 5 )	
					$table .= '<div style="background-color:#FF0; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';									
				else if( (float)$color > 10 )	
					$table .= '<div style="background-color:#F30; width: 10px;  height: 10px; border-radius: 50%; float:left; margin-top:5px;"></div>';
			}
			
							
							
			if( $value['product_group_id'] == 1 )
				$table .= $value['id'].'0725V';
			
			if( $value['product_group_id'] == 2 )
				$table .= $value['id'].'0725G';								 
			if( $value['product_group_id'] == 3 )
				$table .= $value['id'].'0725A';						
			
			$table .='</td>';				
			
			
			$table .='		<td class="center">'. $value['creation_date'] .'</td>';
			
			
			
			if( !empty( $value['agents'] ) ){
					
					$table .='		<td class="center">';
					
					foreach( $value['agents'] as $agent ) 
					
							$table .= $agent['name']. ' '. $agent['lastnames']. ' '. $agent['percentage'] . '% <br>';
					
					$table .='		</td>';
					
			}
			
			else
					$table .='		<td class="center"></td>';
			
			$table .= '<td class="center">'.$value['group_name'] .'</td>';
			$table .= '<td class="center">'.$value['parent_type_name']['name'] .'</td>';
			
			if( !empty( $value['policy'] ) )
				$table .='		<td class="center">'.  $value['policy'][0]['name']. ' '. $value['policy'][0]['lastname_father']. ' '. $value['policy'][0]['lastname_mother'] .'</td>';
			else
				$table .='		<td class="center"></td>';
			
			
													
			
			$table .= '<td class="center"> ';
			
			
			$table .=  ucwords(str_replace( 'tramite', 'pendiente', $value['status_name']));
			
			
			
			$table .= '</td>';
			
			/*				
			if( $value['status_name'] == 'activacion' )
					$table .='<td class="center"></td>';
			
			else
					$table .='<td class="center">'. tiempo_transcurrido($value['creation_date']) .'</td>';
				*/
			$table .='</tr>';
    
    
	
	}
	
	
	return $table;
}


?>