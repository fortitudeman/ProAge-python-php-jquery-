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
		  	
			
			$( '#password' ).val( calcMD5( $( '#password' ).val() ) );
			
			form.submit();
		  }		
		
	});
	
	
	// Hide And Show block agent inputs
	$( '.input-agente' ).hide();
	$( '.input-novel-agente' ).hide();
	$( '.input-fisica' ).hide();
	$( '.input-moral' ).hide();
	
	
	$( '.roles' ).bind( 'click', function(){ 
				
		if( this.value == 1 && this.checked == true )
			$( '.input-agente' ).show();
		else if( this.value == 1 && this.checked == false )
			$( '.input-agente' ).hide();	
	
	})
	
	
	$( '.agente' ).bind( 'click', function(){ 	
		if( this.value == 2 ){
			$( '.input-novel-agente' ).show();
		}else{
			$( '.input-novel-agente' ).hide();
			$( '#folio_nacional_fields' ).html('');	// Clean and reset form
			$( '#folio_provicional_fields' ).html('');	// Clean and reset form
		}
	})
	
	
	
	$( '.persona' ).bind( 'click', function(){ 	
		
		if( this.value == 'fisica' ){
			
			$( '.input-moral' ).hide();	
			$( '.input-fisica' ).show();
			$( '.block-moral' ).removeClass( 'moral' );
			$( '#moral-fields' ).html(''); // Clean and reset form
			
		}else{
			
			$( '.input-fisica' ).hide();
			$( '.input-moral' ).show();	
			$( '.block-moral' ).addClass( 'moral' );
			
		}
	
	})
	
	
	// Addes Fields 
	$( '#folio_nacional_add' ).bind( 'click', function(){
			$( '#folio_nacional_fields' ).append( '<br><input class="input-xlarge focused" name="folio_nacional[]" type="text"><br>' )   
	});
	
	$( '#folio_provicional_add' ).bind( 'click', function(){
			$( '#folio_provicional_fields' ).append( '<br><input class="input-xlarge focused" name="folio_provicional[]" type="text"><br>' )   
	});
	
	
	$( '#moral_add' ).bind( 'click', function(){
		
		
			var fields =   '<div class="control-group error input-moral">';
                fields +=  ' <label class="control-label" for="inputError">Nombre</label>';
                fields +=   ' <div class="controls">';
                fields +=     '<input class="input-xlarge focused required" name="name_r[]" type="text">';
                fields +=    '</div>';
                fields +=  '</div>';
                  
                  
               fields +=   '<div class="control-group error input-moral">';
               fields +=     '<label class="control-label" for="inputError">Apellidos</label>';
               fields +=     '<div class="controls">';
               fields +=      ' <input class="input-xlarge focused required" name="lastname_r[]" type="text">';
               fields +=    ' </div>';
               fields +=  ' </div>';
                   
                   
                 
               fields +=    '<div class="control-group error input-moral">';
               fields +=     '<label class="control-label" for="inputError">Teléfono oficina</label>';
               fields +=     '<div class="controls">';
               fields +=       '<input class="input-xlarge focused required" name="office_phone[]" type="text">';
               fields +=    ' </div>';
               fields +=   '</div>';
                  
               fields +=    '<div class="control-group error input-moral">';
               fields +=     '<label class="control-label" for="inputError">Extensión</label>';
               fields +=      '<div class="controls">';
               fields +=      ' <input class="input-xlarge focused required" name="office_ext[]" type="text">';
               fields +=    ' </div>';
               fields +=  ' </div>';
                  
               fields +=  '<div class="control-group error input-moral">';
               fields +=    '<label class="control-label" for="inputError">Teléfono movil</label>';
               fields +=     '<div class="controls">';
               fields +=      ' <input class="input-xlarge focused required" name="mobile[]" type="text">';
               fields +=    ' </div>';
               fields +=   '</div>';
				
			   fields += '<br>'	;
				
			$( '#moral-fields' ).append( '<br><hr>'+fields )   
	});
	
	
	
	// Field Dates
	$( '#birthdate' ).datepicker({ dateFormat: "yy-mm-dd" });
	$( '#connection_date' ).datepicker({ dateFormat: "yy-mm-dd" });
	$( '#license_expired_date' ).datepicker({ dateFormat: "yy-mm-dd" });
	
	
	
});