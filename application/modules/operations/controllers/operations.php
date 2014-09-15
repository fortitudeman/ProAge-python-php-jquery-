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
class Operations extends CI_Controller {

	public $view = array();

	public $sessions = array();

	public $user_vs_rol = array();

	public $roles_vs_access = array();

	public $access = FALSE;

	public $access_report = FALSE;
	public $access_view = FALSE;
	public $access_create = FALSE;
	public $access_update = FALSE;
	public $access_export_xls = FALSE;
	public $access_all = FALSE;
//	public $access_create_ot = FALSE;

	public $access_activate = FALSE;
	public $access_delete = FALSE;
	
	public $default_period_filter = FALSE;
	public $misc_filters = FALSE;
	public $custom_period_from = FALSE;
	public $custom_period_to = FALSE;
	public $period_filter_for = FALSE;

//	public $agent = FALSE; //??
	public $operation_user = FALSE;
	public $user_id = FALSE;

/** Construct Function **/
/** Setting Load perms **/
	
	public function __construct(){
			
		parent::__construct();
		
		/** Getting Info for logged in User **/
		
		$this->load->model( array( 'usuarios/user', 'roles/rol' ) );

		// Get Session
		$this->sessions = $this->session->userdata('system');
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  )
			redirect( 'usuarios/login', 'refresh' );

		// Get user rol		
		$this->user_vs_rol = $this->rol->user_role( $this->sessions['id'] );

		// Get user rol access
		$this->roles_vs_access = $this->rol->user_roles_vs_access( $this->user_vs_rol );

		// Check permissions to the module and to the functions in the module
		if( !empty( $this->user_vs_rol )  and !empty( $this->roles_vs_access ) )
		{
			foreach( $this->roles_vs_access  as $value )
			{
				if ($value['module_name'] == 'Operations')
				{
					$this->access = true;
					switch ($value['action_name'])
					{
						case 'Ver reporte':
							$this->access_report = TRUE;
						break;
						case 'Ver':
							$this->access_view = TRUE;
						break;
						case 'Crear':
							$this->access_create = TRUE;
						break;
						case 'Editar':
							$this->access_update = TRUE;						
						break;
						case 'Eliminar':
							$this->access_delete = TRUE;						
						break;
						case 'Activar/Desactivar':
							$this->access_activate = TRUE;						
						break;
						case 'Export xls':
							$this->access_export_xls = TRUE;							
						break;
						case 'Ver todos los registros':
							$this->access_all = TRUE;						
						break;						
						default:
						break;
					}
				}
				elseif ($value['module_name'] == 'Orden de trabajo')
				{
					switch ($value['action_name'])
					{
						case 'Crear':
							$this->access_create_ot = TRUE;
						break;
						default:
						break;
					}
				}
			}
		}

		$this->period_filter_for = 'operations';
		$this->default_period_filter = $this->session->userdata('default_period_filter_operations');
		$this->custom_period_from = $this->session->userdata('custom_period_from_operations');
		$this->custom_period_to = $this->session->userdata('custom_period_to_operations');

		$this->misc_filter_name = 'operations_misc_filter';
		$this->misc_filters = $this->session->userdata($this->misc_filter_name);

		$this->load->helper('filter');
	}

	public function index()
	{
		$this->ot();
	}

	public function ot()
	{
		if ($this->default_period_filter == 5)
			set_filter_period( 2 );

		$this->_init_profile();
		if ( !$this->access_report )
		{	
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para ver el reporte "Orden de trabajo" en la sección "Perfil de operaciones", informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}
		$this->load->helper( array('ot/ot', 'filter' ));
		if (count($_POST))
		{
			update_custom_period($this->input->post('cust_period_from'),
				$this->input->post('cust_period_to'), FALSE);
		}
		$base_url = base_url();
		$ramo= 55;
		$content_data = array(
			'access_all' => $this->access_all,
			'period_fields' => show_period_fields('operations', $ramo),
			'agents' => $this->user->getAgents(),
			'gerentes' => $this->user->getSelectsGerentes(),
			'export_url' => $base_url . 'operations/report_export/' .  $this->user_id . '.html'
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

		$("#export-xls").bind( "click", function(){
			$("#export-xls-input").val("export_xls");
			$(this).parents("form").submit();
		})

	});
