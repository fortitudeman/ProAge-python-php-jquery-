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
	
	$( '.table' ).flexigrid({
		
		sortname: "Agente",
        sortorder: "asc",
		width: 'auto',
        height: 500
		
	});
	
	$( '.link-ramo' ).bind( 'click', function(){
		
		
		$( '.vida' ).removeClass( 'item-active' );
		$( '.gmm' ).removeClass( 'item-active' );
		$( '.autos' ).removeClass( 'item-active' );
		
		$( '.vida' ).removeClass( 'item-desactive' );
		$( '.gmm' ).removeClass( 'item-desactive' );
		$( '.autos' ).removeClass( 'item-desactive' );
		
		
		if( this.id == 'vida' ){
			
			$( '.vida' ).addClass( 'item-active' );
			
			$( '.vida h3 a' ).css({ 'color':'#87D4FF','text-decoration' : 'none' });
			
			$( '.gmm h3 a' ).css({ 'color': '#000' ,'text-decoration' : 'none' });
			
			$( '.autos h3 a' ).css({ 'color': '#000' ,'text-decoration' : 'none' });
			
			$( '#ramo' ).val(1);
			
		}
		
		if( this.id == 'gmm' ){
			
			$( '.gmm' ).addClass( 'item-active' );
			
			$( '.gmm h3 a' ).css({ 'color':'#87D4FF','text-decoration' : 'none' });
			
			$( '.vida h3 a' ).css({ 'color': '#000' ,'text-decoration' : 'none' });
			
			$( '.autos h3 a' ).css({ 'color': '#000' ,'text-decoration' : 'none' });
			
			$( '#ramo' ).val(2);
		}
		
		if( this.id == 'autos' ){
			
			$( '.autos' ).addClass( 'item-active' );
			
			$( '.autos h3 a' ).css({ 'color':'#87D4FF','text-decoration' : 'none' });
			
			$( '.vida h3 a' ).css({ 'color': '#000' ,'text-decoration' : 'none' });
			
			$( '.gmm h3 a' ).css({ 'color': '#000' ,'text-decoration' : 'none' });
			
			$( '#ramo' ).val(3);
		}
			
			
		
	});
});