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
	
	$( '.theader' ).hide();
			
	// Esperamos al DOM
	$(window).scroll(function(){
		
		// Anclamos el menú si el scroll es 
		// mayor a la posición superior del tag
		if ( ($(this).scrollTop() >= pos.top)){
			// Añadimos la clase fixes al menú
			//table.addClass('fixed');
						
			$( '.theader' ).show();
			
			$('.theader').addClass('fixed');
			
			// Añadimos la clase scrolling al contenido **
			//$("#content-wrapper").addClass("scrolling");
			// Mostramos la sombre inferior del menú
			//$( '#nav-shadow' ).show('size');
		// Eliminamos las clases para volver a la posición original
		} else if ( ($(this).scrollTop() <= pos.top)){
			// Elimina clase fixes
			table.removeClass('fixed');
			$('.text_total').removeClass('fixed');
			
			$( '.theader' ).hide();
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
		
		$( '.header_manager' ).css({'color': '#000', 'font-weight':'100'} );
		
		$( '#'+this.id ).css({'color': '#06F', 'font-weight':'bold'});
		
	});
	
	$( '.link-ramo' ).bind( 'click', function(){
		
		$( '#vida' ).css({'color': '#000'});
		$( '#gmm' ).css({'color': '#000'});
		$( '#autos' ).css({'color': '#000'});
			
		
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
	
	
	$('.info').hide();
	
	$('.text_azulado' ).bind('click', function()
        { 
            var content = $('#info_'+this.id).html();            
            var added_content = $('#tr_after_'+this.id).length;                
            if(added_content == 0)
            {
                $('#tr_'+this.id).after('<tr class="info" id ="tr_after_'+this.id+'"><td colspan="10">'+content+'</td></tr>').slideDown(1000);            
                $('.btn-hide i.icon-arrow-up').bind('click',function()
                { 
                   $('#tr_after_'+this.id).remove();
                });
            }
        });
	
       
       
       $(".fancybox").fancybox(
       {
           type: 'ajax',
           width :1000,
           scrolling   : 'no',
           openEffect : 'elastic',
           openSpeed  : 150,
           closeEffect : 'elastic',
           closeSpeed  : 150,
           autoDimensions: true,
           height: 'auto',
           afterShow: function() 
           {
                $("tr.tr_pop_class").click(function() 
                {
                    var content = '<a href="javascript:" class="btn btn-link btn-hide"><i class="icon-arrow-up" id="'+this.id+'"></i></a><a href="email_popup" class="btn btn-link send_message">Enviar mensaje al cordinador</a>|<a href="email_popup" class="btn btn-link send_message">Enviar mensaje al Agenta</a>|<a href="email_popup" class="btn btn-link send_message">Enviar mensaje al Director</a>';
                    var added_content = $('#tr_pop_afer'+this.id).length;                
                    if(added_content == 0)
                    {
                        $('#'+this.id).after('<tr class="tr_pop_class" id ="tr_pop_afer'+this.id+'"><td></td><td colspan="11">'+content+'</td></tr>').slideDown(1000);            
                    
                        $('.btn-hide i.icon-arrow-up').bind('click',function()
                        { 
                            $('#tr_pop_afer'+this.id).remove();
                        });                        

                        
                        $('.send_message').bind('click',function()
                        {
                           // var value = $(this).text();  
                            $('.send_message').fancybox(
                            {
                                type: 'ajax',
                                width :800,
                                height:400,
                                scrolling:'no'                                
                            });                         
                        });                         
                    }      
                });
            }
       });

	$(".fancybox_gris").fancybox({
		type: 'ajax',
		width: 680,
		scrolling: 'no',
		openEffect: 'elastic',
		openSpeed: 150,
		closeEffect: 'elastic',
		closeSpeed: 150,
		autoDimensions: true,
		height: 'auto',
		afterShow: function() {
		}
	});

	// add parser through the tablesorter addParser method
	// Note: not used with version 2.14.5 of the tablesorter plugin
/*	$.tablesorter.addParser({
		// set a unique id
		id: 'mydigit',
		is: function(s) {
			// return false so this parser is not auto detected
			return false;
		},
		format: function(s) {
			// format your data for normalization
			return s.replace(/,/g, '');
		},
		// set type, either numeric or text
		type: 'numeric'
	});	*/

	$(".payment_table").tablesorter({ 
		// use custom parser 'mydigit' for column containing a number, formatted 
/*		headers: {
			2: { sorter: "mydigit" }
		}*/
    });
	

       $('#popup_email').submit(function()
       {
           //alert('Yes');
           email_body = $('#email_form').val();           
           $.post("/ot/send_email",{'email_body':email_body},function(dataa)
            {       
//                if(dataa)
//                {         
//                       
//                }
            }, "json");
            return false;        
       });

	$(".ot-action").on( "click", function( event ) {
		var current = $(this);
		var allParams = current.attr('id').split('-');
		if (allParams.length < 4) {
			alert ('Ocurrio un error con los parámetros. Consulte a su administrador.');
			return false;
		}
		var otAction = '';
		var confirmMessage = '';
		var errorMessage_1 = '';
		var errorMessage0 = 'Ocurrio un error, no se pudo guardar la OT, consulte a su administrador.';
		var errorMessageOK = '';
		var url = '';
// allParams[1] contains OT id, allParams[2] contains something called 'gmm', allParams[2] contains something called 'is_poliza'		
		if (current.hasClass('mark-ntu')) {
			otAction = 'mark_ntu';
			confirmMessage = '¿Esta seguro que quiere marcar la OT como NTU?';
			errorMessage_1 = 'No se pudo marcar la OT como NTU. Informe a su administrador.';
			errorMessageOK = 'Se marco la OT como NTU correctamente. La página web debe ser actualizada para reflejar los cambios.';
			url = Config.base_url() + 'ot/mark_ntu.html';
		} else if (current.hasClass('mark-pagada')) {
			otAction = 'mark-pagada';
			confirmMessage = '¿Esta seguro que quiere marcar la OT como pagada?';
			errorMessage_1 = 'No se pudo marcar la OT como pagada. Informe a su administrador.';
			errorMessageOK = 'Se marco la OT como pagada correctamente. La página web debe ser actualizada para reflejar los cambios.';
			url = Config.base_url() + 'ot/mark_paid.html';			
		} else
			return false;

		if ( confirm( confirmMessage ) ) {
			$.ajax({
				url: url,
				type: 'POST',
				data: ({order_id: allParams[1], gmm: allParams[2], is_poliza: allParams[3]}),
				dataType : 'json',
				beforeSend: function(){
					current.hide();
				},
				success: function(response){
					switch (response) {
						case '-1':
							alert (errorMessage_1);
							break;
						case '0':
							alert (errorMessage0);
							break;
//						case '1':
						//  refresh the whole page to reflect the change
//							alert (errorMessageOK);
//							window.location.reload();
							break;
						default:
						//  refresh the view of the OT modified
							if ((response.main !== undefined) && (response.menu !== undefined)) {
								$('#tr_' + allParams[1]).html(response.main);
								$('#hide_' + allParams[1]).html(response.menu);
								alert (errorMessageOK);
						//  refresh the whole page to reflect the change
							    window.location.reload();
							} else {
								alert ('Hay un error en la respuesta del sitio web, consulte a su administrador.');
							}
							break;
					}
				}
			});
		}
		return false;
	});

	$(".action_option").on( "click", function( event ) {
		var current = $(this);
		var paymentAction = '';
		var confirmMessage = '';
		var errorMessage_1 = '';
		var errorMessage0 = '';
		var errorMessageOK = '';		
		if (current.hasClass('mark_ignored')) {
			paymentAction = 'mark_ignored';
			confirmMessage = '¿Esta seguro que desea ignorar el pago ?';
			errorMessage_1 = 'No se pudo marcar el pago como ignorado. Informe a su administrador.';
			errorMessage0 = 'Ocurrio un error, no se pudo guardar el pago, consulte a su administrador.';
			errorMessageOK = 'Se marco el pago como ignorado correctamente. La página web debe ser actualizada para reflejar los cambios.';
		} else if (current.hasClass('payment_delete')) {
			paymentAction = 'payment_delete';
			confirmMessage = '¿Esta seguro que desea borrar el pago ?';
			errorMessage_1 = 'No se pudo borrar el pago. Informe a su administrador.';
			errorMessage0 = 'Ocurrio un error, no se pudo borrar el pago, consulte a su administrador.';
			errorMessageOK = 'Se pudo borrar el pago correctamente. La página web debe ser actualizada para reflejar los cambios.';
		} else
			return false;
		if ( confirm( confirmMessage ) ) {
			var form = $(this).siblings(".payment_detail_form");
			form.children(".payment_action").val(paymentAction);
			$.ajax({
				url: '<?php echo site_url('ot/payment_actions')?>',
				type: 'POST',
				data: form.serialize(),
				dataType : 'json',
				beforeSend: function(){
					$(".action_option").hide();
				},
				success: function(response){
					switch (response) {
						case '-1':
							alert (errorMessage_1);
							break;
						case '0':
							alert (errorMessage0);
							break;
						case '1':
						//  refresh the whole page to reflect the change
							alert (errorMessageOK);
							window.location.reload();
							break;
						default:
							alert ('Hay un error en la respuesta del sitio web, consulte a su administrador.');
							break;
					}
				}
			});
		}
		return false;
	});

/////////
		function explode( val ) {
			return val.split( /\n\s*/ );
		}
		function extractLastRemote( term ) {
			return explode( term ).pop();
		}
		$( ".submit-form").bind("click", function( event ) {
			$( "#form").submit();
		})
		$( "#clear-policy-filter").bind("click", function( event ) {
			$( "#policy-num" ).val("");
			$( "#form").submit();
		})
		$( "#policy-num" )
		// don\'t navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
					$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
/*			.bind( "change", function( event ) {
alert("changed!");
			})*/
			.autocomplete({
				minLength: 3,
/*				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						agentList, extractLastRemote( request.term ) ) );
				},*/
				source: function( request, response ) {
					$.getJSON( Config.base_url() + 'ot/search_polizas.html', {
						term: extractLastRemote( request.term )
					}, response );
				},				
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = explode( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the line feed at the end
					terms.push( "" );
					this.value = terms.join( "\n" );
					$( "#form").submit();
					return false;
				}
			})
});