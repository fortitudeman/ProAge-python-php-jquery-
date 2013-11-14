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
	
	$( '.metas' ).hide();
	
	
	// Change the value for prima on the event click
	$( '.primas-meta' ).hide();
	
	$( '.primas-meta-selector' ).bind( 'click', function(){
		
		$( '#'+this.id ).hide();
		
		$( '#'+this.id+'-field' ).show();
		
	});
	
	
	$( '.primas-meta-field' ).bind( 'blur', function(){
		
		var total=0;
		
		for( var i=1; i<=12; i++ ){
			
			if(  !isNaN( $( '#primas-meta-'+i ).val() ) )
				total += parseFloat( $( '#primas-meta-'+i ).val());
			
		}
			
		$( '#primasAfectasInicialesUbicar' ).val( total );
		
		$( '.primas-meta-selector' ).show();
		
		$( '.primas-meta' ).hide();
		
		getMetas();
		
		save();
		
	});
	
	
	
	
	stickyFooter(); 
	
	$(window).resize(function() {
		stickyFooter();
		var percent = ($("body").height() * 10)/100;
		$(".table-totals").css("height", percent+'px');
	});	
	
	$( '#open_simulator' ).bind( 'click', function(){
		
		$( '.metas' ).hide();
		$( '.simulator' ).show();
		
	});
	
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
		
		ingresoTotal(); ingresoPromedio();
		
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
		
		ingresoTotal(); ingresoPromedio();
		
		getMetas();
	});
	
	
	$( '#primas_promedio' ).bind( 'keyup', function(){ 		
		$( '#metas-prima-promedio' ).val(this.value);
		getMetas();
	});
	
	
	// Prima Promedio Meas
	$( "#metas-prima-promedio" ).bind( 'keyup', function(){ 		
		$( '#primas_promedio' ).val(this.value);	
		getMetas();
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
		
		ingresoTotal(); ingresoPromedio();
		
	});
				
	
	$( '#primasAfectasInicialesUbicar' ).bind( 'keypress', function(){ 
						
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasAfectasInicialesPagar' ).val( total );
		
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionesVentaInicial' ).val( total );
		
		var total = parseFloat( $( '#primasAfectasInicialesPagar' ).val() ) * parseFloat($( '#bonoAplicado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoProductividad' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
		
		getMetas();
		
	});
	
	
	$( '#porAcotamiento' ).bind( 'keypress', function(){
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#porAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasAfectasInicialesPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasAfectasInicialesPagar' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	$( '#primasRenovacion' ).bind( 'keypress', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasRenovacionPagar' ).val( total );
		
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoRenovacion' ).val( total );
		
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionRenovacion' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	
	
	$( '#XAcotamiento' ).bind( 'keypress', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#XAcotamiento' ).val().replace( '%', '' )/100);	
		$( '#primasRenovacionPagar_text' ).html( '$ '+moneyFormat(total) );
		$( '#primasRenovacionPagar' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	$( '#comisionVentaInicial' ).bind( 'keypress', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * parseFloat($( '#comisionVentaInicial' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionesVentaInicial_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionesVentaInicial' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	$( '#comisionVentaRenovacion' ).bind( 'keypress', function(){
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#comisionVentaRenovacion' ).val().replace( '%', '' )/100);	
		$( '#ingresoComisionRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoComisionRenovacion' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	
	$( '#bonoAplicado' ).bind( 'keypress', function(){ 
		var total = parseFloat( $( '#primasAfectasInicialesPagar' ).val() ) * parseFloat($( '#bonoAplicado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoProductividad_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoProductividad' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	$( '#porbonoGanado' ).bind( 'keypress', function(){ 
		var total = parseFloat( $( '#primasRenovacion' ).val() ) * parseFloat($( '#porbonoGanado' ).val().replace( '%', '' )/100);	
		$( '#ingresoBonoRenovacion_text' ).html( '$ '+moneyFormat(total) );
		$( '#ingresoBonoRenovacion' ).val( total );
		
		ingresoTotal(); ingresoPromedio();
	});
	
	
	
	$( '.item-cuatrimestre' ).hide();	
	
	$( '.link-ramo' ).bind( 'click', function(){
		
		$( '#vida' ).css({ 'color': '#000' });
		$( '#gmm' ).css({ 'color': '#000' });
		$( '#autos' ).css({ 'color': '#000' });		
		$( '.item-trimestre' ).hide();	
		$( '.item-cuatrimestre' ).hide();	
								
		if( this.id == 'vida' ){							
			$( '#ramo' ).val(1);			
			$( '#vida' ).css( 'color', '#06F' );			
			$( '#ramo' ).val( 1 );
			$( '#periodo' ).val(3);	
			$( '.item-trimestre' ).show();	
			
		}
		
		if( this.id == 'gmm' ){		
			$( '#ramo' ).val(2);			
			$( '#gmm' ).css( 'color', '#06F' );			
			$( '#ramo' ).val( 2 );			
			$( '#periodo' ).val(4);			
			$( '.item-cuatrimestre' ).show();
			
		}
		
		if( this.id == 'autos' ){			
			$( '#ramo' ).val(3);			
			$( '#autos' ).css( 'color', '#06F' );			
			$( '#ramo' ).val( 3 );
			$( '#periodo' ).val(4);			
			$( '.item-cuatrimestre' ).show();
		}
		
		
		 getMetasPeriod( this.id );
					
	});
				
	$( '#periodo' ).bind( 'change', function(){
		
		if( $( '#ramo' ).val() == 1 ) getMetasPeriod( 'vida' );
		if( $( '#ramo' ).val() == 2 ) getMetasPeriod( 'gmm' );
		if( $( '#ramo' ).val() == 3 ) getMetasPeriod( 'autos' );
		
	});	
	
});


function getMetasPeriod( ramo ){
	
	
	$.ajax({

			url:  Config.base_url()+'simulator/getConfigMeta.html',
			type: "POST",
			data: { ramo: ramo, periodo: $( '#periodo' ).val() },
			cache: false,
			async: false,
			success: function(data){
				//alert( data );
				$( '.metas' ).html(data);
				
				$( '#metas-prima-promedio' ).val($( "#primas_promedio" ).val());	
				
				$( document ).ready( function(){
				
					$( "#metas-prima-promedio" ).bind( 'keyup', function(){ 		
						$( '#primas_promedio' ).val(this.value);	
						getMetas();
					});
				
				});
				
				getMetas();
			}						
	
		});
	
	
}


function ingresoTotal(){
	
	var total = 0;
		
		total += parseFloat( $( '#ingresoComisionesVentaInicial' ).val() );
		
		total += parseFloat( $( '#ingresoComisionRenovacion' ).val() );
		
		total += parseFloat( $( '#ingresoBonoProductividad' ).val() );
		
		total += parseFloat( $( '#ingresoBonoRenovacion' ).val() );
	
	$( '#ingresoTotal_text' ).html( '$ '+moneyFormat(total) );
	
	$( '#ingresoTotal' ).val( total );
}


function ingresoPromedio(){
	
	var total = parseFloat($( '#ingresoTotal' ).val());
	
	
	total = total/parseInt( $( '#periodo' ).val() );
	
	$( '#inresoPromedioMensual_text' ).html( '$ '+moneyFormat(total) );
	$( '#inresoPromedioMensual' ).val(total);
		
}

function save(){
			
	var id = $( '#id' ).val();
	
	$( '.metas' ).show();
	$( '.simulator' ).hide();
	
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

function getMetas(){
		
		if( $( '#primasAfectasInicialesUbicar' ).val() == 0 ) return false;
				
		// Metas
		var totalprimameta = 0;
		
		var totalnegociometa = 0; 	
		
		var totalesnegociometa = 0;
		
		var totalsolicitudmeta= 0;	 	
		
		var totalessolicitudmeta = 0;	 
		
		var totaltrimestre = 0;
		
		for(  var i = 1; i<=12; i++ ){
						
			//var total = parseFloat( $( '#metas-prima-promedio' ).val() ) /  parseInt( $( '#mes-'+i ) .val() );
			
			var total = parseFloat( $( '#primasAfectasInicialesUbicar' ).val() ) * ( parseFloat( $( '#mes-'+i ) .val() ) /100 );
																					
			var meta =  Math.round( total* 100 )/100;
			
			var primapromedio = parseFloat( $( '#metas-prima-promedio' ).val() );
								
				primapromedio =  Math.round( ( meta / primapromedio )*100 );
				
				primapromedio =  primapromedio/100;
						
			var solicitud = primapromedio / parseInt( $( '#mes-'+i ) .val() );
				
			// Show Values
			$( '#primas-meta-'+i ).val( Math.round(total) );
			$( '#primas-meta-text-'+i ).html( Math.round(total) );
			
			// Negocios Meta
			$( '#primas-negocios-meta-'+i ).val( Math.round(primapromedio) );
			$( '#primas-negocios-meta-text-'+i ).html( Math.round(primapromedio) );
			
			// Solicitud Meta
			$( '#primas-solicitud-meta-'+i ).val( Math.round(solicitud) );
			$( '#primas-solicitud-meta-text-'+i ).html( Math.round(solicitud) );
			
			
			if( !isNaN( meta ) )  totaltrimestre+=meta;
			
			if( !isNaN( totaltrimestre ) ) totalprimameta+=totaltrimestre;
						
			if( !isNaN( primapromedio ) )  totalnegociometa += primapromedio;
			
			if( !isNaN( totalnegociometa ) )  totalesnegociometa += totalnegociometa;
			
			if( !isNaN( solicitud ) ) totalsolicitudmeta += solicitud; 
			
			if( !isNaN( totalsolicitudmeta ) ) totalessolicitudmeta += totalsolicitudmeta;
																							
			// Totales
			// $( '#ramo' ).val() == 1			
			if( i == 3 && $( '#ramo' ).val() == 1 ){
														
				$( '#primas-meta-primer' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-primer-text' ).html( Math.round(totaltrimestre));
				
				$( '#primas-negocio-meta-primer' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-primer-text' ).html( Math.round(totalnegociometa) );
				
				$( '#primas-solicitud-meta-primer' ).val( Math.round(totalsolicitudmeta) );
				$( '#primas-solicitud-meta-primer-text' ).html( Math.round(totalsolicitudmeta) );
				
				totaltrimestre = 0;
				
				totalnegociometa= 0;
				
				totalsolicitudmeta= 0;
				
			} 
			
			if( i == 6 && $( '#ramo' ).val() == 1 ){
													
				$( '#primas-meta-segund' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-segund-text' ).html( Math.round(totaltrimestre) );
				
				$( '#primas-negocio-meta-segund' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-segund-text' ).html( Math.round(totalnegociometa) );
				
				$( '#primas-solicitud-meta-segund' ).val( Math.round(totalsolicitudmeta) );
				$( '#primas-solicitud-meta-segund-text' ).html( Math.round(totalsolicitudmeta) );
				
				totaltrimestre = 0;
				
				totalnegociometa= 0;
				
				totalsolicitudmeta= 0;
				
			} 
			
			if( i == 9 && $( '#ramo' ).val() == 1 ){
				
				$( '#primas-meta-tercer' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-tercer-text' ).html( Math.round(totaltrimestre) );
				
				$( '#primas-negocio-meta-tercer' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-tercer-text' ).html( Math.round(totalnegociometa) );
				
				$( '#primas-solicitud-meta-tercer' ).val( Math.round(totalsolicitudmeta) );
				$( '#primas-solicitud-meta-tercer-text' ).html( Math.round(totalsolicitudmeta) );
				
				totaltrimestre = 0;
				
				totalnegociometa= 0;
				
				totalsolicitudmeta= 0;
				
			} 
			
			
			
			if( i == 12 && $( '#ramo' ).val() == 1 ){
				
				
				$( '#primas-meta-cuarto' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-cuarto-text' ).html( Math.round(totaltrimestre) );
				
				$( '#primas-negocio-meta-cuarto' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-cuarto-text' ).html( Math.round(totalnegociometa) );
				
				$( '#primas-solicitud-meta-cuarto' ).val( Math.round(totalsolicitudmeta) );
				$( '#primas-solicitud-meta-cuarto-text' ).html( Math.round(totalsolicitudmeta) );
				
				totaltrimestre = 0;
				
				totalnegociometa= 0;
				
				totalsolicitudmeta= 0;
				
			} 
			
			
			// $( '#ramo' ).val() == 1
			if( i == 4 && ( $( '#ramo' ).val() == 2 || $( '#ramo' ).val() == 3 ) ){
														
				$( '#primas-meta-primer' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-primer-text' ).html( Math.round(totaltrimestre) );
				
				$( '#primas-negocio-meta-primer' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-primer-text' ).html( Math.round(totalnegociometa) );
				
				$( '#primas-solicitud-meta-primer' ).val( totalsolicitudmeta );
				$( '#primas-solicitud-meta-primer-text' ).html( Math.round(totalsolicitudmeta) );
				
				totaltrimestre = 0;
				
				totalnegociometa= 0;
				
				totalsolicitudmeta= 0;
				
			} 
			
			if( i == 8 && ( $( '#ramo' ).val() == 2 || $( '#ramo' ).val() == 3 ) ){
														
				$( '#primas-meta-second' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-second-text' ).html( Math.round(totaltrimestre) );
				
				$( '#primas-negocio-meta-second' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-second-text' ).html( Math.round(totalnegociometa) );
				
				$( '#primas-solicitud-meta-second' ).val( totalsolicitudmeta );
				$( '#primas-solicitud-meta-second-text' ).html( Math.round(totalsolicitudmeta) );
				
				totaltrimestre = 0;
				
				totalnegociometa= 0;
				
				totalsolicitudmeta= 0;
				
			} 
			
			if( i == 12 && ( $( '#ramo' ).val() == 2 || $( '#ramo' ).val() == 3 ) ){
														
				$( '#primas-meta-tercer' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-tercer-text' ).html( Math.round(totaltrimestre) );
				
				$( '#primas-negocio-meta-tercer' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-tercer-text' ).html( Math.round(totalnegociometa) );
				
				$( '#primas-solicitud-meta-tercer' ).val( totalsolicitudmeta );
				$( '#primas-solicitud-meta-tercer-text' ).html( Math.round(totalsolicitudmeta) );
				
				totaltrimestre = 0;
				
				totalnegociometa= 0;
				
				totalsolicitudmeta= 0;
				
			} 
			
			
			$( '#primas-meta-total' ).val( Math.round(totalprimameta) );
			$( '#primas-meta-total-text' ).html( Math.round(totalprimameta) );
			
			$( '#primas-negocios-meta-total' ).val( Math.round(totalesnegociometa) );
			$( '#primas-negocios-meta-total-text' ).html( Math.round(totalessolicitudmeta) );
			
			$( '#primas-solicitud-meta-total' ).val( Math.round(totalesnegociometa) );
			$( '#primas-solicitud-meta-total-text' ).html( Math.round(totalessolicitudmeta) );
			
		}
}

function moneyFormat( n ){
	
	if( isNaN( n ) ) return 0;
	
	return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");	
}