<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Email extends CI_Email {
	
	function __construct($config=array()){
		$config ['protocol'] = "smtp";
		$config ['smtp_host'] = "mail.4axiz.com";
		$config ['smtp_user'] = "test+4axiz.com";
		$config ['smtp_pass'] = "4axiz.com";
		$config ['smtp_port'] = "26";
		$config ['smtp_timeout'] = 7;
		$config ['charset'] = 'utf-8';
		$config ['wordwrap'] = TRUE;
                $config['newline'] = "\r\n";
                $config['mailtype'] = "text";
		
		parent::__construct($config);
	}
}