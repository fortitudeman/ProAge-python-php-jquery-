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
class Agent extends CI_Controller {

	public $view = array();
	
	public $sessions = array();
	
	public $user_vs_rol = array();
	
	public $roles_vs_access = array();
	
	public $access = false; // Force security
	
	public $access_create = false;
	
	public $access_update = false;
	
	public $access_delete = false;
	
	public $access_update_profile = false;
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
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Agent Profile', $value ) ):

			$this->access = true;
			
		break; endif; endforeach;

		/*
		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Agent Profilee', $value ) ):
			
			
			if( $value['action_name'] == 'Crear' )
				$this->access_create = true;
						
			if( $value['action_name'] == 'Editar' )
				$this->access_update = true;
				
			if( $value['action_name'] == 'Eliminar' )
				$this->access_delete = true;	
			
			
		endif; endforeach;
		*/
		
		
		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Usuarios', $value ) ):
			
			if( $value['action_name'] == 'Editar' )
				$this->access_update_profile = true;
			
		endif; endforeach;
					
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
				
	}
	
	

// Show all records	
	public function index( $userid = null, $ramo = null ){
	
		// Check access teh user for create
		if( $this->access == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Perfil Agente", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		
		$this->load->model( array( 'usuarios/user', 'activities/activity', 'simulator/simulators' ) );
						
		$agentid = $this->user->getAgentIdByUser( $userid );
		
		$agent = $this->user->getAgentsById( $agentid );
		
		$ramo = 'vida';
		
		$report = 1;
		
				
		if( !empty( $_POST ) ){            
			$data = $this->user->getReportAgent( $userid, $_POST );
         	
			if( $_POST['query']['ramo'] == 1 ){
				$ramo = 'vida';
				$report = 1;
			}
			
			if( $_POST['query']['ramo'] == 2 ){
				$ramo = 'gmm';
				$report = 2;
			}
			
			if( $_POST['query']['ramo'] == 3 ){
				$ramo = 'autos';
				$report = 2;
			}
				
		}else            
			$data = $this->user->getReportAgent( $userid, array('ramo' => 1,'periodo' => 1 ) );
						
		$activities = $this->activity->getByAgentId( $agentid );
		
		$simulator = $this->simulators->getByAgent( $agentid );		
		
		$simulator = $simulator[0]['data'];
		/*
		echo '<pre>';
		print_r( $activities );
		echo '</pre>';
		echo '<pre>';
		print_r( $data );
		echo '</pre>';
		*/	
		// Config view
		$this->view = array(
				
		  'title' => 'Perfil de agente',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'access_update_profile' => $this->access_update_profile,
		  'css' => array(
		  	'<link rel="stylesheet" href="'. base_url() .'ot/assets/style/main.css">',
			'<link href="'. base_url() .'agent/assets/style/agent.css" rel="stylesheet">',
            '<link rel="stylesheet" href="'. base_url() .'ot/assets/style/jquery.fancybox.css">'
		  ),
		  'scripts' =>  array(
		  	
			'<script type="text/javascript" src="'.base_url().'scripts/config.js"></script>',
			'<script type="text/javascript" src="'.base_url().'simulator/assets/scripts/metas.js"></script>',
			'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			'<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			'<script src="'. base_url() .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
			'<script>window.jQuery || document.write ("<script src='. base_url() .'ot/assets/scripts/vendor/jquery-1.10.1.min.js><\/script>");</script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.ddslick.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.tablesorter.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/main.js"></script>',			
			'<script src="'.base_url().'scripts/config.js"></script>'	,	
			'<script src="'.base_url().'ot/assets/scripts/report.js"></script>',
			'<script src="'.base_url().'ot/assets/scripts/jquery.fancybox.js"></script>',
			'<script src="'.base_url().'agent/assets/scripts/agent.js"></script>',
			'<script src="'.base_url().'agent/assets/scripts/report'.$report.'.js"></script>'
			
		  ),
		  'content' => 'agent/overview', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'userid' =>  $userid,
		  'agentid' =>  $agentid,
		  'ramo' => $ramo,
		  'agent' => $agent,
		  'data' => $data,
		  'activities' => $activities,
		  'simulator' => $simulator,
		  'report' => $report
		);
	
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	}	
/* End of file agent.php */
/* Location: ./application/controllers/agent.php */
}
?>