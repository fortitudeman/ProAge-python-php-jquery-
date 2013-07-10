<?php
/*

  Author		Ulises Rodríguez
  Site:			http://www.ulisesrodriguez.com	
  Twitter:		https://twitter.com/#!/isc_ulises
  Facebook:		http://www.facebook.com/ISC.Ulises
  Github:		https://github.com/ulisesrodriguez
  Email:		ing.ulisesrodriguez@gmail.com
  Skype:		systemonlinesoftware
  Location:		Guadalajara Jalisco Mexíco

  	
*/
class Home extends CI_Controller{
	
	
	
	/** Construct Function **/
	/** Setting Load perms **/
	
	public function __construct(){
			
		parent::__construct();
		
				
		/** Getting Info User **/
		
		$this->load->model( 'usuarios/user' );
				
		// Get Session
		$this->sessions = $this->session->userdata('system');
				
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
			
	}
	
	
	
	public function index(){
		//echo 'saflhasfhlafhl';
		$this->load->view( 'admin/index' ) ;
		
	}
	
	
	
}
?>