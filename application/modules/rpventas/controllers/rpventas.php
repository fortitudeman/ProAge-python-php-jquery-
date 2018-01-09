<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rpventas extends CI_Controller {
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
				if ($value['module_name'] == 'Reporte de produccion')
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

		$this->period_filter_for = 'ventas';
		$this->default_period_filter = $this->session->userdata('default_period_filter_'.$this->period_filter_for);
		$this->custom_period_from = $this->session->userdata('custom_period_from_'.$this->period_filter_for);
		$this->custom_period_to = $this->session->userdata('custom_period_to_'.$this->period_filter_for);

		$this->misc_filter_name = $this->period_filter_for.'_misc_filter';
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
		$this->production();
	}

	public function production(){
		if ( !$this->access_report )
		{	
			$this->session->set_flashdata( 'message', array
			( 
				'type' => false,	
				'message' => 'No tiene permisos para ver el reporte "Resumen de ventas" en la sección "Reporte de ventas", informe a su administrador para que le otorge los permisos necesarios.'
			));	
			redirect( 'home', 'refresh' );
		}

		// Getting filters
		$other_filters = $this->_init_profile();
		
		//Loading Models
		$this->load->model( 'ot/work_order');
		$this->load->model( 'rpventas/rpm');

		//Loading helpers
		$this->load->helper('render');
		$this->load->helper('date');

		//Configure filters of the report
		$base_url = base_url();
		$ramo= 55;
		$ramos = makeDropdown($this->work_order->getProductsGroups(), "id", "name", FALSE);
		$months = getMonths();
		unset($ramos[3]);

		//Create year dropdown
		$periods = array();
        $minYear = $this->rpm->getFirstPaymentYear();
        $auxYear = date("Y");
        do{
        	$periods[$auxYear] = $auxYear;
        	$auxYear--;
        }while ($auxYear > $minYear);
        
		//Get sales graphic info
        $year1 = $other_filters["periodo"];
        $year2 = $year1 - 1;
    	$sramo = $other_filters["ramo"];
        $ventasy1  = $this->rpm->getAllData($year1, $sramo);
        $ventasy2  = $this->rpm->getAllData($year2, $sramo);
        $primasy1 = $this->rpm->getPrimasList($year1, $sramo);
        $primasy2 = $this->rpm->getPrimasList($year2, $sramo);
        $negociosy1 = $this->rpm->getNegociosList($year1, $sramo);
        $negociosy2 = $this->rpm->getNegociosList($year2, $sramo);

        //Get products graphic info
        $products = $this->rpm->getDataByProduct($year1, $sramo);
        //Generate DataSet array
        $colors = array("#0e606b", "#179381", "#2dfca2", "#32fc6b", "#34f937", "#6bf738", "#a3f73d", "#d7f442", "#f9e848", "#f2b148", "#f2844d", "#f25d52", "#ef5677", "#f45da8", "#f461d2", "#eb63f2", "#b962e5", "#9967e5", "#1b04c9", "#0727c6", "#095ac4", "#0d8ec1", "#11c1c1", "#16cc9b", "#1acc6a", "#1ecc3b", "#31cc20", "#66ce25", "#97ce29", "#c8d12e", "#e5bf37", "#d38434", "#cc5737", "#ce3b43", "#ce406f", "#e04aa6", "#e04ecf", "#c850e0", "#8847bc", "#6748b5");
		$productsDS = array();
		$i = 0;
		foreach ($products as $product) {
			if(!empty($product["id"])){
				$totalpvpy = 0;
				foreach ($product["payments"] as $value) {
					$totalpvpy += $value;
				}
				$productsDS[] = array(
					"label" => $product["name"],
					"backgroundColor" => $colors[$i],
					"borderColor" => $colors[$i],
					"data" => $product["payments"],
					"fill" => FALSE,
					"totaly" => $totalpvpy
				);
				$i++;
			}
		}

		//Get the indicators
        $totalnidy1 = $this->rpm->getNegocios($year1, $sramo);
        $totalnidy2 = $this->rpm->getNegocios($year2, $sramo);
        $indebusins = comparationRatio($totalnidy1, $totalnidy2);
        $primessmy1 = $this->rpm->getPrimas($year1, $sramo);
        $primessmy2 = $this->rpm->getPrimas($year2, $sramo);
        $indeprimes = comparationRatio($primessmy1, $primessmy2);
        $numagentsa = $this->rpm->getNumAgents($year1, $sramo);
        $businespai = $this->rpm->getNumBusiness($year1, $sramo);
        if($sramo==2){ $businespai=0; }

		$content_data = array(
			'access_all' => $this->access_all,
			'access_export_xls' => $this->access_export_xls,
			'other_filters' => $other_filters,
			'ramos' => $ramos,
			'periodos' => $periods,
			'months' => $months,
			'year1' => $year1,
			'year2' => $year2,
			'y1' => $ventasy1,
			'y2' => $ventasy2,
			'primasy1' => $primasy1,
			'primasy2' => $primasy2,
			'negociosy1' => $negociosy1,
			'negociosy2' => $negociosy2,
			"productos" => $products,
			'nya' => $totalnidy1,
			'idb' => $indebusins,
			'pya' => $primessmy1,
			'idp' => $indeprimes,
			'naa' => $numagentsa,
			'ngp' => $businespai
		);
		$sub_page_content = $this->load->view('rpventas/summary', $content_data, TRUE);

		$add_js = '
			<script type="text/javascript">
				var P1 = '.json_encode($primasy1).'
				var P2 = '.json_encode($primasy2).'
				var N1 = '.json_encode($negociosy1).'
				var N2 = '.json_encode($negociosy2).'
				var V1 = '.json_encode($ventasy1).'
				var V2 = '.json_encode($ventasy2).'
				var Y1Title = '.$year1.'
				var Y2Title = '.$year2.'
				var months = '.json_encode($months).'
				var ProdDs = '.json_encode($productsDS).'
			</script>
			';
		$this->view = array(
			'title' => 'Reporte de Producción',
			 // Permisions
			'user' => $this->sessions,
			'user_vs_rol' => $this->user_vs_rol,
			'roles_vs_access' => $this->roles_vs_access,
			'css' => array(
				'<link href="' . $base_url . 'ot/assets/style/theme.default.css" rel="stylesheet">',
				'<link rel="stylesheet" href="' . $base_url . 'ot/assets/style/main.css">',
				'<link rel="stylesheet" href="'. $base_url .'agent/assets/style/agent.css">',
				'<link rel="stylesheet" href="'. $base_url .'ot/assets/style/jquery.fancybox.css">',
				'<link rel="stylesheet" href="'. $base_url .'/style/style-report.css?'.time().'">',
				'<link rel="stylesheet" href="'. $base_url .'/style/print-reset.css?'.time().'">',
			),
			'scripts' => array(
				'<script type="text/javascript" src="'. $base_url .'scripts/jquery.cookie.js"></script>',
				'<script src="'. $base_url .'ot/assets/scripts/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>',
				'<script src="' . $base_url . 'scripts/config.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'operations/assets/scripts/jquery.canvasjs.min.js"></script>',
				'<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter-2.14.5.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.tablesorter.widgets-2.14.5.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'ot/assets/scripts/jquery.fancybox.js"></script>',
				'<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.5.2/randomColor.min.js"></script>',
				'<script type="text/javascript" src="'. $base_url .'scripts/report-utilities.js?'.time().'"></script>',
				'<script type="text/javascript" src="'. $base_url .'rpventas/assets/scripts/summary.js?'.time().'"></script>',
				'<script src="https://use.fontawesome.com/884297e135.js"></script>',
				$add_js,
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

		//Generic Filters
		$other_filters = array(
			"periodo" => '',
			"ramo" => '',

		);
		$this->custom_filters->set_array_defaults($other_filters);
		if(!empty($this->misc_filters))
			$other_filters = array_merge($other_filters, $this->misc_filters);

		if(empty($other_filters["ramo"]))
			$other_filters["ramo"] = 1;

		if(empty($other_filters["periodo"]))
			$other_filters["periodo"] = date("Y");

		//Filters
		if($this->input->post()){
			update_custom_period($this->input->post('cust_period_from'),
				$this->input->post('cust_period_to'), FALSE);

			if ( isset($_POST['periodo']) && $this->form_validation->is_natural_no_zero($_POST['periodo']) &&
				($_POST['periodo'] >= 2000) )
				$other_filters["periodo"] = $_POST["periodo"];

			if ( isset($_POST['ramo']) && (($this->form_validation->is_natural_no_zero($_POST['ramo']) &&
				($_POST['ramo'] <= 2)) || (($_POST['ramo']) === '')) )
				$other_filters['ramo'] = $_POST['ramo'];
		}
		
		$this->custom_filters->set_filters_to_save($other_filters);
		$this->custom_filters->set_current_filters($other_filters);
		generic_set_report_filter( $other_filters, array() );
		return $other_filters;
	}
}

/* End of file rpventas.php */
/* Location: ./application/modules/rpventas/controllers/rpventas.php */