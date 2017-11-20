<?php
	if(!function_exists("sort_object")){
		function sort_object(&$ObjectArray, $property){
			foreach ($ObjectArray as $key => $row) {
				$aux[$key] = $row[$property];
			}
			array_multisort($aux, SORT_DESC, $ObjectArray);
		}
	}
