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
    		
	$( '#find' ).bind( 'blur', function(){ 
		
		
		var Data = { find: this.value };
				
		
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
		$('#typeexport').val('busactual');
		$( '#search' ).attr( 'action', $( '#pag' ) .val() );
		$( '#search' ).submit();
	});
	
	
	
});