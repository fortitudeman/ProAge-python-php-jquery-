<?php
if (!function_exists("issetor")) {
	function issetor(&$var, $default = false) {
	    return isset($var) ? $var : $default;
	}
}


if (!function_exists("printEquals")) {
	function printEquals($var, $comparation_value, $print_value) {
	    return $var == $comparation_value ? $print_value : '';
	}
}

if (!function_exists("sign")) {
	function sign($number, $class_positive = "positive", $class_negative = "negative", $class_zero = "positive") {
	    if($number > 0)
	    	return $class_positive;
	    elseif($number == 0)
	    	return $class_zero;
	    else
	    	return $class_negative;
	}
}

if (!function_exists("comparationRatio")) {
	function comparationRatio($value, $comparation_value){
		$ratio = 0;
		if($comparation_value != 0){
			$ratio = ($value-$comparation_value)*100/$comparation_value;
		}
		return $ratio;
	}
}

if (!function_exists("percentageRatio")) {
	function percentageRatio($value, $total){
		$ratio = 0;
		if($total != 0){
			$ratio = ($value/$total)*100;
		}
		return $ratio;
	}
}

