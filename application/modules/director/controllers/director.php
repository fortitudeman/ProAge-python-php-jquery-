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
class Director extends CI_Controller {

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
	public $access_create_simulator = FALSE;
	public $access_update_simulator = FALSE;
	public $access_delete_simulator = FALSE;
	
	public $access_export_xls = false; // Export xls
	public $access_activate = FALSE;
	public $access_ot_report = FALSE;
	public $access_update_ot = FALSE;
	public $access_delete_ot = FALSE;
	public $access_create_ot = FALSE;

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

	public $user_id = FALSE;

/** Construct Function **/
/** Setting Load perms **/
	
	public function __construct()
	{
		parent::__construct();

		/** Getting Info for User **/
		$this->load->model( array( 'usuarios/user', 'roles/rol' ) );

		// Get Session
		$this->sessions = $this->session->userdata('system');
		if ( empty( $this->sessions ) )
			redirect( 'usuarios/login', 'refresh' );

		// Get user rol		
		$this->user_vs_rol = $this->rol->user_role( $this->sessions['id'] );

		// Get user rol access
		$this->roles_vs_access = $this->rol->user_roles_vs_access( $this->user_vs_rol );

		if( !empty( $this->user_vs_rol )  and !empty( $this->roles_vs_access ) )
		{
			// Compute permissions to access this module and its functions
			foreach( $this->roles_vs_access  as $value )
			{
				switch ($value['module_name'])
				{
					case 'Director':
						$this->access = TRUE;
						switch ($value['action_name'])
						{
							case 'Ver reporte':
								$this->access_ot_report = TRUE;
								break;
							case 'Export xls':
								$this->access_export_xls = TRUE;
								break;
							default:
								break;
						}
						break;						
					case 'Simulador':
						$this->access_simulator = TRUE;
						switch ($value['action_name'])
						{
							case 'Crear':
								$this->access_create_simulator = TRUE;
								break;
							case 'Editar':
								$this->access_update_simulator = TRUE;
								break;
							case 'Editar':
								$this->access_delete_simulator = TRUE;
								break;								
							default:
								break;
						}
						break;
					case 'Orden de trabajo':
						switch ($value['action_name'])
						{
							case 'Crear':
								$this->access_create_ot = TRUE;
								break;						
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
		}
		
		$this->period_filter_for = 'director';
		$this->default_period_filter = $this->session->userdata('default_period_filter_director');
		$this->custom_period_from = $this->session->userdata('custom_period_from_director');
		$this->custom_period_to = $this->session->userdata('custom_period_to_director');

		$this->misc_filter_name = 'director_misc_filter';
		$this->misc_filters = $this->session->userdata($this->misc_filter_name);
		$this->load->helper('filter');
	}

	public function index()
	{
		$this->sales_planning();
	}

	public function sales_planning()
	{
		$page = 'sales_planning';
		if ($this->input->post('ver_meta') == 'metas')
			$page = 'metas';

		$this->_init_profile();
		if ( !$this->access_ot_report )
		{
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para ver el reporte "PLANEACIÓN Y DESEMPEÑO DE VENTAS" en la sección "Director Commercial". Informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}

		$agent_array = array();
		$other_filters = array();
		$this->load->helper( array('ot/ot' ));
		if (count($_POST))
		{
			update_custom_period($this->input->post('cust_period_from'),
				$this->input->post('cust_period_to'), FALSE);
		}
		$data = $this->_init_planning_report($agent_array, $other_filters, $page == 'metas');

		$inline_js = get_agent_autocomplete_js($agent_array);
		$base_url = base_url();

		$report_lines = '';
		$ramo = 1;
		if (isset($_POST['query']['ramo']))
			$ramo = $_POST['query']['ramo'];
		else
			$ramo = $this->uri->rsegment(3, 1);
		if ($page == 'sales_planning')
		{
			unset( $data[0] );
			switch ($ramo)
			{
				case 2:
					$report_lines = $this->load->view('ot/report2', array('data' => $data, 'tata' => 2), TRUE);
				break;
				case 3:
					$report_lines = $this->load->view('ot/report3', array('data' => $data, 'tata' => 3), TRUE);
				break;
				default:
					$report_lines = $this->load->view('ot/report1', array('data' => $data, 'tata' => 1), TRUE);
				break;
			}
		}
		else 
			$report_lines = $this->load->view('meta_overview', array('data' => $data, 'ramo' => $ramo), TRUE);

		$content_data = array(
			'manager' => $this->user->getSelectsGerentes2(),
			'period_form' => show_custom_period(),
			'period_fields' => show_period_fields('ot_reporte', $other_filters['ramo']),
			'other_filters' => $other_filters,
			'report_lines' => $report_lines,
			'export_xls' => $this->access_export_xls,
			'page' => $page
			);
		$sub_page_content = $this->load->view('director/report', $content_data, true);

		$base_url = base_url();
		if ($page == 'sales_planning')
		{
			$inline_js .= 
'
<script type="text/javascript">
	function payment_popup(params) {
		$.fancybox.showLoading();
		$.post("' . $base_url . 'director/payment_popup.html", jQuery.param(params) + "&" + $("#form").serialize(), function(data) { 
			if (data) {
				$.fancybox({
					content:data
				});
				return false;
			}
		});
	}
	$( document ).ready(function() {
		$( "#meta-button" ).bind( "click", function(){
			$( "#ver-meta" ).val("metas");
			$( "#form" ).submit();
		});
	});	
</script>';
		}
		else
		{
			$inline_js .= 
'
<script type="text/javascript">
	$( document ).ready(function() {
		$(".tablesorter-childRow td").hide();
		$("#sorter-meta")
			.tablesorter({ 
				theme : "default",
				stringTo: "max",
				headers: {  // non-numeric content is treated as a MIN value
					3: { sorter: "digit", string: "min" },
					4: { sorter: "digit", string: "min" },					
				},
				sortList: [[1,0]],
				// use save sort widget
				widgets: ["saveSort"],
				// this is the default setting
				cssChildRow: "tablesorter-childRow"
			});
		// Toggle child row content (td), not hiding the row since we are using rowspan
		// Using delegate because the pager plugin rebuilds the table after each page change
		// "delegate" works in jQuery 1.4.2+; use "live" back to v1.3; for older jQuery - SOL
		$("#sorter-meta").delegate(".toggle", "click" ,function(){
			// use "nextUntil" to toggle multiple child rows
			// toggle table cells instead of the row
			$(this).closest("tr").nextUntil("tr:not(.tablesorter-childRow)").find("td").toggle();
			return false;
		});
	});
</script>';		
		}
			$inline_js .= 
'
<script type="text/javascript">
	$( document ).ready(function() {
		$("#periodo").bind( "click", function(){
			var parentForm = $(this).parents("form");
			$("#periodo option:selected").each(function () {
				if ($(this).val() == 4) {
					$( "#cust_period-form" ).dialog( "open" );
				} else
					parentForm.submit();
				return false;
			})
		});

		$("#export").bind( "click", function(){
			$( "#form" ).attr( "action", "' . $base_url . 'director/report_export.html" );
			$( "#form" ).submit();
		});
	});
</script>
';
		// Config view
		$this->view = array(
			'title' => 'Director',
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link rel="stylesheet" href="'. $base_url .'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'director/assets/style/director.css">',
				'<link rel="stylesheet" href="'. $base_url .'ot/assets/style/jquery.fancybox.css">',
				'<link href="'. $base_url .'ot/assets/style/report.css" rel="stylesheet">',
				'<link href="'. $base_url .'ot/assets/style/theme.default.css" rel="stylesheet">',
				'<style>
.fancybox_blanco {color: #CCCCFF;}
.fancybox_blanco:hover{color: #FFFFFF;}
</style>'
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
				'<script type="text/javascript" src="'.$base_url.'director/assets/scripts/director.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/select_period.js"></script>',
				$inline_js,
			),
			'content' => 'director/director_profile',
			'message' => $this->session->flashdata('message'),
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );		
	}

	public function report_export()
	{
		$page = 'sales_planning';
		if ($this->input->post('ver_meta') == 'metas')
			$page = 'metas';

		$this->_init_profile();
		if ( !$this->access_export_xls )
		{
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para exportar el reporte "PLANEACIÓN Y DESEMPEÑO DE VENTAS" en la sección "Director Commercial". Informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}

		$agent_array = array();
		$other_filters = array();
		$this->load->helper( array( 'usuarios/csv', 'ot/ot' ));
		if (count($_POST))
		{
			update_custom_period($this->input->post('cust_period_from'),
				$this->input->post('cust_period_to'), FALSE);
		}
		$data = $this->_init_planning_report($agent_array, $other_filters, $page == 'metas');
		if ($page == 'sales_planning')
			$data_report = $this->user->format_export_report($data, 'generic', $other_filters['ramo']);
		else
			$data_report = $this->user->format_export_report($data, 'metas');

		// Generates the .csv
	 	array_to_csv($data_report, 'proages_report.csv');

		if( is_file( 'proages_report.csv' ) )
			echo file_get_contents( 'proages_report.csv' );

		if( is_file( 'proages_report.csv' ) )
			unlink( 'proages_report.csv' );
	}

	public $for_print = false;
	public $print_meta = true;
	public $show_meta = true;

	public function meta( $userid = null, $ramo = null )
	{
		$this->_common_simulator($userid, $ramo);
	}

	public function simulator( $userid = null, $ramo = null )
	{
		$this->show_meta = false;
		$this->_common_simulator($userid, $ramo);
	}

	public function print_index( $userid = null, $ramo = null )
	{
		$segments = $this->uri->rsegment_array();
		$segments[1] = 'simulator';
		redirect(implode('/', $segments), 'refresh' );
	}

	public function print_index_simulator( $userid = null, $ramo = null )
	{
		$segments = $this->uri->rsegment_array();
		$segments[1] = 'simulator';
		redirect(implode('/', $segments), 'refresh' );
	}

	private function _common_simulator($userid = null, $ramo = null)
	{
		$this->_init_profile();
		$agentid = $this->user->getAgentIdByUser( $userid );
		if (!$this->access || !$agentid)
		{
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador" o no tiene permisos ver el simulator de este usuario. Informe a su administrador.'
			));
			redirect( 'home', 'refresh' );
		}
		$users = $this->user->getForUpdateOrDelete( $userid );
		$this->access_create = $this->access_create_simulator;
		$this->access_update = $this->access_update_simulator;
		$this->access_update = $this->access_update_simulator;
		
		$this->load->helper('simulator/simulator');
		$content_data = simulator_view( $users, $userid, $agentid, $ramo );

		$sub_page_content = $this->load->view('simulator/overview', $content_data, true);

		if ($this->show_meta)
			$show_hide = '$("#simulator-section").hide(); $("#meta-section").show();';
		else
			$show_hide = '$("#meta-section").hide(); $("#simulator-section").show();';		

		$content_data['scripts'][] = '
<script type="text/javascript">
$( document ).ready( function(){
	' . $show_hide . 
'
});
</script>
';
		$base_url = base_url();
		// Config view
		$this->view = array(
			'title' => 'Director',
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array_merge(
				array(
					'<link rel="stylesheet" href="'. $base_url .'director/assets/style/director.css">',
				),
				$content_data['css']),
			'scripts' =>  array_merge(
				array(
				'<script src="'. $base_url .'scripts/config.js"></script>',
				'<script type="text/javascript" src="'.$base_url.'director/assets/scripts/director.js"></script>',
				),
				$content_data['scripts']),
			'content' => 'director/director_profile',
			'message' => $this->session->flashdata('message'),
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );	
	}

	public function sales_activities()
	{
		echo 'TODO';
	}

	public function ot()
	{
		echo 'TODO';
	}

	private function _init_profile()
	{
		if( !$this->access )
		{
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Director". Informe a su administrador.'
			));
			redirect( 'home', 'refresh' );
		}
		
		$this->load->model( array( 'activities/activity', 'simulator/simulators', 'ot/work_order' ) );
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

// Init report processing (reporte and exportar)
// To do: factorise with _init_report in ot module
	private function _init_planning_report(&$agent_array, &$other_filters, $meta = false)
	{
		$data = array();
		$agent_array = $this->user->getAgents( FALSE );

		$this->load->helper('filter');
		$default_filter = get_filter_period();
		$other_filters = array(
			'ramo' => 1,
			'gerente' => '',
			'agent' => '',
			'generacion' => '', // not sure if this should not be 1 instead
			'agent_name' => '',
			'policy_num' => ''
		);
		get_generic_filter($other_filters, $agent_array);

		if( !empty( $_POST ) )
		{
			if ( isset($_POST['query']['periodo']) && $this->form_validation->is_natural_no_zero($_POST['query']['periodo']) &&
				($_POST['query']['periodo'] <= 4) )
				set_filter_period($_POST['query']['periodo']);

			$filters_to_save = array();
			if ( isset($_POST['query']['ramo']) && $this->form_validation->is_natural_no_zero($_POST['query']['ramo']) &&
				($_POST['query']['ramo'] <= 3) )
				$filters_to_save['ramo'] = $_POST['query']['ramo'];
			if ( isset($_POST['query']['gerente']) && 
				(($_POST['query']['gerente'] == '') || 
				$this->form_validation->is_natural_no_zero($_POST['query']['gerente']))
				)
				$filters_to_save['gerente'] = $_POST['query']['gerente'];
			if ( isset($_POST['query']['agent']) &&
				(  ($_POST['query']['agent'] == '') || 
				( $this->form_validation->is_natural_no_zero($_POST['query']['agent']) &&
				($_POST['query']['agent'] <= 3))   )
				)
				$filters_to_save['agent'] = $_POST['query']['agent'];
			if ( isset($_POST['query']['generacion']) &&
				(  ($_POST['query']['generacion'] == '') || 
				 ( $this->form_validation->is_natural_no_zero($_POST['query']['generacion']) &&
				($_POST['query']['generacion'] <= 5)) )
				)
				$filters_to_save['generacion'] = $_POST['query']['generacion'];
			if ( isset($_POST['query']['agent_name']))
				$filters_to_save['agent_name'] = $_POST['query']['agent_name'];	
			if ( isset($_POST['query']['policy_num']))
				$filters_to_save['policy_num'] = $_POST['query']['policy_num'];
			generic_set_report_filter( $filters_to_save, $agent_array );
			foreach ($filters_to_save as $key => $value)
				$other_filters[$key] = $value;
			$data = $this->user->getReport($_POST, $meta );
		}
		else
		{
			$query = array_merge($other_filters, array('periodo' => $default_filter));
			$data = $this->user->getReport( array('query' => $query ), $meta );
		}
		return $data;
	}

/* End of file director.php */
/* Location: ./application/modules/director/controllers/director.php */
}
