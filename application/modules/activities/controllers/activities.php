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

	public $access_report = false;

	public $access_viewall = false;

	
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

			if( $value['action_name'] == 'Ver reporte' )
				$this->access_report = true;	
			
			if( $value['action_name'] == 'Ver todos los registros' )
				$this->access_viewall = true;	

			if( $value['action_name'] == 'Export xls' )
				$this->access_export = true;
				
		endif; endforeach;
							
								
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
			
	}
	
	

// Show all records	
	public function index( $userid = null, $filter = null ){
		
		
		
		// Check access teh user for create
		if( $this->access == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Actividad", Informe a su administrador para que le otorgue los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
						
		
		// Load Model
		$this->load->model( array( 'activity', 'user' ) );
		
		
		
		// Pagination config	
		$this->load->library('pagination');
		
		$begin = $this->uri->segment(4);
		
		if( empty( $begin ) ) $begin = 0;
		
		if( !empty( $userid ) ){	
			$agentid = $this->user->getAgentIdByUser( $userid );
			$url = base_url().'activities/index/'.$userid.'/';
			$user = $this->user->getForUpdateOrDelete($userid);
		}else{
			$agentid = $this->user->getAgentIdByUser( $this->sessions['id'] );
			$url = base_url().'activities/index/';
			$user = $this->user->getForUpdateOrDelete($this->sessions['id']);
		}
		
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
		$config['base_url'] = $url;
		$config['total_rows'] = $this->activity->record_count( $agentid, $filter );
		$config['per_page'] = 150;
		$config['num_links'] = 5;
		$config['uri_segment'] = 4;
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
		  'access_report' => $this->access_report,
		  'access_viewall' => $this->access_viewall,
		  'content' => 'activities/list', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $this->activity->overview( $begin, $agentid, $filter ),
		  'userid' => $userid,
		  'usersupdate' => $user[0]		  	   	  		
		);
	
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
	
	
	
	
	
	
	
	
	

// Create new user
	public function create( $userid = null ){
		
				
		
		// Check access the user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Actividad crear", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			if( !empty( $userid ) )				
				redirect( 'activities/index/'.$userid, 'refresh' );
			else
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
			
				if( !empty( $userid ) )	
					$_POST['agent_id'] =  $this->user->getAgentIdByUser( $userid );
				else					
					$_POST['agent_id'] = $this->user->getAgentIdByUser( $this->sessions['id'] );
			
				
				if( $this->activity->exist( 'agents_activity', $_POST ) == true )
								
					if( $this->activity->create( 'agents_activity', $_POST ) == true ){
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => true,	
							'message' => 'Se creó la actividad correctamente.'
										
						));	
						
						
						if( !empty( $userid ) )				
							redirect( 'activities/index/'.$userid, 'refresh' );
						else
							redirect( 'activities', 'refresh' );
						
					}else{
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => false,	
							'message' => 'No se puede crear la actividad, consulte a su administrador.'
										
						));	
						
						
						if( !empty( $userid ) )				
							redirect( 'activities/index/'.$userid, 'refresh' );
						else
							redirect( 'activities', 'refresh' );
						
					}
				
				else{
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se puede crear la actividad ya existe.'
									
					));	
					
					
					if( !empty( $userid ) )				
						redirect( 'activities/index/'.$userid, 'refresh' );
					else
						redirect( 'activities', 'refresh' );
				}
			}	
			
						
		}
		
		
		if( !empty( $userid ) )	
			$user = $this->user->getForUpdateOrDelete($userid);
		else
			$user = $this->user->getForUpdateOrDelete($this->sessions['id']);
		
		
		
		
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
		  'access_report' => $this->access_report,
		  'access_viewall' => $this->access_viewall,
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
		  'userid' => $userid,
		  'usersupdate' => $user[0]
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	}
	

