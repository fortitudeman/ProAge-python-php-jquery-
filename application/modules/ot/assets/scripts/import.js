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

  	$("#delete-submit").on( "click", function( event ) {

		var selectedTipoArchivo = $("#product-type-delete").val();
		var selectedMonth = $("#month-delete").val();
		var selectedYear = $("#year-delete").val();
		if ( (selectedTipoArchivo.length == 0) || (selectedTipoArchivo < 1) || (selectedTipoArchivo > 3) ) {
			alert('El tipo de archivo esta invalido (seleccione un valor).');
			return false;
		}
		if ( (selectedMonth < 1) || (selectedMonth > 12) ||
			( selectedYear < 1900 ) || ( selectedYear > 2100 ) ) {
			alert('El mes - año estan invalidos.');
			return false;
		}

		var tipoArchivoLabel = '';
		$("#product-type-delete option:selected").each(function () {
			tipoArchivoLabel = ' (tipo de archivo : ' + $(this).text() + ')';
			return false;
		});

		var confirmMessage = '¿Está seguro que desea borrar todos los datos de pago del mes '
			+ selectedMonth + '/' + selectedYear + tipoArchivoLabel + ' ?';

		if ( confirm( confirmMessage ) ) {
			url = Config.base_url() + 'ot/delete_payments.html';
			$.ajax({
				url: url,
				type: 'POST',
				data: $( "#import-delete").serialize(),
				dataType : 'json',
				beforeSend: function(){
					$( "#delete-submit").hide();
				},
				success: function(response){
					$( "#delete-submit").show();
					switch (response) {
						case '-1':
							alert ('No se pudo borrar los pagos. Informe a su administrador.');
							break;
						case '-2':
							alert ('Ocurrio un error, no se pudo borrar los pagos, consulte a su administrador.');
							break;
						case '0':
							alert ('No hay pagos para el mes - año ' + selectedMonth + '/' + selectedYear  + tipoArchivoLabel + '.');
							break;
						default:
							alert ('Se pudo borrar los pagos del mes - año ' + selectedMonth + '/' + selectedYear  + tipoArchivoLabel + ' correctamente.');
							break;
					}
				}
			});
		}
		return false;        
	});

        $("#woAsPAI").click(function(){
            if($(this).prop('checked')){
                $(".wo","#woListPAI").prop( "checked", true );
            }else{
                $(".wo","#woListPAI").removeAttr('checked');
  
            }
        });

});	  