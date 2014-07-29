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

	public $access_simulator = FALSE;

	public $access_activate = FALSE;
	public $access_ot_report = FALSE;
	public $access_update_ot = FALSE;
	public $access_delete_ot = FALSE;

	public $access_create_activity = FALSE;
	public $access_activity_list = FALSE;
	public $access_update_activity = FALSE;
	public $access_sales_activities = FALSE;
	public $access_delete_activity = FALSE;

	public $default_period_filter = FALSE;
	public $misc_filters = FALSE;
	public $custom_period_from = FALSE;
	public $custom_period_to = FALSE;
	public $period_filter_for = FALSE;

	public $agent = FALSE;
	public $user_id = FALSE;

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

		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Agent Profile', $value ) ):
/*			if( $value['action_name'] == 'Crear' )
				$this->access_create = true;*/
						
			if( $value['action_name'] == 'Editar' )
				$this->access_update = true;
				
/*			if( $value['action_name'] == 'Eliminar' )
				$this->access_delete = true;*/
		endif; endforeach;

		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Usuarios', $value ) ):
			
			if( $value['action_name'] == 'Editar' )
				$this->access_update_profile = true;
			
		endif; endforeach;

		// Permissions to access other modules
		if( !empty( $this->user_vs_rol )  and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value )
		{
			switch ($value['module_name'])
			{
				case 'Simulador':
					$this->access_simulator = TRUE;
					break;
				case 'Orden de trabajo':
					switch ($value['action_name'])
					{
						case 'Activar/Desactivar':
							$this->access_activate = TRUE;
							break;
						case 'Ver reporte':
							$this->access_ot_report = TRUE;
							break;
						case 'Editar':
							$this->access_update_ot = TRUE;
							break;
						case 'Eliminar':
							$this->access_delete_ot = TRUE;
							break;
						default:
							break;
					}
					break;
				case 'Actividades':
					$this->access_activity_list = TRUE;
					switch ($value['action_name'])
					{
						case 'Crear':
							$this->access_create_activity = TRUE;
							break;
						case 'Editar':
							$this->access_update_activity = TRUE;
							break;
						case 'Actividades de ventas':
							$this->access_sales_activities = TRUE;
							break;
						case 'Eliminar':
							$this->access_delete_activity = TRUE;
							break;
						default:
							break;
					}
					break;
				default:
					break;
			}
		}
		
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
		
		$this->period_filter_for = 'agent_profile';
		$this->default_period_filter = $this->session->userdata('default_period_filter_agent_profile');
		$this->custom_period_from = $this->session->userdata('custom_period_from_agent_profile');
		$this->custom_period_to = $this->session->userdata('custom_period_to_agent_profile');

		$this->misc_filter_name = 'agent_profile_misc_filter';
		$this->misc_filters = $this->session->userdata($this->misc_filter_name);

		$this->load->helper('filter');
	}

