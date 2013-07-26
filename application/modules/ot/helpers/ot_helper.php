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
	
    
    
    		$table .= '<tr id="'.$value['id'].'">';
							
							
			if( $value['product_group_id'] == 1 )
			$table .='				<td class="center">0725V</td>';
			
			if( $value['product_group_id'] == 2 )
			$table .='				<td class="center">0725G</td>';								 
			if( $value['product_group_id'] == 3 )
			$table .='				<td class="center">0725A</td>';						
							
			
			
			$table .='		<td class="center">'. $value['creation_date'] .'</td>';
			
			if( !empty( $value['agents'] ) )
								foreach( $value['agents'] as $agent ) 
			$table .='		<td class="center">'. $agent['name']. ' '. $agent['lastnames']. ' '. $agent['percentage'] . '% <br>' .'</td>';
			
			$table .= '<td class="center">'.$value['group_name'] .'</td>';
			
			if( !empty( $value['policy'] ) )
			$table .='		<td class="center">'.  $value['policy'][0]['name']. ' '. $value['policy'][0]['lastname_father']. ' '. $value['policy'][0]['lastname_mother'] .'</td>';
			
			$color = diferenciaEntreFechas( date('Y-m-d H:i:s'), $value['creation_date'], "DIAS", FALSE );
			//$color = $color*.100;
			$style = '';
			
			if( $color == 50 ) 
				$style = 'style="background-color:#489133"';
			if( $color > 50 )	
				$style = 'style="background-color:#FF0"';
			if( $color > 100 )	
				$style = 'style="background-color:#FF0"';
			
			if( $value['status_name'] == 'activacion' ) $style = '';
			
			
			$table .='	
							<td class="center" '.$style.'>'. ucwords($value['status_name']) .'</td>';
			
							
			if( $value['status_name'] == 'activacion' )
					$table .='<td class="center"></td>';
			
			else
					$table .='<td class="center">'. tiempo_transcurrido($value['creation_date']) .'</td>';
				
			$table .='</tr>';
    
    
	
	}
	
	
	return $table;
}


?>