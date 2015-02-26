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
			case (( $prima_afectadas >= 530000 ) && ( $negocios >= 2 ) && ( $negocios < 4 )):
				$porcentaje = 15;
				break;
			case (( $prima_afectadas >= 530000 ) && ( $negocios >= 4 ) && ( $negocios < 6 )):
				$porcentaje = 30;
				break;
			case (( $prima_afectadas >= 530000 ) && ( $negocios >= 6 ) && ( $negocios < 9 )):		
				$porcentaje = 35;
				break;
			case (( $prima_afectadas >= 530000 ) && ( $negocios >= 9 )):		
				$porcentaje = 40;
				break;
			case (($prima_afectadas >= 420000 ) && ($prima_afectadas < 530000 ) && ( $negocios >= 2 ) && ( $negocios < 4 )):		
				$porcentaje = 13;
				break;
			case (($prima_afectadas >= 420000 ) && ($prima_afectadas < 530000 ) && ( $negocios >= 4 ) && ( $negocios < 6 )):		
				$porcentaje = 28;
				break;
			case (($prima_afectadas >= 420000 ) && ($prima_afectadas < 530000 ) && ( $negocios >= 6 ) && ( $negocios < 9 )):		
				$porcentaje = 32.5;
				break;
			case (($prima_afectadas >= 420000 ) && ($prima_afectadas < 530000 ) && ( $negocios >= 9 )):		
				$porcentaje = 36;
				break;
///////////////////
			case (($prima_afectadas >= 320000 ) && ($prima_afectadas < 420000 ) && ( $negocios >= 2 ) && ( $negocios < 4 )):		
				$porcentaje = 11;
				break;
			case (($prima_afectadas >= 320000 ) && ($prima_afectadas < 420000 ) && ( $negocios >= 4 ) && ( $negocios < 6 )):		
				$porcentaje = 26;
				break;
			case (($prima_afectadas >= 320000 ) && ($prima_afectadas < 420000 ) && ( $negocios >= 6 ) && ( $negocios < 9 )):		
				$porcentaje = 30;
				break;
			case (($prima_afectadas >= 320000 ) && ($prima_afectadas < 420000 ) && ( $negocios >= 9 )):		
				$porcentaje = 32.5;
				break;
///////////////////
			case (($prima_afectadas >= 240000 ) && ($prima_afectadas < 320000 ) && ( $negocios >= 2 ) && ( $negocios < 4 )):		
				$porcentaje = 8;
				break;
			case (($prima_afectadas >= 240000 ) && ($prima_afectadas < 320000 ) && ( $negocios >= 4 ) && ( $negocios < 6 )):		
				$porcentaje = 19;
				break;
			case (($prima_afectadas >= 240000 ) && ($prima_afectadas < 320000 ) && ( $negocios >= 6 ) && ( $negocios < 9 )):		
				$porcentaje = 22.5;
				break;
			case (($prima_afectadas >= 240000 ) && ($prima_afectadas < 320000 ) && ( $negocios >= 9 )):		
				$porcentaje = 25;
				break;
///////////////////
			case (($prima_afectadas >= 190000 ) && ($prima_afectadas < 240000 ) && ( $negocios >= 2 ) && ( $negocios < 4 )):		
				$porcentaje = 7;
				break;
			case (($prima_afectadas >= 190000 ) && ($prima_afectadas < 240000 ) && ( $negocios >= 4 ) && ( $negocios < 6 )):		
				$porcentaje = 16;
				break;
			case (($prima_afectadas >= 190000 ) && ($prima_afectadas < 240000 ) && ( $negocios >= 6 ) && ( $negocios < 9 )):		
				$porcentaje = 20;
				break;
			case (($prima_afectadas >= 190000 ) && ($prima_afectadas < 240000 ) && ( $negocios >= 9 )):		
				$porcentaje = 22.5;
				break;
///////////////////
			case (($prima_afectadas >= 140000 ) && ($prima_afectadas < 190000 ) && ( $negocios >= 2 ) && ( $negocios < 4 )):		
				$porcentaje = 6;
				break;
			case (($prima_afectadas >= 140000 ) && ($prima_afectadas < 190000 ) && ( $negocios >= 4 ) && ( $negocios < 6 )):		
				$porcentaje = 13;
				break;
			case (($prima_afectadas >= 140000 ) && ($prima_afectadas < 190000 ) && ( $negocios >= 6 ) && ( $negocios < 9 )):		
				$porcentaje = 17.5;
				break;
			case (($prima_afectadas >= 140000 ) && ($prima_afectadas < 190000 ) && ( $negocios >= 9 )):		
				$porcentaje = 20;
				break;
