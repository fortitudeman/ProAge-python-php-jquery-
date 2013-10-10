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

  	
*/
$( document ).ready(function() {
    
	$( '#primasAfectasInicialesUbicar' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#porAcotamiento' ).val()/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+total );
		$( '#primasAfectasInicialesPagar' ).val( total );
		
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val()/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+total );
		$( '#ingresoComisionesVentaInicial' ).val( total );
		
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#bonoAplicado' ).val()/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+total );
		$( '#ingresoBonoProductividad' ).val( total );
	});
	
	
	$( '#porAcotamiento' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat(this.value/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+total );
		$( '#primasAfectasInicialesPagar' ).val( total );
	});
	
	
	$( '#primasRenovacion' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val()/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+total );
		$( '#primasRenovacionPagar' ).val( total );
		
		
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val()/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+total );
		$( '#ingresoBonoRenovacion' ).val( total );
		
	});
	
	
	$( '#XAcotamiento' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val()/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+total );
		$( '#primasRenovacionPagar' ).val( total );
	});
	
	$( '#comisionVentaInicial' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val()/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+total );
		$( '#ingresoComisionesVentaInicial' ).val( total );
	});
	
	$( '#bonoAplicado' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#bonoAplicado' ).val()/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+total );
		$( '#ingresoBonoProductividad' ).val( total );
	});
	
	$( '#porbonoGanado' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val()/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+total );
		$( '#ingresoBonoRenovacion' ).val( total );
	});
	
		
	
});

function ingresoTotal(){
	
	var total = 0;
		
		total += parseFloat( $( '#ingresoComisionesVentaInicial' ).val() );
		
		total += parseFloat( $( '#ingresoComisionRenovacion' ).val() );
		
		total += parseFloat( $( '#ingresoBonoProductividad' ).val() );
		
		total += parseFloat( $( '#ingresoBonoRenovacion' ).val() );
	
	$( '#ingresoTotal_text' ).html( '$ '+total );
	
	$( '#ingresoTotal' ).val( total );
}


function ingresoPromedio(){
	
	var total = parseFloat($( '#ingresoTotal' ).val());
	
	
	total = total/parseInt( $( '#periodo' ).val() );
	
	$( '#inresoPromedioMensual_text' ).html( '$ '+total );
	$( '#inresoPromedioMensual' ).val(total);
		
}