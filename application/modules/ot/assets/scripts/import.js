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
$( document ).ready( function(){
	
	
	$( "#dialog-form" ).dialog({
		  autoOpen: false,
		  height: 600,
		  width: 800,
		  modal: true,
		  buttons: {
			Cerrar: function() {
			  $( this ).dialog( "close" );
			  
			  
			  $.ajax({

				url:  Config.base_url()+'ot/getSelectAgents.html',
				type: "POST",
				cache: false,
				async: false,
				success: function(data){
					
					var option = $( '#control' ).val();
			  
					  option = option.split('-');
								
					  $( '.options-'+option[1] ).html(data);						
					
				}						
		
			});
			  
			  
			  
			  
			  
				  
			  
			}
		  }
	});
	
	$( '.create-user' ).bind( 'click', function(){ 
		
		$( "#dialog-form" ).dialog( "open" ); 
		
		$( '#control' ).val( this.id );
		
	});

 /*
$( ".create-user" )
  .button()
  .click(function() {
	$( "#dialog-form" ).dialog( "open" );
  });*/
});	  