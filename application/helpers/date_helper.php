<?php
function sameDayLastYear($date){
	$year_ago = strtotime("-1 year", strtotime($date));
	return date("Y-m-d", $year_ago);
}