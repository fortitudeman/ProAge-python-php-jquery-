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
		  	
			form.submit();
		  }		
		
	});
	
	
	var startDate;
    var endDate;
    
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('#week').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }
    
    $('#week').datepicker( {
        showOtherMonths: true,
        selectOtherMonths: true,
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+1);
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 5);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
            //$('#startDate').text($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
            //$('#endDate').text($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
            //alert( selectedWeek = $.datepicker.iso8601Week(new Date(dateText)));
			$('#startDate').text( month(startDate.getMonth()) + ' ' +  startDate.getDate() +', ' + startDate.getFullYear());
			
			$('#endDate').text( ' - '+  month(endDate.getMonth()) + ' ' +  endDate.getDate() +', ' + endDate.getFullYear() );
			
			selectCurrentWeek();
			
			var Month = startDate.getMonth()+1;
			
			if( Month < 10 ) Month = '0'+Month;
													
			$( '#begin' ).val(  startDate.getFullYear() +'-'+ Month +'-'+ startDate.getDate() );
			
			var Month = endDate.getMonth()+1;
			
			if( Month < 10 ) Month = '0'+Month;
													
			$( '#end' ).val(  endDate.getFullYear() +'-'+ Month +'-'+ endDate.getDate() );
			
        },
        beforeShowDay: function(date) {
            var cssClass = '';
            if(date >= startDate && date <= endDate)
                cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function(year, month, inst) {
            selectCurrentWeek();
        }
    });
    
    $('#week .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
    $('#week .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
		
});

function month( month ){
	
	var monthNames = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
	return monthNames[month];
	
}