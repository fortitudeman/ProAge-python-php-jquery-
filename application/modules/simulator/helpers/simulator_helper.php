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
		$NegociosLogrados = array();
		$PrimasLogradas = array();

		if( $trimestre == 1 ){			
			$SolicitudesLogradas = array(
				'01' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '01', $year ),
				'02' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '02', $year ),
				'03' => $CI->simulators->getSolicitudLograda( $agentid, $product_group_id, '03', $year )
			);			
			$NegociosLogrados = array(
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
			$NegociosLogrados = array(
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
			$NegociosLogrados = array(
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
			$NegociosLogrados = array(
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
		  'NegociosLogrados' => $NegociosLogrados,	
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

