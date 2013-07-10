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
class Usuarios extends CI_Controller {

/**
 |	sessions ->	Save User Session 
 |	data -> Setting Array list data
 *  view -> Set Config to render a view
 **/	
	
	public $sessions = null;
	
	public $data = array();
	
	public $view = array();
	
/** Construct Function **/
/** Setting Load perms **/
	
	public function __construct(){
			
		parent::__construct();
		
				
		/** Getting Info User **/
		
		$this->load->model( 'user' );
				
		// Get Session
		$this->sessions = $this->session->userdata('system');
				
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
			
	}
	
	
// Login method	
	public function login(){
		
		
		if( !empty( $_POST ) ){
						
			// Validations
			$this->form_validation->set_rules('username', 'Usuario', 'required|xxs_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|xxs_clean');
			
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
			
				   
				    
					
					// Load Model
					$this->load->model( 'user' );
					
					
					// Getting data for the user
					$user = $this->user->setLogin( $this->input->post() );
					
					
					// Validation for empty user, not exist
					if( empty( $user ) ){ 
												
							// Set true message		
							$this->session->set_flashdata( 'message', array( 
								
								'type' => false,	
								'message' => 'Los datos que ingresaste no son correctos, verificalos.'
											
							));												
							
							
							redirect( 'usuarios/login', 'refresh' );
							
							
					}
					
					
					
					// Save Session
					$this->session->set_userdata( array( 'system' => $user[0] ) );
					
					redirect( 'home', 'refresh' );
					
					
				}else{
					
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'Debes de ingresar tu nombre de usuario y contraseña.'
									
					));												
					
					
					redirect( 'usuarios/login', 'refresh' );
						
				}			
			
			exit;
			
		}
		
		
		
		
		
		
		
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Login',
		  'css' => array(),
		  'scripts' =>  array(
		  		
				'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			    '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			    '<script src="'.base_url().'scripts/config.js"></script>',	
				'<script src="'.base_url().'usuarios/assets/scripts/md5.js"></script>',							
				'<script src="'.base_url().'usuarios/assets/scripts/login.js"></script>'		
				
				
		  ),
		  'message' => $this->session->flashdata('message') // Return Message, true and false if have		  
		  		
		);
				
		// Render view 
		$this->load->view( 'login', $this->view );	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	

