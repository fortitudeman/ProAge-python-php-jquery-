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
    
	$( '#form' ).validate();
	
	$( '.link-ramo' ).bind( 'click', function(){
		
		$( '#vida' ).css({ 'color': '#000' });
		$( '#gmm' ).css({ 'color': '#000' });
		$( '#autos' ).css({ 'color': '#000' });
			
		
		if( this.id == 'vida' ){
							
			$( '#ramo' ).val(1);
			
			$( '#vida' ).css( 'color', '#06F' );
			
			$( 'label[class="dd-option-text"]' ).html( 'Trimestre' );
			// 'Trimestre' );
			
		}
		
		if( this.id == 'gmm' ){
		
			$( '#ramo' ).val(2);
			
			$( '#gmm' ).css( 'color', '#06F' );
			
			$( 'label[class="dd-option-text"]' ).html( 'Cuatrimestre' );
		}
		
		if( this.id == 'autos' ){
			
			$( '#ramo' ).val(3);
			
			$( '#autos' ).css( 'color', '#06F' );
			
			$( 'label[class="dd-option-text"]' ).html( 'Cuatrimestre' );
		}
			
			
		
	});
});