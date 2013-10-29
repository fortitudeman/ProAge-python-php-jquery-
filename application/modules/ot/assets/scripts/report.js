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
	
       
       
//       $(".fancybox").fancybox(
//       {
//           type: 'ajax',
//           width :1000,
//           scrolling   : 'no',
//           openEffect : 'elastic',
//           openSpeed  : 150,
//           closeEffect : 'elastic',
//           closeSpeed  : 150,
//           autoDimensions: true,
//           height: 'auto',
//           afterShow: function() 
//           {
//                $("tr.tr_pop_class").click(function() 
//                {
//                    var content = '<a href="javascript:" class="btn btn-link btn-hide"><i class="icon-arrow-up" id="'+this.id+'"></i></a><a href="email_popup" class="btn btn-link send_message">Enviar mensaje al cordinador</a>|<a href="email_popup" class="btn btn-link send_message">Enviar mensaje al Agenta</a>|<a href="email_popup" class="btn btn-link send_message">Enviar mensaje al Director</a>';
//                    var added_content = $('#tr_pop_afer'+this.id).length;                
//                    if(added_content == 0)
//                    {
//                        $('#'+this.id).after('<tr class="tr_pop_class" id ="tr_pop_afer'+this.id+'"><td></td><td colspan="11">'+content+'</td></tr>').slideDown(1000);            
//                    
//                        $('.btn-hide i.icon-arrow-up').bind('click',function()
//                        { 
//                            $('#tr_pop_afer'+this.id).remove();
//                        });                        
//
//                        
//                        $('.send_message').bind('click',function()
//                        {
//                           // var value = $(this).text();  
//                            $('.send_message').fancybox(
//                            {
//                                type: 'ajax',
//                                width :800,
//                                height:400,
//                                scrolling:'no'                                
//                            });                         
//                        });                         
//                    }      
//                });
//            }
//       });  
       
       
       
       
       $('#popup_email').submit(function()
       {
           email_body = $('#email_form').val();
           email_address = $('#email_address').val();
           wrk_ids = $('#work_ord_array').val();           
           
           var wrk_ord_ids = new Array();
           wrk_ord_ids = wrk_ids.split(",");           
           
           $.post("ot/send_email",{'email_body':email_body,'email_address':email_address},function(dataa)
            {       
                if(dataa)
                {    
                    $.post("ot/reporte_popup",{wrk_ord_ids:wrk_ord_ids},function(data)
                    { 
                        if(data)
                        {
                            $.fancybox(data);
                            return false;
                        }
                    });
                }
            }, "json");
            return false;        
       });
       
       
    
       
        $('.send_message').bind('click',function()
        {
           emaill_address = this.id;
           poliza_number = $('#poliza_number').html();
           ot_number = $('#ot_number').html();  
           
           var work_ids;
           //var arr = new Array();
           
           $('.wrk_ord_ids').each(function()
           {
              work_ids += this.id+',';
           });           
           
           var result = work_ids.replace("undefined","");        
           
           
           $('.send_message').fancybox(
            {
                type: 'ajax',
                width :800,
                height:400,
                scrolling:'no',
                afterShow: function()
                {
                    $("#email_address").val(emaill_address);
                    $('#ot_numero').html(ot_number);
                    $('#poliza_numero').html(poliza_number);
                    $('#work_ord_array').val(result);
                }
             }); 
        });
               
               
               
        $("tr.tr_pop_class").click(function() 
        {            
            var hide_id = this.id.replace('tr_','');  
            $('#hide_'+hide_id).slideDown(1000);    
        });
       
       
        $('.btn-hide i.icon-arrow-up').bind('click',function()
        { 
            $('#hide_'+this.id).slideUp();
        }); 
        
        
        $("#popup_table").tablesorter(); 
        
        
        
       
});