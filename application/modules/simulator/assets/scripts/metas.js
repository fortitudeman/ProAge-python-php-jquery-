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
	$( '.metas' ).hide();
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
		$( '#primasnetasiniciales' ).val( total );		
		$( '.primas-meta-selector' ).show();		
		$( '.primas-meta' ).hide();		
		getMetas();
		//save();		
	});	
	$(window).resize(function() {
		stickyFooter();
		var percent = ($("body").height() * 10)/100;
		$(".table-totals").css("height", percent+'px');
	});		
	$( '#open_simulator' ).bind( 'click', function(){		
		$( '.metas' ).hide();
		$( '.simulator' ).show();		
	});
	$( '.link-ramo' ).bind( 'click', function(){
		$( '#vida' ).css({ 'color': '#000' });
		$( '#gmm' ).css({ 'color': '#000' });
		$( '#autos' ).css({ 'color': '#000' });	
		if( this.id == 'vida' ){							
			$( '#ramo' ).val(1);			
			$( '#vida' ).css( 'color', '#06F' );			
			$( '#ramo' ).val( 1 );
			$( '#periodo' ).val(3);	
			$.ajax({
				url:  Config.base_url()+'simulator/getSimulator.html',
				type: "POST",
				data: { ramo: 'vida', userid: $( '#userid' ).val() },
				cache: false,
				async: false,
				success: function(data){
					$( '.simulator' ).html(data);	
				}					
			});
			$( '#periodo' ).bind( 'change', function(){		
				if( $( '#ramo' ).val() == 1 ) getMetasPeriod( 'vida' );
				if( $( '#ramo' ).val() == 2 ) getMetasPeriod( 'gmm' );
				if( $( '#ramo' ).val() == 3 ) getMetasPeriod( 'autos' );
			});
			$( '#primasAfectasInicialesUbicar' ).bind( 'keyup', function(){
				getMetas();
			});
			$( '#primasnetasiniciales' ).bind( 'keyup', function(){
				getMetas();
			});	
			$.getScript(Config.base_url()+'simulator/assets/scripts/simulator_vida.js' )
			  .done(function( script, textStatus ) {
				console.log( textStatus );
			  })
			  .fail(function( jqxhr, settings, exception ) {
				alert( 'El script no se puede cargar' );
			});
		}		
		if( this.id == 'gmm' ){		
			$( '#ramo' ).val(2);			
			$( '#gmm' ).css( 'color', '#06F' );			
			$( '#ramo' ).val( 2 );			
			$( '#periodo' ).val(4);			
			$.ajax({
				url:  Config.base_url()+'simulator/getSimulator.html',
				type: "POST",
				data: { ramo: 'gmm', userid: $( '#userid' ).val() },
				cache: false,
				async: false,
				success: function(data){
					$( '.simulator' ).html(data);	
				}					
			});
			$( '#periodo' ).bind( 'change', function(){		
				if( $( '#ramo' ).val() == 1 ) getMetasPeriod( 'vida' );
				if( $( '#ramo' ).val() == 2 ) getMetasPeriod( 'gmm' );
				if( $( '#ramo' ).val() == 3 ) getMetasPeriod( 'autos' );
			});
			$( '#primasAfectasInicialesUbicar' ).bind( 'keyup', function(){
				getMetas();
			});
			$( '#primasnetasiniciales' ).bind( 'keyup', function(){
				getMetas();
			});	
			$.getScript(Config.base_url()+'simulator/assets/scripts/simulator_gmm.js' )
			  .done(function( script, textStatus ) {
				console.log( textStatus );
			  })
			  .fail(function( jqxhr, settings, exception ) {
				alert( 'El script no se puede cargar' );
			});			
		}		
		if( this.id == 'autos' ){			
			$( '#ramo' ).val(3);			
			$( '#autos' ).css( 'color', '#06F' );			
			$( '#ramo' ).val( 3 );
			$( '#periodo' ).val(4);	
			$.ajax({
				url:  Config.base_url()+'simulator/getSimulator.html',
				type: "POST",
				data: { ramo: 'autos', userid: $( '#userid' ).val() },
				cache: false,
				async: false,
				success: function(data){
					$( '.simulator' ).html(data);	
				}					
			});
			$.getScript(Config.base_url()+'simulator/assets/scripts/simulator_autos.js' )
			  .done(function( script, textStatus ) {
				console.log( textStatus );
			  })
			  .fail(function( jqxhr, settings, exception ) {
				alert( 'El script no se puede cargar' );
			});
			$( '#periodo' ).bind( 'change', function(){		
				if( $( '#ramo' ).val() == 1 ) getMetasPeriod( 'vida' );
				if( $( '#ramo' ).val() == 2 ) getMetasPeriod( 'gmm' );
				if( $( '#ramo' ).val() == 3 ) getMetasPeriod( 'autos' );
			});
			$( '#primasAfectasInicialesUbicar' ).bind( 'keyup', function(){
				getMetas();
			});
			$( '#primasnetasiniciales' ).bind( 'keyup', function(){
				getMetas();
			});		
		}
		 getMetasPeriod( this.id );
	});				
	$( '#periodo' ).bind( 'change', function(){		
		if( $( '#ramo' ).val() == 1 ) getMetasPeriod( 'vida' );
		if( $( '#ramo' ).val() == 2 ) getMetasPeriod( 'gmm' );
		if( $( '#ramo' ).val() == 3 ) getMetasPeriod( 'autos' );
	});		
	$( '#primasAfectasInicialesUbicar' ).bind( 'keyup', function(){
		getMetas();
	});
	$( '#primasnetasiniciales' ).bind( 'keyup', function(){
		getMetas();
	});	
		
	$( '.primas-meta-field' ).hide();
	
});


