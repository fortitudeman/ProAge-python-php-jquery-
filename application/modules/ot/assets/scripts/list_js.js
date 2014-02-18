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
var proagesOt = {};
proagesOt.menuRowShown = {};

$( document ).ready(function() {

	$( ".my-btn-hide" ).bind( "click", function(){
		var idPart = $(this).attr("id").substr(12);
		$( "#menu-" + idPart).hide();
		proagesOt.menuRowShown["menu-" + idPart] = null;
	});
	
	$("#sorter").tablesorter({ 
		// sort on all columns except last, order asc 
		sortList: [[0,0], [1,0], [2,0], [3,0], [4,0], [5,0], [6,0]] 
	});
	
	//assign the sortStart and sortEnd events
	$("#sorter")
		.bind("sortStart",function() {

		})
		.bind("sortEnd",function() {
			$( ".popup" ).hide();
			$("#sorter .data-row-class").each(function (i) {
				var idPart = $(this).attr("id").substr(9);
				$(this).after($("#menu-" + idPart));
			});
			$.each( proagesOt.menuRowShown, function( key, value ) {
				if (value !== null) {
					$("#" + value).show();
				}
			});
		});

});