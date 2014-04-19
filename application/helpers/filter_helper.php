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

/*
 Get filter period stored in session if any
 Returns the value of the option in the dropdown used to select filter period
*/
if ( ! function_exists('get_filter_period'))
{
	function get_filter_period()
	{
		$CI =& get_instance();
		$saved_period = $CI->session->userdata('default_period_filter');
		if ($saved_period === FALSE)
			$saved_period = 2;	// custom period by default
		return $saved_period;
	}
}

/*
 Get the default selected html property of the period dropdown options 
 Returns an array
*/
if ( ! function_exists('get_selected_filter_period'))
{
	function get_selected_filter_period()
	{
		$result = array(1 => '', 2 => '', 3 => '', 4 => '');
		$option_selected = get_filter_period();
		if ( isset($result[$option_selected]) )
			$result[$option_selected] = ' selected="selected"';
		else
			$result[2] = ' selected="selected"';
		return $result;
	}
}
/*
 Store filter period in session
 (what is stored is the value of the option in the dropdown used to select filter period)
*/
if ( ! function_exists('set_filter_period'))
{
	function set_filter_period( $to_save )
	{
		$CI =& get_instance();
		if (( $to_save >= 1 ) && ( $to_save <= 4 ))
			$CI->session->set_userdata('default_period_filter', $to_save);
	}
}
/* End of file ot.php */
/* Location: ./application/helpers/filter_helper.php */
?>