// Show all records	
	public function index_old( $userid = null, $ramo = null ){
	
		// Check access teh user for create
		if( $this->access == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Perfil Agente", Informe a su administrador para que le otorgue los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		
		$this->load->model( array( 'usuarios/user', 'activities/activity', 'simulator/simulators' ) );
						
		$agentid = $this->user->getAgentIdByUser( $userid );
		
		$agent = $this->user->getAgentsById( $agentid );
		
		$ramo = 'vida';
		
		$report = 1;
		
		$ramos = 1;
				
		if( !empty( $_POST ) ){            
			$data = $this->user->getReportAgent( $userid, $_POST );
         	
			if( $_POST['query']['ramo'] == 1 ){
				$ramo = 'vida';
				$report = 1;
				$ramos = 1;
			}
			
			if( $_POST['query']['ramo'] == 2 ){
				$ramo = 'gmm';
				$report = 2;
				$ramos = 2;
			}
			
			if( $_POST['query']['ramo'] == 3 ){
				$ramo = 'autos';
				$report = 3;
				$ramos = 3;
			}
				
		}else            
			$data = $this->user->getReportAgent( $userid, array('ramo' => 1,'periodo' => 3 ) );
						
		$activities = $this->activity->getByAgentId( $agentid );
		
		$simulator = $this->simulators->getByAgent( $agentid, $ramos );		
		
		$simulator = $simulator[0]['data'];
		
		
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

	public function index()
	{
		$this->agent_report();
	}

	public function agent_report()
	{
		$this->_init_profile();
		if ( $this->access_ot_report == false )
		{	
			// Set false message		
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para ver el reporte "Orden de trabajo" en la sección "Perfil de agente", Informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}

		$filter = array('ramo' => 1, 'periodo' => get_filter_period());
		if (count($_POST))
		{
			$query = $this->input->post('query');
			if ($query !== FALSE)
			{
				if (isset($query['ramo']) && 
					( $query['ramo'] >= 1) && ( $query['ramo'] <= 3))
					$filter['ramo'] = $query['ramo'];

				if (isset($query['periodo']) && 
					( $query['periodo'] >= 1) && ( $query['periodo'] <= 4))
				{
					$filter['periodo'] = $query['periodo'];
					set_filter_period($query['periodo']);
				}
			}
		}
		$value = $this->user->getReportAgent( $this->user_id, array('query' => $filter ));
		if ($value)
		{
			$value = $value[0];
			$value['agent_id'] = $this->agent->agent_id;
		}

		$content_data = array(
			'filter' => $filter,
			'value' => $value,
			'period_form' => show_custom_period(),
			);
		$sub_page_content = $this->load->view('report', $content_data, true);

		$base_url = base_url();
		// Config view
		$this->view = array(
			'title' => 'Perfil de agente',
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link rel="stylesheet" href="'. $base_url .'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">',
				'<link rel="stylesheet" href="'. $base_url .'ot/assets/style/jquery.fancybox.css">'
			),
			'scripts' =>  array(
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/jquery.validate.js"></script>',
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/es_validator.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.ddslick.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter-2.14.5.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter.widgets-2.14.5.js"></script>',
				'<script src="'. $base_url .'scripts/config.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/main.js"></script>',			
				'<script type="text/javascript" src="'.$base_url.'ot/assets/scripts/report.js"></script>',
				'<script type="text/javascript" src="'.$base_url.'ot/assets/scripts/jquery.fancybox.js"></script>',
				'<script type="text/javascript" src="'.$base_url.'agent/assets/scripts/agent.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/custom-period.js"></script>',
'
<script type="text/javascript">
	function payment_popup(params) {
		$.fancybox.showLoading();
		$.post("' . $base_url . 'agent/payment_popup.html", jQuery.param(params) + "&" + $("#form").serialize(), function(data) { 
			if (data) {
				$.fancybox({
					content:data
				});
				return false;
			}
		});
	}
	$( document ).ready(function() {
		$("#periodo").bind( "click", function(){
			var parentForm = $(this).parents("form");
			$("#periodo option:selected").each(function () {
				if ($(this).val() == 4) {
					$( "#cust_period-form" ).dialog( "open" );
				} else
					parentForm.submit();
				return false;
			});
		})
	});
</script>
'
			),
			'content' => 'agent/agent_profile', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => $this->agent,
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );	
	}

	public function agent_ot()
	{
		$this->_init_profile();

		$content_data = array(
			'period_form' => show_custom_period(),
			'agents' => '<option selected="selected" value="' . $this->agent->agent_id . '">' . $this->agent->agent_name . '</option>',
			'gerentes' => '',
			);
		$sub_page_content = $this->load->view('ot/list', $content_data, true);

		$ramo_tramite_types = $this->work_order->get_tramite_types();

		$add_js = '
<script type="text/javascript">
	$( document ).ready( function(){ 
		proagesOverview.tramiteTypes = {' . 
implode(', ', $ramo_tramite_types) . '
		};
		$( "#patent-type").html(proagesOverview.tramiteTypes[0]);
		
		$("#periodo").bind( "click", function(){
			var parentForm = $(this).parents("form");
			$("#periodo option:selected").each(function () {
				if ($(this).val() == 4) {
					$( "#cust_period-form" ).dialog( "open" );
				} else
					parentForm.submit();
				return false;
			});
		})		
		
	});
</script>
';

		$base_url = base_url();
		// Config view
		$this->view = array(
			'title' => 'Perfil de agente',
			 // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link href="' . $base_url . 'ot/assets/style/report.css" rel="stylesheet">',
				'<link href="' . $base_url . 'ot/assets/style/theme.default.css" rel="stylesheet">',
				'<link rel="stylesheet" href="' . $base_url . 'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">',
				'
<style>
.filterstable {margin-left: 2em; width:80%;}
.filterstable th {text-align: left;}
</style>',
			),
			'scripts' => array(
'
<script type="text/javascript">
	$( document ).ready( function(){ 
		Config.findUrl = "agent/find.html";
	});
</script>
',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter-2.14.5.js"></script>',
				'<script src="' . $base_url . 'ot/assets/scripts/list_js.js"></script>',
				'<script src="' . $base_url . 'scripts/config.js"></script>',
				'<script src="' . $base_url . 'ot/assets/scripts/overview.js"></script>',
				'<script type="text/javascript" src="' . $base_url . 'scripts/custom-period.js"></script>',	
				$add_js,
			),
			'content' => 'agent/agent_profile', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => $this->agent,
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );	
	}

	public function agent_sales_activity()
	{
		$this->_init_profile();

		$this->misc_filters['agent_name'] = $this->agent->agent_id;

		$agent_array = array();
		$other_filters = array();
		$default_week = array();
		$data = $this->_init_report($agent_array, $other_filters, $default_week);

		switch ($other_filters['periodo'])
		{
			case 1:
			case 2:
			case 3:
			case 4:
				$report_period = ' desde ' . $other_filters['begin'] . ' hasta ' . $other_filters['end'];
				break;
			default:
				$report_period = '';
				break;
		}
		$content_data = array(
			'data' => $data,
			'period_form' => show_custom_period(), // custom period configuration form
			'other_filters' => $other_filters,
			'report_period' => $report_period,
			'default_week' => $default_week,
			);

		$sub_page_content = $this->load->view('activities/sales_activities', $content_data, true);

		$base_url = base_url();
		$this->view = array(
			'title' => 'Perfil de agente',
		    // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link href="'. $base_url . 'activities/assets/style/create.css" rel="stylesheet" media="screen">',
				'<link href="'. $base_url . 'activities/assets/style/table_sorter.css" rel="stylesheet">',
				'<link rel="stylesheet" href="'. $base_url .'ot/assets/style/jquery.fancybox.css">',
				'<link rel="stylesheet" href="'. $base_url .'activities/assets/style/activity_sales.css">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">',
			),
			'scripts' =>  array(
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/jquery.validate.js"></script>',
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/es_validator.js"></script>',
				'<script src="'.$base_url.'scripts/config.js"></script>',
				'<script src="'.$base_url.'activities/assets/scripts/activities.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter-2.14.5.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter.widgets-2.14.5.js"></script>',
				'<script src="' . $base_url . 'activities/assets/scripts/sales_activity_report.js"></script>',
				'<script src="' . $base_url . 'ot/assets/scripts/jquery.fancybox.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/custom-period.js"></script>',
			),
			'content' => 'agent/agent_profile', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => $this->agent,
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );		
	}

	public function create_activity()
