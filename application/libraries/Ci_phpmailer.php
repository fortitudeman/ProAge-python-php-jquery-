<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ci_phpmailer{

	public function __construct()
	{
		require_once('PHPMailer/class.phpmailer.php');
	}
}

?>