</script>
';

		// Config view
		$this->view = array(
			'title' => 'Perfil de operaciones',
			 // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link href="' . $base_url . 'ot/assets/style/report.css" rel="stylesheet">',
				'<link href="' . $base_url . 'ot/assets/style/theme.default.css" rel="stylesheet">',
				'<link rel="stylesheet" href="' . $base_url . 'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">', // TO CHECK
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
		Config.findUrl = "operations/find/' . $this->user_id. '.html";
	});
</script>
',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter-2.14.5.js"></script>',
				'<script src="' . $base_url . 'ot/assets/scripts/list_js.js"></script>',
				'<script src="' . $base_url . 'scripts/config.js"></script>',
				'<script src="' . $base_url . 'ot/assets/scripts/overview.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/select_period.js"></script>',
				$add_js,
			),
			'content' => 'operations/operation_profile', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => $this->operation_user,
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );	
	}

// Export the OTs
	public function report_export()
	{
		$this->_init_profile();
		if ( !$this->access_export_xls )
		{	
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para exportar el reporte "Orden de trabajo" en la sección "Perfil de operaciones", informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}
		$data_report = array(
			array(
				"Número de OT",
				"Fecha de alta de la OT",
				"Agente - %",
				"Ramo",
				"Tipo de trámite",
				"Nombre del asegurado",
				"Estado",
				"Prima")
		);

		$data = $this->_read_ots();
		foreach ($data as $value)
		{
			$agents = array();
			if( !empty( $value['agents'] ) )
			{
				foreach( $value['agents'] as $agent ) 
					if( !empty( $agent['company_name'] ) )
						$agents[] = $agent['company_name'] . ' - '. $agent['percentage'];
					else
						$agents[] = $agent['name'] . ' '. $agent['lastnames']. ' - '. $agent['percentage'];
			}
			$agent_value = implode('|', $agents);
			$prima = '_';
			if ($value['is_nuevo_negocio'] && ($value['policy'][0]['prima'] != 'NULL'))
				$prima = number_format($value['policy'][0]['prima'], 2);
			$data_report[] = array(
				$value['uid'],
				$value['creation_date'],
				$agent_value,
				$value['group_name'],
				$value['parent_type_name']['name'],
				$value['policy'][0]['name'],
				ucwords(str_replace( 'desactivada', 'en trámite', $value['status_name'])),
				$prima
			);
		}
		// Export
		$this->load->helper('usuarios/csv');
		$filename = 'operaciones_ot.csv';
		header('Content-Type: application/csv');
		header('Content-Disposition: attachement; filename="$filename"');
	 	array_to_csv($data_report, $filename);
		
		if( is_file( $filename ) )
			echo file_get_contents( $filename );
		if( is_file( $filename ) )
			unlink( $filename );
		exit;
	}

	
	public function statistics()
	{
		$valid_stat_types = array('recap' => 'recap', 'vida' => 1, 'gmm' => 2, 'autos' => 3);
		$stat_type = $this->uri->segment(3);
		if (!isset($valid_stat_types[$stat_type]))
			show_404();
		$stat_type = $valid_stat_types[$stat_type];

		$this->_init_profile(4);
		if ( !$this->access_report )
		{	
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para ver el reporte "Estadística operativa" en la sección "Perfil de operaciones", informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}
		$this->load->helper( array('ot/ot', 'filter' ));
		if (count($_POST))
		{
			update_custom_period($this->input->post('cust_period_from'),
				$this->input->post('cust_period_to'), FALSE);
		}
		if ($stat_type == 'recap')
			$stats = $this->_read_stats();
		else
			$stats = $this->_read_stats($stat_type);

		$base_url = base_url();
		$ramo = 55;
		$content_data = array(
			'access_all' => $this->access_all,
			'period_fields' => show_period_fields('operations', $ramo),
			'stats' => $stats,
			);
		if ($stat_type == 'recap')
			$sub_page_content = $this->load->view('stats_recap', $content_data, true);
		else
			$sub_page_content = $this->load->view('stats_details', $content_data, true);		

		$add_js = '
<script type="text/javascript">
	$( document ).ready( function(){ 

		$("#export-xls").bind( "click", function(){
			$("#export-xls-input").val("export_xls");
			$(this).parents("form").submit();
		})

/*		$("#periodo").bind( "change", function(){
			var parentForm = $(this).parents("form");
			parentForm.submit();
		})*/

		$(".stat-link").bind( "click", function(){
			var linkId = $(this).attr("id");
			linkId = linkId.replace(/_link/, "");
			var detailUrl = "' . $base_url . 
				'operations/stat_details/' . $stat_type . '/" + linkId ' . ' + "/' . $this->user_id . '.html";
			$("#right-col").html("Cargando ...");
			$("#right-col").load(detailUrl, { "posted": ["1", "2"] }, function(){
				});
			return false;
		})
	});
</script>
';

		// Config view
		$this->view = array(
			'title' => 'Perfil de operaciones',
			 // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link href="' . $base_url . 'ot/assets/style/report.css" rel="stylesheet">',
				'<link href="' . $base_url . 'ot/assets/style/theme.default.css" rel="stylesheet">',
				'<link rel="stylesheet" href="' . $base_url . 'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">', // TO CHECK
				'<link rel="stylesheet" href="'. $base_url .'operations/assets/style/operations.css">',
			),
			'scripts' => array(
				'<script src="' . $base_url . 'scripts/config.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/select_period.js"></script>',
				$add_js,
			),
			'content' => 'operations/operation_profile', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => $this->operation_user,
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );
	}

	public function stat_details()
	{
		$valid_stat_types = array(1 => 1, 2 => 2, 3 => 3);
		$valid_status = array(
			'tramite' => 'tramite', 'pagada' => 'pagada',
			'canceladas' => 'canceladas', 'NTU' => 'NTU', 'todos' => 'todos');
		$stat_type = $this->uri->segment(3, 0);
		$status = $this->uri->segment(4, 0);		
		if (!isset($valid_stat_types[$stat_type]) || !isset($valid_status[$status]))
		{
			echo 'Ocurrio un error.';
			exit();
		}

		$this->_init_profile(5);
		if ( !$this->access_report )
		{
			echo 'No tiene permisos para ver el reporte "Estadística operativa" en la sección "Perfil de operaciones", informe a su administrador para que le otorge los permisos necesarios.';
			exit();
		}
		$stats = $this->_read_details($stat_type, $status);
		if (!$stats)
		{
			echo 'Ocurrio un error.';
			exit();
		}
		$data = array('stats' => $stats);
		$this->load->view( 'details_ramo', $data );
	}
	
