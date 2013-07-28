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
    
	$( '#form' ).validate({
		
		 submitHandler: function(form) {
			// some other code
			// maybe disabling submit button
			// then:
			$( '#actions-buttons-forms' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-5.gif">' );
			
			var toDay = new Date();
			var seconds = toDay.getSeconds();
			var minutes = toDay.getMinutes();
			var hour = toDay.getHours();
			
			toDay = hour+':'+minutes+':'+seconds;
			
			$( '#creation_date' ).val( $( '#creation_date' ).val()+' '+ toDay);	
			
			
			form.submit();
		  }		
		
	});
	
	
	
	// Hide Fields
	$( '.typtramite' ).hide();
	$( '.subtype' ).hide();
	$( '#formpoliza' ).hide();
	$( '.poliza' ).hide();
	
	
	
	
	// Setting Today
	var toDay = new Date();
	var year = toDay.getFullYear();
	var month = toDay.getMonth();
		if( month < 10 )
			month='0'+month;
	var day = toDay.getDay();
		if( day < 10 )
			day='0'+day;
	toDay = year+'-'+month+'-'+day;

	$( '#creation_date' ).val(toDay);	
	
	$( '#creation_date' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true });
	
	
	
	
	// Getting type tramite
	$( '.ramo' ).bind( 'click', function(){
		
		var Data = { ramo : this.value };
		
		if( this.value == 1 )
			$('#ot').val('0725V'); 
		if( this.value == 2 )
			$('#ot').val('0725G'); 
		if( this.value == 3 )
			$('#ot').val('0725A'); 	
		
		$.ajax({

			url:  Config.base_url()+'ot/typetramite.html',
			type: "POST",
			data: Data,
			cache: false,
			async: false,
			beforeSend: function(){
	
				
				$( '#loadtype' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-1.gif">   Cargando...' );
				$( '#work_order_type_id' ).html('');
				
			},
			success: function(data){
				
				$( '#loadtype' ).html( '' );	
				$( '#work_order_type_id' ).html( data );
				$( '.typtramite' ).show();								
				
			}						
	
		});
		
		$.ajax({

			url:  Config.base_url()+'ot/policies.html',
			type: "POST",
			data: Data,
			cache: false,
			async: false,
			success: function(data){
								
				$( '#policy_id' ).html(data);								
				
			}						
	
		});
		
		
		var Data = { product_group : this.value };
		
		$.ajax({

			url:  Config.base_url()+'ot/getPolicyByGroup.html',
			type: "POST",
			//dataType: "json",
			data: Data,
			cache: false,
			async: false,
			beforeSend: function(){
	
				
				$( '#loadproduct' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-1.gif">   Cargando...' );
				
			},
			success: function(data){
				
				
				$( '#loadproduct' ).html( '' );	
				$( '#product_id' ).html( data );								
				
			}						
	
		});
		
		
	});
	

// Getting sub type	
	$( '#work_order_type_id' ).bind( 'change', function(){
		
		var Data = { type : this.value };
		
		$.ajax({

			url:  Config.base_url()+'ot/subtype.html',
			type: "POST",
			data: Data,
			cache: false,
			async: false,
			beforeSend: function(){
	
				
				$( '#loadsubtype' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-1.gif">   Cargando...' );
				$( '#subtype' ).html('');
				
			},
			success: function(data){
				
				$( '#loadsubtype' ).html( '' );	
				$( '#subtype' ).html( data );
				$( '.subtype' ).show();								
												
				
			}						
	
		});
		
		
	});




/**
 *	Config Poliza
 **/	
	$( '#subtype' ).bind( 'change', function(){
		
		
		if( $( '#work_order_type_id' ).val() == '90' || $( '#work_order_type_id' ).val() == '47' ){
				$( '#formpoliza' ).show();
				$( '.poliza' ).hide();
		}else{
				$( '.poliza' ).show();
				$( '#formpoliza' ).hide();
		}
	
	});
	
	
	
	
	
});


// Adding Fields
function setFields( id ){
				
	var	array = id.split('-');
		
	var field = array[0];	
	
	var field_count = array[1];		
		
	
	var countAgent = parseInt( $( '#countAgent' ).val() );
		
		countAgent++;		
		
		$( '#countAgent' ).val(countAgent);	
		
		var maxValue=0;
		
		$("input[name='porcentaje[]']").each(function ()
		{
			var val = $(this).val();
			
				val = parseInt(val.replace( '%','' ));
				
			maxValue = maxValue+val;
			
		});
				
		maxValue = 100-maxValue;

		if( $( '#'+id ).val() == 0 ){
			
			var	array = id.split('-');
		
			var field = array[0];	
			
			var field_count = array[1];		
			
			$( '#agent-field-'+field_count ).html('');
			
			return false;
		}
		
		if( maxValue > 0 ){
		
				var fields  =	'<div id="agent-field-'+countAgent+'" class="control-group">';
					fields +=	'	<label class="control-label text-error" for="inputError">Agente</label>';
					fields +=	'				<div class="controls">';
					fields +=	'				   <select class="input-xlarge focused required" id="sel-agent-'+countAgent+'" name="agent[]">';
					fields +=	'';					
					fields +=	'				   </select>';
					fields +=	'				   <input class="input-small focused required porcentaje" id ="agent-'+countAgent+'" name="porcentaje[]" type="text"  onblur="javascript: setFields( \'agent-'+countAgent+'\' )" value="'+maxValue+'">';
					fields +=	'				</div>';
					fields +=	'			  </div>';
			
		
				$( '#dinamicagent' ).append( fields );
			/*
			$('#agent-'+countAgent+'').rules('add', {
				max: maxValue
			});
			*/
					
		}
		
		$( '#'+id ).val( $( '#'+id ).val()+'%' );
		
		// LLenar el select agents
		$.ajax({

			url:  Config.base_url()+'ot/getSelectAgents.html',
			type: "POST",
			cache: false,
			async: false,
			success: function(data){
				
				
				$( '#sel-agent-'+countAgent ).html( data );	
						
				
			}						
	
		});
		
	
}