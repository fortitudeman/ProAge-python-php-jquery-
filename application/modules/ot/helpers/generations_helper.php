<?php
if(!function_exists("getGenerationList")){
	function getGenerationList($params = array()){
		$generaciones = array(
			"generacion_1" => array(
				"title" => "Generacion 1",
			),
			"generacion_2" => array(
				"title" => "Generacion 2",
			),
			"generacion_3" => array(
				"title" => "Generacion 3",
			),
			"generacion_4" => array(
				"title" => "Generacion 4",
			),
			"consolidado" => array(
				"title" => "Consolidado",
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
	function getGenerationDropDown(){
		$list = getGenerationList();
		$dropdown = array();
		foreach ($list as $key => $value) {
			if(isset($value["title"]))
				$dropdown[$key] = $value["title"];
		}

		return $dropdown;
	}
}

if(!function_exists("getGeneracionByConnection")){
	function getGeneracionByConnection($connection_date, $comparation_date = ""){
		if(empty($comparation_date))
			$comparation_date = new Datetime();

		$CI =& get_instance();
		$CI->load->helper('tri_cuatrimester');
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