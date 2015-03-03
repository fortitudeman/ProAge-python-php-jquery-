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
/*
	Prepare meta and simulator data
	TODO: adapt this to simulator module (currently made for director module)
*/
if ( ! function_exists('simulator_view'))
{
	function simulator_view( $users, $userid = null, $agentid = null, $ramo = null )
	{
		if (!$agentid || !$ramo || !$userid)
			return false;

		$ramo_simulator = array(
			1 => 'vida',
			2 => 'gmm',
			3 => 'autos');
		if (isset($ramo_simulator[$ramo]))
			$simulator = $ramo_simulator[$ramo];
		else
			$simulator = 'vida';

		$CI =& get_instance();
		$data = $CI->simulators->getByAgent( $agentid, $ramo );	
		$product_group_id = 1;
		if( !empty( $data[0] ) )
			$product_group_id =  $data[0]['data']->ramo;

		$trimestre = null;	
		$cuatrimestre = null;
		$year = date('Y');
		$month = date('m');
		if( $product_group_id == 1 )
			$trimestre = $CI->simulators->trimestre( $month );
		else					
			$cuatrimestre = $CI->simulators->cuatrimestre( $month );
		
		$SolicitudesLogradas = array();
		$negociosLogrados = array();
		$PrimasLogradas = array();

		if( $trimestre == 1 ){			
			$SolicitudesLogradas = array(
				'01' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '01', $year ),
				'02' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '02', $year ),
				'03' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '03', $year )
			);			
			$negociosLogrados = array(
				'01' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '01', $year ),
				'02' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '02', $year ),
				'03' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '03', $year )
			);			
			$PrimasLogradas = array(
				'01' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '01', $year ),
				'02' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '02', $year ),
				'03' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '03', $year )
			);			
		} 	
		if( $trimestre == 2 ){			
			$SolicitudesLogradas = array(
				'04' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '04', $year ),
				'05' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '05', $year ),
				'06' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '06', $year )
			);			
			$negociosLogrados = array(
				'04' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '04', $year ),
				'05' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '05', $year ),
				'06' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '06', $year ),
			);
			$PrimasLogradas = array(
				'04' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '04', $year ),
				'05' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '05', $year ),
				'06' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '06', $year ),
			);			
		} 
		if( $trimestre == 3 ){			
			$SolicitudesLogradas = array(
				'07' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '07', $year ),
				'08' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '08', $year ),
				'09' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '09', $year ),
			);			
			$negociosLogrados = array(
				'07' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '07', $year ),
				'08' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '08', $year ),
				'09' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '09', $year ),
			);			
			$PrimasLogradas = array(
				'07' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '07', $year ),
				'08' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '08', $year ),
				'09' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '09', $year ),
			);
		} 		
		if( $trimestre == 4 ){			
			$SolicitudesLogradas = array(
				'10' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '10', $year ),
				'11' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '11', $year ),
				'12' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '12', $year )
			);
			$negociosLogrados = array(
				'10' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '10', $year ),
				'11' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '11', $year ),
				'12' => $CI->simulators->getNegociosLograda( $agentid, $product_group_id, '12', $year )
			);			
			$PrimasLogradas = array(
				'10' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '10', $year ),
				'11' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '11', $year ),
				'12' => $CI->simulators->getPrimasLograda( $agentid, $product_group_id, '12', $year )
			);
		} 		
		$settingmeta = '';
		$ShowMeta = $simulator;
	
		$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "'.$ShowMeta.'" ); getMetas(); }); </script>';
		if( !empty( $data ) )			
			if( $data[0]['data']->ramo == 1 ){ 
				$simulator = 'vida';
				$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "vida" ); $( "#metas-prima-promedio" ).val( '.$data[0]['data']->primas_promedio.' ); getMetas(); }); </script>'; 
			} else if( $data[0]['data']->ramo == 2 ){
				$simulator = 'gmm';
				$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "gmm" ); $( "#metas-prima-promedio" ).val( '.$data[0]['data']->primaspromedio.' ); getMetas(); }); </script>'; 
			} else if( $data[0]['data']->ramo == 3 ){
				$simulator = 'autos';
				$requestPromedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "autos" ); $( "#metas-prima-promedio" ).val( '.$data[0]['data']->primaspromedio.' ); getMetas(); }); </script>'; 
			}

		// Config view
		$base_url = base_url();
		$uri_segments = $CI->uri->rsegment_array();
		$js_assets = array(
			'<script type="text/javascript">Config.currentModule = "' . $uri_segments[1] . '";</script>',
			'<script type="text/javascript" src="'. $base_url .'simulator/assets/scripts/metas_simulator.js"></script>',			
		);

		if ($CI->for_print) {
			$css = array(
		  	'<link href="'. base_url() .'simulator/assets/style/simulator.css" rel="stylesheet">',
		  	'<link href="'. base_url() .'simulator/assets/style/simulator_print.css" rel="stylesheet">',
		  );
		  $add_js = '
<script type="text/javascript">
$( document ).ready( function(){
	$("#open_meta").hide();
	$("#print-button").bind( "click", function(){
		$(this).hide(); window.print();
		window.close();
		return false;
		});
	$(".main-menu-span").removeClass("span2");
	$("#content").removeClass("span10").addClass("span12");
	$("#meta-footer td").css("font-size", "10px");
});
</script>
';
			if ($CI->print_meta)
				$js_assets[] = '<script type="text/javascript" src="'. $base_url .'simulator/assets/scripts/metas.js"></script>';
			else {
				$js_assets[] = '<script type="text/javascript" src="'. $base_url .'simulator/assets/scripts/simulator_'.$simulator.'.js"></script>';
				$requestPromedio = '';
			}
		} else {
			$css = array(
		  	'<link href="'. base_url() .'simulator/assets/style/simulator.css" rel="stylesheet" media="screen">'
		  );
		  $uri_segments_meta = $CI->uri->rsegment_array();
		  $uri_segments_simulator = $uri_segments_meta;
		  $uri_segments_meta[2] = 'print_index';
		  $uri_segments_simulator[2] = 'print_index_simulator';
		  $add_js = '
<script type="text/javascript">
$( document ).ready( function(){
	$("#meta-footer td").css("font-size", "18px");
	$("#print-button").bind( "click", function(){
		if ($(".simulator:visible").length > 0) {
			$(this).attr("href", "' . site_url($uri_segments_simulator) . '");
		} else {
			$(this).attr("href", "' . site_url($uri_segments_meta) . '");
		}
	});
});
</script>
';
			$js_assets[] = '<script type="text/javascript" src="'. $base_url .'simulator/assets/scripts/metas.js"></script>';
			$js_assets[] = '<script type="text/javascript" src="'. $base_url .'simulator/assets/scripts/simulator_'.$simulator.'.js"></script>';
		}
		$js_assets[] = $settingmeta;
		$js_assets[] = $requestPromedio;
		$js_assets[] = $add_js;

		$view = array(
		  'access_create' => $CI->access_create,
		  'access_update' => $CI->access_update,
		  'access_delete' => $CI->access_delete,
		  'css' => $css,
		  'scripts' => $js_assets,		  
		  'content' => 'simulator/overview',
		  'no_visible_elements_2' => true,
		  'userid' => $userid,
		  'agentid' => $agentid,
		  'data' =>  $data,		  	  
		  'config' => $CI->simulators->getConfigMetas( false, $trimestre, null ),		  
		  'SolicitudesLogradas' => $SolicitudesLogradas,
		  '$negociosLogrados' => $negociosLogrados,	
		  'PrimasLogradas' => $PrimasLogradas,
		  'trimestre' => $trimestre,
		  'cuatrimestre' => $cuatrimestre,
		  'periodo' => 3,
		  'ramo' => $simulator,
		  'product_group_id' => $product_group_id,
		  'users' => $users,
		  'show_meta' => $CI->show_meta,
		  'for_print' => $CI->for_print,
		  'print_meta' => $CI->print_meta
		);
		return $view;
	}
}
/*
	Prepare meta - new version
	TODO: adapt this to simulator module (currently made for director module)
*/
if ( ! function_exists('new_meta_view'))
{
	function new_meta_view( $users, $userid = null, $agentid = null, $ramo = null, $for_print = FALSE, $print_meta = FALSE )
	{
		if (!$agentid || !$ramo || !$userid)
			return false;

		$ramo_simulator = array(
			1 => 'vida',
			2 => 'gmm',
			3 => 'autos');
		if (isset($ramo_simulator[$ramo]))
			$simulator = $ramo_simulator[$ramo];
		else
			$simulator = 'vida';

		$CI =& get_instance();
		$period = 0;
		$year = $CI->input->post('year');
		if ($year === FALSE)
			$year = $CI->uri->rsegment(6);
		$year = ($year !== FALSE) ? $year : date('Y');

		$data = $CI->simulators->getByAgentNew('meta_new', $agentid, $ramo, $period, $year);
////////////
		$base_url = base_url();
		$request_promedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "' .
			$simulator .
			'" ); getMetas(); }); </script>';

		if( !empty( $data ) )
		{
			$request_promedio = '<script type="text/javascript">$( document ).ready( function(){ getMetasPeriod( "' .
				$simulator . '" ); $( "#metas-prima-promedio" ).val( '
				. $data[0]['data']->primas_promedio . 
				' ); getMetas(); }); </script>'; 
		}
		$module = $CI->uri->segment(1, 'director');

		// Config view
		$js_assets = array(
			'<script type="text/javascript" src="' . $base_url . 'scripts/config.js"></script>',
			'<script type="text/javascript">Config.currentModule = "' . $module . '";</script>',
			'<script type="text/javascript" src="' . $base_url . 'simulator/assets/scripts/metas_simulator.js"></script>',			
		);

		if ($for_print) {
			$css = array(
		  	'<link href="' . $base_url . 'simulator/assets/style/simulator.css" rel="stylesheet">',
		  	'<link href="' . $base_url . 'simulator/assets/style/simulator_print.css" rel="stylesheet">',
		  );
		  $add_js = '
<script type="text/javascript">
$( document ).ready( function(){
	$("#open_meta").hide();
	$("#print-button").bind( "click", function(){
		$(this).hide(); window.print(); window.close(); return false;}
	);
	$(".main-menu-span").removeClass("span2");
	$("#content").removeClass("span10").addClass("span12");
	$("#meta-footer td").css("font-size", "10px");
	
	if (!$("#print-button").hasClass("print-preview"))
		$("#reset-meta").hide();
});
</script>
';
			if ($print_meta)
				$js_assets[] = '<script type="text/javascript" src="' . $base_url . 'simulator/assets/scripts/metas.js"></script>';
			else {
				$js_assets[] = '<script type="text/javascript" src="' . $base_url . 'simulator/assets/scripts/simulator_'.$simulator.'.js"></script>';
				$request_promedio = '';
			}
		} else {
			$css = array(
		  	'<link href="' . $base_url . 'simulator/assets/style/simulator.css" rel="stylesheet" media="screen">'
				);
			$uri_segments_meta = $CI->uri->rsegment_array();
			$uri_segments_meta[5] = $period;
			$uri_segments_meta[6] = $year;			
			$uri_segments_simulator = $uri_segments_meta;
			$uri_segments_meta[2] = 'print_index';
			$uri_segments_simulator[2] = 'print_index_simulator';
			
			$add_js = '
<script type="text/javascript">
$( document ).ready( function(){
	$("#meta-footer td").css("font-size", "18px");
	$("#print-button").bind( "click", function(){
		if ($(".simulator:visible").length > 0) {
			$(this).attr("href", "' . site_url($uri_segments_simulator) . '");
		} else {
			$(this).attr("href", "' . site_url($uri_segments_meta) . '");
		}
	});
});
</script>
';
			$js_assets[] = '<script type="text/javascript" src="' . $base_url . 'simulator/assets/scripts/metas.js"></script>';
			$js_assets[] = '<script type="text/javascript" src="' . $base_url . 'simulator/assets/scripts/simulator_'.$simulator.'.js"></script>';
		}
		$js_assets[] = $request_promedio;
		$js_assets[] = $add_js;

		$CI->load->helper('filter');
		$agent_array = $CI->user->getAgents( FALSE );
		$js_assets[] = get_agent_autocomplete_js($agent_array, '#form');
		$other_filters = array(
			'agent_name' => '',
		);
		get_generic_filter($other_filters, $agent_array);

		$view = array(
		  'css' => $css,
		  'scripts' => $js_assets,		  
		  'content' => 'simulator/overview',
		  'userid' => $userid,
		  'agentid' => $agentid,
		  'data' =>  $data,		  	  
		  'config' => $CI->simulators->getConfigMetas( false, null, null ),	
		  'SolicitudesLogradas' => array(),
		  '$negociosLogrados' => array(),	
		  'PrimasLogradas' => array(),
		  'trimestre' => null,
		  'cuatrimestre' => null,
		  'periodo' => 3,
		  'ramo' => $simulator,
		  'users' => $users,
		  'for_print' => $for_print,
		  'print_meta' => $print_meta,
		  'selected_year' => $year,
		  'other_filters' => $other_filters,
		);
		return $view;
	}
}
/*
	Helper for bonos - venta inicial (vida)
*/
if ( ! function_exists('calc_perc_bono_aplicado'))
{
	function calc_perc_bono_aplicado( $prima_afectadas, $negocios, $base = 0 )
	{
		$porcentaje = 0;
		if (($base == 'm89') || ($base == 89))
			return $porcentaje;
		switch (TRUE)
		{
			case (( $prima_afectadas >= 560000 ) && ( $negocios >= 3 ) && ( $negocios < 5 )):
				$porcentaje = 15;
				break;
			case (( $prima_afectadas >= 560000 ) && ( $negocios >= 5 ) && ( $negocios < 7 )):
				$porcentaje = 30;
				break;
			case (( $prima_afectadas >= 560000 ) && ( $negocios >= 7 ) && ( $negocios < 9 )):		
				$porcentaje = 35;
				break;
			case (( $prima_afectadas >= 560000 ) && ( $negocios >= 9 )):		
				$porcentaje = 40;
				break;
			case (($prima_afectadas >= 440000 ) && ($prima_afectadas < 560000 ) && ( $negocios >= 3 ) && ( $negocios < 5 )):		
				$porcentaje = 13;
				break;
			case (($prima_afectadas >= 440000 ) && ($prima_afectadas < 560000 ) && ( $negocios >= 5 ) && ( $negocios < 7 )):		
				$porcentaje = 28;
				break;
			case (($prima_afectadas >= 440000 ) && ($prima_afectadas < 560000 ) && ( $negocios >= 7 ) && ( $negocios < 9 )):		
				$porcentaje = 32.5;
				break;
			case (($prima_afectadas >= 440000 ) && ($prima_afectadas < 560000 ) && ( $negocios >= 9 )):		
				$porcentaje = 36;
				break;
///////////////////
			case (($prima_afectadas >= 340000 ) && ($prima_afectadas < 440000 ) && ( $negocios >= 3 ) && ( $negocios < 5 )):		
				$porcentaje = 11;
				break;
			case (($prima_afectadas >= 340000 ) && ($prima_afectadas < 440000 ) && ( $negocios >= 5 ) && ( $negocios < 7 )):		
				$porcentaje = 26;
				break;
			case (($prima_afectadas >= 340000 ) && ($prima_afectadas < 440000 ) && ( $negocios >= 7 ) && ( $negocios < 9 )):		
				$porcentaje = 30;
				break;
			case (($prima_afectadas >= 340000 ) && ($prima_afectadas < 440000 ) && ( $negocios >= 9 )):		
				$porcentaje = 32.5;
				break;
///////////////////
			case (($prima_afectadas >= 250000 ) && ($prima_afectadas < 340000 ) && ( $negocios >= 3 ) && ( $negocios < 5 )):		
				$porcentaje = 8;
				break;
			case (($prima_afectadas >= 250000 ) && ($prima_afectadas < 340000 ) && ( $negocios >= 5 ) && ( $negocios < 7 )):		
				$porcentaje = 19;
				break;
			case (($prima_afectadas >= 250000 ) && ($prima_afectadas < 340000 ) && ( $negocios >= 7 ) && ( $negocios < 9 )):		
				$porcentaje = 22.5;
				break;
			case (($prima_afectadas >= 250000 ) && ($prima_afectadas < 340000 ) && ( $negocios >= 9 )):		
				$porcentaje = 25;
				break;
///////////////////
			case (($prima_afectadas >= 200000 ) && ($prima_afectadas < 250000 ) && ( $negocios >= 3 ) && ( $negocios < 5 )):		
				$porcentaje = 7;
				break;
			case (($prima_afectadas >= 200000 ) && ($prima_afectadas < 250000 ) && ( $negocios >= 5 ) && ( $negocios < 7 )):		
				$porcentaje = 16;
				break;
			case (($prima_afectadas >= 200000 ) && ($prima_afectadas < 250000 ) && ( $negocios >= 7 ) && ( $negocios < 9 )):		
				$porcentaje = 20;
				break;
			case (($prima_afectadas >= 200000 ) && ($prima_afectadas < 250000 ) && ( $negocios >= 9 )):		
				$porcentaje = 22.5;
				break;
///////////////////
			case (($prima_afectadas >= 150000 ) && ($prima_afectadas < 200000 ) && ( $negocios >= 3 ) && ( $negocios < 5 )):		
				$porcentaje = 6;
				break;
			case (($prima_afectadas >= 150000 ) && ($prima_afectadas < 200000 ) && ( $negocios >= 5 ) && ( $negocios < 7 )):		
				$porcentaje = 13;
				break;
			case (($prima_afectadas >= 150000 ) && ($prima_afectadas < 200000 ) && ( $negocios >= 7 ) && ( $negocios < 9 )):		
				$porcentaje = 17.5;
				break;
			case (($prima_afectadas >= 150000 ) && ($prima_afectadas < 200000 ) && ( $negocios >= 9 )):		
				$porcentaje = 20;
				break;
///////////////////
			case (($prima_afectadas >= 105000 ) && ($prima_afectadas < 150000 ) && ( $negocios >= 3 ) && ( $negocios < 5 )):		
				$porcentaje = 5;
				break;
			case (($prima_afectadas >= 105000 ) && ($prima_afectadas < 150000 ) && ( $negocios >= 5 ) && ( $negocios < 7 )):		
				$porcentaje = 10;
				break;
			case (($prima_afectadas >= 105000 ) && ($prima_afectadas < 150000 ) && ( $negocios >= 7 ) && ( $negocios < 9 )):		
				$porcentaje = 15;
				break;
			case (($prima_afectadas >= 105000 ) && ($prima_afectadas < 150000 ) && ( $negocios >= 9 )):		
				$porcentaje = 17.5;
				break;
		}
		return $porcentaje;
	}
}
/*
	Helper for bonos - conservacion (vida)
*/
if ( ! function_exists('calc_perc_conservacion'))
{
	function calc_perc_conservacion($base, $prima_afectadas)
	{
		$porcentaje = 0;
		if ($base == 'm89')
			return $porcentaje;
		switch (true)
		{
			case (($base == 0) && ($prima_afectadas >= 490000)):
				$porcentaje = 11;
				break;
			case (($base == 0) && ($prima_afectadas >= 390000) && ($prima_afectadas < 490000)):
				$porcentaje = 10;
				break;
			case (($base == 0) && ($prima_afectadas >= 280000) && ($prima_afectadas < 390000)):
				$porcentaje = 9;
				break;
			case (($base == 0) && ($prima_afectadas >= 230000) && ($prima_afectadas < 280000)):
				$porcentaje = 7;
				break;
			case (($base == 0) && ($prima_afectadas >= 170000) && ($prima_afectadas < 230000)):
				$porcentaje = 5;
				break;
			case (($base == 0) && ($prima_afectadas >= 140000) && ($prima_afectadas < 170000)):
				$porcentaje = 4;
				break;
			case (($base == 0) && ($prima_afectadas >= 105000) && ($prima_afectadas < 140000)):
				$porcentaje = 2;
				break;
//////////////
			case (($base == 89) && ($prima_afectadas >= 490000)):
				$porcentaje = 9;
				break;
			case (($base == 89) && ($prima_afectadas >= 390000) && ($prima_afectadas < 490000)):
				$porcentaje = 8;
				break;
			case (($base == 89) && ($prima_afectadas >= 280000) && ($prima_afectadas < 390000)):
				$porcentaje = 7;
				break;
			case (($base == 89) && ($prima_afectadas >= 230000) && ($prima_afectadas < 280000)):
				$porcentaje = 4;
				break;
			case (($base == 89) && ($prima_afectadas >= 170000) && ($prima_afectadas < 230000)):
				$porcentaje = 3;
				break;
			case (($base == 89) && ($prima_afectadas >= 140000) && ($prima_afectadas < 170000)):
				$porcentaje = 2;
				break;
			case (($base == 89) && ($prima_afectadas >= 105000) && ($prima_afectadas < 140000)):
				$porcentaje = 1;
				break;
//////////////
			case (($base == 91) && ($prima_afectadas >= 490000)):
				$porcentaje = 10;
				break;
			case (($base == 91) && ($prima_afectadas >= 390000) && ($prima_afectadas < 490000)):
				$porcentaje = 9;
				break;
			case (($base == 91) && ($prima_afectadas >= 280000) && ($prima_afectadas < 390000)):
				$porcentaje = 8;
				break;
			case (($base == 91) && ($prima_afectadas >= 230000) && ($prima_afectadas < 280000)):
				$porcentaje = 5;
				break;
			case (($base == 91) && ($prima_afectadas >= 170000) && ($prima_afectadas < 230000)):
				$porcentaje = 4;
				break;
			case (($base == 91) && ($prima_afectadas >= 140000) && ($prima_afectadas < 170000)):
				$porcentaje = 3;
				break;
			case (($base == 91) && ($prima_afectadas >= 105000) && ($prima_afectadas < 140000)):
				$porcentaje = 2;
				break;
			case (($base == 91) && ($prima_afectadas >= 490000)):
				$porcentaje = 10;
				break;
			case (($base == 91) && ($prima_afectadas >= 390000) && ($prima_afectadas < 490000)):
				$porcentaje = 9;
				break;
			case (($base == 91) && ($prima_afectadas >= 280000) && ($prima_afectadas < 390000)):
				$porcentaje = 8;
				break;
			case (($base == 91) && ($prima_afectadas >= 230000) && ($prima_afectadas < 280000)):
				$porcentaje = 5;
				break;
			case (($base == 91) && ($prima_afectadas >= 170000) && ($prima_afectadas < 230000)):
				$porcentaje = 4;
				break;
			case (($base == 91) && ($prima_afectadas >= 140000) && ($prima_afectadas < 170000)):
				$porcentaje = 3;
				break;
			case (($base == 91) && ($prima_afectadas >= 105000) && ($prima_afectadas < 140000)):
				$porcentaje = 2;
				break;
//////////////
			case (($base == 93) && ($prima_afectadas >= 490000)):
				$porcentaje = 11;
				break;
			case (($base == 93) && ($prima_afectadas >= 390000) && ($prima_afectadas < 490000)):
				$porcentaje = 10;
				break;
			case (($base == 93) && ($prima_afectadas >= 280000) && ($prima_afectadas < 390000)):
				$porcentaje = 9;
				break;
			case (($base == 93) && ($prima_afectadas >= 230000) && ($prima_afectadas < 280000)):
				$porcentaje = 6;
				break;
			case (($base == 93) && ($prima_afectadas >= 170000) && ($prima_afectadas < 230000)):
				$porcentaje = 5;
				break;
			case (($base == 93) && ($prima_afectadas >= 140000) && ($prima_afectadas < 170000)):
				$porcentaje = 4;
				break;
			case (($base == 93) && ($prima_afectadas >= 105000) && ($prima_afectadas < 140000)):
				$porcentaje = 3;
				break;
/////////////
			case (($base == 95) && ($prima_afectadas >= 490000)):
				$porcentaje = 12;
				break;
			case (($base == 95) && ($prima_afectadas >= 390000) && ($prima_afectadas < 490000)):
				$porcentaje = 11;
				break;
			case (($base == 95) && ($prima_afectadas >= 280000) && ($prima_afectadas < 390000)):
				$porcentaje = 10;
				break;
			case (($base == 95) && ($prima_afectadas >= 230000) && ($prima_afectadas < 280000)):
				$porcentaje = 7;
				break;
			case (($base == 95) && ($prima_afectadas >= 170000) && ($prima_afectadas < 230000)):
				$porcentaje = 6;
				break;
			case (($base == 95) && ($prima_afectadas >= 140000) && ($prima_afectadas < 170000)):
				$porcentaje = 5;
				break;
			case (($base == 95) && ($prima_afectadas >= 105000) && ($prima_afectadas < 140000)):
				$porcentaje = 5;
				break;
		}
		return $porcentaje;
	}
}
/*
	Helper for bonos - primas iniciales (gmm)
*/
if ( ! function_exists('get_inicial_gmm_percent'))
{
	function get_inicial_gmm_percent ($prima) {
		$porcentaje = 0;
		switch (true)
		{
			case ($prima >= 440000):
				$porcentaje = 15;
				break;
			case (($prima >= 330000) && ($prima < 440000)):
				$porcentaje = 12.5;
				break;
			case (($prima >= 220000) && ($prima < 330000)):
				$porcentaje = 10;
				break;
			case (($prima >= 160000) && ($prima < 220000)):
				$porcentaje = 7.5;
				break;
			case (($prima >= 95000) && ($prima < 160000)):
				$porcentaje = 5;
				break;
			case ($prima < 95000):
				$porcentaje = 0;
				break;
			default:
				break;
		}
		return $porcentaje;
	}
}
/*
	Helper for bonos - primas renovacion (gmm)
*/
if ( ! function_exists('get_renovacion_gmm_percent'))
{
	function get_renovacion_gmm_percent ($prima, $sinistrad) {
		$porcentaje = 0;
		switch (true)
		{
			case (($sinistrad == 68) && ($prima >= 490000)):
				$porcentaje = 3;
				break;
			case (($sinistrad == 64) && ($prima >= 490000)):
				$porcentaje = 5;
				break;
			case (($sinistrad == 60) && ($prima >= 490000)):
				$porcentaje = 8;
				break;				
/////////////
			case (($sinistrad == 68) && ($prima >= 390000) && ($prima < 490000)):
				$porcentaje = 2;
				break;
			case (($sinistrad == 64) && ($prima >= 390000) && ($prima < 490000)):
				$porcentaje = 4;
				break;
			case (($sinistrad == 60) && ($prima >= 390000) && ($prima < 490000)):
				$porcentaje = 6;
				break;					
/////////////
			case (($sinistrad == 68) && ($prima >= 270000) && ($prima < 390000)):
				$porcentaje = 1.5;
				break;
			case (($sinistrad == 64) && ($prima >= 270000) && ($prima < 390000)):
				$porcentaje = 3;
				break;
			case (($sinistrad == 60) && ($prima >= 270000) && ($prima < 390000)):
				$porcentaje = 4.5;
				break;	
/////////////
			case (($sinistrad == 68) && ($prima >= 200000) && ($prima < 270000)):
				$porcentaje = 1;
				break;
			case (($sinistrad == 64) && ($prima >= 200000) && ($prima < 270000)):
				$porcentaje = 2;
				break;
			case (($sinistrad == 60) && ($prima >= 200000) && ($prima < 270000)):
				$porcentaje = 3;
				break;
/////////////
			case (($sinistrad == 68) && ($prima >= 150000) && ($prima < 200000)):
				$porcentaje = 0.5;
				break;
			case (($sinistrad == 64) && ($prima >= 150000) && ($prima < 200000)):
				$porcentaje = 1;
				break;
			case (($sinistrad == 60) && ($prima >= 150000) && ($prima < 200000)):
				$porcentaje = 2;
				break;
/////////////
/*			case (($sinistrad == 68) && ($prima < 150000)):
				$porcentaje = 0;
				break;
			case (($sinistrad == 64) && ($prima < 150000)):
				$porcentaje = 1;
				break;
			case (($sinistrad == 60) && ($prima < 150000)):
				$porcentaje = 2;
				break;					
*/
			default:
				break;
		}
		return $porcentaje;
	}
}
