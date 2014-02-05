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
class Simulator extends CI_Controller {

	public $view = array();
	
	public $sessions = array();
	
	public $user_vs_rol = array();
	
	public $roles_vs_access = array();
	
	public $access = false; // Force security
	
	public $access_create = false;
	
	public $access_update = false;
	
	public $access_delete = false;
	
	private $for_print = false;
	
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
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Simulador', $value ) ):

			$this->access = true;
			
		break; endif; endforeach;


		// Added Acctions for user, change the bool access
		if( !empty( $this->user_vs_rol ) and !empty( $this->roles_vs_access ) )	
		foreach( $this->roles_vs_access  as $value ): if( in_array( 'Simulador', $value ) ):
			
			
			if( $value['action_name'] == 'Crear' )
				$this->access_create = true;
						
			if( $value['action_name'] == 'Editar' )
				$this->access_update = true;
				
			if( $value['action_name'] == 'Eliminar' )
				$this->access_delete = true;	
			
			
		endif; endforeach;
							
								
		if( empty( $this->sessions ) and $this->uri->segment(2) != 'login'  ) redirect( 'usuarios/login', 'refresh' );
			
	}

	public function index( $userid = null, $ramo = null ) {

		$this->_index_common( $userid, $ramo);
	}

	public function print_index( $userid = null, $ramo = null ) {

		$this->for_print = true;
		$this->_index_common( $userid, $ramo);
	}

	// Show all records	
	private function _index_common( $userid = null, $ramo = null ){
		
		// Check access teh user for create
		if( $this->access == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		$simulator = 'vida';
		if( $ramo == 1 ) $simulator = 'vida';
		if( $ramo == 2 ) $simulator = 'gmm';
		if( $ramo == 3 ) $simulator = 'autos';
			
		$this->load->model( array( 'user', 'simulators' ) );
		
		$agentid = $this->user->getAgentIdByUser( $userid );
		
		$users = $this->user->getForUpdateOrDelete( $userid );
		
		$data = $this->simulators->getByAgent( $agentid, $ramo );	
		
		$product_group_id = 1;
		
		if( !empty( $data[0] ) )
			$product_group_id =  $data[0]['data']->ramo;
		
		$trimestre = null;	
		
		$cuatrimestre = null;
		
		if( $product_group_id == 1 )
			$trimestre = $this->simulators->trimestre( date('m') );
		else					
			$cuatrimestre = $this->simulators->cuatrimestre( date('m') );
				
		//$userid = $this->user->getUserIdByAgentId( $userid );
		
		$SolicitudesLogradas = array();
		$NegociosLogrados = array();
		$PrimasLogradas = array();
		
		if( $trimestre == 1 ){			
			$SolicitudesLogradas = array(
				'01' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
				'02' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
				'03' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '03', date( 'Y' ) )
			);			
			$NegociosLogrados = array(
				'01' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
				'02' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
				'03' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '03', date( 'Y' ) )
			);			
			$PrimasLogradas = array(
				'01' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
				'02' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
				'03' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '03', date( 'Y' ) )
			);			
		} 	
		if( $trimestre == 2 ){			
			$SolicitudesLogradas = array(
				'04' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
				'05' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
				'06' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '06', date( 'Y' ) )
			);			
			$NegociosLogrados = array(
				'04' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
				'05' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
				'06' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
			);
			$PrimasLogradas = array(
				'04' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
				'05' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
				'06' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
			);			
		} 
		if( $trimestre == 3 ){			
			$SolicitudesLogradas = array(
				'07' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
				'08' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
				'09' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
			);			
			$NegociosLogrados = array(
				'07' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
				'08' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
				'09' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
			);			
			$PrimasLogradas = array(
				'07' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
				'08' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
				'09' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
			);
		} 		
		if( $trimestre == 4 ){			
			$SolicitudesLogradas = array(
				'10' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
				'11' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
				'12' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
			);
			$NegociosLogrados = array(
				'10' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
				'11' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
				'12' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
			);			
			$PrimasLogradas = array(
				'10' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
				'11' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
				'12' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
			);
		} 		
		$settingmeta = '';		
		/*	
		if( !empty( $setmeta ) ){
			
			$settingmeta = '<script type="text/javascript">$(document).ready( function(){   $( ".simulator" ).hide(); $( ".metas" ).show(); });</script>';
			
		};*/	
		if ($ramo==1) $ShowMeta = "vida";				
		elseif ($ramo==2) $ShowMeta = "gmm";				
		elseif ($ramo==3) $ShowMeta = "autos";	
					
		$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "'.$ShowMeta.'" ); getMetas(); }); </script>';
		//$simulator = 'vida';
		if( !empty( $data ) )			
			if( $data[0]['data']->ramo == 1 ){ $simulator = 'vida';
				$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "vida" ); $( "#metas-prima-promedio" ).val( '.$data[0]['data']->primas_promedio.' ); getMetas(); }); </script>'; 
			}else if( $data[0]['data']->ramo == 2 ){	$simulator = 'gmm';
				$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "gmm" ); $( "#metas-prima-promedio" ).val( '.$data[0]['data']->primaspromedio.' ); getMetas(); }); </script>'; 
			}else if( $data[0]['data']->ramo == 3 ){	$simulator = 'autos';
				$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "autos" ); $( "#metas-prima-promedio" ).val( '.$data[0]['data']->primaspromedio.' ); getMetas(); }); </script>'; 
			}
			
		// Config view
		if ($this->for_print) {
			$css = array(
		  	'<link href="'. base_url() .'simulator/assets/style/simulator.css" rel="stylesheet">',
		  	'<link href="'. base_url() .'simulator/assets/style/simulator_print.css" rel="stylesheet">',
		  );
		  $add_js = '
<script type="text/javascript">
$( document ).ready( function(){
/*	$("#print-button").bind( "click", function(){
		$(this).hide(); window.print(); window.close(); return false;}
	);*/
	$(".main-menu-span").removeClass("span2");
	$("#content").removeClass("span10").addClass("span12");
	$("#print-button").hide();
	window.print();
	window.close();
});
</script>
'; 
		} else {
			$css = array(
		  	'<link href="'. base_url() .'simulator/assets/style/simulator.css" rel="stylesheet" media="screen">'
		  );
		  $add_js = '';
		}
		$this->view = array(
				
		  'title' => 'Simulador',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'css' => $css,
		  'scripts' =>  array(
		  	
			'<script type="text/javascript" src="'.base_url().'scripts/config.js"></script>',
			'<script type="text/javascript" src="'.base_url().'simulator/assets/scripts/metas.js"></script>',
			'<script type="text/javascript" src="'.base_url().'simulator/assets/scripts/simulator_'.$simulator.'.js"></script>',
			$settingmeta,
			$requestPromedio,
			$add_js
			
		  ),
		  'content' => 'simulator/overview', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'no_visible_elements_2' => true,
		  'userid' =>  $userid,
		  'agentid' =>  $agentid,
		  'data' =>  $this->simulators->getByAgent( $agentid, $product_group_id ),		  	  
		  'config' => $this->simulators->getConfigMetas( false, $trimestre, null ),		  
		  'SolicitudesLogradas' => $SolicitudesLogradas,
		  'NegociosLogrados' => $NegociosLogrados,	
		  'PrimasLogradas' => $PrimasLogradas,
		  'trimestre' => $trimestre,
		  'cuatrimestre' => $cuatrimestre	,
		  'periodo' => 3,
		  'ramo' => $simulator,
		  'product_group_id' => $product_group_id,
		  'users' => $users
		);
		$this->load->vars( array( 'for_print' => $this->for_print ) );
		
		// Render view 
		$this->load->view( 'index', $this->view );	
	}
	
	public function getSimulator(){
		
		if( !$this->input->is_ajax_request() ) exit;
		$this->load->model( array( 'user', 'simulators' ) );
		$userid = $_POST['userid']; 
		$agentid = $this->user->getAgentIdByUser( $userid );
		if ($_POST['ramo']=="vida") $product_group_id = 1;
		elseif ($_POST['ramo']=="gmm") $product_group_id = 2;
		elseif ($_POST['ramo']=="autos") $product_group_id = 3;
		$data = $this->simulators->getByAgent( $agentid, $product_group_id );
		
		if( !isset( $_POST['varx'] ) ){
			if( isset( $data[0]['data'] ) )
			 $dataview = array( 'data' => $data[0]['data'] );
			else $dataview = array(); 
			$this->load->view( 'simulator_'.$_POST['ramo'], $dataview );
		}else{
			if( isset( $data[0]['data'] ) )
				echo $data[0]['data']->id;
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getConfigMeta(){
		
		if( !$this->input->is_ajax_request() ) exit;
		
		$this->load->model( array( 'user', 'simulators' ) );
		
		$userid = $_POST['userid'];		
				
		$agentid = $this->user->getAgentIdByUser( $userid );
		
		//$agent = $this->user->getAgentsById( $agentid );
		
		//$userid = $this->user->getUserIdByAgentId( $agentid );
				
		$trimestre = null;
				
		$cuatrimestre = null;
		
		$product_group_id = null;
		
	    if( isset( $_POST['ramo'] ) and  $_POST['ramo'] == 'vida' ){ 
			$trimestre = $this->simulators->trimestre( date('m') ); 
			$product_group_id = 1; 
		}	
	    if( isset( $_POST['ramo'] ) and  $_POST['ramo'] == 'gmm' ){ 
			$cuatrimestre = $this->simulators->cuatrimestre( date('m') );
			$product_group_id = 2;	
		}
		if( isset( $_POST['ramo'] ) and  $_POST['ramo'] == 'autos' ){
			$cuatrimestre = $this->simulators->cuatrimestre( date('m') );
			$product_group_id = 3;	
		}
		
		if( $_POST['periodo'] == 12 ){
			
			$trimestre = null;
			
			$cuatrimestre = null; 
			
		}
		
		
		if( $trimestre != null and $cuatrimestre == null ){
						
			if( $trimestre == 1 ){
			
				$SolicitudesLogradas = array(
					'01' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
					'02' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
					'03' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '03', date( 'Y' ) )
				);
				
				$NegociosLogrados = array(
					'01' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
					'02' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
					'03' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '03', date( 'Y' ) )
				);
				
				$PrimasLogradas = array(
					'01' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
					'02' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
					'03' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '03', date( 'Y' ) )
				);
				
			} 	
			
			
			if( $trimestre == 2 ){
				
				$SolicitudesLogradas = array(
					'04' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
					'05' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
					'06' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '06', date( 'Y' ) )
					
				);
				
				$NegociosLogrados = array(
					'04' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
					'05' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
					'06' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
				);
				
				
				$PrimasLogradas = array(
					'04' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
					'05' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
					'06' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
				);
				
			} 	
			
			
			if( $trimestre == 3 ){
				
				$SolicitudesLogradas = array(
					'07' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
					'08' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
					'09' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
					
				);
				
				$NegociosLogrados = array(
					'07' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
					'08' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
					'09' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
				);
				
				$PrimasLogradas = array(
					'07' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
					'08' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
					'09' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
				);
				
			} 	
			
			
			if( $trimestre == 4 ){
								
				
				$SolicitudesLogradas = array(
					'10' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
					'11' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
					'12' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
					
				);
				
				$NegociosLogrados = array(
					'10' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
					'11' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
					'12' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
				);
				
				$PrimasLogradas = array(
					'10' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
					'11' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
					'12' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
				);
				
			} 
			
			
			$config = $this->simulators->getConfigMetas( false, $trimestre, null );
			
		}
		
		
		if( $trimestre == null and $cuatrimestre != null ){
						
			if( $cuatrimestre == 1 ){
			
				$SolicitudesLogradas = array(
					'01' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
					'02' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
					'03' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '03', date( 'Y' ) ),
					'04' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '04', date( 'Y' ) )
				);
				
				$NegociosLogrados = array(
					'01' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
					'02' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
					'03' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '03', date( 'Y' ) ),
					'04' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '04', date( 'Y' ) )
				);
				
				$PrimasLogradas = array(
					'01' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
					'02' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
					'03' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '03', date( 'Y' ) ),
					'04' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '04', date( 'Y' ) )
				);
				
			} 	
			
			
			if( $cuatrimestre == 2 ){
				
				$SolicitudesLogradas = array(
					'05' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
					'06' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
					'07' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
					'08' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '08', date( 'Y' ) )
				);
				
				$NegociosLogrados = array(
					'05' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
					'06' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
					'07' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
					'08' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '08', date( 'Y' ) )
				);
				
				$PrimasLogradas = array(
					'05' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
					'06' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
					'07' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
					'08' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '08', date( 'Y' ) )
				);
				
			}
			
			
			if( $cuatrimestre == 3 ){
				
				$SolicitudesLogradas = array(
					'09' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
					'10' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
					'11' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
					'12' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
				);
				
				$NegociosLogrados = array(
					'09' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
					'10' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
					'11' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
					'12' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
				);
				
				$PrimasLogradas = array(
					'09' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
					'10' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
					'11' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
					'12' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
				);
			}
			
			$config = $this->simulators->getConfigMetas( false, null, $cuatrimestre );
			
		}
		
		
		if( $trimestre == null and $cuatrimestre == null ){
			
			$SolicitudesLogradas = array(
				'01' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
				'02' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
				'03' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '03', date( 'Y' ) ),
				'04' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
				'05' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
				'06' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
				'07' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
				'08' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
				'09' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
				'10' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
				'11' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
				'12' => $this->simulators-> getSolicitudLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
			);
			
			
			$NegociosLogrados = array(
				'01' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
				'02' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
				'03' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '03', date( 'Y' ) ),
				'04' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
				'05' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
				'06' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
				'07' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
				'08' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
				'09' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
				'10' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
				'11' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
				'12' => $this->simulators-> getNegociosLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
			);
			
			
			$PrimasLogradas = array(
				'01' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '01', date( 'Y' ) ),
				'02' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '02', date( 'Y' ) ),
				'03' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '03', date( 'Y' ) ),
				'04' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '04', date( 'Y' ) ),
				'05' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '05', date( 'Y' ) ),
				'06' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '06', date( 'Y' ) ),
				'07' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '07', date( 'Y' ) ),
				'08' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '08', date( 'Y' ) ),
				'09' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '09', date( 'Y' ) ),
				'10' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '10', date( 'Y' ) ),
				'11' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '11', date( 'Y' ) ),
				'12' => $this->simulators-> getPrimasLograda( $agentid, $product_group_id, '12', date( 'Y' ) )
			);
			
			$config = $this->simulators->getConfigMetas( true, null, null );
				
		}
								
		
		if( isset( $config ) )
		   $dataview = array( 'config' => $config );
		 else $dataview = array();  
		
		$data = $this->simulators->getByAgent( $agentid, $product_group_id );	;
		
		$dataview['data'] = $data[0]['data'];
		$dataview['ramo'] = $_POST['ramo'];
		$dataview['SolicitudesLogradas'] = $SolicitudesLogradas;
		$dataview['NegociosLogrados'] = $NegociosLogrados;
		$dataview['PrimasLogradas'] = $PrimasLogradas;
		$dataview['trimestre'] = $trimestre;
		$dataview['cuatrimestre'] = $cuatrimestre;				
		$dataview['periodo'] = 	$_POST['periodo'];
						
		$this->load->view( 'metas', $dataview );
		
	}
	
	
	
	
	
	
	
	
	public function save(){
		
		
		if( $this->input->is_ajax_request() == false ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No se puede acceder a esta sección "Simulador Crear".'
							
			));	
			
			
			redirect( 'home', 'refresh' );
			
		}
		
		
		// Check access teh user for create
		if( $this->access_create == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Crear", Informe a su administrador para que le otorgue los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		if( empty( $_POST ) ) exit;
		
		$this->load->model( array( 'simulators' ) );
		
		$simulator = array(
			'agent_id' => $_POST['agent_id'],
			'product_group_id' => $_POST['ramo'],
			'data' => json_encode($_POST)
		);
		
		if( $this->simulators->create( 'simulator', $simulator ) == true ){
			
			
			$id = $this->simulators->getByAgent( $_POST['agent_id'], $product_group_id );
							
			echo $id[0]['id'];
			
		}else
			
			echo false;
		
			
	}
	
	public function update(){
		
		if( !$this->input->is_ajax_request() ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No se puede acceder a esta sección "Simulador Editar".'
							
			));	
			
			
			redirect( 'home', 'refresh' );
			
		}
		
		
		// Check access teh user for create
		if( $this->access_update == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Editar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		if( empty( $_POST ) ) exit;
		
		$this->load->model( array( 'simulators' ) );
		
		$id = $_POST['id'];
		
		unset( $_POST['id'] );
		
		$simulator = array(
			'agent_id' => $_POST['agent_id'],
			'product_group_id' => $_POST['ramo'],
			'data' => json_encode($_POST)
		);
		
		if( $this->simulators->update( 'simulator', $id, $simulator ) == true )
			
			echo true;
			
		else
			
			echo false;
		
	}
	
	
	
	
	
	
	public function config(){
		
		// Check access teh user for create
		if( $this->access_update == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Configuración Default", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		
		$this->load->model( array( 'simulators' ) );
							 
		// Config view
		$this->view = array(
				
		  'title' => 'Simulador | Configuración Default',
		   // Permisions
		  'user' => $this->sessions,
		  'user_vs_rol' => $this->user_vs_rol,
		  'roles_vs_access' => $this->roles_vs_access,
		  'access_create' => $this->access_create,
		  'access_update' => $this->access_update,
		  'access_delete' => $this->access_delete,
		  'scripts' =>  array(
		  	
			'<script type="text/javascript" src="'.base_url().'scripts/config.js"></script>',
			'<script type="text/javascript" src="'.base_url().'simulator/assets/scripts/config.js"></script>'
			
		  ),
		  'content' => 'simulator/config', // View to load
		  'message' => $this->session->flashdata('message'), // Return Message, true and false if have
		  'data' => $this->simulators->getConfig()		  	  	  	  		
		);
	
		
		// Render view 
		$this->load->view( 'index', $this->view );	
		
	}
	
	public function configSave(){
		
		if( !$this->input->is_ajax_request() ){
			
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No se puede acceder a esta sección "Simulador Configuración Default".'
							
			));	
			
			
			redirect( 'home', 'refresh' );
			
		}
		
		
		// Check access teh user for create
		if( $this->access_update == false ){
				
			// Set false message		
			$this->session->set_flashdata( 'message', array( 
				
				'type' => false,	
				'message' => 'No tiene permisos para ingresar en esta sección "Simulador Editar", Informe a su administrador para que le otorge los permisos necesarios.'
							
			));	
			
			
			redirect( 'home', 'refresh' );
		
		}
		
		$item = explode( '-', $_POST['item'] );
		
		$id  = $item[0];
		
		if( $item[1] == 1 ) 	$field = 'vida';
		if( $item[1] == 2 ) 	$field = 'gmm';
		if( $item[1] == 3 ) 	$field = 'autos';
		
		
		$data = array( $field => $_POST['value'] );
		
		$this->load->model( array( 'simulators' ) );
		
		if( $this->simulators-> update( 'simulator_default_estacionalidad', $id, $data ) == true )
			
			echo true;
		
		else
			
			echo false;
		
		exit;		
		
	}
	
/* End of file simulator.php */
/* Location: ./application/controllers/simulator.php */
}
?>