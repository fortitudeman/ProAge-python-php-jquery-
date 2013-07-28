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
	  
	  
	// Filter
	$( '.find' ).bind( 'click', function(){
	  	
		// Reset Color
		$( '.find' ).removeClass( 'searchclicked' );
		
		
		// Set Color
		$(this).addClass( 'searchclicked' );
				
		var Data = { work_order_status_id: this.id };
				
		$( '#findvalue' ).val( this.id );
		
		$.ajax({

			url:  Config.base_url()+'ot/find.html',
			type: "POST",
			data: Data,
			cache: false,
			async: false,
			//dataType: 'json',
			beforeSend: function(){
	
				
				$( '#loading' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-1.gif">   Cargando...' );
								
			},
			success: function(data){
				
				$( '#loading' ).html( '' );	
				$( '#data' ).html( data );
					
				
			}						
	
		});
		
		
		$.ajax({

			url:  Config.base_url()+'ot/find_scripts.html',
			type: "POST",
			data: Data,
			cache: true,
			async: false,
			dataType: "script",
			beforeSend: function(){
	
				
				$( '#loading' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-1.gif">   Cargando...' );
				
								
			},
			success: function(data){
				
				console.log( data );
				$( '#loading' ).html( '' );	
				
				
			}						
	
		});
		
		
		
	});
	 
	
	// Filters
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
	 
	 
	 
	 
	$( '#creation_date' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true });		
	
	
	$( '#findfilters' ).bind( 'click', function(){ 
		
		
		var checked = [];
		$("input[name='advanced[]']:checked").each(function ()
		{
			var element = $(this).val();
										
			checked.push( [$(this).val(), $( '#'+element ).val() ] );
		});
		
		
		
		var Data = { work_order_status_id: $('#findvalue').val(), advanced: checked };
				
		$.ajax({

			url:  Config.base_url()+'ot/find.html',
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
	 
	  
	  
});


function chooseOption( choose ){
	
	var choose = choose.split('-');
		
		if( choose[0] == 'activate' )
			window.location=Config.base_url()+"ot/activate/"+choose[1]+".html";
		if( choose[0] == 'update' )
			window.location=Config.base_url()+"ot/update/"+choose[1]+".html";
		if( choose[0] == 'delete' )
			window.location=Config.base_url()+"ot/cancel/"+choose[1]+".html";
	
}