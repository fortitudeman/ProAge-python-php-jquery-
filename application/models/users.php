<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model{
	
// Functions General
	private $data = array();
	
// Clean $this->data
    public function __construct(){
		
        parent::__construct();
		
		unset( $this->data );
		
		$this->data = array();
		
	}
	
	// Ejemplos de uso
	// fecha en formato yyyy-mm-dd
	// echo tiempo_transcurrido('2010/02/05');
	// fecha y hora
	// echo tiempo_transcurrido('2010/02/10 08:30:00');

}
?>