// Copied / pasted from the code of activities/create.html
	{
		$this->_init_profile();
		// Check access
		if( $this->access_create_activity == false )
		{
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Actividad crear", Informe a su administrador para que le otorge los permisos necesarios.'
			));
			redirect( 'agent/agent_sales_activity/' . $this->user_id, 'refresh' );
		}

		if( !empty( $_POST ) )
		{
			// General validations
			$this->form_validation->set_rules('begin', 'Semana', 'required');
			$this->form_validation->set_rules('end', 'Semana', 'required');
			$this->form_validation->set_rules('cita', 'Citas', 'required|numeric');
			$this->form_validation->set_rules('prospectus', 'Prospectos', 'required|numeric');
			$this->form_validation->set_rules('interview', 'Entrevistas', 'required|numeric');
			$this->form_validation->set_rules('vida_requests', 'Solicitudes Vida', 'required|numeric');
			$this->form_validation->set_rules('vida_businesses', ' Negocios Vida', 'required|numeric');
			$this->form_validation->set_rules('gmm_requests', 'Solicitudes GMM', 'required|numeric');
			$this->form_validation->set_rules('gmm_businesses', ' Negocios GMM', 'required|numeric');
			$this->form_validation->set_rules('autos_businesses', ' Negocios AUtos', 'required|numeric');

			// Run Validation
			if ( $this->form_validation->run() == TRUE )
			{
				$values = array_merge($_POST, array('agent_id' => $this->agent->agent_id));
				if ( $this->activity->exist( 'agents_activity', $values ))
					if ( $this->activity->create( 'agents_activity', $values ) )
					{
						$this->session->set_flashdata( 'message', array( 
							'type' => true,	
							'message' => 'Se creó la actividad correctamente.'
						));	
						redirect( 'agent/agent_sales_activity/' . $this->user_id, 'refresh' );

					}
					else
					{
						$this->session->set_flashdata( 'message', array( 
							'type' => false,	
							'message' => 'No se puede crear la actividad, consulte a su administrador.'
						));	
						redirect( 'agent/agent_sales_activity/' . $this->user_id, 'refresh' );
					}

				else
				{
					$this->session->set_flashdata( 'message', array( 
						'type' => false,	
						'message' => 'No se puede crear la actividad ya existe.'
					));	
					redirect( 'agent/agent_sales_activity/' . $this->user_id, 'refresh' );
				}
			}
		}
		
		$content_data = array(
			'access_update' => $this->access_update_activity
			);
		$sub_page_content = $this->load->view('activities/create', $content_data, true);

		// Config view
		$base_url = base_url();
		$this->view = array(
			'title' => 'Perfil de agente',
			  // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link href="'. base_url() .'activities/assets/style/create.css" rel="stylesheet" media="screen">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">',
			),
			'scripts' =>  array(
				'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/jquery.validate.js"></script>',
				'<script type="text/javascript" src="'.base_url().'plugins/jquery-validation/es_validator.js"></script>',
				'<script src="'.base_url().'scripts/config.js"></script>',
				'<script src="'.base_url().'activities/assets/scripts/activities.js"></script>'
			),
			'content' => 'agent/agent_profile', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => $this->agent,
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );	
	}

	public function activity_details()
