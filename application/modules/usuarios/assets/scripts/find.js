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
    
	// Field Dates
	$( '#birthdate' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true });		
	$( '#license_expired_date' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true });		
			
	$( '#searchfind' ).bind( 'click', function(){ 
		
		
		var checked = [];
		$("input[name='advanced[]']:checked").each(function ()
		{
			var element = $(this).val();
										
			checked.push( [$(this).val(), $( '#'+element ).val() ] );
		});
		
		var Data = { find: this.value, rol: $( '#rolsearch' ).val(), advanced: checked };
				
		
		$.ajax({

			url:  Config.base_url()+'usuarios/find.html',
			type: "POST",
			data: Data,
			cache: false,
			async: false,
			beforeSend: function(){
	
				
				$( '#loading' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-1.gif">   Cargando...' );
				
			},
			success: function(data){
					
				$( '#loading' ).html( '' );	
				$( '#data' ).html( data );
												
				
			}						
	
		});
		
		
	});
	
	
	
	
	
	// Advanced find options
	$( '.advanced' ).hide();
	$( '.hide' ).hide();
	$( '.link-advanced' ).bind( 'click', function(){

		if( this.id == 'showadvanced' ){
			
			$( '.link-advanced' ).attr( 'id', 'hideadvanced' );
			$( '.advanced' ).show();
			
		}else{
			
			$( '.link-advanced' ).attr( 'id', 'showadvanced' );
			$( '.advanced' ).hide();
			
		}
			
			
	});
	
	$( '.checkboxadvance' ).bind( 'click', function(){
		
		if( this.checked == true )
			
			$( '#'+this.value ).show();
		
		else{
			$( '#'+this.value ).hide();
			$( '#'+this.value ).val('');
		}
		
	});
	
	// Rol search
	$( '.rol-search' ).bind( 'click', function(){
		
		$( '#rolsearch' ).val( this.id );
		
		var Data = { rol: this.id };


		$.ajax({

			url:  Config.base_url()+'usuarios/find.html',
			type: "POST",
			data: Data,
			cache: false,
			async: false,
			beforeSend: function(){
	
				
				$( '#loading' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-1.gif">   Cargando...' );
				
			},
			success: function(data){
					
				$( '#loading' ).html( '' );	
				$( '#data' ).html( data );
												
				
			}						
	
		});
				
	});
	
	
	// Export Info
	$( '#pagactual' ).bind( 'click', function(){
		$('#typeexport').val('pagactual');
		$( '#search' ).attr( 'action', $( '#pag' ).val() );
		$( '#search' ).submit();
	});
	
	// Export Info
	$( '#busactual' ).bind( 'click', function(){
		
		if( $( '#find' ) .val().length > 0 ){
			$('#typeexport').val('busactual');
			$( '#search' ).attr( 'action', $( '#pag' ) .val() );
			$( '#search' ).submit();
		}else{
			alert( 'El campo de busqueda esta vacio' );
		}
	});
	
	
	
});