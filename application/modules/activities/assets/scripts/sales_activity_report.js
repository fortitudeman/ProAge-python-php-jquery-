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

	$(".tablesorter-childRow td").hide();	
	$(".sales-activity-results")
		.tablesorter({ 
			theme : 'default',
			// this is the default setting
			cssChildRow: "tablesorter-childRow"
		});

	// Toggle child row content (td), not hiding the row since we are using rowspan
	// Using delegate because the pager plugin rebuilds the table after each page change
	// "delegate" works in jQuery 1.4.2+; use "live" back to v1.3; for older jQuery - SOL
	$(".sales-activity-results").delegate(".toggle", "click" ,function(){
		// use "nextUntil" to toggle multiple child rows
		// toggle table cells instead of the row
		$(this).closest('tr').nextUntil('tr:not(.tablesorter-childRow)').find('td').toggle();

		return false;
	});

	//assign the sortStart and sortEnd events (for the moment, no special handling)
	$(".sales-activity-results")
		.on("sortStart",function(e, t) {
		})
		.on("sortEnd",function(e, t) {
		});

});