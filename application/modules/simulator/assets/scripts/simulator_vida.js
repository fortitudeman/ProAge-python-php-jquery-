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
	// % Bono Productividad
	$( "#noNegocios" ).bind( 'keyup', function(){ 		
		var primaAfectadas = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() );			
		var	negocios = parseInt( $( "#noNegocios" ).val() );		
		var porcentage = 0;			
		if( primaAfectadas >= 500000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 15;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 30;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 35;				
			if( negocios >= 8 )	porcentage = 40;			
		}		
		if( primaAfectadas >= 400000 && primaAfectadas < 500000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 13;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 28;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 32.5;				
			if( negocios >= 8 )	porcentage = 36;			
		}		
		if( primaAfectadas >= 300000 && primaAfectadas < 400000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 11;		
			if( negocios >= 3 && negocios < 5 )	porcentage = 26;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 30;				
			if( negocios >= 8 )	porcentage = 32.5;			
		}		
		if( primaAfectadas >= 230000 && primaAfectadas < 300000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 8;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 19;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 22.5;				
			if( negocios >= 8 )	porcentage = 25;			
		}		
		if( primaAfectadas >= 180000 && primaAfectadas < 230000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 7;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 16;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 20;				
			if( negocios >= 8 )	porcentage = 22.5;			
		}		
		if( primaAfectadas >= 130000 && primaAfectadas < 180000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 6;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 13;			
			if( negocios >= 5 && negocios < 8 )	porcentage = 17.5;			
			if( negocios >= 8 )	porcentage = 20;			
		}		
		if( primaAfectadas >= 100000 && primaAfectadas < 130000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 5;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 10;			
			if( negocios >= 5 && negocios < 8 )	porcentage = 15;			
			if( negocios >= 8 )	porcentage = 17.5;			
		}		
		$( '#bonoAplicado' ).val( porcentage );		
		// Primas Promedio
		var primas_promedio = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) / parseFloat( $( '#noNegocios' ).val() );		
		if( isNaN( primas_promedio ) ) primas_promedio = 0;		
		$( '#primas_promedio' ).val(primas_promedio)
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
		
	});
	$( "#primasAfectasInicialesUbicar" ).bind( 'keyup', function(){
		var primaAfectadas = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() );			
		var	negocios = parseInt( $( "#noNegocios" ).val() );		
		var porcentage = 0;			
		if( primaAfectadas >= 500000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 15;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 30;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 35;				
			if( negocios >= 8 )	porcentage = 40;
		}		
		if( primaAfectadas >= 400000 && primaAfectadas < 500000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 13;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 28;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 32.5;				
			if( negocios >= 8 )	porcentage = 36;			
		}		
		if( primaAfectadas >= 300000 && primaAfectadas < 400000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 11;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 26;			
			if( negocios >= 5 && negocios < 8 )	porcentage = 30;		
			if( negocios >= 8 )	porcentage = 32.5;			
		}		
		if( primaAfectadas >= 230000 && primaAfectadas < 300000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 8;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 19;			
			if( negocios >= 5 && negocios < 8 )	porcentage = 22.5;				
			if( negocios >= 8 )	porcentage = 25;			
		}		
		if( primaAfectadas >= 180000 && primaAfectadas < 230000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 7;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 16;				
			if( negocios >= 5 && negocios < 8 )	porcentage = 20;			
			if( negocios >= 8 )	porcentage = 22.5;			
		}		
		if( primaAfectadas >= 130000 && primaAfectadas < 180000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 6;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 13;			
			if( negocios >= 5 && negocios < 8 )	porcentage = 17.5;				
			if( negocios >= 8 )	porcentage = 20;		
		}		
		if( primaAfectadas >= 100000 && primaAfectadas < 130000 ){		
			if( negocios >= 1 && negocios < 3 )	porcentage = 5;			
			if( negocios >= 3 && negocios < 5 )	porcentage = 10;			
			if( negocios >= 5 && negocios < 8 )	porcentage = 15;			
			if( negocios >= 8 )	porcentage = 17.5;			
		}
		$( '#bonoAplicado' ).val( porcentage );		
		// Primas Promedio
		var noNegocios = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) / parseFloat( $( '#primas_promedio' ).val() );		
		if( isNaN( noNegocios ) ) noNegocios = 0;		
		$( '#noNegocios' ).val( noNegocios )			
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});	
	$( '#primas_promedio' ).bind( 'keyup', function(){ 		
		var negocios = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) / parseFloat( $( '#primas_promedio' ).val() );		
		if( isNaN( negocios ) ) negocios = 0;		
		$( '#noNegocios' ).val(round(negocios)+1);
		$( '#metas-prima-promedio' ).val(this.value);
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});	
	// Prima Promedio Meas
	$( "#metas-prima-promedio" ).bind( 'keyup', function(){ 		
		$( '#primas_promedio' ).val(this.value);	
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	// % Bono Renovacion
	$( "#porcentajeConservacion" ).bind( 'change', function(){ 	
		var primaAfectadas = parseFloat( $( '#primasRenovacionPagar' ).val() );			
		var	base = parseInt( $( "#porcentajeConservacion" ).val() );			
		var porcentage = 0;
		if( base == 0 ){						
			if( primaAfectadas >= 450000 )	porcentage = 11;			
			if( primaAfectadas >= 350000 && primaAfectadas < 450000 )	porcentage = 10;			
			if( primaAfectadas >= 260000 && primaAfectadas < 350000 )	porcentage = 9;			
			if( primaAfectadas >= 210000 && primaAfectadas < 260000 )	porcentage = 7;			
			if( primaAfectadas >= 150000 && primaAfectadas < 210000 )	porcentage = 5;				
			if( primaAfectadas >= 120000 && primaAfectadas < 150000 )	porcentage = 4;				
			if( primaAfectadas >= 100000 && primaAfectadas < 120000 )	porcentage = 2;	
		}		
		if( base != 0 ){						
			if( base == 89 ){				
				if( primaAfectadas >= 450000 )	porcentage = 9;				
				if( primaAfectadas >= 350000 && primaAfectadas < 450000 )	porcentage = 8;				
				if( primaAfectadas >= 260000 && primaAfectadas < 350000 )	porcentage = 7;				
				if( primaAfectadas >= 210000 && primaAfectadas < 260000 )	porcentage = 4;				
				if( primaAfectadas >= 150000 && primaAfectadas < 210000 )	porcentage = 3;	
				if( primaAfectadas >= 120000 && primaAfectadas < 150000 )	porcentage = 2;				
				if( primaAfectadas >= 100000 && primaAfectadas < 120000 )	porcentage = 1;	
			}			
			if( base == 91 ){				
				if( primaAfectadas >= 450000 )	porcentage = 10;				
				if( primaAfectadas >= 350000 && primaAfectadas < 450000 )	porcentage = 9;				
				if( primaAfectadas >= 260000 && primaAfectadas < 350000 )	porcentage = 8;				
				if( primaAfectadas >= 210000 && primaAfectadas < 260000 )	porcentage = 5;				
				if( primaAfectadas >= 150000 && primaAfectadas < 210000 )	porcentage = 4;	
				if( primaAfectadas >= 120000 && primaAfectadas < 150000 )	porcentage = 3;					
				if( primaAfectadas >= 100000 && primaAfectadas < 120000 )	porcentage = 2;	
			}			
			if( base == 93 ){				
				if( primaAfectadas >= 450000 )	porcentage = 11;				
				if( primaAfectadas >= 350000 && primaAfectadas < 450000 )	porcentage = 10;				
				if( primaAfectadas >= 260000 && primaAfectadas < 350000 )	porcentage = 9;				
				if( primaAfectadas >= 210000 && primaAfectadas < 260000 )	porcentage = 6;				
				if( primaAfectadas >= 150000 && primaAfectadas < 210000 )	porcentage = 5;	
				if( primaAfectadas >= 120000 && primaAfectadas < 150000 )	porcentage = 4;	
				if( primaAfectadas >= 100000 && primaAfectadas < 120000 )	porcentage = 3;	
			}			
			if( base == 95 ){				
				if( primaAfectadas >= 450000 )	porcentage = 12;				
				if( primaAfectadas >= 350000 && primaAfectadas < 450000 )	porcentage = 11;				
				if( primaAfectadas >= 260000 && primaAfectadas < 350000 )	porcentage = 10;				
				if( primaAfectadas >= 210000 && primaAfectadas < 260000 )	porcentage = 7;				
				if( primaAfectadas >= 150000 && primaAfectadas < 210000 )	porcentage = 6;	
				if( primaAfectadas >= 120000 && primaAfectadas < 150000 )	porcentage = 5;
				if( primaAfectadas >= 100000 && primaAfectadas < 120000 )	porcentage = 4;
			}
		}						
		$( '#porbonoGanado' ).val( porcentage );
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val()/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoRenovacion' ).val( total );		
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	$( '#primasAfectasInicialesUbicar' ).bind( 'keyup', function(){ 						
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasAfectasInicialesPagar' ).val( total );		
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionesVentaInicial' ).val( total );		
		var total = parseFloat( $( '#primasAfectasInicialesPagar' ).val() ) * parseFloat($( '#bonoAplicado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoProductividad' ).val( total );		
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	$( '#porAcotamiento' ).bind( 'keyup', function(){
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasAfectasInicialesPagar' ).val( total );
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});	
	$( '#primasRenovacion' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasRenovacionPagar' ).val( total );		
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoRenovacion' ).val( total );		
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionRenovacion' ).val( total );		
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	$( '#XAcotamiento' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasRenovacionPagar' ).val( total );		
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	$( '#comisionVentaInicial' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionesVentaInicial' ).val( total );		
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	$( '#comisionVentaRenovacion' ).bind( 'keyup', function(){
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionRenovacion' ).val( total );		
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	$( '#bonoAplicado' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesPagar' ).val() ) * parseFloat($( '#bonoAplicado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoProductividad' ).val( total );
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});
	$( '#porbonoGanado' ).bind( 'keyup', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoRenovacion' ).val( total );
		vida_ingresoTotal(); vida_ingresoPromedio(); getMetas();
	});	
		
});
function vida_ingresoTotal(){	
	var total = 0;		
		total += parseFloat( $( '#ingresoComisionesVentaInicial' ).val() );		
		total += parseFloat( $( '#ingresoComisionRenovacion' ).val() );		
		total += parseFloat( $( '#ingresoBonoProductividad' ).val() );		
		total += parseFloat( $( '#ingresoBonoRenovacion' ).val() );	
	$( '#ingresoTotal_text' ).html( '$ '+moneyFormat(total) );	
	$( '#ingresoTotal' ).val( total );
}
function vida_ingresoPromedio(){	
	var total = parseFloat($( '#ingresoTotal' ).val());	
	total = total/parseInt( $( '#periodo' ).val() );	
	$( '#inresoPromedioMensual_text' ).html( '$ '+moneyFormat(total) );
	$( '#inresoPromedioMensual' ).val(total);		
}