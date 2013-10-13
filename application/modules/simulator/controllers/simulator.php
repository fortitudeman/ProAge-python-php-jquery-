<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
class Simulator extends CI_Controller {

	public $view = array();
	
	public $sessions = array();
	
	public $user_vs_rol = array();
	
	public $roles_vs_access = array();
	
	public $access = false; // Force security
	
	public $access_create = false;
	
	public $access_update = false;
	
	public $access_delete = false;
	
/** Construct Function **/
/** Setting Load perms **/
	
	public function __construct(){
			
		parent::__construct();
		
		/** Getting Info bu login User **/
		
		$this->load->model( array( 'usuarios/user', 'roles/rol' ) );
				
		// Get Session
		$this->sessions = $this->session->userdata('system');
				
		
		// Get user rol		
		$this->user_vs_rol = $this->rol->user_role( $this->sessions['id'] );
		
		// Get user rol access
		$this->roles_vs_access = $this->rol->user_roles_vs_access( $this->user_vs_rol );
		
		
	
		// If exist the module name, the user accessed
		if( !empty( $this->user_vs_rol )  and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Simulador', $value ) ):

			$this->access = true;
			
		break; endif; endforeach;


		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Simulador', $value ) ):
			
			
			if( $value['action_name'] == 'Crear' )
				$this->access_create = true;
						
			if( $value['action_name'] == 'Editar' )
				$this->access_update = true;
				
			if( $value['action_name'] == 'Eliminar' )
				$this->access_delete = true;	
			
			
		endif; endforeach;
							
								
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
			
	}
	
	

// Show all records	
	public function index( $agentid = null ){
		
		
		
		// Check access teh user for create
		if( $this->access == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
			
			
		$this->load->model( array( 'user', 'simulators' ) );
		
		$agent = $this->user->getAgentsById( $agentid );
						 
		// Config view
		$this->view = array(
				
		  'title' => 'Simulador',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'scripts' =>  array(
		  	
			'<script type="text/javascript" src="'.base_url().'scripts/config.js"></script>',
			'<script type="text/javascript" src="'.base_url().'simulator/assets/scripts/simulator.js"></script>'
			
		  ),
		  'content' => 'simulator/overview', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'no_visible_elements' => true,
		  'agent' =>  $agent,
		  'agentid' =>  $agentid,
		  'data' => $this->simulators->getByAgent( $agentid )		  	  
		  //'data' => $this->activity->overview( $begin, 1, $filter )		  	  		
		);
	
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
	
	public function save(){
		
		
		if( $this->input->is_ajax_request() == false ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No se puede acceder a esta sección "Simulador Crear".'
							
			));	
			
			
			redirect( 'home', 'refresh' );
			
		}
		
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Crear", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		if( empty( $_POST ) ) exit;
		
		$this->load->model( array( 'simulators' ) );
		
		$simulator = array(
			'period' => $_POST['periodo'],
			'agent_id' => $_POST['agent_id'],
			'product_group_id' => $_POST['ramo'],
			'data' => json_encode($_POST)
		);
		
		if( $this->simulators->create( 'simulator', $simulator ) == true ){
			
			
			$id = $this->simulators->getByAgent( $_POST['agent_id'] );
							
			echo $id[0]['id'];
			
		}else
			
			echo false;
		
			
	}
	
	public function update(){
		
		if( !$this->input->is_ajax_request() ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No se puede acceder a esta sección "Simulador Editar".'
							
			));	
			
			
			redirect( 'home', 'refresh' );
			
		}
		
		
		// Check access teh user for create
		if( $this->access_update == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Editar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		if( empty( $_POST ) ) exit;
		
		$this->load->model( array( 'simulators' ) );
		
		$id = $_POST['id'];
		
		unset( $_POST['id'] );
		
		$simulator = array(
			'period' => $_POST['periodo'],
			'agent_id' => $_POST['agent_id'],
			'product_group_id' => $_POST['ramo'],
			'data' => json_encode($_POST)
		);
		
		if( $this->simulators->update( 'simulator', $id, $simulator ) == true )
			
			echo true;
			
		else
			
			echo false;
		
	}
	
	
	
	
	
	
	public function config(){
		
		// Check access teh user for create
		if( $this->access_update == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Configuración Default", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		
		$this->load->model( array( 'simulators' ) );
							 
		// Config view
		$this->view = array(
				
		  'title' => 'Simulador | Configuración Default',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'scripts' =>  array(
		  	
			'<script type="text/javascript" src="'.base_url().'scripts/config.js"></script>',
			'<script type="text/javascript" src="'.base_url().'simulator/assets/scripts/config.js"></script>'
			
		  ),
		  'content' => 'simulator/config', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $this->simulators->getConfig()		  	  	  	  		
		);
	
		
		// Render view 
		$this->load->view( 'index', $this->view );	
		
	}
	
	public function configSave(){
		
		if( !$this->input->is_ajax_request() ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No se puede acceder a esta sección "Simulador Configuración Default".'
							
			));	
			
			
			redirect( 'home', 'refresh' );
			
		}
		
		
		// Check access teh user for create
		if( $this->access_update == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Editar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		$item = explode( '-', $_POST['item'] );
		
		$id  = $item[0];
		
		if( $item[1] == 1 ) 	$field = 'vida';
		if( $item[1] == 2 ) 	$field = 'gmm';
		if( $item[1] == 3 ) 	$field = 'autos';
		
		
		$data = array( $field => $_POST['value'] );
		
		$this->load->model( array( 'simulators' ) );
		
		if( $this->simulators-> update( 'simulator_default_estacionalidad', $id, $data ) == true )
			
			echo true;
		
		else
			
			echo false;
		
		exit;		
		
	}
	
/* End of file simulator.php */
/* Location: ./application/controllers/simulator.php */
}
?>