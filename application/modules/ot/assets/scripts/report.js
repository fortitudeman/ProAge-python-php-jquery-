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
    
	
	var table = $('.head');
	pos = table.offset();	
			
	// Esperamos al DOM
	$(window).scroll(function(){
		
		// Anclamos el menú si el scroll es 
		// mayor a la posición superior del tag
		if ( ($(this).scrollTop() >= pos.top)){
			// Añadimos la clase fixes al menú
			table.addClass('fixed');
			// Añadimos la clase scrolling al contenido **
			//$("#content-wrapper").addClass("scrolling");
			// Mostramos la sombre inferior del menú
			//$( '#nav-shadow' ).show('size');
		// Eliminamos las clases para volver a la posición original
		} else if ( ($(this).scrollTop() <= pos.top)){
			// Elimina clase fixes
			table.removeClass('fixed');
			// Elimina clase scrolling
			//$("#content-wrapper").removeClass("scrolling");
			// Esconde la sombra
			//$( '#nav-shadow' ).hide();
		}
	});
	
	
	
	$( '#form' ).validate();
	
	$( '.set_periodo2' ).hide();
	
	$( '#gerente' ).val( $( '#gerente_value' ).val() );
	
	$( '.header_manager' ).bind( 'click', function(){ 
		
		$( '.header_manager' ).css({ 'color': '#000', 'font-weight':'100' } );
		
		$( '#'+this.id ).css({ 'color': '#06F', 'font-weight':'bold' });
		
	});
	
	$( '.link-ramo' ).bind( 'click', function(){
		
		$( '#vida' ).css({ 'color': '#000' });
		$( '#gmm' ).css({ 'color': '#000' });
		$( '#autos' ).css({ 'color': '#000' });
			
		
		if( this.id == 'vida' ){
							
			$( '#ramo' ).val(1);
			
			$( '#vida' ).css( 'color', '#06F' );
			
			$( '.set_periodo' ).html( 'Trimestre' );
			// 'Trimestre' );
			
		}
		
		if( this.id == 'gmm' ){
		
			$( '#ramo' ).val(2);
			
			$( '#gmm' ).css( 'color', '#06F' );
			
			$( '.set_periodo' ).html( 'Cuatrimestre' );
		}
		
		if( this.id == 'autos' ){
			
			$( '#ramo' ).val(3);
			
			$( '#autos' ).css( 'color', '#06F' );
			
			$( '.set_periodo' ).html( 'Cuatrimestre' );
		}
			
		
		$( '#form' ).attr( "action", '' );	
		
		$( '#form' ).submit();
		
	});
			
	$( '.filter' ).bind( 'click', function(){
		$( '#form' ).attr( "action", '' );
	});
	
	$( '.download' ).bind( 'click', function(){
		
		$( '#form' ).attr( "action", Config.base_url() + 'ot/report_export.html' );
		
		$( '#form' ).submit();
		
		$( '#form' ).attr( "action", '' );
		
	});
	
	
	$( '.info' ).hide();
	
	$( '.text_azulado' ).bind( 'click', function(){ $( '#info-'+this.id ).show(); })
	
	$( '.text_azulado' ).bind( 'dblclick', function(){ $( '#info-'+this.id ).hide(); })
	
});