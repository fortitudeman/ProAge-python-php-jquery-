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

function stickyFooter(){

    positionFooter(); 
    function positionFooter(){
		//$(".table-totals").css({position: "absolute",top:($(window).scrollTop()+$(window).height()-$(".table-totals").height())+"px"})    
    }
 
    $(window)
        .scroll(positionFooter)
        .resize(positionFooter)
}
 
$( document ).ready(function() {
	
	stickyFooter(); 
	
	$(window).resize(function() {
		stickyFooter();
		var percent = ($("body").height() * 10)/100;
		$(".table-totals").css("height", percent+'px');
	});	
	
	// % Bono Productividad
	
	$( "#noNegocios" ).bind( 'blur', function(){ 
		
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
		
		ingresoTotal(); ingresoPromedio();
		
	});
	
	
	$( "#primasAfectasInicialesUbicar" ).bind( 'blur', function(){ 
		
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
		
		ingresoTotal(); ingresoPromedio();
		
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
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+total );
		$( '#ingresoBonoRenovacion' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
		
	});
				
	
	$( '#primasAfectasInicialesUbicar' ).bind( 'blur', function(){ 
						
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+total );
		$( '#primasAfectasInicialesPagar' ).val( total );
		
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+total );
		$( '#ingresoComisionesVentaInicial' ).val( total );
		
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#bonoAplicado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+total );
		$( '#ingresoBonoProductividad' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
		
	});
	
	
	$( '#porAcotamiento' ).bind( 'blur', function(){
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+total );
		$( '#primasAfectasInicialesPagar' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	$( '#primasRenovacion' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+total );
		$( '#primasRenovacionPagar' ).val( total );
		
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+total );
		$( '#ingresoBonoRenovacion' ).val( total );
		
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+total );
		$( '#ingresoComisionRenovacion' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	
	
	$( '#XAcotamiento' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+total );
		$( '#primasRenovacionPagar' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	$( '#comisionVentaInicial' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+total );
		$( '#ingresoComisionesVentaInicial' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	$( '#comisionVentaRenovacion' ).bind( 'blur', function(){
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+total );
		$( '#ingresoComisionRenovacion' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	
	$( '#bonoAplicado' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#bonoAplicado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+total );
		$( '#ingresoBonoProductividad' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	$( '#porbonoGanado' ).bind( 'blur', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+total );
		$( '#ingresoBonoRenovacion' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	
	
	$( '.link-ramo' ).bind( 'click', function(){
		
		$( '#vida' ).css({ 'color': '#000' });
		$( '#gmm' ).css({ 'color': '#000' });
		$( '#autos' ).css({ 'color': '#000' });
			
		
		if( this.id == 'vida' ){
							
			$( '#ramo' ).val(1);
			
			$( '#vida' ).css( 'color', '#06F' );
			
			$( '#ramo' ).val( 1 );
			// 'Trimestre' );
			
		}
		
		if( this.id == 'gmm' ){
		
			$( '#ramo' ).val(2);
			
			$( '#gmm' ).css( 'color', '#06F' );
			
			$( '#ramo' ).val( 2 );
		}
		
		if( this.id == 'autos' ){
			
			$( '#ramo' ).val(3);
			
			$( '#autos' ).css( 'color', '#06F' );
			
			$( '#ramo' ).val( 3 );
		}
					
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

function save(){
			
	var id = $( '#id' ).val();
	
	if( id == 0 ){
	 	 	
	  $.ajax({

			url:  Config.base_url()+'simulator/save.html',
			type: "POST",
			data: $( '#form' ).serialize(),
			cache: false,
			async: false,
			success: function(data){
								
				$( '#id' ).val(data);
				
			}						
	
		});
	
	}else{
		
		 $.ajax({

			url:  Config.base_url()+'simulator/update.html',
			type: "POST",
			data: $( '#form' ).serialize(),
			cache: false,
			async: false,
			success: function(data){
				
			}						
	
		});
		
	}
	
	
	
	
}