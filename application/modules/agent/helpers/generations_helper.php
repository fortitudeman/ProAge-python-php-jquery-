<?php
if(!function_exists("getGenerationList")){
	function getGenerationList($params = array()){
		$generaciones = array(
			"generacion_1" => array(
				"title" => getGeneracionTitleByID("generacion_1"),
			),
			"generacion_2" => array(
				"title" => getGeneracionTitleByID("generacion_2"),
			),
			"generacion_3" => array(
				"title" => getGeneracionTitleByID("generacion_3"),
			),
			"generacion_4" => array(
				"title" => getGeneracionTitleByID("generacion_4"),
			),
			"consolidado" => array(
				"title" => getGeneracionTitleByID("consolidado"),
			)
		);

		foreach ($params as $param) {
			foreach ($generaciones as $key => $generacion) {
				$generaciones[$key][$param] = 0;
			}
		}

		return $generaciones;
	}
}

if(!function_exists("getGenerationDropDown")){
	function getGenerationDropDown($label = "Todas las Generaciones"){
		$list = getGenerationList();
		$dropdown = array(
			"" => $label,
		);
		foreach ($list as $key => $value) {
			if(isset($value["title"]))
				$dropdown[$key] = $value["title"];
		}

		return $dropdown;
	}
}

if(!function_exists("getGeneracionByConnection")){
	function getGeneracionByConnection($connection_date, $comparation_date = ""){
		//Set comparation date
		if(empty($comparation_date))
			$comparation_date = new Datetime();
		else
			$comparation_date = date_create($comparation_date);

		//Validation of connection date
		if(empty($connection_date) || $connection_date == "0000-00-00")
			$connection_date = date("Y-m-d");

		$CI =& get_instance();
		$CI->load->helper('date');

		$connection = date_create($connection_date);
		$connection = lastDayOf("quarter", $connection);
		$connection->modify("+1 day");
		$connection_years = $comparation_date->diff($connection)->y;
		switch ($connection_years) {
			case 0:
				$index = "generacion_1";
				break;
			case 1:
				$index = "generacion_2";
				break;
			case 2:
				$index = "generacion_3";
				break;
			case 3:
				$index = "generacion_4";
			default:
				$index = "consolidado";
				break;
		}
		return $index;
	}
}

if(!function_exists("getGeneracionTitleByID")){
	function getGeneracionTitleByID($generation_id){
		switch ($generation_id) {
			case "generacion_2":
				$title = "Generación 2";
				break;
			case "generacion_3":
				$title = "Generación 3";
				break;
			case "generacion_4":
				$title = "Generación 4";
				break;
			case "consolidado":
				$title = "Consolidado";
				break;
			default:
				$title = "Generación 1";
				break;
		}
		return $title;
	}
}

if(!function_exists("getGeneracionDateRange")){
	function getGeneracionDateRange($generation_id, $comparation_date = ""){
		//Set comparation date
		if(empty($comparation_date))
			$comparation_date = new Datetime();
		else
			$comparation_date = date_create($comparation_date);

		$CI =& get_instance();
		$CI->load->helper('date');

		$comparation_date = firstDayOf("quarter", $comparation_date);

		$init_date = clone $comparation_date;
		$init_date->modify("+1 day");
		$end_date = clone $comparation_date;

		switch ($generation_id) {
			case 'generacion_1':
				$init_date->modify("-1 year");
				break;
			case 'generacion_2':
				$init_date->modify("-2 year");
				$end_date->modify("-1 year");
				break;
			case 'generacion_3':
				$init_date->modify("-3 year");
				$end_date->modify("-2 year");
				break;
			case 'generacion_4':
				$init_date->modify("-4 year");
				$end_date->modify("-3 year");
				break;
			default:
				$init_date = NULL;
				$end_date->modify("-4 year");
				break;
		}

		$return = array(
			"generation" => $generation_id
		);
		if(!is_null($init_date))
			$return["init"] = $init_date->format("Y-m-d");
		$return["end"] = $end_date->format("Y-m-d");
		return $return;
	}
}