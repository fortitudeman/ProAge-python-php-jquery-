<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class solicitudes extends CI_Controller {
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

	private $coordinator_select = '';
	private $inline_js = '';

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
				if ($value['module_name'] == 'Solicitudes')
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
			}
		}

		$this->period_filter_for = 'requests';
		$this->default_period_filter = $this->session->userdata('default_period_filter_'.$this->period_filter_for);
		$this->custom_period_from = $this->session->userdata('custom_period_from_'.$this->period_filter_for);
		$this->custom_period_to = $this->session->userdata('custom_period_to_'.$this->period_filter_for);

		$this->misc_filter_name = 'operations_misc_filter';
		$this->misc_filters = $this->session->userdata($this->misc_filter_name);

		$options = array(
			"name" => "general",
			"page" => "requests",
			"general_open" => "<table><thead><tr>",
			"general_close" => "</tr></thead></table>",
			"filter_open" => "<th>",
			"filter_close" => "</th>",
		);
		$this->load->library('custom_filters', $options);
                
		$this->load->helper('filter');
	}

	public function index()
	{
		$this->summary();
	}

	public function summary(){
		if ($this->default_period_filter == 5)
			set_filter_period( 2 );

		$other_filters = $this->_init_profile();
		if ( !$this->access_report )
		{	
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para ver el reporte "Resumen de solicitacion" en la sección "Solicitudes", informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}

		$other_filters["nuevos_negocios"] = 1;
		$other_filters["periodo"] = get_filter_period();

		$this->load->model( 'ot/work_order' );
		//General work orders
		$work_orders_general = $this->work_order->getWorkOrdersGroupBy($other_filters);
		//Formating names
		foreach ($work_orders_general as $i => $order){
			if(empty($order["name"]) && empty($order["lastnames"]))
				$work_orders_general[$i]["name"] = $order["company_name"];
			$work_orders_general[$i]["lastnames"].= " - <b>". $order["percentage"]."</b>";
		}

		//Configuration agent group
		$args = array(
			"select" => "users.company_name, users.name, users.lastnames, policies_vs_users.percentage",
			"by" => "users.company_name, agents.id, policies_vs_users.percentage",
			"order" => "conteo desc",
		);
		$work_orders_agents = $this->work_order->getWorkOrdersGroupBy($other_filters, $args);
		$work_orders_data = array();
		$work_orders_labels = array();
		foreach ($work_orders_agents as $order){
			$work_orders_labels[] = empty($order["name"]) && empty($order["lastnames"]) ? $order["company_name"] :$order["name"]." ".$order["lastnames"];
			$work_orders_data[] = $order["conteo"];
		}
		$work_orders_data = json_encode($work_orders_data);
		$work_orders_labels = json_encode($work_orders_labels);
		//Configuration status group
		$args = array(
			"select" => "work_order_status.name status",
			"by" => "work_order_status.name",
			"order" => "conteo desc",
		);
		$work_orders_status = $this->work_order->getWorkOrdersGroupBy($other_filters, $args);
		$work_orders_status_labels = array();
		$work_orders_status_data_graph = array();
		foreach ($work_orders_status as $order){
			$work_orders_status_labels[] = $order["status"];
			$work_orders_status_data_graph[] = $order["conteo"];
		}
		$work_orders_status_labels = json_encode($work_orders_status_labels);
		$work_orders_status_data_graph = json_encode($work_orders_status_data_graph);

		//Configuration products group
		$args = array(
			"select" => "products.name producto",
			"by" => "products.id",
			"order" => "conteo desc",
		);
		$work_orders_products = $this->work_order->getWorkOrdersGroupBy($other_filters, $args);
		$work_orders_products_data = array();
		$work_orders_products_labels = array();
		foreach ($work_orders_products as $order){
			$work_orders_products_data[] = $order["conteo"];
			$work_orders_products_labels[] = $order["producto"];
		}
		$work_orders_products_data = json_encode($work_orders_products_data);
		$work_orders_products_labels = json_encode($work_orders_products_labels);

		$base_url = base_url();
		$ramo= 55;
		$ramos = $this->work_order->getProductsGroups();
		unset($ramos[3]);

		$this->form_validation->run();

		$content_data = array(
			'access_all' => $this->access_all,
			'period_fields' => show_period_fields('requests', $ramo),
			'selected_period' => get_filter_period(),
			'other_filters' => $other_filters,
			'ramos' => $ramos,
			'wo_general' => $work_orders_general,
			'wo_agents' => $work_orders_agents,
			'wo_status' => $work_orders_status,
			'wo_products' => $work_orders_products,
		);

		$sub_page_content = $this->load->view('solicitudes/summary', $content_data, TRUE);

		$add_js = '
			<script type="text/javascript">
				var StatusGraph;
				$(document).ready( function(){ 
					$("#myTab a").click(function (e) {
					  e.preventDefault();
					  $(this).tab("show");
					});
					var ctxAgents = document.getElementById("agentsContainer").getContext("2d");
					var AgentsGraph = new Chart(ctxAgents, {
					    type: "horizontalBar",
					    data: {
							labels: '.$work_orders_labels.',
							datasets: [{
							    label: "# Solicitudes",
							    data: '.$work_orders_data.',
							    backgroundColor: "rgba(54, 162, 235, 0.4)",
							    borderWidth: 1
							}]
						},
						options: {
							scales: {
							    yAxes: [{
							        ticks: {
							            beginAtZero:true
							        },
							    }],
							},
							title: {
					            display: true,
					            text: "SOLICITUDES"
							},
							maintainAspectRatio: false,
						}
					});
					var ctxStatus = document.getElementById("statusContainer").getContext("2d");
					StatusGraph = new Chart(ctxStatus, {
					    type: "pie",
					    data: {
							labels: '.$work_orders_status_labels.',
							datasets: [{
							    label: "# Solicitudes",
							    data: '.$work_orders_status_data_graph.',
							    borderWidth: 1,
							    backgroundColor: [
				                    "#4d4d4d",
									"#5da5da",
									"#faa43a",
									"#60bd68",
									"#f17cB0",
									"#b2912f",
									"#b276b2",
									"#decf3f",
									"#f15854",
				                ],
							}]
						},	
						options: {
							scales: {
							    yAxes: [{
							        ticks: {
							            beginAtZero:true
							        },
							    }],
							},
							title: {
					            display: true,
					            text: "OT\'S POR ESTATUS"
							},
							maintainAspectRatio: false,
						}
					});
					var ctxProducts = document.getElementById("productsContainer").getContext("2d");
					ProductsGraph = new Chart(ctxProducts, {
					    type: "pie",
					    data: {
							labels: '.$work_orders_products_labels.',
							datasets: [{
							    label: "# Solicitudes",
							    data: '.$work_orders_products_data.',
							    borderWidth: 1,
							    backgroundColor: [
				                    "#e6194b",
				                    "#3cb44b",
				                    "#ffe119",
				                    "#0082c8",
				                    "#f58231",
				                    "#911eb4",
				                    "#46f0f0",
				                    "#f032e6",
				                    "#d2f53c",
				                    "#fabebe",
				                    "#008080",
				                    "#e6beff",
				                    "#aa6e28",
				                    "#fffac8",
				                    "#800000",
				                    "#aaffc3",
				                    "#808000",
				                    "#ffd8b1",
				                    "#000080",
				                    "#808080",
				                    "#FFFFFF",
				                    "#000000",
				                ],	
							}]
						},
						options: {
							scales: {
							    yAxes: [{
							        ticks: {
							            beginAtZero:true
							        },
							    }],
							},
							title: {
					            display: true,
					            text: "PRODUCTOS SOLICITADOS"
							},
							maintainAspectRatio: false,
						}
					});
					$(".toggleTable").on("click", function(e){
						e.preventDefault();
						var target = $(this).attr("data-target");
						var resize_target = $(this).attr("data-resize");
						var itag = $(this).find("i");
						itag.toggleClass("icon-plus");
						itag.toggleClass("icon-minus");

						var spantext = $(this).find("span").text();
						if(spantext == "Ver tabla")
							$(this).find("span").text("Ver grafico");
						else
							$(this).find("span").text("Ver tabla");

						var resize_cell = $(this).closest(".row").find(resize_target);
						resize_cell.toggle("fast");
						$(target).toggle("fast");

					});
					$("#tablesorted")
						.tablesorter({theme : "default", widthFixed: true, widgets: ["saveSort", "zebra"]});
				});
			</script>
			';
		$add_css = '
		<style>
			.filterstable {margin-left: 2em; width:80%;}
			.filterstable th {text-align: left;}
			.tab-content {overflow: hidden;}
		</style>
		';

		$this->view = array(
			'title' => 'Resumen de Solicitación',
			 // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link href="' . $base_url . 'ot/assets/style/theme.default.css" rel="stylesheet">',
				'<link rel="stylesheet" href="' . $base_url . 'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">', // TO CHECK
				$add_css,
			),
			'scripts' => array(
				'<script type="text/javascript" src="'. $base_url .'scripts/jquery.cookie.js"></script>',
				'<script src="'. $base_url .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
				'<script src="' . $base_url . 'scripts/config.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/select_period.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'operations/assets/scripts/jquery.canvasjs.min.js"></script>',
				'<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter-2.14.5.js"></script>',
				$add_js,
				$this->custom_filters->render_javascript(),
			),
			'content' => 'report_template', // View to load
			'message' => $this->session->flashdata('message'),
			'data' => array(),
			'sub_page_content' => $sub_page_content,
		);

		// Render view 
		$this->load->view( 'index', $this->view );
	}

	public function _init_profile(){
		$this->load->helper('ot/ot');

		$other_filters = array(
			"periodo" => 2,
			"ramo" => '',
		);

		//Filters
		if($this->input->post()){
			update_custom_period($this->input->post('cust_period_from'),
				$this->input->post('cust_period_to'), FALSE);

			if ( isset($_POST['periodo']) && $this->form_validation->is_natural_no_zero($_POST['periodo']) &&
				($_POST['periodo'] <= 4) )
				set_filter_period($_POST['periodo']);

			if ( isset($_POST['ramo']) && (($this->form_validation->is_natural_no_zero($_POST['ramo']) &&
				($_POST['ramo'] <= 3)) || (($_POST['ramo']) === '')) )
				$other_filters['ramo'] = $_POST['ramo'];


			$this->custom_filters->set_filters_to_save($other_filters);
			$this->custom_filters->set_current_filters($other_filters);
			generic_set_report_filter( $other_filters, array() );
		}
		return $other_filters;
	}

}

/* End of file solicitudes.php */
/* Location: ./application/modules/solicitudes/controllers/solicitudes.php */