///////////////////
			case (($prima_afectadas >= 100000 ) && ($prima_afectadas < 140000 ) && ( $negocios >= 2 ) && ( $negocios < 4 )):		
				$porcentaje = 5;
				break;
			case (($prima_afectadas >= 100000 ) && ($prima_afectadas < 140000 ) && ( $negocios >= 4 ) && ( $negocios < 6 )):		
				$porcentaje = 10;
				break;
			case (($prima_afectadas >= 100000 ) && ($prima_afectadas < 140000 ) && ( $negocios >= 6 ) && ( $negocios < 9 )):		
				$porcentaje = 15;
				break;
			case (($prima_afectadas >= 100000 ) && ($prima_afectadas < 140000 ) && ( $negocios >= 9 )):		
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
			case (($base == 0) && ($prima_afectadas >= 470000)):
				$porcentaje = 11;
				break;
			case (($base == 0) && ($prima_afectadas >= 370000) && ($prima_afectadas < 470000)):
				$porcentaje = 10;
				break;
			case (($base == 0) && ($prima_afectadas >= 270000) && ($prima_afectadas < 370000)):
				$porcentaje = 9;
				break;
			case (($base == 0) && ($prima_afectadas >= 220000) && ($prima_afectadas < 270000)):
				$porcentaje = 7;
				break;
			case (($base == 0) && ($prima_afectadas >= 160000) && ($prima_afectadas < 220000)):
				$porcentaje = 5;
				break;
			case (($base == 0) && ($prima_afectadas >= 130000) && ($prima_afectadas < 160000)):
				$porcentaje = 4;
				break;
			case (($base == 0) && ($prima_afectadas >= 100000) && ($prima_afectadas < 130000)):
				$porcentaje = 2;
				break;
//////////////
			case (($base == 89) && ($prima_afectadas >= 470000)):
				$porcentaje = 9;
				break;
			case (($base == 89) && ($prima_afectadas >= 370000) && ($prima_afectadas < 470000)):
				$porcentaje = 8;
				break;
			case (($base == 89) && ($prima_afectadas >= 270000) && ($prima_afectadas < 370000)):
				$porcentaje = 7;
				break;
			case (($base == 89) && ($prima_afectadas >= 220000) && ($prima_afectadas < 270000)):
				$porcentaje = 4;
				break;
			case (($base == 89) && ($prima_afectadas >= 160000) && ($prima_afectadas < 220000)):
				$porcentaje = 3;
				break;
			case (($base == 89) && ($prima_afectadas >= 130000) && ($prima_afectadas < 160000)):
				$porcentaje = 2;
				break;
			case (($base == 89) && ($prima_afectadas >= 100000) && ($prima_afectadas < 130000)):
				$porcentaje = 1;
				break;
//////////////
			case (($base == 91) && ($prima_afectadas >= 470000)):
				$porcentaje = 10;
				break;
			case (($base == 91) && ($prima_afectadas >= 370000) && ($prima_afectadas < 470000)):
				$porcentaje = 9;
				break;
			case (($base == 91) && ($prima_afectadas >= 270000) && ($prima_afectadas < 370000)):
				$porcentaje = 8;
				break;
			case (($base == 91) && ($prima_afectadas >= 220000) && ($prima_afectadas < 270000)):
				$porcentaje = 5;
				break;
			case (($base == 91) && ($prima_afectadas >= 160000) && ($prima_afectadas < 220000)):
				$porcentaje = 4;
				break;
			case (($base == 91) && ($prima_afectadas >= 130000) && ($prima_afectadas < 160000)):
				$porcentaje = 3;
				break;
			case (($base == 91) && ($prima_afectadas >= 100000) && ($prima_afectadas < 130000)):
				$porcentaje = 2;
				break;
			case (($base == 91) && ($prima_afectadas >= 470000)):
				$porcentaje = 10;
				break;
			case (($base == 91) && ($prima_afectadas >= 370000) && ($prima_afectadas < 470000)):
				$porcentaje = 9;
				break;
			case (($base == 91) && ($prima_afectadas >= 270000) && ($prima_afectadas < 370000)):
				$porcentaje = 8;
				break;
			case (($base == 91) && ($prima_afectadas >= 220000) && ($prima_afectadas < 270000)):
				$porcentaje = 5;
				break;
			case (($base == 91) && ($prima_afectadas >= 160000) && ($prima_afectadas < 220000)):
				$porcentaje = 4;
				break;
			case (($base == 91) && ($prima_afectadas >= 130000) && ($prima_afectadas < 160000)):
				$porcentaje = 3;
				break;
			case (($base == 91) && ($prima_afectadas >= 100000) && ($prima_afectadas < 130000)):
				$porcentaje = 2;
				break;
