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
							<td class="center">'. $value['folio_nacional'] .'</td>
							<td class="center">'. $value['folio_provicional'] .'</td>
							<td class="center">'. $value['clave'] .'</td>
							<td class="center">'. $value['nombre'] .'</td>
							<td class="center">'. $value['apellidos'] .'</td>
							<td class="center">'. $value['email'] .'</td>
							<td class="center">'. $value['tipo'] .'</td>
							<td class="center">'. $value['date'] .'</td>
							<td class="center">'. $value['last_updated'] .'</td>
							<td class="center">
								<a class="btn btn-success" href="'. base_url() .'usuarios/permisions/'. $value['id'] .'.html" title="Ver información completa">
									<i class="icon-zoom-in icon-white"></i>         
								</a>
								<a class="btn btn-info" href="'. base_url() .'usuarios/update/'. $value['id'] .'.html" title="Editar Registro">
									<i class="icon-edit icon-white"></i>            
								</a>
								<a class="btn btn-danger" href="'. base_url() .'usuarios/delete/'. $value['id'] .'.html" title="Eliminar Registro">
									<i class="icon-trash icon-white"></i> 
								</a>
							</td>
						</tr>';
    
    
	
	}
	
	return $table;
}


?>