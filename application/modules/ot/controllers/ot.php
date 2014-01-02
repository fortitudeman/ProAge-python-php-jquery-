<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

  Authors		Ulises Rodríguez
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
	
	public $access_all = false;
	
	public $access_export_xls = false; // Import payments
	
	public $access_import_payments = false; // Import payments
	
	public $access_report = false; // View report
	
	
	
	
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
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Orden de trabajo', $value ) ):

			$this->access = true;
			
		break; endif; endforeach;
		
		
		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Orden de trabajo', $value ) ):
			
			
			if( $value['action_name'] == 'Crear' )
				$this->access_create = true;
						
			if( $value['action_name'] == 'Editar' )
				$this->access_update = true;
				
			if( $value['action_name'] == 'Eliminar' )
				$this->access_delete = true;	
			
			if( $value['action_name'] = 'Activar/Desactivar' )
				$this->access_activate = true;
			
			if( $value['action_name'] ='Ver todos los registros' )
				$this->access_all = true;
			
			if( $value['action_name'] ='Importar payments' )
				$this->access_import_payments = true;	
			
			if( $value['action_name'] ='Ver reporte' )
				$this->access_report = true;		
						
			if( $value['action_name'] ='Export xls' )
				$this->access_export_xls = true;		
			
			
						
		endif; endforeach;
					
								
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
					
	}
	
	
	
	
	

