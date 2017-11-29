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