// User logout	
	public function logout(){
	
		
		// Remove vars of user login
		$this->session->unset_userdata( 'system' );
		
		
		/*  
			$this->session->unset_userdata( 'id' );
			$this->session->unset_userdata( 'agency_id' );
			$this->session->unset_userdata( 'office_id' );
			$this->session->unset_userdata( 'name' );
			$this->session->unset_userdata( 'lastname' );
			$this->session->unset_userdata( 'agencia' );
			$this->session->unset_userdata( 'email' );
			$this->session->unset_userdata( 'working_since' );
			$this->session->unset_userdata( 'disabled' );
			$this->session->unset_userdata( 'date' );
			$this->session->unset_userdata( 'last_updated' );
		*/
		
		
		redirect( 'usuarios/login', 'refresh' );
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

// Show all records	
	public function index(){
		
		
		
		// Load Model
		$this->load->model( 'user' );
		
		
		
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
		$config['base_url'] = base_url().'usuarios/index/';
		$config['total_rows'] = $this->user->record_count();
		$config['per_page'] = 2;
		$config['num_links'] = 5;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config); 
				
						
		// Config view
		$this->view = array(
				
		  'title' => 'Usuarios',
		  'css' => array(),
		  'scripts' =>  array(
		  	  
			  '<script src="'.base_url().'scripts/config.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/find.js"></script>'	
			  
			 
		  ),
		  'content' => 'usuarios/list', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $this->user->all( $begin )		  
		  		
		);
				
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
	
	
	
	
	
	
	
	
	
	
	

// Create new role
	public function create(){
		
		/*		
		if( !isset( $this->perm['view'] )){
			echo '<script type="text/javascript"> history.back() </script>';
		}
		*/
			
			
		
		if( !empty( $_POST ) ){
			
			
			// Generals for user what does not agent
			$this->form_validation->set_rules('group[]', 'Grupo', 'required');
			$this->form_validation->set_rules('persona', 'Persona', 'required');
			$this->form_validation->set_rules('company_name', 'Nombre de compañia', 'required');
			$this->form_validation->set_rules('username', 'Usuario', 'required');
			$this->form_validation->set_rules('password', 'Contraseña', 'required|md5');
			$this->form_validation->set_rules('email', 'Correo', 'required|valid_email|is_unique[users.email]');
			
			
			if( $this->input->post('persona') == 'fisica' ){
				$this->form_validation->set_rules('name', 'Nombre', 'required|is_unique[users.name]');
				$this->form_validation->set_rules('lastname', 'Apellido', 'required');
				$this->form_validation->set_rules('birthdate', 'Fecha de cumpleaños', 'required');
			}
			
			if( $this->input->post('persona') == 'moral' ){
				$this->form_validation->set_rules('name', 'Nombre', 'required|is_unique[users.name]');
			}
				
			
			// User Agent Validations
			if( in_array( 1, $this->input->post('group') ) ){
				
				// General for Agents
				$this->form_validation->set_rules('manager_id', 'Gerente', 'required');
				
				// If process of conexion == 1 or yes
				if( $this->input->post( 'type' ) == 1 ){
					
					// SET validation fields
					$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia
', 'required');
				}else{ // Else conexion == 2 or not
					
					// SET validation fields
					$this->form_validation->set_rules('clave', 'Clave', 'required');
					$this->form_validation->set_rules('folio_nacional[]', 'Folio Nacional', 'required');
					$this->form_validation->set_rules('folio_provincial[]', 'Folio Provicional', 'required');
					$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia
', 'required');
					
				}
				
			
			}
			
			
			
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
					
				
				
				$controlSaved = true;
			
				// Save User Table							
				$user = array(
					'office_id'  => 0,
					'manager_id' => 0,
					'company_name'  => $this->input->post( 'company_name' ),
					'username'  => $this->input->post( 'username' ),
					'password'  => $this->input->post( 'password' ),					
					'name'  => $this->input->post( 'name' ),
					'lastnames'  => $this->input->post( 'lastname' ),
					'birthdate'  => $this->input->post( 'birthdate' ),					
					'email'  => $this->input->post( 'email' ),
					'disabled'  => $this->input->post( 'disabled' )
				);
				
				// Add Manager if is an agent
				if( in_array( 1, $this->input->post('group') ) ) $user['manager_id'] = $this->input->post( 'manager_id' );  
								
								
				if( $this->user->create( 'users', $user ) == false) $controlSaved = false ;
				
				if( $controlSaved == false ){
						
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se pudo guardar el registro, Usuario, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
									
					));												
					
					
					redirect( 'usuarios/create', 'refresh' );
					
				}
			
				// Recovery id last user saved
				$idSaved = $this->user->insert_id();
							
				
				// Added User roles groups
				$user_roles = array();				
				
				
				if( !empty( $_POST['group'] ) )
					foreach( $this->input->post( 'group' ) as $group )
						$user_roles[] = array( 'user_id' => $idSaved , 'user_role_id' => $group );
				
				if( $this->user->create_banch( 'users_vs_user_roles', $user_roles ) == false) $controlSaved = false ;
				
				
				if( $controlSaved == false ){
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => false,	
							'message' => 'No se pudo guardar el registro, Asignación de rol, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
										
						));												
						
						
						redirect( 'usuarios/create', 'refresh' );
						
				}
							
				/*	
				// Save values of moral person
				if( $_POST['persona'] == 'fisica' ){
					
					$fisica= array(
						
						'user_id'  => $idSaved,
						'name'  => $this->input->post( 'name' ),
						'lastnames'  => $this->input->post( 'lastname' ),
						'birthdate'  => $this->input->post( 'birthdate' )
						
					);
					
					
					//if( $this->user->create( 'agents', $fisica ) == false) $controlSaved = false ;
					
					
				}*/
				
				
				
				
				// Save values of moral person
				if( $_POST['persona'] == 'moral' ){
										
					$timestamp = date( 'Y-m-d H:i:s' ) ;
					
					$moral= array();
					
					for( $i=0; $i<=count( $_POST['name_r'] ); $i++ )
							
							if( isset( $_POST['name_r'][$i] ) )
							$moral[] = array(
								
								'user_id'  => $idSaved,
								'name'  => $_POST['name_r'][$i],
								'lastnames'  =>  $_POST['lastname_r'][$i],
								'office_phone'  => $_POST['office_phone'][$i],
								'office_ext'  => $_POST['office_ext'][$i],
								'mobile'  => $_POST['mobile'][$i],
								'last_updated' => $timestamp,
								'date' => $timestamp
								
							);
					
					
					
					if( $this->user->create_banch( 'representatives', $moral ) == false) $controlSaved = false ;
					
					if( $controlSaved == false ){
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => false,	
							'message' => 'No se pudo guardar el registro, Representantes morales ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
										
						));												
						
						
						redirect( 'usuarios/create', 'refresh' );
						
					}
																
				}
				
				
				
				
				
				
					
				
				if( in_array( 1, $this->input->post('group') ) ){
					
					
					$agent= array(
						
						'user_id'  => $idSaved,
						'connection_date'  => $this->input->post( 'connection_date' ),
						'license_expired_date'  =>$this->input->post( 'license_expired_date' ),
						
					);
					
					
					if( $this->user->create( 'agents', $agent ) == false) $controlSaved = false ;
					
					
					
					// Saved Agents
					if( $controlSaved == false ){
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => false,	
							'message' => 'No se pudo guardar el registro, agentes ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
										
						));												
						
						
						redirect( 'usuarios/create', 'refresh' );
						
					}
					
					
					
					
					
					$idAgentSaved = $this->user->insert_id();
																				
					$uids_agens = array();
					
					$timestamp = date( 'Y-m-d H:i:s' ) ;
					
					// Added Clave
					$uids_agens[] = array(
								'agent_id' => $idAgentSaved,
								'type' =>  'clave',
								'uid' =>  $this->input->post( 'clave' ),
								'last_updated' => $timestamp,
								'date' => $timestamp
					);
					
					
					
					// added folio nacional
					if( !empty( $_POST['folio_nacional'] ) )
						foreach( $this->input->post( 'folio_nacional' ) as $value )
							$uids_agens[] = array(
								'agent_id' => $idAgentSaved,
								'type' =>  'national',
								'uid' =>  $value,
								'last_updated' => $timestamp,
								'date' => $timestamp
							);
					
					
					
					
					
					// Added folio provicional
					if( !empty( $_POST['folio_provincial'] ) )
						foreach( $this->input->post( 'folio_provincial' ) as $value )
							$uids_agens[] = array(
								'agent_id' => $idAgentSaved,
								'type' => 'provincial',
								'uid' =>  $value,
								'last_updated' => $timestamp,
								'date' => $timestamp
							);
					
					
					if( $this->user->create_banch( 'agent_uids', $uids_agens ) == false) $controlSaved = false ;
					
					
					if( $controlSaved == false ){
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => false,	
							'message' => 'No se pudo guardar el registro, Folio provicional, Folio Nacional, Clave ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
										
						));												
						
						
						redirect( 'usuarios/create', 'refresh' );
						
					}
					
				}
				
				
				
				// Save Record	
				if( $controlSaved == true ){
					
					
					// Set true message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se guardo el registro correctamente'
									
					));												
					
					
					redirect( 'usuarios', 'refresh' );
					
					
					
				}
				
				
			}	
			
						
		}
		
		
		// Load Model Dependencies
		$this->load->model( 
						array( 
							'roles/rol'
						 ) 
		);
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Crear Usuario',
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/md5.js"></script>',	
			  '<script src="'.base_url().'usuarios/assets/scripts/usuarios.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'				
		  ),
		  'content' => 'usuarios/create', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
			
			
		 //Selects	
		  'group' => $this->rol->checkbox(),
		  'gerentes' => $this->user->getSelectsGerentes()			
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	}
	
	
// Find for field name filter	
	public function find(){  
		
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		
		// Load MOdel
		$this->load->model( 'user' );
		
		
		// Filter method
		$this->data = $this->user->find(  $this->input->post( 'find' ) );
		
		
		// If empty load all records again
		if( empty( $this->data ) )
			
			$this->data = $this->user->all( 0 );
		
		
		// Load Helper
		$this->load->helper( 'user' );
		
		
		
		// Getting table
		echo renderTable( $this->data );
		
		exit;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
// Update role	
	public function update( $id = null ){
		
		
		
		// Validation of id number
		if( empty( $id ) or !is_numeric( $id ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No es valido. El registro no se puede encontrar.'
							
			));												
			
			
			redirect( 'roles', 'refresh' );
			
		}
		
		
		
		// Load model
		$this->load->model( 'rol' );
		
		
		$data = $this->rol->id( $id );
		
		// Validation rol
		if( empty( $data ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'El registro no existe'
							
			));												
			
			
			redirect( 'roles', 'refresh' );
			
		}
		
		
		
		
		
		
		
		
		
		
		
		if( !empty( $_POST ) ){
			
			
			// Load model
			$this->load->model( 'rol' );
			
			
			// Validations
			$this->form_validation->set_rules('name', 'Nombre de Rol', 'required');
			
			
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
					
					
				// Save Record	
				if( $this->rol->update( $id, $this->input->post() ) == true ){
					
					
					// Set true message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se guardo el registro correctamente'
									
					));												
					
					
					redirect( 'roles', 'refresh' );
					
					
					
				}else{
					
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se pudo guardar el registro, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
									
					));												
					
					
					redirect( 'roles', 'refresh' );
						
				}						
					
			}	
			
						
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Editar role -' .$data['name'],
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="'.base_url().'roles/assets/scripts/roles.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'				
		  ),
		  'content' => 'roles/update', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $data		
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
		
		
	}