// Copied / pasted from the code of activities/index.html
// But without the pagination that does not work in activities/index.html
	{
		$this->_init_profile();
		// Check access
		if( $this->access_activity_list == false )
		{
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Actividad", Informe a su administrador para que le otorgue los permisos necesarios.'
			));	
			redirect( 'agent/agent_sales_activity/' . $this->user_id, 'refresh' );
		}

		$this->load->helper('filter');

		$agent_array = array();
		$other_filters = array();
		$default_week = array();
		$data = $this->_init_report($agent_array, $other_filters, $default_week, TRUE);
		switch ($other_filters['periodo'])
		{
			case 1:
			case 2:
			case 3:
			case 4:
				$report_period = ' desde ' . $other_filters['begin'] . ' hasta ' . $other_filters['end'];
				break;
			default:
				$report_period = '';
				break;
		}
		$content_data = array(
			'data' => $data,
			'period_form' => show_custom_period(), // custom period configuration form
			'other_filters' => $other_filters,
			'report_period' => $report_period,
			'access_update' => $this->access_update_activity,
			'access_delete' => $this->access_delete_activity,
			'userid' => $this->user_id,
			);

		$sub_page_content = $this->load->view('activities/list', $content_data, true);

		// Config view
		$base_url = base_url();
		$this->view = array(
			'title' => 'Perfil de agente',
			 // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">',
			),
			'scripts' =>  array(
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/jquery.validate.js"></script>',
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/es_validator.js"></script>',
				'<script src="'.$base_url.'scripts/config.js"></script>',
				'<script src="'.$base_url.'activities/assets/scripts/activities.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter-2.14.5.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter.widgets-2.14.5.js"></script>',
				'<script src="' . $base_url . 'activities/assets/scripts/sales_activity_report.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/custom-period.js"></script>'
			),
			'content' => 'agent/agent_profile', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => $this->agent,
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );	
	}

	private function _init_profile()
	{
		if (($this->user_id = $this->uri->segment(3)) === FALSE)
			show_404();

		// Allow user to access his/her agent profile page
		$this->access = $this->access || ($this->user_id == $this->sessions['id']);
		if( $this->access == false )
		{
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Perfil Agente" o para ingresar el perfil del usuario. Informe a su administrador.'
			));
			redirect( 'home', 'refresh' );
		}
		$this->access_ot_report = $this->access_ot_report || ($this->user_id == $this->sessions['id']);
		
		$this->load->model( array( 'usuarios/user', 'activities/activity', 'simulator/simulators', 'ot/work_order' ) );
		$this->agent = $this->user->get_agent_by_user( (int) $this->user_id );
		if ($this->agent === FALSE)
			show_404();
	}

