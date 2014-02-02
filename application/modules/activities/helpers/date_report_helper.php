<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Function to check the dates inputted for querying reports
 *
 */

if ( ! function_exists('checkdate_from_to'))
{
	function checkdate_from_to($from, $to)
	{
		$result = FALSE;
		if ($from && $to)
		{
			$from_len = strlen($from);
			$to_len = strlen($to);
			if (($from_len < 10) || ($to_len < 10))
				return $result;
			if ($from_len == 10)
				$from .= ' 00:01';
			if ($to_len == 10)
				$to .= ' 23:59';
			$from_to_time = strtotime($from);
			$to_to_time =  strtotime($to);
			if (($from_to_time !== -1) && ($to_to_time !== -1) && ($from_to_time <= $to_to_time))
				$result = TRUE;
		}
		return $result;
	}

}


/* End of file date_report_helper.php */
/* Location: ./application/modules/activities/helpers/date_report_helper.php */