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
/*
function menu( item ){
  $( '#'+item ).show();
  proagesOt.menuRowShown[item] = item;
}*/
var proagesOverview = {};

$( document ).ready( function(){

	proagesOverview.getOts = function(Data) {

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
				var resort = true;
				$("#sorter").trigger("update", [resort]);
				$(".tablesorter-childRow td").hide();	
			}
		});
	}				

	$( '.filter-field').bind( 'change', function(){
		if ( this.id == 'ramo' ) {
			switch ($(this).val()) {
				case '1': // Vida
					$( '.set_periodo' ).html( 'Trimestre' );
					$( '#patent-type').html(proagesOverview.tramiteTypes[$(this).val()]);					
					break;
				case '2': // GMM
				case '3': // Autos
					$( '.set_periodo' ).html( 'Cuatrimestre' );
					$( '#patent-type').html(proagesOverview.tramiteTypes[$(this).val()]);
					break;
				default:
					$( '.set_periodo' ).html( 'Trimestre' );
					$( '#patent-type').html(proagesOverview.tramiteTypes[0]);
					break;
			}

		}
		var Data = $( "#ot-form").serialize();
		proagesOverview.getOts(Data);
	});
  
	$( '.find' ).bind( 'click', function(){

		var currentUser = $( '#todas-mias').val();
		if ( currentUser != (this.id) ) {
			// Reset Color
			$( '.find' ).removeClass( 'btn btn-primary' );
			$(this).addClass( 'btn btn-link' );
			$( '.find' ).css( 'margin-left', 15 ) ;
			// Set Color
			$(this).addClass( 'btn-primary' );
			$(this).removeClass( 'btn-link' );

			$( '#todas-mias').val( this.id );

			var Data = $( "#ot-form").serialize();
			proagesOverview.getOts(Data);
		}
	});

	$( '#ot-form').submit( function () {
		proagesOverview.getOts($( "#ot-form").serialize());
		return false;
	});

	// Filters
	$( '.hide' ).hide();

	proagesOverview.getOts($( "#ot-form").serialize());
	
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