// Popup pertaining to payments (NOTE: copied and pasted of ot/payment_popup.html code)
	public function payment_popup()
	{
		$data = array('values' => FALSE,
			'access_update' => $this->access_update_ot,
			'access_delete' => $this->access_delete_ot,
		);
		$this->load->model('usuarios/user');
		$filter = array();
		$posted_filter_query = $this->input->post('query');
		if ( ($posted_filter_query !== FALSE) )
			$filter['query'] = $posted_filter_query;

		$request_type = $this->input->post('type');
		switch ( $request_type )
		{
			case 'negocio':
				$data['values'] = $this->user->getNegocioDetails( $this->input->post('for_agent_id'), $filter );
				break;
			case 'negociopai':
				$data['values'] = $this->user->getNegocioPai( $this->input->post('for_agent_id'), $filter );
				break;
			case 'prima':
				$data['values'] = $this->user->getPrimaDetails( $this->input->post('for_agent_id'), $filter );
				break;				
			default:
				exit('Ocurrio un error. Consulte a su administrador.');
				break;
		}
		$this->load->view('ot/popup_payment', $data);
	}

// Copied and pasted from the code of ot/reporte_popup.html:
	public function reporte_popup()
	{
		$work_order_ids = $this->input->post('wrk_ord_ids');  
		$data['is_poliza'] = $this->input->post('is_poliza');
		$data['gmm'] = $this->input->post('gmm');

		$this->load->model( array( 'ot/work_order', 'usuarios/user' ) );

		$base_url = base_url();
		$this->view = array(
			'css' => array(
				'<link href="'. $base_url .'ot/assets/style/report.css" rel="stylesheet">',
				'<!--<link rel="stylesheet" href="'. $base_url .'ot/assets/style/normalize.min.css">-->
				<link rel="stylesheet" href="'. $base_url .'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'ot/assets/style/jquery.fancybox.css">'
			),
			'scripts' =>  array(
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/jquery.validate.js"></script>',
				'<script type="text/javascript" src="'.$base_url.'plugins/jquery-validation/es_validator.js"></script>',
				'<script src="'. $base_url .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.ddslick.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/main.js"></script>',
				'<script src="'.$base_url.'scripts/config.js"></script>'	,	
				'<script src="'.$base_url.'ot/assets/scripts/report.js"></script>',
				'<script src="'.$base_url.'ot/assets/scripts/jquery.fancybox.js"></script>'
			));

		$ramo = 1;
		$period = 2;
		$prev_post = $this->input->post('prev_post');
		if (($prev_post !== FALSE) && is_array($prev_post))
		{
			if (isset($prev_post['ramo']))
				$ramo = (int) $prev_post['ramo'];
			if (isset($prev_post['periodo']))
				$period = $prev_post['periodo'];
		}
		$results = array();
		$row_result = array_merge($data, array('access_update' => $this->access_update));
		$data['values'] = array();
		foreach($work_order_ids as $work_order_id)
		{
			$row_result['value'] = $this->work_order->pop_up_data($work_order_id, (int)$this->input->post('agent_id'));
			$row_result['value']['general'][0]->adjusted_prima = $row_result['value']['general'][0]->prima;

			// For OTs en tramite and pendientes, adjust prima:
			if (($row_result['value']['general'][0]->work_order_status_id == 5) ||
				($row_result['value']['general'][0]->work_order_status_id == 9) ||
				($row_result['value']['general'][0]->work_order_status_id == 7) )
			{
				$row_result['value']['general'][0]->adjusted_prima = 
					$this->user->get_adjusted_prima($row_result['value']['general'][0]->policy_id,
					$ramo, $period) * ($row_result['value']['general'][0]->p_percentage / 100);
			}
			$data['values'][$work_order_id]['main'] = $this->load->view('ot/popup_report_main_row', $row_result, TRUE);
			$data['values'][$work_order_id]['menu'] = $this->load->view('ot/popup_report_menu_row', $row_result, TRUE);
		}
		$this->load->view('ot/popup_report', $data);	
	}

