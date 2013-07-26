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
class Ot extends CI_Controller {

	
	public $view = array();
	
	public $sessions = array();
	
	public $user_vs_rol = array();
	
	public $roles_vs_access = array();
	
	public $access = false; // Force security
	
	public $access_create = false;
	
	public $access_update = false;
	
	public $access_delete = false;
	
	public $access_activate = false;
	//public $access_create_policy = false;
	
	
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
		if( !empty( $this->user_vs_rol ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Usuarios', $value ) ):

			$this->access = true;
			
		break; endif; endforeach;
		
		
		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Usuarios', $value ) ):
			
			
			if( $value['action_name'] == 'Crear' )
				$this->access_create = true;
						
			if( $value['action_name'] == 'Editar' )
				$this->access_update = true;
				
			if( $value['action_name'] == 'Eliminar' )
				$this->access_delete = true;	
			
			if( $value['action_name'] = 'Activar/Desactivar' )
				$this->access_activate = true;
						
		endif; endforeach;
							
								
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
			
	}
	
	
	
	
	

// Show all records	
	public function index(){
		
		
		
		// Load Model
		$this->load->model( 'work_order' );
		
		// Load Helpers
		$this->load->helper( 'date' );
		
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
		$config['base_url'] = base_url().'ot/index/';
		$config['total_rows'] = $this->work_order->record_count();
		$config['per_page'] = 50;
		$config['num_links'] = 5;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config); 
		
		$data = $this->work_order->overview( $begin );
		
		$scrips = '';
		
		if( !empty( $data ) )
			
			foreach( $data as $value ){
				
				$scrips .= '<script type="text/javascript">
								$("#'.$value['id'].'").popover({
										title: "Opciones",
										trigger:"click",
										placement:"bottom",
										html:true, 
										content: function(){
											
											var content = "Escoja una opción<br>";';
										
												if( $this->access_activate == true )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'activate-'.$value['id'].'\')\">Activar/Desactivar</a><br>";';
												
												if( $this->access_update == true )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'update-'.$value['id'].'\')\">Editar</a><br>";';
												if( $this->access_delete == true )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'delete-'.$value['id'].'\')\">Eliminar</a>";
												
											return content;
										}
								});
							 </script>';
				
			}
						 
		// Config view
		$this->view = array(
				
		  'title' => 'Orden de trabajo',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'scripts' => array(
		  	
			'<script src="'.base_url().'scripts/config.js"></script>',
			'<script src="'.base_url().'ot/assets/scripts/overview.js"></script>',		
			$scrips
		  ),
		  'content' => 'ot/list', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $data
		  		
		);
				
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
	
// Getting Filter
	public function find(){
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		// Load Model
		$this->load->model( 'work_order' );
		
		// Load Helper
		$this->load->helper( array( 'ot', 'date' ) );
		
		$data = $this->work_order->find( $this->input->post( 'work_order_status_id' ) );
		
				
		echo renderTable( $data );	
		
	}	
	
	
	public function find_scripts(){
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		// Load Model
		$this->load->model( 'work_order' );
		
		$data = $this->work_order->find( $this->input->post( 'work_order_status_id' ) );
		
		$scrips = '';
		
		if( !empty( $data ) )
			
			foreach( $data as $value ){
				
				$scrips .= '
								$("#'.$value['id'].'").popover({
										title: "Opciones",
										trigger:"click",
										placement:"bottom",
										html:true, 
										content: function(){
											
											var content = "Escoja una opción<br>";';
										
												if( $this->access_activate == true )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'activate-'.$value['id'].'\')\">Activar/Desactivar</a><br>";';
												
												if( $this->access_update == true )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'update-'.$value['id'].'\')\">Editar</a><br>";';
												if( $this->access_delete == true )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'delete-'.$value['id'].'\')\">Eliminar</a>";
												
											return content;
										}
								});
							 ';
				
			}
		
		echo $scrips;	
	}
	
	
	
	
	
	
	
	

// Create new role
	public function create(){
		
		
		
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Crear", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		}
		
		
		
		
		
		
		
		if( !empty( $_POST ) ){
			
			
			
			$this->form_validation->set_rules('ramo', 'Ramo', 'required');
			$this->form_validation->set_rules('work_order_type_id', 'Tipo de tramite', 'required');
			$this->form_validation->set_rules('subtype', 'Sub tipo', 'required');
			$this->form_validation->set_rules('comments', 'Comentarios', 'required');
			
			
						
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
				
				// Load Model
				$this->load->model( 'work_order' );
				
				$ot = array(
					
					'policy_id' => 0,
					'product_group_id' => $this->input->post( 'ramo' ),
					'work_order_type_id' => $this->input->post( 'subtype' ),
					'work_order_status_id' => 5,
					'work_order_responsible_id' => 0,
					'uid' => 0,
					'creation_date' => $this->input->post('creation_date'),
					'comments' => $this->input->post('comments'),
					'duration' => '',
					'last_updated' => date( 'Y-m-d H:s:i' ),
					'date' => date( 'Y-m-d H:s:i' )
					
				);	
				
				if( !empty( $_POST['policy_id'] ) )
					 $_POST['policy_id'] =  $this->input->post( 'policy_id' );
				
				
				if( $this->work_order->create( 'work_order', $ot ) == true ){
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se ha creado el registro correctamente.'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}else{
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'El registro no puede ser creado, consulte a su administrador..'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}
									 
			}	
			
				
				exit;		
		}
		
				
		// Config view
		$this->view = array(
				
		  'title' => 'Crear OT',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'ot/assets/scripts/create.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'ot/create', // View to load
		  'message' => $this->session->flashdata('message') // Return Message, true and false if have
			
	
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	}
	
	
	
	
	
	
	
	
	
	
	// Getting type tramite
	public function typetramite(){
		
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		// Load Model
		$this->load->model( 'work_order' );	
		
		$options = $this->work_order->getTypeTramite( $this->input->post( 'ramo' ) );
		
		echo $options;
		
		
		return;
	}
	
	
	
	// Getting sub type
	public function subtype(){
		
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		// Load Model
		$this->load->model( 'work_order' );	
		
		$options = $this->work_order->getSubType( $this->input->post( 'type' ) );
		
		echo $options;
		
		
		return;
	}
	
	
/**
 *	Condig Policies
 **/	
	public function policies(){
		
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		// Load Model
		$this->load->model( 'work_order' );	
		
		$options = $this->work_order->getPolicies( $this->input->post( 'ramo' ) );
		//print_r($_POST);
		echo $options;
		
		
		return;
	}
	
	
	
/**
 *	Create policies
 **/
	
	public function create_policy(){
		
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Crear Politica.", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		}
		
		
		
		// Load model
		$this->load->model( array( 'work_order', 'user' ) );
		
		
		
		// Save the record
		if( !empty( $_POST ) ){
			
						
			
						
			// Validations
			$this->form_validation->set_rules('ramo', 'Ramo', 'required|xxs_clean');
			$this->form_validation->set_rules('product_id', 'Producto', 'required|xxs_clean');
			$this->form_validation->set_rules('currency_id', 'Moneda', 'required|xxs_clean');
			$this->form_validation->set_rules('payment_interval_id', 'Conducto', 'required|xxs_clean');
			$this->form_validation->set_rules('payment_method_id', 'Forma de pago', 'required|xxs_clean');
			$this->form_validation->set_rules('name', 'Nombre', 'required|xxs_clean');
			$this->form_validation->set_rules('lastname_father', 'Apellido paterno', 'required|xxs_clean');
			$this->form_validation->set_rules('lastname_mother', 'Apellido materno', 'required|xxs_clean');
			//$this->form_validation->set_rules('agent[]', 'Agente', 'required|xxs_clean');
			//$this->form_validation->set_rules('porcentaje[]', 'Porcentaje', 'required|xxs_clean');

			
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
				
				  $controlSave = true;
				
				  $policy = array(
				  	
					'product_id' => $this->input->post( 'product_id' ),
					'currency_id' => $this->input->post( 'currency_id' ),
					'payment_interval_id' => $this->input->post( 'payment_interval_id' ),
					'payment_method_id' => $this->input->post( 'payment_method_id' ),
					'uid' => $this->input->post( 'uid' ),
					'name' => $this->input->post( 'name' ),
					'lastname_father' => $this->input->post( 'lastname_father' ),
					'lastname_mother' => $this->input->post( 'lastname_mother' ),
					'year_premium' => $this->input->post( 'year_premium' ),
					'expired_date' => $this->input->post( 'expired_date' ),
					'last_updated' => date( 'Y-m-d H:i:s' ),
					'date' => date( 'Y-m-d H:i:s' )
					
				  );
				  
				  if( $this->work_order->create( 'policies', $policy ) == false )
				  	 
					 $controlSave = false;
				  
				  
				  
				  $policyId = $this->work_order->insert_id();
				  
				  // Agents Adds
				  $agents = array();
			
				  for( $i=0; $i<=count( $this->input->post('agent') ); $i++ )
					  
					  if( !empty(  $_POST['agent'][$i] ) )
					 
						  $agents[] = array( 
								
								'user_id' => $_POST['agent'][$i], 
								'policy_id' => $policyId,
								'percentage' => $_POST['porcentaje'][$i],
								'since' => date( 'Y-m-d H:i:s' )
							
						  );

				
				 if( $this->work_order->create_banch( 'policies_vs_users', $agents ) == false );
				  	
					$controlSave = false;
				  
				
				 if( $controlSave == true ){ 
					 
					  // Set true message		
					  $this->session->set_flashdata( 'message', array( 
						  
						  'type' => true,	
						  'message' => 'Se agrego la nueva politica.'
									  
					  ));												
					  
					  
					  redirect( 'ot/create', 'refresh' );
				  
				 }else{
					
					// Set true message		
					  $this->session->set_flashdata( 'message', array( 
						  
						  'type' => false,	
						  'message' => 'Ocurrio un error no se puede guardar la nueva politica, consulte a su administrador.'
									  
					  ));												
					  
					  
					  redirect( 'ot/create', 'refresh' );
				 }
				 
			}
			
			
			
			exit;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// Get products
		$product = $this->work_order->getProductsOptions();
		
		
		//Get Currency
		$currency = $this->work_order->getCurrencyOptions();
		
		// Get Payments
		$payments_methods = $this->work_order->getPaymentMethodsOptions();		
		
		// Get Conduct
		$payment_conduct = $this->work_order->getPaymentMethodsConductoOptions();
		
		// Get Agents
		$agents = $this->user->getAgents();
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Crear Politica',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'ot/assets/scripts/create_polocy.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'ot/create_policy', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  
		  
		  'product' => $product,
		  'currency' => $currency,
		  'payments_methods' => $payments_methods,
		  'payment_conduct' => $payment_conduct,
		  'agents' => $agents
	
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
	
	// Get Options for a new select
	public function getSelectAgents(){
		
		if( !$this->input->is_ajax_request() ){ echo 'Access denied'; exit; }
		
		
		
		// Load model
		$this->load->model( 'user' );
		
		// Get Agents
		$agents = $this->user->getAgents();
		
		echo $agents;
	}
	
	
	
	
	
	
	// Load Products by Produc Group
	public function getPolicyByGroup(){
		
		
		if( !$this->input->is_ajax_request() ){ echo 'Access denied'; exit; }
		
		
		// Load model
		$this->load->model( 'work_order' );
		
		$product = $this->work_order->getProductsOptions( $this->input->post( 'product_group' ) );
		
		
		echo $product;
		
		exit;
	}
	
	
	
	
	
	
	
	/**
	 *	Activate/Desactivate
	 **/
	public function activate( $ot = null ){
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Crear Politica.", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		}
		
		// Load Model 
		$this->load->model( 'work_order' );
		
		
		
		
		// Save Record
		if( !empty( $_POST ) ){
			
			
			$work_order = array(
				
				'work_order_status_id' => $this->input->post( 'work_order_status_id' ),
				'work_order_reason_id' => $this->input->post( 'work_order_reason_id' ),
				'work_order_responsible_id' => $this->input->post( 'work_order_responsible_id' ),
				'comments' => $this->input->post( 'comments' ),
				'last_updated' => date( 'd-m-Y H:i:s' )
			);
			
			if( $this->input->post( 'work_order_status_id' ) == 1 )
				
				$work_order['creation_date'] = $this->input->post( 'creation_date' );
			
			
			
			if( $this->work_order->update( 'work_order', $ot, $work_order ) == true ){
				
				// Set true message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => true,	
					'message' => 'Se ha guardado el registro correctamente.'
								
				));												
				
				
				redirect( 'ot', 'refresh' );
				
			}else{
				
				
				// Set true message		
				$this->session->set_flashdata( 'message', array( 
					
					'type' => false,	
					'message' => 'Ocurrio un error el registro no puede ser guardado, consulte a su administrador.'
								
				));												
				
				
				redirect( 'ot', 'refresh' );
				
			}
			exit;
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		$data = $this->work_order->getOtActivateDesactivate( $ot );
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Activar / Desactivar',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'ot/assets/scripts/activate_desactivate.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'ot/activate_desactivate', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  
		  'ot' => $ot,
		  
		  'status' => $this->work_order->getStatus( $data[0]['work_order_status_id'] ),		  
		  'reason' => $this->work_order->getReason( $data[0]['work_order_reason_id'] ),
		  
		  'responsibles' => $this->work_order->getResponsibles(  $data[0]['work_order_responsible_id'] ),
		  'data' => $data
		  
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
		
	}
	
	
	

// update work order
	public function update( $ot = null ){
		
		
		
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Crear", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		}
		
		if( empty( $ot ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No existe esta orden de trabajo..'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
			
		}
		
		
		// Load Model
		$this->load->model( 'work_order' );
		
		
		
		if( !empty( $_POST ) ){
			
			
			
			$this->form_validation->set_rules('ramo', 'Ramo', 'required');
			$this->form_validation->set_rules('work_order_type_id', 'Tipo de tramite', 'required');
			$this->form_validation->set_rules('subtype', 'Sub tipo', 'required');
			$this->form_validation->set_rules('comments', 'Comentarios', 'required');
			
			
						
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
				
				
				
				$otupdate = array(
					
					'policy_id' => $this->input->post( 'policy_id' ),
					'product_group_id' => $this->input->post( 'ramo' ),
					'work_order_type_id' => $this->input->post( 'subtype' ),
					'creation_date' => $this->input->post('creation_date'),
					'comments' => $this->input->post('comments'),
					'duration' => '',
					'last_updated' => date( 'Y-m-d H:s:i' )
					
				);	
				
				if( $this->work_order->update( 'work_order', $ot, $otupdate ) == true ){
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se ha guardado el registro correctamente.'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}else{
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'El registro no puede ser modificado, consulte a su administrador..'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}
									 
			}	
			
				
				exit;		
		}
		
		
		
		$data = $this->work_order->getById( $ot );
		
				
		// Config view
		$this->view = array(
				
		  'title' => 'Modificar OT',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'ot/assets/scripts/update.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'ot/update', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $data	
	
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	}


// delete work order
	public function delete( $ot = null ){
		
		
		
		
		// Check access teh user for create
		if( $this->access_delete == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Crear", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		}
		
		if( empty( $ot ) ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No existe esta orden de trabajo..'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
			
		}
		
		
		// Load Model
		$this->load->model( 'work_order' );
		
		
		
		if( !empty( $_POST ) ){
							
				
				$otupdate = array(
					
					'work_order_status_id' => 2,
					'last_updated' => date( 'Y-m-d H:s:i' )
					
				);	
				
				if( $this->work_order->update( 'work_order', $ot, $otupdate ) == true ){
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se ha guardado el registro correctamente.'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}else{
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'El registro no puede ser modificado, consulte a su administrador..'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}
									 
			exit;	
		}
		
		
		
		$data = $this->work_order->getById( $ot );
		
				
		// Config view
		$this->view = array(
				
		  'title' => 'Cancelar OT',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			  '<script src="'.base_url().'ot/assets/scripts/delete.js"></script>',		
			  '<script src="'.base_url().'scripts/config.js"></script>'
			  	
		  ),
		  'content' => 'ot/delete', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $data	
	
		);
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	
	}	
	
	
	
	
	
	
	
	
	
	
/* End of file ot.php */
/* Location: ./application/controllers/ot.php */
}
?>