//////////////
			case (($base == 93) && ($prima_afectadas >= 470000)):
				$porcentaje = 11;
				break;
			case (($base == 93) && ($prima_afectadas >= 370000) && ($prima_afectadas < 470000)):
				$porcentaje = 10;
				break;
			case (($base == 93) && ($prima_afectadas >= 270000) && ($prima_afectadas < 370000)):
				$porcentaje = 9;
				break;
			case (($base == 93) && ($prima_afectadas >= 220000) && ($prima_afectadas < 270000)):
				$porcentaje = 6;
				break;
			case (($base == 93) && ($prima_afectadas >= 160000) && ($prima_afectadas < 220000)):
				$porcentaje = 5;
				break;
			case (($base == 93) && ($prima_afectadas >= 130000) && ($prima_afectadas < 160000)):
				$porcentaje = 4;
				break;
			case (($base == 93) && ($prima_afectadas >= 100000) && ($prima_afectadas < 130000)):
				$porcentaje = 3;
				break;
/////////////
			case (($base == 95) && ($prima_afectadas >= 470000)):
				$porcentaje = 12;
				break;
			case (($base == 95) && ($prima_afectadas >= 370000) && ($prima_afectadas < 470000)):
				$porcentaje = 11;
				break;
			case (($base == 95) && ($prima_afectadas >= 270000) && ($prima_afectadas < 370000)):
				$porcentaje = 10;
				break;
			case (($base == 95) && ($prima_afectadas >= 220000) && ($prima_afectadas < 270000)):
				$porcentaje = 7;
				break;
			case (($base == 95) && ($prima_afectadas >= 160000) && ($prima_afectadas < 220000)):
				$porcentaje = 6;
				break;
			case (($base == 95) && ($prima_afectadas >= 130000) && ($prima_afectadas < 160000)):
				$porcentaje = 5;
				break;
			case (($base == 95) && ($prima_afectadas >= 100000) && ($prima_afectadas < 130000)):
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
			case ($prima >= 420000):
				$porcentaje = 15;
				break;
			case (($prima >= 310000) && ($prima < 420000)):
				$porcentaje = 12;
				break;
			case (($prima >= 210000) && ($prima < 310000)):
				$porcentaje = 10;
				break;
			case (($prima >= 150000) && ($prima < 210000)):
				$porcentaje = 7.5;
				break;
			case (($prima >= 90000) && ($prima < 150000)):
				$porcentaje = 5;
				break;
			case ($prima < 90000):
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
			case (($sinistrad == 68) && ($prima >= 470000)):
				$porcentaje = 3;
				break;
			case (($sinistrad == 64) && ($prima >= 470000)):
				$porcentaje = 5;
				break;
			case (($sinistrad == 60) && ($prima >= 470000)):
				$porcentaje = 8;
				break;				
/////////////
			case (($sinistrad == 68) && ($prima >= 370000) && ($prima < 470000)):
				$porcentaje = 2;
				break;
			case (($sinistrad == 64) && ($prima >= 370000) && ($prima < 470000)):
				$porcentaje = 4;
				break;
			case (($sinistrad == 60) && ($prima >= 370000) && ($prima < 470000)):
				$porcentaje = 6;
				break;					
/////////////
			case (($sinistrad == 68) && ($prima >= 260000) && ($prima < 370000)):
				$porcentaje = 1.5;
				break;
			case (($sinistrad == 64) && ($prima >= 260000) && ($prima < 370000)):
				$porcentaje = 3;
				break;
			case (($sinistrad == 60) && ($prima >= 260000) && ($prima < 370000)):
				$porcentaje = 4.5;
				break;	
/////////////
			case (($sinistrad == 68) && ($prima >= 190000) && ($prima < 260000)):
				$porcentaje = 1;
				break;
			case (($sinistrad == 64) && ($prima >= 190000) && ($prima < 260000)):
				$porcentaje = 2;
				break;
			case (($sinistrad == 60) && ($prima >= 190000) && ($prima < 260000)):
				$porcentaje = 3;
				break;
/////////////
			case (($sinistrad == 68) && ($prima >= 140000) && ($prima < 190000)):
				$porcentaje = 0.5;
				break;
			case (($sinistrad == 64) && ($prima >= 140000) && ($prima < 190000)):
				$porcentaje = 1;
				break;
			case (($sinistrad == 60) && ($prima >= 140000) && ($prima < 190000)):
				$porcentaje = 2;
				break;
/////////////
/*			case (($sinistrad == 68) && ($prima < 140000)):
				$porcentaje = 0;
				break;
			case (($sinistrad == 64) && ($prima < 140000)):
				$porcentaje = 1;
				break;
			case (($sinistrad == 60) && ($prima < 140000)):
				$porcentaje = 2;
				break;					
*/
			default:
				break;
		}
		return $porcentaje;
	}
}
