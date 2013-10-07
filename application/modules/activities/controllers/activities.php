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
class Activities extends CI_Controller {

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
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Actividades', $value ) ):

			$this->access = true;
			
		break; endif; endforeach;


		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Actividades', $value ) ):
			
			
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
	public function index( $filter = null ){
		
		
		
		// Check access teh user for create
		if( $this->access == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Actividad", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
						
		
		// Load Model
		$this->load->model( array( 'activity' ) );
		
		
		
		// Pagination config	
		$this->load->library('pagination');
		
		$begin = $this->uri->segment(3);
		
		if( empty( $begin ) ) $begin = 0;
		
					
		$config['full_tag_open'] = '<div class="pagination pagination-right"><ul>'; 
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Anterior';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Siguiente &rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';					
		$config['base_url'] = base_url().'activities/index/';
		$config['total_rows'] = $this->activity->record_count( $this->user->getAgentIdByUser( $this->sessions['id'] ), $filter );
		//$config['total_rows'] = $this->activity->record_count( 1, $filter );
		$config['per_page'] = 150;
		$config['num_links'] = 5;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config); 
	
					 
		// Config view
		$this->view = array(
				
		  'title' => 'Actividad',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'content' => 'activities/list', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $this->activity->overview( $begin, $this->user->getAgentIdByUser( $this->sessions['id'] ), $filter )		  	  
		  //'data' => $this->activity->overview( $begin, 1, $filter )		  	  		
		);
	
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
	
	
	
	
	
	
	
	
	
	
	

// Create new user
	public function create(){
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Actividad crear", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'activities', 'refresh' );
		
		}
			
			
		
		if( !empty( $_POST ) ){
										
			// Generals validations
			$this->form_validation->set_rules('begin', 'Semana', 'required');
			$this->form_validation->set_rules('cita', 'Cita', 'required|numeric');
			$this->form_validation->set_rules('prospectus', 'Prospecto', 'required|numeric');
			$this->form_validation->set_rules('interview', 'Entrevista', 'required|numeric');
					
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
				
				//Load Model
				$this->load->model( array( 'activity', 'user' ) );
			
				$_POST['agent_id'] =  $this->user->getAgentIdByUser( $this->sessions['id'] );
				
				
				if( $this->activity->exist( 'agents_activity', $_POST ) == true )
								
					if( $this->activity->create( 'agents_activity', $_POST ) == true ){
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => true,	
							'message' => 'Se creó la actividad correctamente.'
										
						));	
						
						
						redirect( 'activities', 'refresh' );
						
					}else{
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => false,	
							'message' => 'No se puede crear la actividad, consulte a su administrador.'
										
						));	
						
						
						redirect( 'activities', 'refresh' );
						
					}
				
				else{
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se puede crear la actividad ya existe.'
									
					));	
					
					
					redirect( 'activities/create', 'refresh' );	
				}
			}	
			
						
		}
						
		// Config view
		$this->view = array(
				
		  'title' => 'Crear Actividad',
		    // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'css' => array(
		  	'<link href="'. base_url() .'activities/assets/style/create.css" rel="stylesheet" media="screen">'
		  ),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'scripts/config.js"></script>',
			  '<script src="'.base_url().'activities/assets/scripts/activities.js"></script>'
			  	
		  ),
		  'content' => 'activities/create', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	}
/* End of file activities.php */
/* Location: ./application/controllers/activities.php */
}
?>