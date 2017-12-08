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

