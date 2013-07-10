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
	
    
    
    		$table .= '<tr>
							<td class="center">'. $value['clave'] .'</td>
							<td class="center">'. $value['national'] .'</td>
							<td class="center">'. $value['provincial'] .'</td>
							<td class="center">'. $value['manager_id'] .'</td>
							<td class="center">'. $value['name'] .'</td>
							<td class="center">'. $value['lastnames'] .'</td>
							<td class="center">'. $value['email'] .'</td>
							<td class="center">'. $value['tipo'] .'</td>
							<td class="center">'. $value['date'] .'</td>
							<td class="center">'. $value['last_updated'] .'</td>
						</tr>';
    
    
	
	}
	
	return $table;
}


?>