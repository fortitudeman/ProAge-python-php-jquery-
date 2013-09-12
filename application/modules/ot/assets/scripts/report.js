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
	
	//$( '.advanced' ).hide();
					
	$( '#creation_date' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true });
	$( '#creation_date1' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true });
	$( '#connection_date' ).datepicker({ dateFormat: "yy-mm-dd", changeYear: true, changeMonth:true });
	
});