// Delete role	
	public function delete( $id = null ){
		
		
		
		// Validation of id number
		if( empty( $id ) or !is_numeric( $id ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No es valido. El registro no se puede encontrar.'
							
			));												
			
			
			redirect( 'roles', 'refresh' );
			
		}
		
		
		
		// Load model
		$this->load->model( 'rol' );
		
		
		$data = $this->rol->id( $id );
		
		// Validation rol
		if( empty( $data ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'El registro no existe'
							
			));												
			
			
			redirect( 'roles', 'refresh' );
			
		}
		
		
		
		
		
		
		
		
		
		
		
		if( !empty( $_POST ) ){
			
			
			// Load model
			$this->load->model( 'rol' );
			
			// Save Record	
			if( $this->rol->delete( $id ) == true ){
				
				
				// Set true message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => true,	
					'message' => 'Se elimino el registro correctamente'
								
				));												
				
				
				redirect( 'roles', 'refresh' );
				
				
				
			}else{
				
				
				// Set false message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => false,	
					'message' => 'No se pudo eliminar el registro, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
								
				));												
				
				
				redirect( 'roles', 'refresh' );
					
			}						
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Eliminar role -' .$data['name'],
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="'.base_url().'roles/assets/scripts/roles.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'				
		  ),
		  'content' => 'roles/delete', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $data		
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	}

/* End of file roles.php */
/* Location: ./application/controllers/roles.php */
}
?>