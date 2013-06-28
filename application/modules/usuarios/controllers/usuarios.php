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
	
	public $sessions = '';
	
	public $data = array();
	
	public $view = array();
	
/** Construct Function **/
/** Setting Load perms **/
	
	public function __construct(){
			
		parent::__construct();
		
				
		/** Getting Info User **/
		
		$this->load->model( 'users' );
				
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
					
					redirect( 'proages', 'refresh' );
					
					
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
		
		
		redirect( 'usuaros/login', 'refresh' );
	
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
		  'scripts' =>  array(),
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
			
			
			// Load model
			$this->load->model( 'rol' );
			
			
			// Validations
			$this->form_validation->set_rules('name', 'Nombre de Rol', 'required');
			
			
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
					
					
				// Save Record	
				if( $this->rol->create( $this->input->post() ) == true ){
					
					
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
		
		
		// Load Model Dependencies
		$this->load->model( 
						array( 
							'direccion_comercial/comercial',
							'agencia/agencias' 
						 ) 
		);
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Crear Usuario',
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="'.base_url().'usuarios/assets/scripts/usuarios.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'				
		  ),
		  'content' => 'usuarios/create', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
			
			
		  //Selects	
		  'direccion_comercial' => $this->comercial->getSelect(),
		  'agencias' => $this->agencias->getSelect()			
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
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