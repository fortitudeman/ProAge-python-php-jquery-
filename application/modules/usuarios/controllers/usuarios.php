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

	public $view = array();
	
	public $sessions = array();
	
	public $user_vs_rol = array();
	
	public $roles_vs_access = array();
	
	public $access = false; // Force security
	
	public $access_create = false;
	
	public $access_update = false;
	
	public $access_delete = false;
	
	public $access_export = false;
	
	public $access_import = false;
	
	public $access_request_new_user = false;
	
	public $access_send_message = false;
	
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
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Usuarios', $value ) ):

			$this->access = true;
			
		break; endif; endforeach;


		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Usuarios', $value ) ):
			
			
			if( $value['action_name'] == 'Crear' )
				$this->access_create = true;
						
			if( $value['action_name'] == 'Editar' )
				$this->access_update = true;
				
			if( $value['action_name'] == 'Eliminar' )
				$this->access_delete = true;	
			
			if( $value['action_name'] == 'Petición nuevo usuario' )
				$this->access_request_new_user = true;
			
			if( $value['action_name'] == 'Import xls' )
				$this->access_import = true;	
			
			if( $value['action_name'] == 'Export xls' )
				$this->access_export = true;		
			
			if( $value['action_name'] == 'Enviar correo' )
				$this->access_send_message = true;			
			
						
			
			
		endif; endforeach;
							
								
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
		
		redirect( 'usuarios/login', 'refresh' );
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