// Show all records	
	public function index(){
		
		
		
		// Load Model
		$this->load->model( array( 'work_order', 'user' ) );
		
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
		
		if( $this->access_all == false )
			$config['total_rows'] = $this->work_order->record_count( $this->access_all );
		else
			$config['total_rows'] = $this->work_order->record_count();
		
		$config['per_page'] = 50;
		$config['num_links'] = 5;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		
		$this->pagination->initialize($config); 
		
		
		if( $this->access_all == false )
		
			$data = $this->work_order->overview( $begin, $this->sessions['id'] );
		
		else
			
			$data = $this->work_order->overview( $begin );
		
		
		
		$scrips = '';
								 
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
		  'access_all' => $this->access_all,
		  'scripts' => array(
		  	
			'<script src="'.base_url().'scripts/config.js"></script>',
			'<script src="'.base_url().'ot/assets/scripts/overview.js"></script>',		
			$scrips
		  ),
		  'content' => 'ot/list', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $data,
		  'agents' => $this->user->getAgents(),
		  'gerentes' => $this->user->getSelectsGerentes()			 
		  		
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
		
									
		if( $this->access_all == false )
			$data = $this->work_order->find( $this->input->post(), $this->sessions['id'] );
		
		else
			$data = $this->work_order->find( $this->input->post() );
				
		echo renderTable( $data, $this->access_activate, $this->access_update, $this->access_delete );	
		
	}	
	
	
	public function find_scripts(){
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		
		echo " $( '.popup' ).hide(); $( '.btn-hide' ).bind( 'click', function(){ $( '.popup' ).hide(); });  ";exit;
		
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
			$this->form_validation->set_rules('ot', 'Número de OT', 'is_unique[work_order.uid]');
			$this->form_validation->set_rules('work_order_type_id', 'Tipo de tramite', 'required');
			$this->form_validation->set_rules('subtype', 'Sub tipo', 'required');
			
			
			
			// IF IS A NEW BUSSINESS
			if( $this->input->post( 'work_order_type_id' ) == '90' or $this->input->post( 'work_order_type_id' ) == '47' ){
				
				// Validations
				$this->form_validation->set_rules('product_id', 'Producto', 'required|xxs_clean');
				$this->form_validation->set_rules('currency_id', 'Moneda', 'required|xxs_clean');
				$this->form_validation->set_rules('payment_interval_id', 'Conducto', 'required|xxs_clean');
				$this->form_validation->set_rules('payment_method_id', 'Forma de pago', 'required|xxs_clean');
				$this->form_validation->set_rules('name', 'Nombre', 'required|xxs_clean');
				//$this->form_validation->set_rules('lastname_father', 'Apellido paterno', 'required|xxs_clean');
				//$this->form_validation->set_rules('lastname_mother', 'Apellido materno', 'required|xxs_clean');
				
			}
			
			
			
			
			
			
					
			// Run Validation
			if ( $this->form_validation->run() == TRUE ){
				
				
				// Load Model
				$this->load->model( 'work_order' );
				
				$controlSaved = true;
				
				$policyId = 0;
				
				// Save new bussiness
				//if( $this->input->post( 'work_order_type_id' ) == '90' or $this->input->post( 'work_order_type_id' ) == '47' ){
						
					
				if( !empty( $_POST['product_id'] ) ){
					
					$policy = array(
					
						'product_id' => $this->input->post( 'product_id' ),
						'period' => $this->input->post( 'period' ),
						'currency_id' => $this->input->post( 'currency_id' ),
						'payment_interval_id' => $this->input->post( 'payment_interval_id' ),
						'payment_method_id' => $this->input->post( 'payment_method_id' ),
						'prima' => $this->input->post( 'prima' ),
						'uid' => $this->input->post( 'uid' ),
						'name' => $this->input->post( 'name' ),
						'lastname_father' => $this->input->post( 'lastname_father' ),
						'lastname_mother' => $this->input->post( 'lastname_mother' ),
						'year_premium' => $this->input->post( 'year_premium' ),
						'expired_date' => $this->input->post( 'expired_date' ),
						'last_updated' => date( 'Y-m-d H:i:s' ),
						'date' => date( 'Y-m-d H:i:s' )
						
					  );
					  
				}else{
					$policy = array(
						'name' => $this->input->post( 'name' ),
						'uid' => $this->input->post( 'uid' ),
						'last_updated' => date( 'Y-m-d H:i:s' ),
						'date' => date( 'Y-m-d H:i:s' )
					);
				}
				
				  
				if( $this->work_order->create( 'policies', $policy ) == false )
				   
				   $controlSaved = false;
									  
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
			  
			  
			  
			  
			   if( $this->work_order->create_banch( 'policies_vs_users', $agents ) == false )
				  
				  $controlSaved = false;	
						
				//}
				
				
				
				if( $controlSaved == false ){
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se puede crear la orden de trabajo Poliza, consulte a su administrador.'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}
				
				
				
				
				
				
				
				
				
				$ot = array(
					'user' => $this->sessions['id'],
					'policy_id' => $policyId,
					'product_group_id' => $this->input->post( 'ramo' ),
					'work_order_type_id' => $this->input->post( 'subtype' ),
					'work_order_status_id' => 5,
					'work_order_responsible_id' => 0,
					'uid' => $this->input->post( 'ot' ),
					'creation_date' => $this->input->post('creation_date'),
					'comments' => $this->input->post('comments'),
					'duration' => '',
					'last_updated' => date( 'Y-m-d H:s:i' ),
					'date' => date( 'Y-m-d H:s:i' )
					
				);	
							
				// Save OT
				if( $this->work_order->create( 'work_order', $ot ) == false )
					
					 $controlSaved = false;
				
				
				if( $controlSaved == false ){
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => false,	
						'message' => 'No se puede crear la orden de trabajo, consulte a su administrador.'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}
				
				
				
				
				// Send Email		
				$this->load->library( 'mailer' );
				
				$notification = $this->work_order->getNotification();
						
				$this->mailer->notifications( $notification );
				
				
								
				if( $controlSaved == true ){
					
					// Set false message		
					$this->session->set_flashdata( 'message', array( 
						
						'type' => true,	
						'message' => 'Se ha creado el registro correctamente.'
									
					));	
					
					
					redirect( 'ot', 'refresh' );
					
				}
				 
			}	
						
		}
		
		
		// Load Model
		$this->load->model( 'work_order' );
		
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
	
	public function period(){
		
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		// Load Model
		$this->load->model( 'work_order' );	
		
		$options = $this->work_order->getPeriod( $this->input->post( 'id' ) );
		//print_r($_POST);
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
		
		exit;
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
	 *	set Pay
	 **/
	
	public function setPay(){
		
		if( !$this->input->is_ajax_request() ){ echo 'Access denied'; exit; }
		
		// Load Model 
		$this->load->model( 'work_order' );
		
		$work_order = array(				
				'work_order_status_id' => 4
		);
		
		$this->work_order->update( 'work_order', $this->input->post( 'id' ), $work_order );
		
		echo 'Ot Marcada como pagada correctamente';
		
		exit;
	}
	
	
	
	
	/**
	 *	Activate/Desactivate
	 **/
	public function activar( $ot = null ){
		
		
		
		// Check access teh user for create
		if( $this->access_activate == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Activar.", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		}
		
		// Load Model 
		$this->load->model( 'work_order' );
		
		
		
		
		// Save Record
		if( !empty( $_POST ) ){
			
			
					
			
			$work_order = array(
				
				'work_order_status_id' => 6,
				'work_order_reason_id' => $this->input->post( 'work_order_reason_id' ),
				'work_order_responsible_id' => $this->input->post( 'work_order_responsible_id' ),
				'creation_date' => '0000-00-00 00:00:00', // Quitar el tiempo
				'comments' => $this->input->post( 'comments' ),
				'last_updated' => date( 'd-m-Y H:i:s' )
			);
			
					
			if( $this->work_order->update( 'work_order', $ot, $work_order ) == true ){
												
				
			// Send Email		
			$this->load->library( 'mailer' );
			
			$notification = $this->work_order->getNotification( $ot );
			
			
			$responsible = $this->work_order->getResponsiblesById( $notification[0]['work_order_responsible_id'] );
			$reason = $this->work_order->getResponsiblesById( $notification[0]['work_order_reason_id'] );
					
			$this->mailer->notifications( $notification, $reason[0]['name'], $responsible[0]['name'] );
				
				
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
				
		  'title' => 'Activar OT',
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
		  'content' => 'ot/activate', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  
		  'ot' => $ot,
		  
		  'reason' => $this->work_order->getReason( $data[0]['product_group_id'], 6, $data[0]['work_order_reason_id'] ),
		  
		  'responsibles' => $this->work_order->getResponsibles(  $data[0]['work_order_responsible_id'] ),
		  'data' => $data
		  
		);
				
		// Render view 
		$this->load->view( 'index', $this->view );	
		
	}
	
	
	public function desactivar( $ot = null ){
		
			$this->load->model( 'work_order' );
			$work_order = array(
				
				'work_order_status_id' => 9,
				'creation_date' => date( 'Y-m-d H:i:s' ), // Quitar el tiempo
				'last_updated' => date( 'Y-m-d H:i:s' )
			);
			
				
			if( $this->work_order->update( 'work_order', $ot, $work_order ) == true ){
				
				
				// Send Email		
				$this->load->library( 'mailer' );
				
				$notification = $this->work_order->getNotification( $ot );
													
				$this->mailer->notifications( $notification );
				
				
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
	
	
	
	
	
	
	public function cancelar( $ot = null ){
		
		// Check access teh user for create
		if( $this->access_delete == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Cancelar.", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		}
		
		// Load Model 
		$this->load->model( 'work_order' );
		
		
		
		
		// Save Record
		if( !empty( $_POST ) ){
			
			
			$work_order = array(
				
				'work_order_status_id' => 2,
				'work_order_reason_id' => $this->input->post( 'work_order_reason_id' ),
				'work_order_responsible_id' => $this->input->post( 'work_order_responsible_id' ),
				'last_updated' => date( 'd-m-Y H:i:s' )
			);
			
			if( $this->work_order->update( 'work_order', $ot, $work_order ) == true ){
				
				
				
				$this->load->library( 'mailer' );
			
				$notification = $this->work_order->getNotification( $ot );
				
				
				$responsible = $this->work_order->getResponsiblesById( $notification[0]['work_order_responsible_id'] );
				$reason = $this->work_order->getResponsiblesById( $notification[0]['work_order_reason_id'] );
						
				$this->mailer->notifications( $notification, $reason[0]['name'], $responsible[0]['name'] );
				
				
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
				
		  'title' => 'Desactivar OT',
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
		  'content' => 'ot/cancelar', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  
		  'ot' => $ot,
		  
		  'reason' => $this->work_order->getReason( $data[0]['product_group_id'], 2, $data[0]['work_order_reason_id'] ),
		  
		  'responsibles' => $this->work_order->getResponsibles(  $data[0]['work_order_responsible_id'] ),
		  'data' => $data
		  
		);
				
		// Render view 
		$this->load->view( 'index', $this->view );	
		
	}
	
	
	
	
	/**
	 *	Aceptar y rechazar
	 **/
	public function aceptar( $ot = null, $poliza = null, $pago = null ){
		
		
		// Load Model
			$this->load->model( 'work_order' );
		
			$work_order = array(				
				'work_order_status_id' => 7,
				'last_updated' => date( 'd-m-Y H:i:s' )
			);
			
			if( !empty( $pago ) and $pago == 1 ) $work_order['work_order_status_id']=4;
			
			
			$this->work_order->setPolicy( $ot, $poliza );
						
			if( $this->work_order->update( 'work_order', $ot, $work_order ) == true ){
				
				
				// Send Email		
				$this->load->library( 'mailer' );
				
				$notification = $this->work_order->getNotification( $ot );
								
				$this->mailer->notifications( $notification );
				
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
		
	} 
	 
	public function rechazar( $ot = null ){
			
			// Load Model
			$this->load->model( 'work_order' );
		
			$work_order = array(
				
				'work_order_status_id' => 8,
				'last_updated' => date( 'd-m-Y H:i:s' )
			);
			
						
			if( $this->work_order->update( 'work_order', $ot, $work_order ) == true ){
				
				
				// Send Email		
				$this->load->library( 'mailer' );
				
				$notification = $this->work_order->getNotification( $ot );
								
				$this->mailer->notifications( $notification );
				
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
		
	}	
	
	
	
	
/*
// Cancel work order
	public function cancelar( $ot = null ){
		
		
		
		
		// Check access teh user for create
		if( $this->access_delete == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Canselar", Informe a su administrador para que le otorge los permisos necesarios.'
							
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
*/	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

// update work order
	public function update( $ot = null ){
		
		
		// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Editar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'ot', 'refresh' );
		
		
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Editar", Informe a su administrador para que le otorge los permisos necesarios.'
							
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
	

	
	
	
	
	
	
	
	
	
	
	
	
/**
 *	Payments
 **/
	public function import_payments(){
		
		
		
		// Check access teh for import
		if( $this->access_import_payments == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Importar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( '/', 'refresh' );
		
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$tmp_file =null;
		
		$file_array = array();	
		
		$process = '';
								
		if( !empty( $_FILES ) ){
			
			$process = 'change-index';
			
			$product = $_POST['product'];
			
			$name = explode( '.', $_FILES['file']['name'] );
						
			if( $name[1] == 'xls' ){
			
				// Load Library
				$this->load->library( 'reader_excel' );
				
				$file = $this->reader_excel->upload();
				
							
				if( !empty( $file ) ){
					
					 $this->reader_excel->setInstance( $file );
					
				 	 $file_array = $this->reader_excel->reader();
					
				}
				
				
				$tmp_file = $file;
							
			}
			
			if( $name[1] == 'csv' ){
						
				// Load Library
				$this->load->library( 'reader_csv' );
				
				$file = $this->reader_csv->upload();
											
				if( !empty( $file ) ){
					
					 $this->reader_csv->setInstance( $file );
					
				 	 $file_array = $this->reader_csv->reader();
					
				}
				
				$tmp_file = $file;
			
			}
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// Chane index
		if( !empty( $_POST ) and isset( $_POST['process'] ) and $_POST['process'] == 'change-index' ){
	
			$process = 'choose-agents';
			
			$product = $_POST['product'];
			
			// Load Model
			$this->load->model( array( 'work_order', 'usuarios/user' ) );
			
			$tmp_file = $_POST['tmp_file'];
						
			$name = explode( '.', $tmp_file );
			
			if( $name[1] == 'xls' ){
				
				// Load Library
				$this->load->library( 'reader_excel' );
											
				if( !empty( $tmp_file ) ){
					
					 $this->reader_excel->setInstance( $tmp_file );
					
				 	 $file_array = $this->reader_excel->reader();
					
				}
				
				
			}else{
				
				
				// Load Library
				$this->load->library( 'reader_csv' );
				
				if( !empty( $tmp_file ) ){
					
					 $this->reader_csv->setInstance( $tmp_file );
					
				 	 $file_array = $this->reader_csv->reader();
					
				}
				
				
			}
			
			unset( $_POST['tmp_file'], $_POST['process'], $_POST['product'] );
			
			for( $i=0; $i<=count( $file_array ); $i++ ){
				
				if( isset( $file_array[$i] ) ) 
				
				for( $index=1; $index<=count( $_POST ); $index++ ){
							
					if( $_POST[$index] != 'nonimport' ){
						
						$file_array[$i][$_POST[$index]]=$file_array[$i][$index];
						
						
						if( $_POST[$index] == 'clave' ){
														
							$file_array[$i]['agent'] = $this->user->getAgentByFolio( $file_array[$i][$_POST[$index]], 'clave', $i  );
							
							$file_array[$i]['agent_id'] = $this->user->getIdAgentByFolio( $file_array[$i][$_POST[$index]] );
															
						}		
								
																								
						if( $_POST[$index] == 'agent_uidsnational' ){
																					
							$file_array[$i]['agent'] = $this->user->getAgentByFolio( $file_array[$i][$_POST[$index]], 'national', $i  );
							
							$file_array[$i]['agent_id'] = $this->user->getIdAgentByFolio( $file_array[$i][$_POST[$index]] );
															
						}						
						
						if( $_POST[$index] == 'agent_uidsprovincial' ){
														
							$file_array[$i]['agent'] = $this->user->getAgentByFolio( $file_array[$i][$_POST[$index]], 'provincial', $i  );
							
							$file_array[$i]['agent_id'] = $this->user->getIdAgentByFolio( $file_array[$i][$_POST[$index]] );
															
						}
						
						if( $_POST[$index] == 'uid' ){
							
							$file_array[$i]['uid']=ltrim( $file_array[$i]['uid'], '00000' );
							$file_array[$i]['uid']=ltrim( $file_array[$i]['uid'], '0000' );
							$file_array[$i]['uid']=ltrim( $file_array[$i]['uid'], '000' );
							$file_array[$i]['uid']=ltrim( $file_array[$i]['uid'], '00' );
							$file_array[$i]['uid']=ltrim( $file_array[$i]['uid'], '0' );
							
							
						}
						
						$file_array[$i]['wathdo'] = '';						
																							
						if( isset( $file_array[$i]['year_prime'] ) and $file_array[$i]['year_prime'] == 1 ){
							
							$policy = $this->work_order->getPolicyByUid( $file_array[$i]['uid'] );
							
							if( empty( $policy ) )
								
								$file_array[$i]['wathdo'] = $this->work_order->getWathdo( $i );
							
							else
								
								$file_array[$i]['wathdo'] =  $this->work_order->getByPolicyUid( $file_array[$i]['uid'] );					
									
								
																												
						}else if( isset( $file_array[$i]['year_prime'] ) and $file_array[$i]['year_prime'] == 0 ){
							
							$file_array[$i]['wathdo'] = '';
							
						}
						
					}
																			
					unset( $file_array[$i][$index] );
					
				}
				
			}
					
			// Load Model
			$this->load->model( 'work_order' );
						
			$this->work_order->importPaymentsTmp( $file_array );
			
			for( $i=0; $i<=count( $file_array ); $i++ )
				
				unset( $file_array[$i]['agent_id'] );
						
		}
	
	
	
	
	
	
	  // Change Selects Agents
	  if( !empty( $_POST ) and isset( $_POST['process'] ) and $_POST['process'] == 'choose-agents' ){
		  
		 
		  // Load Model
		  $this->load->model( array( 'work_order', 'usuarios/user' ) );
		  
		  $file_array = $this->work_order->getImportPaymentsTmp();
		  		  		  
		  $file_array = json_decode( $file_array[0]['data'] );
		  
		 		 		  
		  $tmp_file = $_POST['tmp_file'];
		  
		  $process = 'preview';
		  
		  $product = $_POST['product'];
		  		  
		  unset( $_POST['tmp_file'], $_POST['process'],  $_POST['product'] );
		 		  
		  $i=0;
		  
		 
		  	  		  
		  foreach( $file_array as $value ){
						 	
			 			 
			 if( isset( $_POST['agent_id'][$i] ) and is_numeric( $_POST['agent_id'][$i] ) ){
			 	
				$file_array[$i]->agent_id =  $_POST['agent_id'][$i];
				
				$file_array[$i]->agent = $this->user->getAgentsById( $_POST['agent_id'][$i] );
				
				$timestamp = strtotime( date( 'Y-m-d H:s:i' ) );
				
				if( isset( $file_array[$i]->agent_uidsnational ) ){
						
					  $exist = $this->user->getIdAgentByFolio( $file_array[$i]->agent_uidsnational );
						
					  $uids_agens = array(
						  'agent_id' => $file_array[$i]->agent_id,
						  'type' => 'national',
						  'uid' =>  $file_array[$i]->agent_uidsnational,
						  'last_updated' => $timestamp,
						  'date' => $timestamp
					  );
					  
					  if( empty( $exist ) )
					 	 $this->user->create( 'agent_uids', $uids_agens );
				
				}
				
							
				
				
				if(  isset( $file_array[$i]->agent_uidsprovincial ) ){
					
					 $exist = $this->user->getIdAgentByFolio( $file_array[$i]->agent_uidsprovincial );
					
					 $uids_agens = array(
						  'agent_id' => $file_array[$i]->agent_id,
						  'type' => 'provincial',
						  'uid' =>  $file_array[$i]->agent_uidsprovincial,
						  'last_updated' => $timestamp,
						  'date' => $timestamp
					  );
					  
					  if( empty( $exist ) )
					 	 $this->user->create( 'agent_uids', $uids_agens );
						
				}
				
			 }
			 
			 
			  if( isset( $_POST['assing'][$i] ) ){
				    
					
					 if( $_POST['assing'][$i] == 'noasignar' )
					 	
						$value->wathdo = 'Sin Asignar';
					
					 else{
					 							
						$policy = $this->work_order->getPolicyByUid( $value->uid );
					 	
						$ot = $this->work_order->getWorkOrderById(  $_POST['assing'][$i] );
						
						$work_order = array( 'policy_id' => $policy[0]['id'] );
								
						$this->work_order->update( 'work_order', $ot[0]['id'], $work_order );
						
						$value->wathdo = $this->work_order->getOtPolicyAssing( $ot[0]['id'] );
						
					 }
					
			  }
			 
			
			 $i++;
			 
			 
			
		  }
		  
		   
		  
		  $this->work_order->importPaymentsTmp( $file_array );
		  
		  for( $i=0; $i<=count( $file_array ); $i++ )
				
				if( isset( $file_array[$i]->agent_id ) )
			
						unset( $file_array[$i]->agent_id );
		
	  }
	
	
	
	
	
	
	 // Preview
	  if( !empty( $_POST ) and isset( $_POST['process'] ) and $_POST['process'] == 'preview' ){
		  
		  
		  
		 
		  // Load Model
		  $this->load->model( array( 'work_order', 'usuarios/user' ) );
		  		  		  
		  $file_array = $this->work_order->getImportPaymentsTmp();
		    
		  
		  $file_array = json_decode( $file_array[0]['data'] );
		  
		 
		  $controlSaved = true;
		  
		  $i = 1;
		  
		  $message = array( 'type' => false );
		  
		 		  
		  foreach( $file_array as $item ){
			 		  
			  // Verify policy
			  $policy = $this->work_order->getPolicyByUid( $item->uid );
			 
			  if( empty( $policy ) ){
			  	
				$policy = array(
					'product_group_id' => $_POST['product'],
					'prima' => $item->amount,
					'uid' => $item->uid,
					'last_updated' => date( 'Y-m-d H:i:s' ),
					'date' => date( 'Y-m-d H:i:s' )
				);
				
				if( isset(  $item->name ) )
					
					$policy['name'] = $item->name;
				
				$this->work_order->create( 'policies', $policy );
				
				$policy = $this->work_order->getPolicyByUid( $item->uid );
				
				
				$agent = $this->user->getUserIdByAgentId( $item->agent_id  );
				
				$agents = array( 							  
					  'user_id' => $agent, 
					  'policy_id' => $policy[0]['id'],
					  'since' => date( 'Y-m-d H:i:s' )
				);
			  	
				if( isset( $item->percentage ) )	
						  
					$agents['percentage'] = $item->percentage;
				else
					
					$agents['percentage'] = 100;		  
						  
						  
			 	$this->work_order->create( 'policies_vs_users', $agents );
														
			  }
			  			  
			  $payment = array( 
			  	
				'policy_id' => $policy[0]['id'],
				'currency_id' => 1,
				'amount' => $item->amount,
				'payment_date' => $item->payment_date,
				'last_updated' => date( 'Y-m-d H:i:s' ),
				'business' => $item->is_new,
				'policy_number' => $item->uid,
				'date' => date( 'Y-m-d H:i:s' )
				
			  );		 
			  
			  
			  $user_id = $this->user->getUserIdByAgentId( $item->agent_id  );
			 			 
			  if( $this->work_order->checkPayment( $item->uid, $item->amount, $item->payment_date, $user_id ) == true ){
					  
					  if( $this->work_order->create( 'payments', $payment ) == false )	$controlSaved = false;
					  					  			  		
					  
					  if( (float)$policy[0]['prima'] >= (float)$item->amount ){
					  		
							$ot = $this->work_order->getWorkOrderByPolicy(  $policy[0]['id'] );
							
							if( !empty( $ot ) ){
							
								$work_order = array( 'work_order_status_id' => 4 );
								
								$this->work_order->update( 'work_order', $ot[0]['id'], $work_order );
							}
					  }
					  	
					  
					  if( $controlSaved == false )
						
						$message['message'][0][$i]['saved'] = 'La linea '.$i.' no se ha podido importar';
					
					
										  
			  }else{
			  	
				$message['message'] = true;
				$message['message'][0][$i]['saved'] = 'La linea '.$i.' ya existia y no se ha guardado.';
				
			  }
			    
			  $i++;
		  }
		  
		  
		  
		  if( !isset( $message['message'] ) ){
		  	
			$message['type'] = true;
			$message['message'][0][0]['saved'] = 'El archivo se importo correctamente.';
			
			
		  }
		  
		  
		  
		  // Clean System
		  $tmp_file = $_POST['tmp_file'];
						
		  $name = explode( '.', $tmp_file );
		  
		  if( $name[1] == 'xls' ){
			  
			  // Load Library
			  $this->load->library( 'reader_excel' );
										  
			  if( !empty( $tmp_file ) ){
				  
				   $this->reader_excel->setInstance( $tmp_file );
				  
				   $this->reader_excel->drop();
				  
			  }
			  
			  
		  }else{
			  // Load Library
			  $this->load->library( 'reader_csv' );
			  
			  if( !empty( $tmp_file ) ){
				  
				   $this->reader_csv->setInstance( $tmp_file );				  
				   $this->reader_csv->drop();				  
			  }			 
		  }		  
		  $this->work_order->removeImportPaymentsTmp();
	  }

                // Load Model
		$this->load->model( 'work_order' );
		
                $products = $this->work_order->getProductsGroupsOptions();
		
		// Config view
		$this->view = array(
				
		  'title' => 'Ot Importar',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'css' => array(
		  	'<link href="'. base_url() .'ot/assets/style/import_payments.css" rel="stylesheet">'
		  ),
		  'scripts' =>  array(
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			  '<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			  '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',	
			  '<script type="text/javascript">$( document ).ready( function(){ $( "#formfile" ).validate(); });</script>',
			  '<script src="'.base_url().'scripts/config.js"></script>',
			  '<script src="'.base_url().'ot/assets/scripts/import.js"></script>'				
		  ),
		  'content' => 'ot/import_payments', // View to load
		  'products' => $products,
		  'message' => $this->session->flashdata('message') // Return Message, true and false if have
		);
		
		
		if( isset( $message ) ){ $this->view['message'] = $message; unset( $tmp_file, $file_array ); }				
		if( isset( $tmp_file ) and !empty( $tmp_file ) ) $this->view['tmp_file'] = $tmp_file;		
		if( isset( $process ) and !empty( $process ) ) $this->view['process'] = $process;		
		if( isset( $product ) and !empty( $product ) ) $this->view['product'] = $product;		
		if( isset( $file_array ) and !empty( $file_array ) ) $this->view['file_array'] = $file_array;                
		// Render view 
		$this->load->view('index',$this->view );
	}
	
	
	


/**
 *	Reports
 **/	
	public function reporte()
         {	
            
		// Check access for report
		if( $this->access_report == false )
                {	
                    // Set false message		
                    $this->session->set_flashdata( 'message', array
                    ( 
                        'type' => false,	
                        'message' => 'No tiene permisos para ingresar en esta sección "Orden de trabajo Ver Reporte", Informe a su administrador para que le otorge los permisos necesarios.'
                    ));	
                    redirect( '/', 'refresh' );
		}
		
		if( !empty( $_POST ) )
		{	
                   
                    $data = $this->user->getReport($_POST );
                }
		else
                    $data = $this->user->getReport( array('query' => array('ramo' => 1,'periodo' => 1 ) ) );
		
		$this->load->helper( 'ot' );
		
		// Load model
		$this->load->model( array( 'usuarios/user', 'work_order' ) );
		
		unset( $data[0] );
										
		// Config view
		$this->view = array(
				
		  'title' => 'Ot Ver reporte',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'export_xls' => $this->access_export_xls,
		  'css' => array(
			'<link href="'. base_url() .'ot/assets/style/report.css" rel="stylesheet">',			
			'<!--<link rel="stylesheet" href="'. base_url() .'ot/assets/style/normalize.min.css">-->
                        <link rel="stylesheet" href="'. base_url() .'ot/assets/style/main.css">',
                        '<link rel="stylesheet" href="'. base_url() .'ot/assets/style/jquery.fancybox.css">'
			
		  ),
		  'scripts' =>  array(
		  	'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			'<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			//'<script type="text/javascript" language="javascript" src="'. base_url() .'ot/assets/plugins/DataTables/media/js/jquery.dataTables.js"<script>',			
			'<script src="'. base_url() .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
			'<script>window.jQuery || document.write ("<script src='. base_url() .'ot/assets/scripts/vendor/jquery-1.10.1.min.js><\/script>");</script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.ddslick.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.tablesorter.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/main.js"></script>',			
			'<script src="'.base_url().'scripts/config.js"></script>'	,	
			'<script src="'.base_url().'ot/assets/scripts/report.js"></script>',
                      '<script src="'.base_url().'ot/assets/scripts/jquery.fancybox.js"></script>'
		  ),
		  'manager' => $this->user->getSelectsGerentes2(),
		  'content' => 'ot/report', // View to load
		  'data' => $data,
                  'tata' => $_POST,
                    
		  'message' => $this->session->flashdata('message') // Return Message, true and false if have
		  	
		);
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
        
        
/**
 *	Reports Popup
 **/	
	public function reporte_popup()
        {
           
            $work_order_ids = $this->input->post('wrk_ord_ids');  
            $data['is_poliza'] = $this->input->post('is_poliza');
            $data['gmm'] = $this->input->post('gmm');
            $this->load->model('work_order');   
           
            $this->view = array(
                'css' => array(
			'<link href="'. base_url() .'ot/assets/style/report.css" rel="stylesheet">',			
			'<!--<link rel="stylesheet" href="'. base_url() .'ot/assets/style/normalize.min.css">-->
                        <link rel="stylesheet" href="'. base_url() .'ot/assets/style/main.css">',
                        '<link rel="stylesheet" href="'. base_url() .'ot/assets/style/jquery.fancybox.css">'
			
		  ),
                'scripts' =>  array(
		  	'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			'<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			//'<script type="text/javascript" language="javascript" src="'. base_url() .'ot/assets/plugins/DataTables/media/js/jquery.dataTables.js"<script>',			
			'<script src="'. base_url() .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
			'<script>window.jQuery || document.write ("<script src='. base_url() .'ot/assets/scripts/vendor/jquery-1.10.1.min.js><\/script>");</script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.ddslick.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.tablesorter.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/main.js"></script>',			
			'<script src="'.base_url().'scripts/config.js"></script>'	,	
			'<script src="'.base_url().'ot/assets/scripts/report.js"></script>',
                      '<script src="'.base_url().'ot/assets/scripts/jquery.fancybox.js"></script>'
		  ));
            
            
            $results = array();  
            foreach($work_order_ids as $work_order_id)
            {
                $results[] = $this->work_order->pop_up_data($work_order_id);                
            }
            $data['values'] = $results;
            $this->load->view('popup_report',$data);	
	}
        public function reporte_popupa()
        {
           
            $work_order_ids = $this->input->post('wrk_ord_ids'); 
            $data['is_poliza'] = $this->input->post('is_poliza');
            $data['gmm'] = $this->input->post('gmm');
            $work_ids = explode(',',$work_order_ids);
            $this->load->model('work_order');   
            
            $this->view = array(
                'css' => array(
			'<link href="'. base_url() .'ot/assets/style/report.css" rel="stylesheet">',			
			'<!--<link rel="stylesheet" href="'. base_url() .'ot/assets/style/normalize.min.css">-->
                        <link rel="stylesheet" href="'. base_url() .'ot/assets/style/main.css">',
                        '<link rel="stylesheet" href="'. base_url() .'ot/assets/style/jquery.fancybox.css">'
			
		  ),
                'scripts' =>  array(
		  	'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
			'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
			'<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js"></script>',
			//'<script type="text/javascript" language="javascript" src="'. base_url() .'ot/assets/plugins/DataTables/media/js/jquery.dataTables.js"<script>',			
			'<script src="'. base_url() .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
			'<script>window.jQuery || document.write ("<script src='. base_url() .'ot/assets/scripts/vendor/jquery-1.10.1.min.js><\/script>");</script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.ddslick.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/jquery.tablesorter.js"></script>',
			'<script type="text/javascript" src="'. base_url() .'ot/assets/scripts/main.js"></script>',			
			'<script src="'.base_url().'scripts/config.js"></script>'	,	
			'<script src="'.base_url().'ot/assets/scripts/report.js"></script>',
                      '<script src="'.base_url().'ot/assets/scripts/jquery.fancybox.js"></script>'
		  ));
            
            $results = array();  
            foreach($work_ids as $work_order_id)
            {
                $results[] = $this->work_order->pop_up_data($work_order_id);                
            }
            $data['values'] = $results;
            $this->load->view('popup_report',$data);	
	}
        
 /**
 *	Reports Popup
 **/	
	public function reporte_popup_later()
        {
            //$data['value'] = $this->uri->segment(3);
            $this->load->model(array('work_order'));            
            $data['values'] = $this->work_order->pop_up_data(); 
            $result = $this->load->view('popup_report',$data);
            echo json_encode($result);
	}
        
        
/**
 *	Email Popup
 **/	
	public function email_popup()
        {
            //$data['email_address'] = $this->uri->segment(3);  
            $tata = $this->input->post("work_ids");
            $email = $this->input->post("email");
            $data['Id'] = substr($tata,9, -1);
            $data['username'] = $this->sessions['username'];
            
            $this->load->view('popup_email',$data);	
	}  
        
       
 /**
 *	Send Email 
 **/	
	public function send_email()
        {
            $email_address = $this->input->post('email_address');            
            $email_body = $this->input->post('email_body');            
            $this->load->library('email');
            $this->email->set_mailtype("html");
            $this->email->from('proAges@example.com','proAges');
            $this->email->to($email_address);
            $this->email->subject('Email from proAges');
            $this->email->message($email_body);
         
            $result = $this->email->send(); 
            echo json_encode($result); 
	}         
        
	
	public function report_export(){
		
		$data = array();
		 
		if( !empty( $_POST ) )
			
			 $data = $this->user->getReport( $_POST );
		
		else
		 	
			$data = $this->user->getReport( array( 'query' => array( 'ramo' => 1, 'periodo' => 1 ) ) );
		
		
		// Load Helper 
		$this->load->helper( array( 'usuarios/csv', 'ot' ) );
		
		
		
		if( empty( $_POST ) or isset( $_POST['query']['ramo'] )  and $_POST['query']['ramo'] !=3  ):
		/*			
			[name] => Agentes
                        [negocio] => Negocios Pagados
                        [negociopai] => Negocios Pal
                        [prima] => Primas Pagadas
                        [tramite] => Negocios en Tramite
                        [tramite_prima] => Primas en Tramite
                        [pendientes] => Negocios Pendientes
                        [pendientes_primas] => Primas Pendientes
                        [negocios_proyectados] => Negocios Proyectados
                        [negocios_proyectados_primas] => Primas Proyectadas,
                                    ['iniciales'] => 'Iniciales',
			['renovaciones'] => 'Renovaciones'
		
		*/
		
		
		$total_negocio=0;
		$total_negocio_pai=0;
		$total_primas_pagadas=0;
		$total_negocios_tramite=0;
		$total_primas_tramite=0;
		$total_negocio_pendiente=0;
		$total_primas_pendientes=0;
		$total_negocios_proyectados=0;
		$total_primas_proyectados=0;
								
		if( !empty( $data ) )
			
			$i = 0;
			
			foreach( $data  as $value ){
				
				if( $i>0 ){
				
				unset( $data[$i]['id'] );
				
				
				if( $value['disabled'] == 1 ) $value['disabled'] = 'Vigente'; else $value['disabled'] = 'Cancelado';
				
				if( !empty( $value['uids'][0]['uid'] ) )								
					$data[$i]['name'] =  $value['uids'][0]['uid']. ' - ';
				
				else
				   $data[$i]['name'] = 'Sin clave asignada -';
				   
						
				$data[$i]['name'] .= $value['disabled'] .' -  Generacion 1 - '; 
                          
						 
							        
                if( $value['connection_date'] != '0000-00-00' ) 
                         $data[$i]['name'] .=  'Conectado'. getFormatDate( $value['connection_date'] );
                else 
                         $data[$i]['name'] .=   'No Conectado';                
																
				unset( $data[$i]['disabled'], $data[$i]['connection_date'], $data[$i]['uids'] );				
				$data[$i]['negociopai'] = count( $value['negociopai'] );					
					
				if( isset( $value['tramite']['count'] ) ){
					
					$data[$i]['tramite_count'] = $value['tramite']['count'];
					$data[$i]['tramite_prima'] = $value['tramite']['prima'];
					$data[$i]['tramite'] = $data[$i]['tramite_count'];					
					unset( $data[$i]['tramite_count'] );
				}else{
					
					$data[$i]['tramite_count'] = 0;
					$data[$i]['tramite_prima'] = 0;					
					$data[$i]['tramite'] = $data[$i]['tramite_count'];					
					unset( $data[$i]['tramite_count'] );
				}
				
				
				
				if( isset( $value['aceptadas']['count'] ) ){
					
					$data[$i]['pendientes'] = $value['aceptadas']['count'];
					$data[$i]['pendientes_primas'] = $value['aceptadas']['prima'];
					unset( $data[$i]['aceptadas'] );
				}else{
					
					$data[$i]['pendientes'] = 0;
					$data[$i]['pendientes_primas'] = 0;
					unset( $data[$i]['aceptadas'] );
				}
								
			   	
				 $data[$i]['negocios_proyectados'] = ( (int)$data[$i]['pendientes']+(int)$data[$i]['tramite']+(int)$data[$i]['negociopai']+(int)$data[$i]['negocio'] );
				 $data[$i]['negocios_proyectados_primas'] =( (float)$data[$i]['prima']+(float)$data[$i]['pendientes_primas']+(float)$data[$i]['tramite_prima']);
			     
				 
				 $total_negocio += (int)$data[$i]['negocio'];
				 $total_negocio_pai += (int)$data[$i]['negociopai'];
			   	 $total_primas_pagadas += (float)$data[$i]['prima'];
				 $total_negocios_tramite += (int)$data[$i]['tramite'];
				 $total_primas_tramite += (float)$data[$i]['tramite_prima'];
				 $total_negocio_pendiente += (int)$data[$i]['pendientes'];
				 $total_primas_pendientes += (float)$data[$i]['pendientes_primas'];
				 $total_negocios_proyectados += (int) $data[$i]['negocios_proyectados'];
				 $total_primas_proyectados += (float) $data[$i]['negocios_proyectados_primas'];
				 
				 
				 $data[$i]['prima'] = '$ '.$data[$i]['prima'];
				 $data[$i]['tramite_prima'] = '$ '.$data[$i]['tramite_prima'];
				 $data[$i]['pendientes_primas'] = '$ '.$data[$i]['pendientes_primas'];
				 $data[$i]['negocios_proyectados_primas'] = '$ '.$data[$i]['negocios_proyectados_primas'];
				 
			   }
				
				$i++;	
			}
		
		/*
			[name] => Agentes
            [negocio] => Negocios Pagados
            [negociopai] => Negocios Pal
            [prima] => Primas Pagadas
            [tramite] => Negocios en Tramite
            [tramite_prima] => Primas en Tramite
            [pendientes] => Negocios Pendientes
            [pendientes_primas] => Primas Pendientes
            [negocios_proyectados] => Negocios Proyectados
            [negocios_proyectados_primas] => Primas Proyectadas
            [iniciales] => Iniciales
            [renovaciones] => Renovaciones
		*/
	
	
		$data[$i] = array(
			'name' => 'Totales: ',	
			'negocio' => $total_negocio,	
			'negociopai' => $total_negocio_pai,	
			'prima' => '$ '.$total_primas_pagadas,	
			'tramite' => $total_negocios_tramite,	
			'tramite_prima' => '$ '.$total_primas_tramite,	
			'pendientes' => $total_negocio_pendiente,	
			'pendientes_primas' => '$ '.$total_primas_pendientes,	
			'negocios_proyectados' => $total_negocios_proyectados,	
			'negocios_proyectados_primas' => '$ '.$total_primas_proyectados,	
		);
				
		
		else:
			
			$iniciales=0;
			$renovacion=0;
			$total=0;
			$totalgeneral=0;
			
			/*[name] => Agentes
                        [negocio] => Negocios Pagados
                        [negociopai] => Negocios Pal
                        [prima] => Primas Pagadas
                        [tramite] => Negocios en Tramite
                        [tramite_prima] => Primas en Tramite
                        [pendientes] => Negocios Pendientes
                        [pendientes_primas] => Primas Pendientes
                        [negocios_proyectados] => Negocios Proyectados
                        [negocios_proyectados_primas] => Primas Proyectadas
                        [iniciales] => Iniciales
                        [renovaciones] => Renovaciones
			*/
			
			unset( $data[0]['negocio'],$data[0]['negociopai'],$data[0]['prima'],$data[0]['tramite'], $data[0]['tramite_prima'] );
			unset( $data[0]['pendientes'],$data[0]['pendientes_primas'],$data[0]['negocios_proyectados'],$data[0]['negocios_proyectados_primas'] );
			
			 $data[0]['total'] = 'Total';
			
			if( !empty( $data ) )
                            {
				$i = 0;
				foreach( $data  as $value )
                                    {
					if( $i>0 ){
					
						unset( $data[$i]['id'] );
				
				
						if( $value['disabled'] == 1 ) $value['disabled'] = 'Vigente'; else $value['disabled'] = 'Cancelado';
						
						if( !empty( $value['uids'][0]['uid'] ) )								
							$data[$i]['name'] =  $value['uids'][0]['uid']. ' - ';						
						else
						   $data[$i]['name'] = 'Sin clave asignada -';						   
								
						$data[$i]['name'] .= $value['disabled'] .' -  Generacion 1 - '; 
											
						if( $value['connection_date'] != '0000-00-00' ) 
								 $data[$i]['name'] .=  'Conectado'. getFormatDate( $value['connection_date'] );
						else 
								 $data[$i]['name'] .=   'No Conectado';
					
						$iniciales += (int)$value['iniciales'];		
						$renovacion +=(int) $value['renovacion'];		
						$total =  (int)$value['iniciales']+(int)$value['renovacion'];
						$totalgeneral += (int)$total;						
						$data[$i]['totales'] =$total;
					
						unset( $data[$i]['id'], $data[$i]['uids'],$data[$i]['connection_date'],$data[$i]['disabled'],$data[$i]['negocio'] );
						unset( $data[$i]['negociopai'],$data[$i]['prima'],$data[$i]['tramite'],$data[$i]['aceptadas'] );
						unset( $data[$i]['generacion'] );
					}
					$i++;
				}
				
				$data[$i] = array(
					'name' => 'Totales: ',	
					'iniciales' => $iniciales,	
					'renovacion' => $renovacion,	
					'totalgeneral' => $totalgeneral
				);
			}
		endif;	
		
	 	array_to_csv($data, 'proages_report.csv');
		
		if( is_file( 'proages_report.csv' ) )
			echo file_get_contents( 'proages_report.csv' );
		
		if( is_file( 'proages_report.csv' ) )
			unlink( 'proages_report.csv' );		
	}
	
	
	
	
	
	
	
	
	
/* End of file ot.php */
/* Location: ./application/controllers/ot.php */
}
?>
