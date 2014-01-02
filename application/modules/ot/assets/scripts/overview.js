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
function menu( item ){
  $( '.popup' ).hide();
  $( '#'+item ).show();
}


$( document ).ready( function(){
		
	
	$( '.popup' ).hide();	
	  
	$( '.btn-hide' ).bind( 'click', function(){ $( '.popup' ).hide(); });  
	  
	$( '.find' ).bind( 'click', function(){
			
		// Reset Color
		$( '.find' ).removeClass( 'btn btn-primary' );
		$(this).addClass( 'btn btn-link' );
		$( '.find' ).css( 'margin-left', 15 ) ;
		// Set Color
		$(this).addClass( 'btn-primary' );
		$(this).removeClass( 'btn-link' );	
			
		$( '#findvalue' ).val( this.id );
			
	});
	
	  
	// Filter alls or my
	$( '.findsub' ).bind( 'click', function(){
	  	
		// Reset Color
		$( '.findsub' ).removeClass( 'btn btn-primary' );
		$(this).addClass( 'btn btn-link' );
		$( '.findsub' ).css( 'margin-left', 15 ) ;
		// Set Color
		$(this).addClass( 'btn-primary' );
		$(this).removeClass( 'btn-link' );
		
		
		var checked = [];
		$("input[name='advanced[]']:checked").each(function ()
		{
			var element = $(this).val();
			
			if(  element == 'creation_date' ) 
				
				checked.push( [$(this).val(), $( '#'+element ).val()+ '00:00:00', $( '#creation_date1' ).val()+'23:59:59'  ] );
			
			else							
				checked.push( [$(this).val(), $( '#'+element ).val() ] );
		});
		
		
		
		var Data = { user: $( '#findvalue' ).val(), work_order_status_id: this.id, advanced: checked };
				
		$( '#findsubvalue' ).val( this.id );
		
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
				
				if( data != "" )
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
			
			
			var x=$('.link-advanced'); 
				x.text("Ocultar Filtros");
						
			
		}else{
			
			$( '.link-advanced' ).attr( 'id', 'showadvanced' );
			$( '.advanced' ).hide();
			
			var x=$('.link-advanced'); 
				x.text("Mostrar Filtros");
			
		}
			
			
	});
	$( '.checkboxadvance' ).bind( 'click', function(){
		
		if( this.checked == true ){
			
			$( '#'+this.value ).show();
			
			if( this.value == 'creation_date' )
				$( '#creation_date1' ).show();
				
		}
		else{
			$( '#'+this.value ).hide();
			$( '#'+this.value ).val('');
			
			if( this.value == 'creation_date' ){
				$( '#creation_date1' ).hide();
				$( '#creation_date1' ).val('');
			}
			
		}
		
	}); 
	 
	 
	 var toDay = new Date();
		toDay = toDay.getFullYear();	
	
	$( '#creation_date' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true, yearRange: "1788:"+toDay });		
	$( '#creation_date1' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true , yearRange: "1788:"+toDay});		
	
	
	$( '.filtros' ).bind( 'click', function(){ 
		
		var checked = [];
		$("input[name='advanced[]']:checked").each(function ()
		{
			var element = $(this).val();
			
			if(  element == 'creation_date' ) 
				
				checked.push( [$(this).val(), $( '#'+element ).val()+ '00:00:00', $( '#creation_date1' ).val()+'23:59:59'  ] );
			
			else							
				checked.push( [$(this).val(), $( '#'+element ).val() ] );
		});
		
		
		
		var Data = { user: $( '#findvalue' ).val(), work_order_status_id: $('#findsubvalue').val(), advanced: checked };
				
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
				
				if( data != "" )
					console.log( data );
				$( '#loading' ).html( '' );	
				
				
			}						
	
		});
				
	}); 
			 	  
});
function chooseOption( choose, is_new ){
	
	var choose = choose.split('-');
		
		if( choose[0] == 'activar' )
			window.location=Config.base_url()+"ot/activar/"+choose[1]+".html";
		if( choose[0] == 'desactivar' )
			window.location=Config.base_url()+"ot/desactivar/"+choose[1]+".html";	
		if( choose[0] == 'aceptar' ){
			
			if( confirm( 'Seguro quiere marcar como aceptada' ) ){
				
				if( is_new == true ){
					var poliza=prompt("Ingresa un número de poliza","");	
					var pago=confirm("¿Quiere marcar la Póliza como pagada?");	
					if( poliza!=null )
						window.location=Config.base_url()+"ot/aceptar/"+choose[1]+"/"+poliza+"/"+pago+".html";	
					
				}else{
					window.location=Config.base_url()+"ot/aceptar/"+choose[1]+".html";	
				}
				
				
			}
			
		}
		if( choose[0] == 'rechazar' )
			if( confirm( 'Seguro quiere marcar como rechazada' ) ) window.location=Config.base_url()+"ot/rechazar/"+choose[1]+".html";		
		if( choose[0] == 'cancelar' )
			window.location=Config.base_url()+"ot/cancelar/"+choose[1]+".html";
	
}

function setPay( id ){
	if( confirm( "¿Está seguro que quiere marcar la OT como pagada?" ) ){		
		var Data = { id: id };		
		$.ajax({

			url:  Config.base_url()+'ot/setPay.html',
			type: "POST",
			data: Data,
			cache: true,
			async: false,
			success: function(data){
				alert(data);
				window.location=Config.base_url()+"ot.html";
			}						
	
		});
	}	
}