function getMetasPeriod( ramo ){		
	$.ajax({
			url:  Config.base_url()+'simulator/getConfigMeta.html',
			type: "POST",
			data: { ramo: ramo, periodo: $( '#periodo' ).val(), userid: $( '#userid' ).val() },
			cache: false,
			async: false,
			success: function(data){
				//alert( data );
				$( '.metas' ).html(data);				
				$( '.primas-meta-field' ).hide();					
				var i = $( '#primas_promedio' ).val();
					if( i == 0 || i > 0 )
						$( "#metas-prima-promedio" ).val( $( '#primas_promedio' ).val() ); 
					else 
						$( "#metas-prima-promedio" ).val( $( '#primaspromedio' ).val() ); 
				getMetas();						
				$( document ).ready( function(){			
					$( "#metas-prima-promedio" ).bind( 'keyup', function(){ 		
						$( '#primas_promedio' ).val(this.value);	
						$( '#primaspromedio' ).val(this.value);							
						getMetas();
					});	
					$( "#primas_promedio" ).bind( 'keyup', function(){ 		
						$( '#metas-prima-promedio' ).val(this.value);	
						getMetas();
					});	
					$( "#primaspromedio" ).bind( 'keyup', function(){ 		
						$( '#metas-prima-promedio' ).val(this.value);	
						getMetas();
					});	
					$( '#open_simulator' ).bind( 'click', function(){		
						$( '.metas' ).hide();
						$( '.simulator' ).show();	
						//save();					
					});
					// Change the value for prima on the event click
					$( '.primas-meta' ).hide();					
					$( '.primas-meta-field' ).show();					
					$( '.primas-meta-selector' ).bind( 'click', function(){						
						$( '#'+this.id ).hide();						
						$( '#'+this.id+'-field' ).show();												
					});					
					$( '.primas-meta-field' ).bind( 'blur', function(){			
						var total=0;						
						for( var i=1; i<=12; i++ ){							
							if(  !isNaN( $( '#primas-meta-'+i ).val() ) ){
								$( '#primas-meta-text-'+i ).html( '$ '+moneyFormat(parseFloat($( '#primas-meta-'+i ).val())));
								total += parseFloat( $( '#primas-meta-'+i ).val());
							}
						}							
						$( '#primas_promedio' ).val( total );	
						$( '#metas-prima-promedio' ).val( total );	
						$( '.primas-meta-selector' ).show();						
						$( '.primas-meta' ).hide();						
						save();		
						getMetas();	
					});
					$( '#periodo' ).bind( 'change', function(){		
						if( $( '#ramo' ).val() == 1 ) getMetasPeriod( 'vida' );
						if( $( '#ramo' ).val() == 2 ) getMetasPeriod( 'gmm' );
						if( $( '#ramo' ).val() == 3 ) getMetasPeriod( 'autos' );
					});
					$( '#primasAfectasInicialesUbicar' ).bind( 'keyup', function(){
						getMetas();
					});
					$( '#primasnetasiniciales' ).bind( 'keyup', function(){
						getMetas();
					});	
				});
				getMetas();
			}						
	
		});
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
		if( $( '#metas-prima-promedio' ).val() == 0 ) return false;	
		// Metas
		var totalprimameta = 0;		
		var totalnegociometa = 0; 			
		var totalesnegociometa = 0;		
		var totalsolicitudmeta= 0;	
		var totalessolicitudmeta = 0;
		var totaltrimestre = 0;
		for(  var i = 1; i<=12; i++ ){						
			var total = parseFloat( $( '#metas-prima-promedio' ).val() ) * (parseFloat( $( '#mes-'+i ) .val() ) * 100 /100);
			var meta =  total;//;Math.round( total* 100 )/100;			
			var primapromedio =  Math.round( ( total /  parseFloat( $( '#metas-prima-promedio' ).val() ) ) );
			var efectividad = $( '#efectividad' ) .val();	
				efectividad = efectividad.replace( '%', '' );
				efectividad =  parseInt( efectividad ) / 100;	
			var solicitud = primapromedio / efectividad ;		
			$( '#primas-meta-'+i ).val( Math.round(total) );
			$( '#primas-meta-text-'+i ).html( '$ ' + moneyFormat(Math.round(total)) );			
			// Negocios Meta
			$( '#primas-negocios-meta-'+i ).val( Math.round(primapromedio) );
			$( '#primas-negocios-meta-text-'+i ).html( Math.round(primapromedio) );			
			// Solicitud Meta
			$( '#primas-solicitud-meta-'+i ).val( Math.round(solicitud) );
			$( '#primas-solicitud-meta-text-'+i ).html( Math.round(solicitud) );	
			if( !isNaN( meta ) )  totaltrimestre+=meta;
			if( !isNaN( meta ) ) totalprimameta+=meta;
			if( !isNaN( primapromedio ) )  totalnegociometa += primapromedio;
			if( !isNaN( totalnegociometa ) )  totalesnegociometa += totalnegociometa;
			if( !isNaN( solicitud ) ) totalsolicitudmeta += solicitud; 
			if( !isNaN( totalsolicitudmeta ) ) totalessolicitudmeta += totalsolicitudmeta;
			// Totales
			// $( '#ramo' ).val() == 1			
			if( i == 3 && $( '#ramo' ).val() == 1 ){														
				$( '#primas-meta-primer' ).val( Math.round(totaltrimestre) );
				$( '#primas-meta-primer-text' ).html( '$ ' + moneyFormat(Math.round(totaltrimestre)));				
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
				$( '#primas-meta-segund-text' ).html( '$ ' + moneyFormat(Math.round(totaltrimestre)) );				
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
				$( '#primas-meta-tercer-text' ).html( '$ ' + moneyFormat(Math.round(totaltrimestre)) );				
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
				$( '#primas-meta-cuarto-text' ).html('$ ' + moneyFormat( Math.round(totaltrimestre)) );				
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
				$( '#primas-meta-primer-text' ).html( '$ ' + moneyFormat(Math.round(totaltrimestre)) );				
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
				$( '#primas-meta-second-text' ).html( '$ ' + moneyFormat(Math.round(totaltrimestre)) );				
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
				$( '#primas-meta-tercer-text' ).html('$ ' + moneyFormat( Math.round(totaltrimestre)) );				
				$( '#primas-negocio-meta-tercer' ).val( Math.round(totalnegociometa) );
				$( '#primas-negocio-meta-tercer-text' ).html( Math.round(totalnegociometa) );				
				$( '#primas-solicitud-meta-tercer' ).val( totalsolicitudmeta );
				$( '#primas-solicitud-meta-tercer-text' ).html( Math.round(totalsolicitudmeta) );				
				totaltrimestre = 0;				
				totalnegociometa= 0;				
				totalsolicitudmeta= 0;				
			} 
		}		
		$( '#primas-meta-total' ).val(Math.round(totalprimameta) );
		$( '#primas-meta-total-text' ).html( '$ ' + moneyFormat( Math.round(totalprimameta)) );
		
		$( '#primas-negocios-meta-total' ).val( Math.round(totalesnegociometa) );
		$( '#primas-negocios-meta-total-text' ).html( Math.round(totalesnegociometa) );
		
		$( '#primas-solicitud-meta-total' ).val( Math.round(totalessolicitudmeta) );
		$( '#primas-solicitud-meta-total-text' ).html( Math.round(totalessolicitudmeta) );
		
}
function moneyFormat( n ){	
	if( isNaN( n ) ) return 0;	
	return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");	
}