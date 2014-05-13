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
 Get filter period stored in ( pseudo ) session if any
 Returns the value of the option in the dropdown used to select filter period
*/
if ( ! function_exists('get_filter_period'))
{
	function get_filter_period()
	{
		$CI =& get_instance();
		$saved_period = $CI->default_period_filter;
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
		{
			$CI->session->set_userdata('default_period_filter', $to_save);
			$CI->default_period_filter = $to_save;
		}
	}
}
/*
Display custom filter period
*/
if ( ! function_exists('show_custom_period'))
{
	function show_custom_period()
	{
		$CI =& get_instance();
		$data = array(
			'from' => $CI->custom_period_from,
			'to' => $CI->custom_period_to
		);
		if ( ( $data['from'] === FALSE ) || ( $data['to'] === FALSE ) )
		{
			$data['from'] = date('Y-m-d');
			$data['to'] = $data['from'];
		}
		return $CI->load->view('custom_period', $data, TRUE);
	}
}
/*
	Update custom filter period in session
*/
if ( ! function_exists('update_custom_period'))
{
	function update_custom_period($from, $to)
	{
		$result = 0;
		if (($from !== FALSE) && ($to !== FALSE))
		{
			$from_array = explode('-', $from);
			$to_array = explode('-', $to);
			if ( (count($from_array) == 3) && (count($to_array) == 3) &&
				checkdate ( $from_array[1], $from_array[2], $from_array[0]) && 
				checkdate ( $to_array[1], $to_array[2], $to_array[0]) )
			{
				$CI =& get_instance();
				$CI->session->set_userdata( array(
					'custom_period_from' => $from,
					'custom_period_to' => $to,
					'default_period_filter' => 4
				));
				$CI->custom_period_from = $from;
				$CI->custom_period_to = $to;
				$CI->default_period_filter = 4;
				$result = 1;
			}
		}
		return $result;
	}
}
/*
	Get start and end date depending on period selection (for activity report)
*/
if ( ! function_exists('get_period_start_end'))
{
	function get_period_start_end(&$selection)
	{
		if (!isset($selection['periodo']) || !isset($selection['begin']) || !isset($selection['end']))
			return;
		$current_month = date('m');
		$current_year = date('Y');
		switch ($selection['periodo']) 
		{
			case 1: // Month
				$selection['begin'] = sprintf("%s-%s-01", $current_year, $current_month);
				$selection['end'] = sprintf("%s-%s-%s", $current_year, $current_month, date('t'));
				break;
			case 2: // Week
				break;	
			case 3: // Year
				$selection['begin'] = sprintf("%s-01-01", $current_year);
				$selection['end'] = sprintf("%s-12-31", $current_year);
				break;
			case 4: // Custom
				$CI =& get_instance();
				$in_session = array(
					'from' => $CI->custom_period_from,
					'to' => $CI->custom_period_to
				);
				if ( ( $in_session['from'] === FALSE ) || ( $in_session['to'] === FALSE ) )
				{
					$in_session['from'] = date('Y-m-d');
					$in_session['to'] = $data['from'];
				}
				$selection['begin'] = $in_session['from'];
				$selection['end'] = $in_session['to'];
				break;
			default:
				break;
		}
	}
}
/*
 Store ot/reporte/html filter fields other than the period in session
*/
if ( ! function_exists('set_ot_report_filter'))
{
	function set_ot_report_filter( $to_save, $agents_in_db )
	{
		if (!$to_save)
			return;
		$CI =& get_instance();

		$to_check_array2 = array();
		if (isset($to_save['agent_name']))
		{
			$to_check_array1 = explode("\n", $to_save['agent_name']);
			$to_replace = array(']', "\n", "\r");
			foreach ($to_check_array1 as $value)
			{
				$pieces = explode( ' [ID: ', $value);
				if (isset($pieces[1]))
				{
					$pieces[1] = str_replace($to_replace, '', $pieces[1]);
					if (isset($agents_in_db[$pieces[1]]) && !isset($to_check_array2[$pieces[1]]))
						$to_check_array2[] = $pieces[1];
				}
			}
		}
		$to_save['agent_name'] = implode('|', $to_check_array2);
		$CI->session->set_userdata('ot_r_misc_filter', $to_save);
		$CI->ot_r_misc_filter = $to_save;
	}
}

/*
 Get ot/reporte/html filter fields other than the period
*/
if ( ! function_exists('get_ot_report_filter'))
{
	function get_ot_report_filter(&$other_filters, $agents_in_db)
	{
		$CI =& get_instance();
		if ( $CI->ot_r_misc_filter !== FALSE )
		{
			foreach ($CI->ot_r_misc_filter as $key => $value)
			{
				if ($key != 'agent_name')
					$other_filters[$key] = $value;
				else
				{
					$agent_names_in_session = explode('|', $value);
					foreach ($agent_names_in_session as $agent_value)
					{
						if (isset($agents_in_db[$agent_value]))
						{
							$other_filters['agent_name'] .= $agents_in_db[$agent_value] . " [ID: $agent_value]\n";
						}
					}
				}
			}
//			$result = array_merge($other_filters, $CI->ot_r_misc_filter);
		}
	}
}

/* End of file ot.php */
/* Location: ./application/helpers/filter_helper.php */
?>