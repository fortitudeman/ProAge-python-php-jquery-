<?php
/*
	Get Begin and End date for given trimestre or cuatrimestre (in $rank)

*/
 
if ( ! function_exists('get_tri_cuatrimestre'))
{
	function get_tri_cuatrimester( $rank = 1, $type = 'trimestre' )
	{
		$result = array();
		$current_year = date( 'Y' );
		if ($type == 'trimestre')
		{
			switch ( $rank )
			{
				case 1:
					$result = array(
						'begind' => $current_year . '-01-01 00:00:00',	
						'end' => $current_year . '-03-31 23:59:59');	
					break;
				case 2:
					$result = array(
						'begind' => $current_year . '-04-01 00:00:00',
						'end' => $current_year . '-06-30 23:59:59');	
					break;
				case 3:
					$result = array(
						'begind' => $current_year . '-07-01 00:00:00',
						'end' => $current_year . '-09-30 23:59:59');	
					break;
				case 4:
					$result = array(
						'begind' => $current_year . '-10-01 00:00:00',	
						'end' => $current_year . '-12-31 23:59:59');	
					break;
				default:
					break;
			}
		} else { // cuatrimestre
			switch ( $rank )
			{
				case 1:
					$result = array(
						'begind' => $current_year . '-01-01 00:00:00',	
						'end' => $current_year . '-04-30 23:59:59');	
					break;
				case 2:
					$result = array(
						'begind' => $current_year . '-05-01 00:00:00',
						'end' => $current_year .'-08-31 23:59:59');	
					break;
				case 3:
					$result = array(
						'begind' => $current_year .'-09-01 00:00:00',	
						'end' => $current_year .'-12-31 23:59:59');	
					break;
				default:
					break;
			}
		}
		return $result;
	}
}

?>