// List OTs
// Copied and pasted from the code of agent/find:
	public function find()
	{
		// If is not ajax request redirect
		if( !$this->input->is_ajax_request() )  redirect( '/', 'refresh' );

		// Load Model
		$this->load->model( 'ot/work_order' );

		// Load Helpers
		$this->load->helper( array( 'ot/ot', 'ot/date', 'filter' ) );

		if ( ( ( $periodo = $this->input->post('periodo') ) !== FALSE ) && 
			( ( $periodo == 1 ) || (  $periodo == 2 ) || ( $periodo == 3 ) || ( $periodo == 4) ) )
			set_filter_period($periodo);

		$data = $this->work_order->find( TRUE );

		$view_data = array('data' => $data);
		$this->load->view('ot/list_render', $view_data);
	}

	// Init actividades de venta report processing
// Copied / pasted to the code of agent/agent_sales_activity/89.html
	private function _init_report(&$agent_array, &$other_filters, &$default_week, $details = FALSE)
	{
		$data = array();
		$agent_array = array($this->agent->agent_id => $this->agent->agent_name);
		$this->load->helper(array('filter', 'activities/date_report'));
		$default_filter = get_filter_period();
		$default_week = get_calendar_week();

		$other_filters = array(
			'agent_name' => '',
			'activity_view' => 'normal',
			'begin' => $default_week['start'],
			'end' => $default_week['end']
		);
		get_generic_filter($other_filters, $agent_array);

		if ( count( $_POST ) && (($periodo = $this->input->post('periodo')) !== FALSE) &&
			(($agent_name = $this->input->post('agent_name')) !== FALSE) && 
			(($activity_view = $this->input->post('activity_view')) !== FALSE) &&
			(($begin = $this->input->post('begin')) !== FALSE) &&
			(($end = $this->input->post('end')) !== FALSE))
		{
			$default_week = array('start' => $begin, 'end' => $end);
			if ( $this->form_validation->is_natural_no_zero($periodo) &&
				($periodo <= 4))
				set_filter_period($periodo);

			if (($activity_view != 'normal') && ($activity_view != 'efectividad'))
				$activity_view = 'normal';

			$other_filters['agent_name'] = $agent_name;				
			$other_filters['periodo'] = $periodo;
			$other_filters['begin'] = $begin;
			$other_filters['end'] = $end;			
			get_period_start_end($other_filters);

			$filters_to_save = array(
				'agent_name' => $agent_name,
				'activity_view' => $activity_view,
				'begin' => $other_filters['begin'],
				'end' => $other_filters['end']
				);
			generic_set_report_filter( $filters_to_save, $agent_array );
		}
		else
		{
			$other_filters = array_merge(
				$other_filters, array('periodo' => $default_filter));
			get_period_start_end($other_filters);
		}
		if (!$details)
			$data = $this->activity->sales_activity($other_filters);
		else
			$data = $this->activity->overview(0, $this->agent->agent_id, $other_filters);

		return $data;
	}

/* End of file agent.php */
/* Location: ./application/modules/agent/controllers/agent.php */
}
?>