// Show all records	
	public function index( $filter = null ){
		
		
		
		// Check access teh user for create
		if( $this->access == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Usuarios", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
						
		
		// Load Model
		$this->load->model( array( 'user', 'rol' ) );
		
		
		
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
		$config['total_rows'] = $this->user->record_count( $filter );
		$config['per_page'] = 150;
		$config['num_links'] = 5;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config); 
		
		// Setting url for export currently
		if( $begin  == 0 ) $pag = 'usuarios/exportar.html';	else $pag =  'usuarios/exportar/'.$begin.'.html';
						 
		// Config view
		$this->view = array(
				
		  'title' => 'Usuarios',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'access_import' => $this->access_import,
		  'access_export' => $this->access_export,
		  'access_request_new_user' => $this->access_request_new_user,
		  'scripts' =>  array(
		  	  
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'scripts/config.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/find.js"></script>'
			  
			 
		  ),
		  'content' => 'usuarios/list', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $this->user->overview( $begin, $filter ),
		  'pag' => $pag,
		  'rol' => $this->rol->all( 0 ),
		  'gerentes' => $this->user->getSelectsGerentes()			  	  
		  		
		);
		
		
		if( !empty( $filter ) )
			$this->view['filter'] = $filter;
				
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
				'message' => 'No tiene permisos para ingresar en esta sección "Usuarios crear", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
		
		}
			
			
		
		if( !empty( $_POST ) ){
			
					
			// Generals for user what does not agent
			$this->form_validation->set_rules('group[]', 'Grupo', 'required');
			$this->form_validation->set_rules('persona', 'Persona', 'required');
			$this->form_validation->set_rules('username', 'Usuario', 'required|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Contraseña', 'required');
			$this->form_validation->set_rules('email', 'Correo', 'required|valid_email|is_unique[users.email]');
			
			
			if( $this->input->post('persona') == 'fisica' ){
				$this->form_validation->set_rules('lastname', 'Apellido', 'required');
				//$this->form_validation->set_rules('birthdate', 'Fecha de cumpleaños', 'required');
			}
			
			if( $this->input->post('persona') == 'moral' ){
				//$this->form_validation->set_rules('company_name', 'Nombre de compañia', 'required');
			}
				
			
			// User Agent Validations
			if( in_array( 1, $this->input->post('group') ) ){
				
				// General for Agents
				//$this->form_validation->set_rules('manager_id', 'Gerente', 'required');
				
				// If process of conexion == 1 or yes
				if( $this->input->post( 'type' ) == 'Si' ){
					
					// SET validation fields
					//$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					//$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia', 'required');
				}else{ // Else conexion == 2 or not
					
					// SET validation fields
					$this->form_validation->set_rules('clave', 'Clave', 'required|is_unique[agent_uids.uid]');
					$this->form_validation->set_rules('folio_nacional[]', 'Folio Nacional', 'required|is_unique[agent_uids.uid]');
					$this->form_validation->set_rules('folio_provincial[]', 'Folio Provicional', 'required|is_unique[agent_uids.uid]');
					//$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					//$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia', 'required');
					
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
					'password'  => md5($this->input->post( 'password' )),					
					'name'  => $this->input->post( 'name' ),
					'lastnames'  => $this->input->post( 'lastname' ),
					'birthdate'  => $this->input->post( 'birthdate' ),					
					'email'  => $this->input->post( 'email' ),
				);
				
				// Add Manager if is an agent
				if( in_array( 1, $this->input->post('group') ) ) $user['manager_id'] = $this->input->post( 'manager_id' );  
				
				if( $this->input->post( 'disabled' ) == 'Si' ) $user['disabled']  = 1; else $user['disabled'] = 0;
				
				// Uploaded a picture
				if( !empty( $_FILES['imagen']['name'] ) ){
			
						$file = $_FILES['imagen']['name'];  
		 
						$file = strtr($file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
					
						// replace characters other than letters, numbers and . by _
						$file = preg_replace('/([^.a-z0-9]+)/i', '_', $file);
						
					 
						if ( move_uploaded_file( $_FILES['imagen']['tmp_name'], APPPATH.'modules/usuarios/assets/profiles/'.$file ) ){
							$user['picture'] = $file;
						}else{
							$user['picture'] = "default.png";
						};
					
				}else{
					$user['picture'] = "default.png";
				}
				
								
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
					
					for( $i=0; $i<=count( $_POST['name_r'] ); $i++ ){
							
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
					}
					
					
					
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
		    // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
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
	
	
	











// Create request new user
	public function create_request_new_user(){
		
		// Check access teh user for create
		if( $this->access_request_new_user == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Usuarios Crear Petición de nuevo usuario", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
		
		}
			
			
		
		if( !empty( $_POST ) ){
			
			
									
			// Generals for user what does not agent
			$this->form_validation->set_rules('group[]', 'Grupo', 'required');
			$this->form_validation->set_rules('persona', 'Persona', 'required');
			$this->form_validation->set_rules('username', 'Usuario', 'required|is_unique[users.username]');
			$this->form_validation->set_rules('password', 'Contraseña', 'required');
			$this->form_validation->set_rules('email', 'Correo', 'required|valid_email|is_unique[users.email]');
			
			
			if( $this->input->post('persona') == 'fisica' ){
				$this->form_validation->set_rules('lastname', 'Apellido', 'required');
				//$this->form_validation->set_rules('birthdate', 'Fecha de cumpleaños', 'required');
			}
			
			if( $this->input->post('persona') == 'moral' ){
				//$this->form_validation->set_rules('company_name', 'Nombre de compañia', 'required');
			}
				
			
			// User Agent Validations
			if( in_array( 1, $this->input->post('group') ) ){
				
				// General for Agents
				//$this->form_validation->set_rules('manager_id', 'Gerente', 'required');
				
				// If process of conexion == 1 or yes
				if( $this->input->post( 'type' ) == 'Si' ){
					
					// SET validation fields
					//$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					//$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia', 'required');
				}else{ // Else conexion == 2 or not
					
					// SET validation fields
					$this->form_validation->set_rules('clave', 'Clave', 'required|is_unique[agent_uids.uid]');
					$this->form_validation->set_rules('folio_nacional[]', 'Folio Nacional', 'required|is_unique[agent_uids.uid]');
					$this->form_validation->set_rules('folio_provincial[]', 'Folio Provicional', 'required|is_unique[agent_uids.uid]');
					//$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					//$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia', 'required');
					
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
					'password'  => md5($this->input->post( 'password' )),					
					'name'  => $this->input->post( 'name' ),
					'lastnames'  => $this->input->post( 'lastname' ),
					'birthdate'  => $this->input->post( 'birthdate' ),					
					'email'  => $this->input->post( 'email' ),
				);
				
				// Add Manager if is an agent
				if( in_array( 1, $this->input->post('group') ) ) $user['manager_id'] = $this->input->post( 'manager_id' );  
				
				if( $this->input->post( 'disabled' ) == 'Si' ) $user['disabled']  = 1; else $user['disabled'] = 0;
				
				// Uploaded a picture
				if( !empty( $_FILES['imagen']['name'] ) ){
			
						$file = $_FILES['imagen']['name'];  
		 
						$file = strtr($file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
					
						// replace characters other than letters, numbers and . by _
						$file = preg_replace('/([^.a-z0-9]+)/i', '_', $file);
						
					 
						if ( move_uploaded_file( $_FILES['imagen']['tmp_name'], APPPATH.'modules/usuarios/assets/profiles/'.$file ) ){
							$user['picture'] = $file;
						}else{
							$user['picture'] = "default.png";
						};
					
				}else{
					$user['picture'] = "default.png";
				}
				
								
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
					
					for( $i=0; $i<=count( $_POST['name_r'] ); $i++ ){
							
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
					}
					
					
					
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
				
		  'title' => 'Crear Petición nuevo usuario',
		    // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/md5.js"></script>',	
			  '<script src="'.base_url().'usuarios/assets/scripts/usuarios.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'usuarios/create_request_new_user', // View to load
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
		
		//print_r( $this->input->post() );
		//exit;
		// Filter method
		$this->data = $this->user->find(  $this->input->post() );
				
		// If empty load all records again
		if( empty( $this->data ) )
			
			echo '<tr><td colspan="10"><div class="alert alert-warning">No se encontrarón registros</div></td></tr>';
			
			//$this->data = $this->user->overview( 0 );
		
		
		// Load Helper
		$this->load->helper( 'user' );
		
				
		// Getting table
		echo renderTable( $this->data, $this->access_update, $this->access_delete );
		
		exit;
	}
	
	
	
	
	



// Import	
	public function importar(){
		
		
		// Check access teh user for import
		if( $this->access_import == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Usuarios Importar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
		
		}
	
	
	
	
	
// Load File
		if( isset( $_FILES['file'] ) and !empty( $_FILES  ) ){
			
			
			// Setting file temporal file named			
			$tmp_file = $_FILES['file']['name'];

			$tmp_file = strtr($tmp_file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

			$tmp_file = preg_replace('/([^.a-z0-9]+)/i', '_', $tmp_file);

			
			
			// Upload Temporal file CSV			
			if( is_dir( APPPATH.'modules/usuarios/assets/tmp/' ) )
					
					move_uploaded_file( $_FILES['file']['tmp_name'],  APPPATH.'modules/usuarios/assets/tmp/'  . $tmp_file );
					
			
			
			
			// Read File			
			if( is_file( APPPATH.'modules/usuarios/assets/tmp/' . $tmp_file ) ){
						
				$file_handle = fopen( APPPATH.'modules/usuarios/assets/tmp/'  . $tmp_file, "r");
				
				
				$file_array = array();
				
				
				while (!feof($file_handle) )
				
					$file_array[] = fgetcsv($file_handle, 1024);
					
				
				fclose($file_handle);
				
			}
			
		}
	




// Change indexes
		if( !empty( $_POST ) ){
			
			// Load Model
			$this->load->model( array( 'user', 'roles/rol' ) );
			
			$tmp_file = $_POST['tmp_file'];
			
			
			// Read File			
			if( is_file( APPPATH.'modules/usuarios/assets/tmp/' . $tmp_file  ) ){
						
				$file_handle = fopen( APPPATH.'modules/usuarios/assets/tmp/'  . $tmp_file , "r");
				
				
				$file_array = array();
				
				
				while (!feof($file_handle) )
				
					$file_array[] = fgetcsv($file_handle, 1024);
					
				
				fclose($file_handle);
				
			}
			
			// Change indexes
			for( $i=0; $i<=count($file_array); $i++ ){
				
					if( !empty( $file_array[$i] ) ){
						
						
						for( $a=0; $a<=count($_POST); $a++ ){
							
							if( !empty( $_POST[$a] ) ){
								
								$file_array[$i][$_POST[$a]] = $file_array[$i][$a];
								
								if( isset( $file_array[$i][$a] ) ) unset( $file_array[$i][$a] ); // Clean array
								
							
							}
						}
						
						if( isset( $file_array[$i][$a+1] ) ) unset( $file_array[$i][$a+1] ); // Clean array
						
						
												
					}
			
			}
			
			
			
		
			// Saved records
			if( !empty( $file_array ) ){
				
				if( isset( $message ) ) unset( $message );
			
				// Message saved errors
				$message = array();
				
				$lin=1;
				
				// Validations
				foreach( $file_array as $items ){
					
					
					if( empty( $items ) ) break;

				
					if( isset( $items['name'] ) and !empty( $items['name'] ) ) $name = ' Nombre: '.$items['name'] . ' Apellido: '.$items['lastname']; else $name = '';
						
						
					// Validations geenral										
					if( isset( $items['group'] ) and empty( $items['group'] ) ) $message[$lin][] = array( 'messagerol' => 'El rol del usuario es requerido, linea de archivo: ' . $lin . $name );
					if( isset( $items['persona'] ) and empty( $items['persona'] ) ) $message[$lin][] = array( 'messagetipo' => 'El tipo de persona es requerido, linea de archivo: ' . $lin . $name );
					
					if( isset( $items['username'] ) and empty( $items['username'] ) ) $message[$lin][] = array( 'messageuser' => 'El usuario es requedido, linea de archivo: ' . $lin . $name );
					if( isset( $items['password'] ) and empty( $items['password'] ) ) $message[$lin][] = array( 'messagepassword' => 'El password es requerido, linea de archivo: ' . $lin . $name );
					if( isset( $items['email'] ) and empty( $items['email'] ) ) $message[$lin][] = array( 'messageemail' => 'El correo es requerido, linea de archivo: ' . $lin . $name );
					
					
					if(  $this->user->is_unique( 'email', $items['email'] ) == false  ) $message[$lin][] = array( 'messageemailexist' => 'El Correo ya existe, linea de archivo: ' . $lin . $name );
					
					
															
					// Validation for moral person
					if( isset( $items['persona'] ) and strtolower( trim($items['persona'] ) ) == 'moral' ){
						
						if( empty( $items['name'] ) ) $message[$lin][] = array( 'messagepersonaname' => 'El nombre es requerido, linea de archivo: ' . $lin . $name );
												
					}
										
					
					
					
					
					
					// Validation for agents
					if( isset( $items['group'] ) ){
					
						$group = explode( ' ', strtolower(trim($items['group'])) );

						if( in_array( 'agente', $group ) ){
							
							if( isset( $items['manager_id'] ) and empty( $items['manager_id'] ) ) 
									
									$message[$lin] = array( 'messageagente' => 'El gerente es requeda, linea de archivo: ' . $lin . $name );
																					
							
							// If process of conexion == 1 or yes
							if( isset( $items['type'] ) and strtolower(trim($items['type']))  == 'si' ){
								
								// SET validation fields
								if( isset( $items['connection_date'] ) and empty( $items['connection_date'] ) ) 
											
									$message[$lin][] = array( 'messagefechaconexion' => 'Fecha de conexión es requerido, linea de archivo: ' . $lin . $name );
					
								if( isset( $items['license_expired_date'] ) and empty( $items['license_expired_date'] ) ) 
											
									$message[$lin][] = array( 'messagelicenseexpireddate' => 'Expiración de licencia es requerido, linea de archivo: ' . $lin . $name );			
							
							
							}else{ // Else conexion == 2 or not
								
								// SET validation fields
								if( isset( $items['clave'] ) and  empty( $items['clave'] ) ) 
									
									$message[$lin][] = array( 'messageclave' => 'Clave es requerido, linea de archivo: ' . $lin . $name );
								
								if( isset( $items['folio_nacional'] ) and empty( $items['folio_nacional'] ) ) 
										
									$message[$lin][] = array( 'message' => 'Folio nacional es requerido, linea de archivo: ' . $lin . $name );
								
								
								if( isset( $items['folio_provincial'] ) and empty( $items['folio_provincial'] ) ) 
									
									$message[$lin][] = array( 'messagefolio_provincial' => 'Folioprovincial es requerido, linea de archivo: ' . $lin . $name );
								
								
								
								if( isset( $items['connection_date'] ) and empty( $items['connection_date'] ) ) 
										
									$message[$lin][] = array( 'messageconnection_date' => 'Fecha de conexión es requerido, linea de archivo: ' . $lin . $name );
								
								if( isset( $items['license_expired_date'] ) and empty( $items['license_expired_date'] ) ) 
									
									$message[$lin][] = array( 'messagelicense_expired_date' => 'Expiración de licencia es requerido, linea de archivo: ' . $lin . $name );
								
								
							}
							
							
							
						}
						
						
						
						
						// Save import					
						
						
						
						
				
						$controlSaved=true;
						// Saved record
						if( empty( $message[$lin] ) ){
							
							
							// Adding user
																	
							$user = array(
								'office_id'  => 0,
								'manager_id' => 0,
								'disabled' => 1,
								'username'  => $items['username'],
								'password'  => md5($items['password']),					
								'name'  => $items['name'],
								'lastnames'  => $items['lastname'],
								'email'  => $items['email'],
								'picture' => 'default.png'
							);
							
							if( isset( $items['company_name'] ) ) $user['company_name'] = $items['company_name'];
							if( isset( $items['disabled'] ) ) $user['disabled'] = $items['disabled'];
							if( isset( $items['birthdate'] ) ) $user['birthdate'] = $items['birthdate'];
							
																					
							if( $this->user->create( 'users', $user ) == false) $controlSaved = false ;
							
							unset( $user ); // Free Memory
							
							
							if( $controlSaved == false ){
								
								
								$message[$lin][] = array( 'messagesavederroruser' => 'No se pudo guardar el registro, Usuario, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador, linea de archivo: ' . $lin . $name );
															
								
							}
							
									
							// Recovery id last user saved
							$idSaved = $this->user->insert_id();		
							
							
							
						
																	
							// Adding roles
							$user_roles = array();
							
							
							$group = explode( ',', strtolower(trim($items['group'])) );
														
							if( !empty( $group ) and is_array( $group ) ){
								
								foreach( $group as $rol )
									$user_roles[] = array( 'user_id' => $idSaved , 'user_role_id' => $this->user->getIdRol($rol) );
						
								
								if( $this->user->create_banch( 'users_vs_user_roles', $user_roles ) == false) $controlSaved = false ;
							
							}else{
								$user_roles[] = array( 'user_id' => $idSaved , 'user_role_id' => $this->user->getIdRol($group) );
							}
						
							if( $controlSaved == false ){
									
									$message[$lin][] = array( 'messagesavederroruserrole' => 'No se pudo guardar el registro, Usuario -Rol, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador, linea de archivo: ' . $lin . $name );
																										
							}
																												
																												
							// Save values of moral person
							if( isset( $items['persona'] ) and strtolower(trim($items['persona'])) == 'moral' and isset( $items['name_r'] )){
													
								$timestamp = date( 'Y-m-d H:i:s' ) ;
								
								$moral= array();
								
								$name_r = explode( ',', $items['name_r'] );
								$lastname_r = explode( ',', $items['lastname_r'] );
								$office_phone = explode( ',', $items['office_phone'] );
								$office_ext = explode( ',', $items['office_ext'] );
								$mobile = explode( ',', $items['mobile'] );
								
								
								for( $i=0; $i<=count( $name_r ); $i++ )
										
										if( isset( $name_r[$i] ) )
										
										$moral[] = array(
											
											'user_id'  => $idSaved,
											'name'  => $person['name_r'][$i],
											'lastnames'  =>  $lastname_r['lastname_r'][$i],
											'office_phone'  => $office_phone['office_phone'][$i],
											'office_ext'  => $office_ext['office_ext'][$i],
											'mobile'  => $mobile['mobile'][$i],
											'last_updated' => $timestamp,
											'date' => $timestamp
											
										);
								
								
								
								if( $this->user->create_banch( 'representatives', $moral ) == false) $controlSaved = false ;
								
								if( $controlSaved == false ){
									
									$message[$lin][] = array( 'messagesavederroruserpersonmoral' => 'No se pudo guardar el registro, Representantes Morales, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador, linea de archivo: ' . $lin . $name );
									
								}
								
								
								
								
								if( in_array( 'agente', $group ) ){
									
									$timestamp = date( 'Y-m-d H:i:s' ) ;
					
									$agent= array(
										
										'user_id'  => $idSaved,
										'license_expired_date'  => $items['license_expired_date'],
										'last_updated' => $timestamp,
										'date' => $timestamp
										
										
									);
									
									if( isset( $items['connection_date'] ) )
									
										$agent['connection_date'] =$items['connection_date'];
									
									if( isset( $items['license_expired_date'] ) )
									
										$agent['license_expired_date'] =$items['license_expired_date'];	
									
									
									if( $this->user->create( 'agents', $agent ) == false) $controlSaved = false ;
									
									
									
									// Saved Agents
									if( $controlSaved == false ){
										
										$message[$lin][] = array( 'messagesavederroruserconexion' => 'No se pudo guardar el registro, Agente Proceso de conexión, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador, linea de archivo: ' . $lin . $name );
										
									}
									
									
									
									
									
									$idAgentSaved = $this->user->insert_id();
																								
									$uids_agens = array();
									
									$timestamp = date( 'Y-m-d H:i:s' ) ;
									
									// Added Clave
									$uids_agens[] = array(
										'agent_id' => $idAgentSaved,
										'type' =>  'clave',
										'last_updated' => $timestamp,
										'date' => $timestamp
									);
								
									if( isset(  $items['clave'] ) )
										
										$uids_agens['uid'] = $items['clave'];
										
										
									if( isset(  $item['folio_nacional'] ) )
										$folio_nacional = explode( ',', $item['folio_nacional'] );
									
									
									// added folio nacional
									if( isset( $folio_nacional ) and !empty( $folio_nacional ) and is_array( $folio_nacional ) )
										foreach( $folio_nacional as $value )
											$uids_agens[] = array(
												'agent_id' => $idAgentSaved,
												'type' =>  'national',
												'uid' =>  $value,
												'last_updated' => $timestamp,
												'date' => $timestamp
											);
									
									
									if( isset(  $item['folio_provincial'] ) )
										$folio_provincial = explode( ',', $item['folio_provincial'] );
									
									
									// Added folio provicional
									if( isset( $folio_provincial ) and !empty( $folio_provincial ) and is_array( $folio_provincial ) )
										foreach( $folio_provincial as $value )
											$uids_agens[] = array(
												'agent_id' => $idAgentSaved,
												'type' => 'provincial',
												'uid' =>  $value,
												'last_updated' => $timestamp,
												'date' => $timestamp
											);
									
									
									if( $this->user->create_banch( 'agent_uids', $uids_agens ) == false) $controlSaved = false ;
									
									
									if( $controlSaved == false ){
										
										$message[$lin][] = array( 'messagesavederroruserclaves' => 'No se pudo guardar el registro, Clave, Folio Nacional, Folio Provincial, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador, linea de archivo: ' . $lin . $name );
										
									}
									
								}
																								
																			
							}
							
							
							
						  unset( $name_r, $lastname_r, $office_phone, $office_ext, $mobile, $group, $folio_nacional, $folio_provincial ); // Free memory
													
						}
						
						
						$lin++;	
					}
																				
														
				}
				
				
				if( is_file( APPPATH.'modules/usuarios/assets/tmp/' . $tmp_file  ) )
					unlink( APPPATH.'modules/usuarios/assets/tmp/' . $tmp_file );
				
				
				// Save Record	
				if( $controlSaved == true ){
					
					
					// Set true message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se importo  el archivo correctamente'
									
					));												
					
					
					redirect( 'usuarios', 'refresh' );
					
					
					
				}
				
				
				
			}
			
									
		}
		
	
	
	
	
	
	
		// Config view
		$this->view = array(
				
		  'title' => 'Crear Importar',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',	
			  '<script src="'.base_url().'scripts/config.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/import.js"></script>'				
		  ),
		  'content' => 'usuarios/import', // View to load
		  'message' => $this->session->flashdata('message') // Return Message, true and false if have
				
		);
		
		
		if( isset( $message ) ){ $this->view['message'] = $message; unset( $tmp_file, $file_array ); }
		
		
		if( isset( $tmp_file ) and !empty( $tmp_file ) ) $this->view['tmp_file'] = $tmp_file;
		
		if( isset( $file_array ) and !empty( $file_array ) ) $this->view['file_array'] = $file_array;
		
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	
	}
	
	
	
	
	
	
	
	
	
	
// Export	
	public function exportar( $begin = 0 ){
		
		// Check access teh user for export
		if( $this->access_export == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Usuarios Exportar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
		
		}
				
		header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="proages_usuarios.csv"');
		
		
		// Load MOdel
		$this->load->model( 'user' );
				
		
		// Load Helper 
		$this->load->helper('usuarios/csv');
		
		
		
		// Find for name Current data
		if( isset( $_POST['find'] ) and !empty( $_POST['find']  ) )
			
			$this->data = $this->user->export_find( $this->input->post() );
		
		else // Export current pag
			
			$this->data = $this->user->export( $begin );
		
		
	 	array_to_csv($this->data, 'proages_usuarios.csv');
		
		if( is_file( 'proages_usuarios.csv' ) )
			echo file_get_contents( 'proages_usuarios.csv' );
		
		if( is_file( 'proages_usuarios.csv' ) )
			unlink( 'proages_usuarios.csv' );
				
		exit;
		
	}
	
	
	
// Update profile for user
	public function editar_perfil( $id = null ){
		
		
		if( empty( $id ) or $this->sessions['id'] != $id ){
			
							
		  // Set false message		
		  $this->session->set_flashdata( 'message', array( 
			  
			  'type' => false,	
			  'message' => 'No puedes editar tu perfil, Informe a su administrador para que le otorge los permisos necesarios.'
						  
		  ));	
		  
		  
		  redirect( 'home', 'refresh' );
			
						
		}	
		
		// Load Model
			$user = $this->user->getByIdToUpdate( $id );		
					
			
		
		if( !empty( $_POST ) ){
			
			
			
			// Generals for user what does not agent
			if( $user['username'] != $this->input->post( 'username' ) )
				$this->form_validation->set_rules('username', 'Usuario', 'is_unique[users.username]');
				
			
			if( !empty( $_POST['password'] ) and md5($_POST['passwordlast']) == $user['password'] )
				$this->form_validation->set_rules('password', 'Nuevo Password', 'matches[passwordnew]');
		
			if( $user['email'] != $this->input->post( 'email' ) )
				$this->form_validation->set_rules('email', 'Correo', 'valid_email|is_unique[users.email]');
			
			
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
				
				$usernew = array();
				
				if( !empty( $_POST['username'] ) )
					$usernew['username'] = $this->input->post('username');
				
				if( !empty( $_POST['password'] ) )
					$usernew['password'] = md5($this->input->post('password'));
				
				if( !empty( $_POST['email'] ) )
					$usernew['email'] = md5($this->input->post('email'));						
				
				// Uploaded a picture
				if( !empty( $_FILES['imagen']['name'] ) ){
						
						// Drop Last Image
						if( is_file( APPPATH.'modules/usuarios/assets/profiles/'.$user['picture'] ) and $user['picture'] != 'default.png' )
								unlink( APPPATH.'modules/usuarios/assets/profiles/'.$user['picture'] );
							
							
							
						$file = $_FILES['imagen']['name'];  
		 
						$file = strtr($file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
					
						// replace characters other than letters, numbers and . by _
						$file = preg_replace('/([^.a-z0-9]+)/i', '_', $file);
						
						  
					 
						if ( move_uploaded_file( $_FILES['imagen']['tmp_name'], APPPATH.'modules/usuarios/assets/profiles/'.$file ) ){
							$usernew['picture'] = $file;
						}
				}				
				
				
				if( $this->input->post( 'deleteimage' ) == 'true' ){
				
					// Drop Last Image
					if( is_file( APPPATH.'modules/usuarios/assets/profiles/'.$user['picture'] ) and $user['picture'] != 'default.png' )
							unlink( APPPATH.'modules/usuarios/assets/profiles/'.$user['picture'] );
					
					$usernew['picture'] = 'default.png';
				
			}
			
			
			if( $this->user->update( 'users', $id, $usernew ) == true ){
					
					// Set true message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se guardo el registro correctamente'
									
					));												
					
					
					redirect( 'home', 'refresh' );
					
					
			}else{
				
				// Set true message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se puede guardar los datos nuevos de tu perfil.'
									
					));												
					
					
					redirect( 'home', 'refresh' );
				
			} 
				
			}
			
						
		}
		
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Editar perfil',
		    // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/profile.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'usuarios/profile', // View to load
		  'message' => $this->session->flashdata('message') ,// Return Message, true and false if have
		  'data' => $user
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	}		
	
	
	
	
// Update record	
	public function update( $id = null ){
		
		
		// Check access teh user for delete
		if( $this->access_update == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Usuarios Editar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
		
		}
		
		
		
		
		$this->load->model( 'user' );
		$data = $this->user->getForUpdateOrDelete( $id );
		
		// Check Record if exist
		if( empty( $data ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No existe el registro. No puede editar este registro.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
			
		}
		
		
		
		
		if( !empty( $_POST ) ){
			
			
			
			
			// Generals for user what does not agent
			$this->form_validation->set_rules('group[]', 'Grupo', 'required');
			$this->form_validation->set_rules('persona', 'Persona', 'required');
			
			
			if( $data[0]['username'] != $this->input->post('username') )
				$this->form_validation->set_rules('username', 'Usuario', 'required|is_unique[users.username]');
			
			if( $data[0]['email'] != $this->input->post('email') )
				$this->form_validation->set_rules('email', 'Correo', 'required|valid_email|is_unique[users.email]');
			
			
			if( $this->input->post('persona') == 'fisica' ){
				$this->form_validation->set_rules('lastname', 'Apellido', 'required');
				//$this->form_validation->set_rules('birthdate', 'Fecha de cumpleaños', 'required');
			}
			
						
			// User Agent Validations
			if( in_array( 1, $this->input->post('group') ) ){
				
				// General for Agents
				//$this->form_validation->set_rules('manager_id', 'Gerente', 'required');
				
				// If process of conexion == 1 or yes
				if( $this->input->post( 'type' ) == 'Si' ){
					
					// SET validation fields
					//$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					//$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia', 'required');
				}else{ // Else conexion == 2 or not
					
					// SET validation fields
					//$this->form_validation->set_rules('clave', 'Clave', 'required|is_unique[agent_uids.uid]');
					//$this->form_validation->set_rules('folio_nacional[]', 'Folio Nacional', 'required|is_unique[agent_uids.uid]');
					//$this->form_validation->set_rules('folio_provincial[]', 'Folio Provicional', 'required|is_unique[agent_uids.uid]');
					//$this->form_validation->set_rules('connection_date', 'Fecha de conexión', 'required');
					//$this->form_validation->set_rules('license_expired_date', 'Expiración de licencia', 'required');
					
				}
				
			
			}
			
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
					
				
				
				
				$controlSaved = true;
				
				$timestamp = date( 'Y-m-d H:i:s' ) ;
												
				
				// Save User Table							
				$user = array(
					'office_id'  => 0,
					'manager_id' => 0,
					'company_name'  => $this->input->post( 'company_name' ),
					'username'  => $this->input->post( 'username' ),			
					'name'  => $this->input->post( 'name' ),
					'lastnames'  => $this->input->post( 'lastname' ),
					'birthdate'  => $this->input->post( 'birthdate' ),					
					'email'  => $this->input->post( 'email' ),
					'last_updated' => $timestamp,
				);
								
				// Add Manager if is an agent
				if( in_array( 1, $this->input->post('group') ) ) $user['manager_id'] = $this->input->post( 'manager_id' );  
				
				if( $this->input->post( 'disabled' ) == 'Si' ) $user['disabled']  = 1; else $user['disabled'] = 0;
				
				// Uploaded a picture
				if( !empty( $_FILES['imagen']['name'] ) ){
			
						$file = $_FILES['imagen']['name'];  
		 
						$file = strtr($file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
					
						// replace characters other than letters, numbers and . by _
						$file = preg_replace('/([^.a-z0-9]+)/i', '_', $file);
						
					 
						if ( move_uploaded_file( $_FILES['imagen']['tmp_name'], APPPATH.'modules/usuarios/assets/profiles/'.$file ) ){
							$user['picture'] = $file;
						}else{
							$user['picture'] = "default.png";
						};
												
						if( $data[0]['picture'] != $file and is_file( APPPATH.'modules/usuarios/assets/profiles/'.$data[0]['picture'] ) )
							unlink( APPPATH.'modules/usuarios/assets/profiles/'.$data[0]['picture'] );
						
					
				}else{
					$user['picture'] = $data[0]['picture'];
				}
				
				
				
				if( !empty( $_POST['password'] ) )
					$user['password']  = md5($this->input->post( 'password' ) );		
				
				
				
				
							
								
				if( $this->user->update( 'users', $id, $user ) == false) $controlSaved = false ;
				
				if( $controlSaved == false ){
						
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se pudo guardar el registro, Usuario, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
									
					));												
					
					
					redirect( 'usuarios/update/'.$id, 'refresh' );
					
				}
				
				
				
				
				
				// Added User roles groups
				$user_roles = array();				
				
				
				if( !empty( $_POST['group'] ) ){
					
					$this->user->delete( 'users_vs_user_roles', 'user_id',  $data[0]['id'] );
					
					
					foreach( $this->input->post( 'group' ) as $group )
						$user_roles[] = array( 'user_id' => $id , 'user_role_id' => $group );
				
					if( $this->user->create_banch( 'users_vs_user_roles', $user_roles ) == false) $controlSaved = false ;
					
					
					if( $controlSaved == false ){
							
							// Set false message		
							$this->session->set_flashdata( 'message', array( 
								
								'type' => false,	
								'message' => 'No se pudo guardar el registro, Asignación de rol, ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
											
							));												
							
							
							redirect( 'usuarios/update/'.$id, 'refresh' );
							
					}
				
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
					
					
					$this->user->delete( 'representatives', 'user_id',  $data[0]['id'] );
					
					
					$moral= array();
					
					for( $i=0; $i<=count( $_POST['name_r'] ); $i++ )
							
							if( isset( $_POST['name_r'][$i] ) )
							$moral[] = array(
								
								'user_id'  => $id,
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
						
						
						redirect( 'usuarios/update/'.$id, 'refresh' );
						
					}
																
				}
				
				
				
				
				
				
					
				
				if( in_array( 1, $this->input->post('group') ) ){
					
					
					$this->user->delete( 'agents', 'user_id',  $data[0]['id'] );
					
					$agent= array(
						
						'user_id'  => $id,
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
						
						
						redirect( 'usuarios/update/'.$id, 'refresh' );
						
					}
					
					
					$idAgentSaved = $this->user->insert_id();
					
																			
					$uids_agens = array();
				
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
					
					
					$this->user->delete( 'agent_uids', 'agent_id',  $data['agents'][0]['id'] );
					
					if( $this->user->create_banch( 'agent_uids', $uids_agens ) == false) $controlSaved = false ;
					
										
					if( $controlSaved == false ){
						
						// Set false message		
						$this->session->set_flashdata( 'message', array( 
							
							'type' => false,	
							'message' => 'No se pudo guardar el registro, Folio provicional, Folio Nacional, Clave ocurrio un error en la base de datos. Pongase en contacto con el desarrollador'
										
						));												
						
						
						redirect( 'usuarios/update/'.$id, 'refresh' );
						
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
		
		
		
		
		
		
		
		
		
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Editar Usuario',
		    // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/update.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'usuarios/update', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
			
			
		 //Selects	
		  'group' => $this->rol->checkbox(),
		  'gerentes' => $this->user->getSelectsGerentes(),
		  
		  'data' => $data			
		); 
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
				
	}
	
	
	
	
	
	
	
	// Delete Users
	public function delete( $id = null ){
		
		
		// Check access teh user for delete
		if( $this->access_delete == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Usuarios Eliminar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
		
		}
		
		
		// Load Model
		$this->load->model( 'user' );
		$user = $this->user->getForUpdateOrDelete( $id );
		
		// Check Record if exist
		if( empty( $user ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No existe el registro. No puede eliminar este registro.'
							
			));	
			
			
			redirect( 'usuarios', 'refresh' );
			
		}
		
		
		if( !empty( $_POST ) and isset( $_POST['delete'] ) and $_POST['delete'] == true ){
			
			$deleteControl = true;
			
			
			
			
			// Drop Image
			if( is_file( APPPATH.'modules/usuarios/assets/profiles/'.$user[0]['picture'] ) and $user[0]['picture'] != 'default.png' )
					unlink( APPPATH.'modules/usuarios/assets/profiles/'.$user[0]['picture'] );
					
			
			
			
			// Delete from users
			if( isset( $user[0]['id'] ) )
				if( $this->user->delete( 'users', 'id',  $user[0]['id'] ) == false )  $deleteControl = false;
				
		   
		   	
			
			
			if( $deleteControl == false ){
				
				// Set false message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => false,	
					'message' => 'No se puede borrar el registro. Usuarios. Informe a su administrador para que le otorge los permisos necesarios.'
								
				));	
				
				
				//redirect( 'usuarios', 'refresh' );
				
				
			}
			
			
			// Delete from users_vs_user_roles
			if( isset( $user[0]['id'] ) )
				if( $this->user->delete( 'users_vs_user_roles', 'user_id',  $user[0]['id'] ) == false )  $deleteControl = false;				
			
			if( $deleteControl == false ){
				
				// Set false message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => false,	
					'message' => 'No se puede borrar el registro. Usuarios Roles. Informe a su administrador para que le otorge los permisos necesarios.'
								
				));	
				
				
				//redirect( 'usuarios', 'refresh' );
				
				
			}
			
			
					
			
			
			
			// Delete From Agents
			if( isset( $user['agents'] ) and !empty( $user['agents'] ) )
				if( $this->user->delete( 'agents', 'user_id',  $user[0]['id'] ) == false )  $deleteControl = false;
			
			if( $deleteControl == false ){
				
				// Set false message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => false,	
					'message' => 'No se puede borrar el registro. Usuarios - Agente. Informe a su administrador para que le otorge los permisos necesarios.'
								
				));	
				
				
				redirect( 'usuarios', 'refresh' );
				
				
			}
			
			
			
			// Delete From agent_uids
			if( isset( $user['agents'][0] ) and !empty( $user['agents'][0] ) )
				if( $this->user->delete( 'agent_uids', 'agent_id',  $user['agents'][0]['id'] ) == false )  $deleteControl = false;
			
			
			if( $deleteControl == false ){
				
				// Set false message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => false,	
					'message' => 'No se puede borrar el registro. Usuarios - Agente UIDS. Informe a su administrador para que le otorge los permisos necesarios.'
								
				));	
				
				
				redirect( 'usuarios', 'refresh' );
				
				
			}
			
			
			// Delete From representatives
			if( isset( $user['representatives'] ) and !empty( $user['representatives'] ) )
				if( $this->user->delete( 'representatives', 'user_id',  $user[0]['id'] ) == false )  $deleteControl = false;
			
			
			if( $deleteControl == false ){
				
				// Set false message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => false,	
					'message' => 'No se puede borrar el registro. Usuarios - Agente Representantes. Informe a su administrador para que le otorge los permisos necesarios.'
								
				));	
				
				
				redirect( 'usuarios', 'refresh' );
				
				
			}	
			
			
			if( $deleteControl == true ){
				
				// Set false message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => true,	
					'message' => 'El registro se elimino correctamente.'
								
				));	
				
				
				redirect( 'usuarios', 'refresh' );
				
				
			}	
			
		}
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Editar perfil',
		    // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/delete.js"></script>',		
			  	
		  ),
		  'content' => 'usuarios/delete', // View to load
		  'message' => $this->session->flashdata('message') ,// Return Message, true and false if have
		  'data' => $user
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */
}
?>