// Export stat recap
	public function stat_recap_export()
	{
		$valid_stat_types = array('recap' => 'recap', 'vida' => 1, 'gmm' => 2, 'autos' => 3);
		$stat_type = $this->uri->segment(3);
		if (!isset($valid_stat_types[$stat_type]))
			show_404();

		$filename = 'operaciones_estadistica_' . $stat_type . '.csv';
		$stat_type = $valid_stat_types[$stat_type];

		$this->_init_profile(4);

		if ( !$this->access_export_xls )
		{	
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para exportar el reporte "Orden de trabajo" en la sección "Perfil de operaciones", informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}

		$na_value = 'N/D';
		if ($stat_type == 'recap')
		{
			$stats = $this->_read_stats();
			$data_report = array(
				array(
					"Ordenes de Trabajo Procesadas",
					$stats['recap-left']
				),
			);
			$per_tramite = array(1 => 'Vida', 2 => 'Gastos Médicos', 3 => 'Automóviles');
			foreach ($per_tramite as $tramite_key => $tramite_value)
			{
				$data_report[] = array(
					$tramite_value,
					$stats['per_ramo_tramite'][$tramite_key]['all'],
					$stats['recap-left'] ? round(100 * $stats['per_ramo_tramite'][$tramite_key]['all'] / $stats['recap-left']) . '%' : $na_value,
				);
				foreach ($stats['per_ramo_tramite'][$tramite_key] as $key => $value)
				{
					if ($key != 'all')
					{
						$data_report[] = array(
							$value['label'],
							$value['value'], 
							$stats['recap-left'] ? round(100 * $value['value'] / $stats['recap-left']) . '%' : $na_value
						);
					}
				}
				$data_report[] = array('');
			}

			$per_status = array('tramite' => 'En trámite',
				'terminada' => 'Terminadas',
				'canceladas' => 'Canceladas',
				'activadas' => 'Activadas');
			foreach ($per_status as $key_status => $value_status)
			{
				$data_report[] = array(
					$value_status,
					$stats['per_status'][$key_status],
					$stats['recap-middle'] ? round(100 * $stats['per_status'][$key_status] / $stats['recap-middle']) . '%' : $na_value
				);
			}
			$data_report[] = array(
				'Ordenes de Trabajo Procesadas',
				$stats['recap-middle'],
				$stats['recap-middle'] ? '100%' : $na_value
				);

			$data_report[] = array('');
			$data_report[] = array(
				"RESPONSABLES DE ACTIVACIÓN Y/O CANCELACIÓN",
				);

			foreach ($stats['per_responsible'] as  $value)
			{
				$data_report[] = array(
					$value['label'],
					$value['value'],
					$stats['recap-right'] ? round(100 * $value['value'] / $stats['recap-right']) . '%' : $na_value
				);
			}
			$data_report[] = array(
				'Ordenes de Activadas / canceladas',
				$stats['recap-right'],
				$stats['recap-right'] ? '100%' : $na_value
			);
		}
		else
		{
			$stats = $this->_read_stats($stat_type);
			$data_report = array(
				array(
					'Nuevos de Negocios ' . ucfirst($this->uri->rsegment(3))
				),
			);
			$per_status = array('tramite' => 'En trámite',
				'pagada' => 'Pagados',
				'canceladas' => 'Cancelados',
				'NTU' => 'NTU');
			$total = 0;
			foreach ($per_status as $key_status => $value_status)
			{
				$data_report[] = array(
					$value_status,
					$stats['per_status'][$key_status],
				);
				$total += $stats['per_status'][$key_status];
			}
			$data_report[] = array(
				'Trámites de nuevos negocios:',
				$total,
				);
		}

		// Export
		$this->load->helper('usuarios/csv');

		header('Content-Type: application/csv');
		header('Content-Disposition: attachement; filename="$filename"');
	 	array_to_csv($data_report, $filename);
		
		if( is_file( $filename ) )
			echo file_get_contents( $filename );
		if( is_file( $filename ) )
			unlink( $filename );
		exit;
	}

	// Export stat details
	public function stat_detail_export()
	{
		$valid_stat_types = array(1 => 1, 2 => 2, 3 => 3);
		$valid_status = array(
			'tramite' => 'tramite', 'pagada' => 'pagada',
			'canceladas' => 'canceladas', 'NTU' => 'NTU');
		$stat_type = $this->uri->segment(3, 0);

		$status = $this->uri->segment(4, 0);		
		if (!isset($valid_stat_types[$stat_type]) || !isset($valid_status[$status]))
		{
			echo 'Ocurrio un error.';
			exit();
		}

		$this->_init_profile(5);
		if ( !$this->access_report )
		{
			echo 'No tiene permisos para ver el reporte "Estadística operativa" en la sección "Perfil de operaciones", informe a su administrador para que le otorge los permisos necesarios.';
			exit();
		}
		$stats = $this->_read_details($stat_type, $status);
		if (!$stats)
		{
			echo 'Ocurrio un error.';
			exit();
		}
		$data_report = array();
		$na_value = 'N/D';
		foreach ($stats as $key => $value)
		{
			if ($key && $value['value'])
			{
				$data_report[] = array(
					$value['label'],
					$value['value'],
                    $stats[0]['value'] ? round(100 * $value['value'] / $stats[0]['value']) . '%' : $na_value
				);
			}
		}
		$data_report[] = array(
			'Total',
			$stats[0]['value'],
			$stats[0]['value'] ? '100%' : $na_value
			);

		$types_text = array(1 => 'vida', 2 => 'gmm', 3 => 'autos');
		$filename = 'operaciones_estadistica_' . $types_text[$stat_type] . '_' . $status . '_detalles.csv';

		// Export
		$this->load->helper('usuarios/csv');
		header('Content-Type: application/csv');
		header('Content-Disposition: attachement; filename="$filename"');
	 	array_to_csv($data_report, $filename);
		
		if( is_file( $filename ) )
			echo file_get_contents( $filename );
		if( is_file( $filename ) )
			unlink( $filename );
		exit;
	}

	private function _init_profile($segment = 3)
	{
		if (($this->user_id = $this->uri->rsegment($segment)) === FALSE)
			redirect( 'operations/index/' . $this->sessions['id'], 'refresh' );		

		// Allow user to access his/her profile page
		$this->access = $this->access || ($this->user_id == $this->sessions['id']);
		if ( !$this->access )
		{
			$this->session->set_flashdata( 'message', array( 
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Operaciones" o para ingresar los operaciones del usuario. Informe a su administrador.'
			));
			redirect( 'home', 'refresh' );
		}
		$this->load->model( 'ot/work_order' );
		$user = $this->work_order->generic_get('users', array('id' => (int) $this->user_id ), 1);
		if (!$user)
			show_404();
		$this->operation_user = $user[0];
		$this->operation_user->displayed_user_name = $this->operation_user->company_name ? 
			$this->operation_user->company_name : 
			$this->operation_user->name . ' ' . $this->operation_user->lastnames;
	}

