// JavaScript Document
/*

  Author		Ulises Rodríguez
  Site:			http://www.ulisesrodriguez.com	
  Twitter:		https://twitter.com/#!/isc_ulises
  Facebook:		http://www.facebook.com/ISC.Ulises
  Github:		https://github.com/ulisesrodriguez
  Email:		ing.ulisesrodriguez@gmail.com
  Skype:		systemonlinesoftware
  Location:		Guadalajara Jalisco Mexíco
  
  GMM Scripts
  	
*/ 
$( document ).ready(function() {
	
	$( '#primasnetasiniciales' ).bind( 'keyup', function(){  
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasAfectasInicialesPagar' ).val( total );
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) / parseFloat($( '#primaspromedio' ).val().replace( '%', '' ));	
		$( '#nonegocios' ).val( Math.ceil(total) );
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) / parseFloat($( '#nonegocios' ).val().replace( '%', '' ));	
		//$( '#primaspromedio' ).val( Math.ceil(total) );
		//porAcotamiento
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasAfectasInicialesPagar' ).val( total );
		//primasRenovacion
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasRenovacionPagar' ).val( total );
		//comisionVentaInicial
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionesVentaInicial' ).val( total );	
		// Bonos de primer año
		var primasnetasiniciales = parseFloat( $( '#primasnetasiniciales' ).val() );
		if( primasnetasiniciales/3 > 300000 && primasnetasiniciales/3 <= 400000 ){
			$( '#bonoAplicado' ).val( 15.0+'%' );
			var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat( 15/100 );	
			$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
			$( '#ingresoBonoProductividad' ).val( total );
		}
		if( primasnetasiniciales/3 > 200000 && primasnetasiniciales/3 <= 300000 ){
			$( '#bonoAplicado' ).val( 12.0+'%' );
			var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat( 12/100 );	
			$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
			$( '#ingresoBonoProductividad' ).val( total );
		}
		if( primasnetasiniciales/3 > 150000 && primasnetasiniciales/3 <= 200000 ){
			$( '#bonoAplicado' ).val( 10.0+'%' );
			var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat( 10/100 );	
			$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
			$( '#ingresoBonoProductividad' ).val( total );
		}
		if( primasnetasiniciales/3 > 100000 && primasnetasiniciales/3 <= 150000 ){
			$( '#bonoAplicado' ).val( 7.5+'%' );
			var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat( 7.5/100 );	
			$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
			$( '#ingresoBonoProductividad' ).val( total );
		}
		
		if( primasnetasiniciales/3 == 100000 ){
			$( '#bonoAplicado' ).val( 5+'%' );
			var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat( 5/100 );	
			$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
			$( '#ingresoBonoProductividad' ).val( total );
		}
		//Ingreso por bono de renovación:
		var primasnetasiniciales = parseFloat( $( '#primasnetasiniciales' ).val() );
		var siniestridad = $( '#porsiniestridad' ).val();
		if( primasnetasiniciales/3 >= 450000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 8+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (8/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 >= 350000 && primasnetasiniciales/3 < 450000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 4+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (4/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 6+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (6/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}		
		if( primasnetasiniciales/3 >= 250000 && primasnetasiniciales/3 < 350000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 1.5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 4.5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (4.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 >= 180000 && primasnetasiniciales/3 < 250000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 1+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 >= 130000 && primasnetasiniciales/3 < 180000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( .5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 1+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}	
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});	
	
	$( '#nonegocios' ).bind( 'keyup', function(){
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) / parseFloat($( '#nonegocios' ).val().replace( '%', '' ));	
		//$( '#primaspromedio' ).val( Math.ceil(total) );
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});
	
	$( '#primaspromedio' ).bind( 'keyup', function(){
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) / parseFloat($( '#primaspromedio' ).val().replace( '%', '' ));	
		$( '#nonegocios' ).val( Math.ceil(total) );
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});
	
	$( '#porAcotamiento' ).bind( 'keyup', function(){
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasAfectasInicialesPagar' ).val( total );
		var primasnetasiniciales = parseFloat( $( '#primasnetasiniciales' ).val() );
		var siniestridad = $( '#porsiniestridad' ).val();
		if( primasnetasiniciales/3 >= 450000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 8+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (8/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 >= 350000 && primasnetasiniciales/3 < 450000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 4+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (4/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 6+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (6/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}		
		if( primasnetasiniciales/3 >= 250000 && primasnetasiniciales/3 < 350000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 1.5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 4.5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (4.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 >= 180000 && primasnetasiniciales/3 < 250000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 1+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 >= 130000 && primasnetasiniciales/3 < 180000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( .5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 1+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});	
	
	$( '#primasRenovacion' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasRenovacionPagar' ).val( total );
		//comisionVentaRenovacion
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionRenovacion' ).val( total );
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});
	
	$( '#XAcotamiento' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasRenovacionPagar' ).val( total );		
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});
	$( '#comisionVentaInicial' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionesVentaInicial' ).val( total );		
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});
	
	$( '#comisionVentaRenovacion' ).bind( 'keyup', function(){
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionRenovacion' ).val( total );
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});
	
	$( '#porsiniestridad' ).bind( 'change', function(){
		var primasnetasiniciales = parseFloat( $( '#primasnetasiniciales' ).val() );
		var siniestridad = $( '#porsiniestridad' ).val();
		if( primasnetasiniciales/3 > 350000 && primasnetasiniciales/3 <= 450000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 8+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (8/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 > 250000 && primasnetasiniciales/3 <= 350000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 4+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (4/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 6+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (6/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}		
		if( primasnetasiniciales/3 > 180000 && primasnetasiniciales/3 <= 250000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 1.5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 4.5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (4.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 > 130000 && primasnetasiniciales/3 <= 180000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( 1+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 3+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (3/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}
		if( primasnetasiniciales/3 >= 130000 ){
			if( siniestridad == '68' ){
				$( '#porbonoganado' ).val( .5+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (.5/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '64' ){
				$( '#porbonoganado' ).val( 1+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (1/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
			if( siniestridad == '60' ){
				$( '#porbonoganado' ).val( 2+'%' );
				var total = parseFloat( $( '#primasnetasiniciales' ).val() ) * (2/100);	
				$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
				$( '#ingresoBonoRenovacion' ).val( total );	
			}
		}		
		gmm_ingresototal(); gmm_ingresopromedio();	getMetas();
	});
		gmm_ingresototal(); gmm_ingresopromedio();	
});
function gmm_ingresototal(){
	var ingresoComisionesVentaInicial = parseFloat( $( '#ingresoComisionesVentaInicial' ).val() );
	var ingresoComisionRenovacion = parseFloat( $( '#ingresoComisionRenovacion' ).val() );
	var ingresoBonoProductividad = parseFloat( $( '#ingresoBonoProductividad' ).val() );
	var ingresoBonoRenovacion = parseFloat( $( '#ingresoBonoRenovacion' ).val() );
	var total = ingresoComisionesVentaInicial;
		total += ingresoComisionRenovacion;
		total += ingresoBonoProductividad;
		total += ingresoBonoRenovacion;
		$( '#ingresoTotal_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoTotal' ).val( total );
	
}
function gmm_ingresopromedio(){
	var ingresoTotal = parseFloat( $( '#ingresoTotal' ).val() );
	var periodo = parseInt( $( '#periodo' ).val() );
	var total = ingresoTotal/periodo;
		$( '#inresoPromedioMensual_text' ).html( '$ '+moneyFormat(total) );
		$( '#inresoPromedioMensual' ).val( total );
	
}