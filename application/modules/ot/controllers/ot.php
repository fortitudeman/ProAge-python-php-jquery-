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
	
	public $access_all = false;
	
	public $access_import_payments = false;
	
	
	
	
	
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

		if( !empty( $data ) )
			
			foreach( $data as $value ){
				
				if( $value['status_name'] != 'aceptado' and $value['status_name'] != 'rechazado' and  $value['status_name'] != 'cancelada' ){
												
				
				$scrips .= '<script type="text/javascript">
								$("#'.$value['id'].'").popover({
										title: "Opciones",
										trigger:"click",
										placement:"left",
										html:true, 
										content: function(){ ';
												
													
												
												
														
												
					
					if( $value['status_name'] != 'cancelada' ){
					
					$scrips .= '				var content = "Escoja una opción<br>";';
												
												$new = false;
												
												if( $value['parent_type_name']['name'] == 'NUEVO NEGOCIO' )
												
													$new = true;
												
												if( $this->access_activate == true and $value['status_name'] ==  'desactivada' )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')\">Activar</a><br>";';
												
												
												else if( $this->access_activate == true and $value['status_name'] ==  'activada' )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'desactivar-'.$value['id'].'\', \''.$new.'\')\">Desactivar</a><br>";';
												else 
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')\">Activar</a><br>";';
												
												
												
												
												if( $this->access_update == true ){
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'aceptar-'.$value['id'].'\', \''.$new.'\')\">Marcar como aceptada</a><br>";';
												
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'rechazar-'.$value['id'].'\', \''.$new.'\')\">Marcar como rechazada</a><br>";';
												}
												if( $this->access_delete == true )
												
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'cancelar-'.$value['id'].'\', \''.$new.'\')\">Cancelar</a>";';
												
					}
												
												
					
											$scrips .= 'return content;
										}
								});
							 </script>';
				
				}
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
				
		echo renderTable( $data );	
		
	}	
	
	
	public function find_scripts(){
		
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );
		
		// Load Model
		$this->load->model( 'work_order' );
		
		if( $this->access_all == false )
			$data = $this->work_order->find( $this->input->post(), $this->sessions['id'] );
		
		else
			$data = $this->work_order->find( $this->input->post() );
		
		$scrips = '';
		
		if( !empty( $data ) )
			
			foreach( $data as $value ){
				
				if( $value['status_name'] != 'aceptado' and $value['status_name'] != 'rechazado' and  $value['status_name'] != 'cancelada' ){
				
				$scrips .= '
								$("#'.$value['id'].'").popover({
										title: "Opciones",
										trigger:"click",
										placement:"left",
										html:true, 
										content: function(){';
											
											if( $value['status_name'] != 'cancelada' ){
												
												$scrips .= 'var content = "Escoja una opción<br>";';
																													
												$new = false;
												
												if( $value['parent_type_name']['name'] == 'NUEVO NEGOCIO' )
												
													$new = true;
												
												if( $this->access_activate == true and $value['status_name'] ==  'desactivada' )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')\">Activar</a><br>";';
												
												
												else if( $this->access_activate == true and $value['status_name'] ==  'activada' )
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'desactivar-'.$value['id'].'\', \''.$new.'\')\">Desactivar</a><br>";';
												else 
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'activar-'.$value['id'].'\', \''.$new.'\')\">Activar</a><br>";';
												
												
												
												
												if( $this->access_update == true ){
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'aceptar-'.$value['id'].'\', \''.$new.'\')\">Marcar como aceptada</a><br>";';
												
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'rechazar-'.$value['id'].'\', \''.$new.'\')\">Marcar como rechazada</a><br>";';
												}
												if( $this->access_delete == true )
												
												$scrips .= 'content += "<a href=\"javascript:void(0)\" onclick=\"chooseOption(\'cancelar-'.$value['id'].'\', \''.$new.'\')\">Cancelar</a>";';
												
												}
												
												
					
												$scrips .= 'return content;
										}
								});
							 ';
				}
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
			
				
				exit;		
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
	public function aceptar( $ot = null, $poliza = null ){
		
		
		// Load Model
			$this->load->model( 'work_order' );
		
			$work_order = array(
				
				'work_order_status_id' => 7,
				'last_updated' => date( 'd-m-Y H:i:s' )
			);
			/*
			$policy = $this->work_order->getWorkOrderById( $ot );
			
			if( !empty( $policy[0]['policy_id'] ) ){
			
				//$work_order['uid'] = $poliza;
			
			}else{
			
			
			}
			*/
			
			
						
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
		
		
		
		
		
		
		if( isset( $_FILES['file'] ) and !empty( $_FILES  ) ){
			
			
			// Setting file temporal file named			
			$tmp_file = $_FILES['file']['name'];

			$tmp_file = strtr($tmp_file, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

			$tmp_file = preg_replace('/([^.a-z0-9]+)/i', '_', $tmp_file);

			
			
			// Upload Temporal file CSV			
			if( is_dir( APPPATH.'modules/ot/assets/tmp/' ) )
					
					move_uploaded_file( $_FILES['file']['tmp_name'],  APPPATH.'modules/ot/assets/tmp/'  . $tmp_file );
					
			
			
			
			// Read File			
			if( is_file( APPPATH.'modules/ot/assets/tmp/' . $tmp_file ) ){
						
				$file_handle = fopen( APPPATH.'modules/ot/assets/tmp/'  . $tmp_file, "r");
				
				
				$file_array = array();
				
				
				while (!feof($file_handle) )
				
					$file_array[] = fgetcsv($file_handle, 1024);
					
				
				fclose($file_handle);
				
			}
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// Config view
		$this->view = array(
				
		  'title' => 'Ot Importar',
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
			  '<script src="'.base_url().'ot/assets/scripts/import.js"></script>'				
		  ),
		  'content' => 'ot/import_payments', // View to load
		  'message' => $this->session->flashdata('message') // Return Message, true and false if have
				
		);
		
		
		if( isset( $message ) ){ $this->view['message'] = $message; unset( $tmp_file, $file_array ); }
		
		
		if( isset( $tmp_file ) and !empty( $tmp_file ) ) $this->view['tmp_file'] = $tmp_file;
		
		if( isset( $file_array ) and !empty( $file_array ) ) $this->view['file_array'] = $file_array;
		
		
		
		// Render view 
		$this->load->view( 'index', $this->view );	
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
/* End of file ot.php */
/* Location: ./application/controllers/ot.php */
}
?>