// List OTs
// Inspired from the code of agent/find:
	public function find()
	{
		// If is not ajax request redirect
		if	( !$this->input->is_ajax_request() )
			redirect( '/', 'refresh' );
		$this->_init_profile();
		$data = $this->_read_ots();
		$view_data = array('data' => $data);
//		$this->access_create = $this->access_create_ot;
		$this->load->view('ot/list_render', $view_data);
	}

	private function _read_ots()
	{
		// Load Helpers
		$this->load->helper( array( 'ot/ot', 'ot/date', 'filter' ) );
		if (count($_POST))
		{
			update_custom_period($this->input->post('cust_period_from'),
				$this->input->post('cust_period_to'), FALSE);
		}
		$save_session = $this->sessions['id'];
		$this->sessions['id'] = $this->user_id;
		$data = get_ot_data($other_filters, $this->access_all);
		$this->sessions['id']= $save_session;
		return $data;
	}

	private function _read_stats($ramo = NULL)
	{
		$this->load->helper('filter');
		$periodo = get_filter_period();
		if (( ($posted_periodo = $this->input->post('periodo')) !== FALSE) && 
			$this->form_validation->is_natural_no_zero($posted_periodo) &&
			($posted_periodo <= 5))
		{
			set_filter_period($posted_periodo);
			$periodo = $posted_periodo;
		}
		$this->work_order->init_operations($this->user_id, $periodo, $ramo);
		$add_where = $ramo ? array('t2.name' => 'NUEVO NEGOCIO') : NULL;
		$result = $this->work_order->operation_stats($ramo, $add_where);
		return $result;
	}

	private function _read_details($ramo = NULL, $status = NULL)
	{
		$this->load->helper('filter');
		$periodo = get_filter_period();
		$this->work_order->init_operations($this->user_id, $periodo, $ramo);
		$result = $this->work_order->operation_detailed($ramo, $status);
		return $result;		
	}
}

/* End of file operations.php */
/* Location: ./application/modules/operations/controllers/operations.php */