//Report of Activities
	public function report( $userid = null ){

		// Check access the user for create
		if( $this->access_report == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Actividades: Reporte", Informe a su administrador para que le otorgue los permisos necesarios.'
							
			));	
			
			
			if( !empty( $userid ) )				
				redirect( 'activities/index/'.$userid, 'refresh' );
			else
				redirect( 'activities', 'refresh' );
			
		
		}
			
			
		
		if( !empty( $_POST['begin'] ) ){
										
			// Generals validations
			$this->form_validation->set_rules('begin', 'Semana', 'required');
					
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
				
				//Load Model
				$this->load->model( array( 'activity', 'user' ) );
				
			}	
			
			$this->view = array(
					
			  'title' => 'Reporte de Actividades',
			    // Permisions
			  'user' => $this->sessions,
			  'user_vs_rol' => $this->user_vs_rol,
			  'roles_vs_access' => $this->roles_vs_access,
			  'access_create' => $this->access_create,
			  'access_update' => $this->access_update,
			  'access_delete' => $this->access_delete,
			  'access_report' => $this->access_report,
			  'access_viewall' => $this->access_viewall,
			  'access_export' => $this->access_export,
			  'css' => array(
			  	'<link href="'. base_url() .'activities/assets/style/create.css" rel="stylesheet" media="screen">'
			  ),
			  'scripts' =>  array(
				  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
				  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
				  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
				  '<script src="'.base_url().'scripts/config.js"></script>',
				  '<script src="'.base_url().'activities/assets/scripts/activities.js"></script>',
				  '<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.tablesorter.js"></script>'
			  ),
			  'content' => 'activities/report', // View to load
			  'data' => $this->activity->report( 'agents_activity', $_POST ), // View to load
			  'message' => $this->session->flashdata('message') // Return Message, true and false if have
			);
						
		}				
				
		else {

			$this->view = array(
					
			  'title' => 'Reporte de Actividades',
			    // Permisions
			  'user' => $this->sessions,
			  'user_vs_rol' => $this->user_vs_rol,
			  'roles_vs_access' => $this->roles_vs_access,
			  'access_create' => $this->access_create,
			  'access_update' => $this->access_update,
			  'access_delete' => $this->access_delete,
			  'access_report' => $this->access_report,
			  'access_viewall' => $this->access_viewall,
			  'access_export' => $this->access_export,
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
			  'content' => 'activities/report', // View to load
			  'message' => $this->session->flashdata('message') // Return Message, true and false if have
			);

		}				
		
		// Render view 
		$this->load->view( 'index', $this->view );		
	
	}

// Export	
	public function exportar( $userid = null ){

		// Check access for export
		if( $this->access_export == false ){

			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Report Exportar", Informe a su administrador para que le otorge los permisos necesarios.'
			));

			if( !empty( $userid ) )				
				redirect( 'activities/index/'.$userid, 'refresh' );
			else
				redirect( 'activities', 'refresh' );
		}

		// Check begin and end dates
		$this->load->helper('activities/date_report');
		if ( !isset($_POST['begin']) || !isset($_POST['end']) || 
			!checkdate_from_to( $_POST['begin'], $_POST['end'] ) ) {

			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'Fecha no válida.'
			));

			if( !empty( $userid ) )				
				redirect( 'activities/index/'.$userid, 'refresh' );
			else
				redirect( 'activities', 'refresh' );
		}

		$filename = "proages_actividades_report_" . $_POST['begin'] . ".csv";
		header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="$filename"');
		
		// Load Model and csv helper
		$this->load->model( 'activity' );
		$this->load->helper('usuarios/csv');

		// Generate report and output it
		$data = $this->activity->report( 'agents_activity', $_POST );
		$report_data = array(
			array(
				'Agente', 'Citas', 'Entrevistas', 'Prospectos', 'Solicitudes Vida', 
				'Negocios Vida', 'Solicitudes GMM', 'Negocios GMM', 'Negocios Autos', 'Comentarios'
			)
		);
		foreach ($data['rows'] as $value) {
			$report_data[] = array(
				$value['name'] . ' ' . $value['lastnames'],
				$value['cita'], $value['interview'],
				$value['prospectus'], $value['vida_requests'],
				$value['vida_businesses'], $value['gmm_requests'], $value['gmm_businesses'],
				$value['autos_businesses'], $value['comments']
			);
		}

		$report_data[] = array(
			'TOTALS', $data['totals']['cita'], $data['totals']['interview'],
			$data['totals']['prospectus'], $data['totals']['vida_requests'],
			$data['totals']['vida_businesses'], $data['totals']['gmm_requests'],
			$data['totals']['gmm_businesses'], $data['totals']['autos_businesses']
		);

	 	array_to_csv($report_data, $filename);
		
		if( is_file( $filename ) )
			echo file_get_contents( $filename );
		
		if( is_file( $filename ) )
			unlink( $filename );
				
		exit;

	}
	
/* End of file activities.php */
/* Location: ./application/controllers/activities.php */
}
?>