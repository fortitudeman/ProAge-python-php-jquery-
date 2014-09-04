var defFrom = '';
var defTo = '';
var parentForm;

$( document ).ready(function() {

	var selectedRamo = $("#selected-ramo").html();

	var monthNames = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];

	var startDate;
    var endDate;
    var defaultDate = '';
    var beginField = $('#begin').val();
    var endField = $('#end').val();
    if ( ( beginField.length > 0 ) && ( endField.length > 0 ) ) {
        var beginParts = beginField.split('-', 3);
        var endParts = endField.split('-', 3);		
        if ( ( beginParts.length == 3 ) && ( endParts.length == 3) ) {
            defaultDate = beginParts[1].substr(0, 2) + '/' + beginParts[2].substr(0, 2) + '/' + beginParts[0].substr(2, 2);
            startDate = new Date(beginParts[0] + '/' + beginParts[1] + '/' +  beginParts[2]);
            endDate = new Date(endParts[0] + '/' + endParts[1] + '/' + endParts[2]);
        }
    }
	
    var selectCurrentWeek = function() {
        window.setTimeout(function () {
            $('#week').find('.ui-datepicker-current-day a').addClass('ui-state-active')
        }, 1);
    }

    $('#week').datepicker( {
        defaultDate: defaultDate,
        showOtherMonths: true,
        selectOtherMonths: true,
		firstDay:1,
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        onSelect: function(dateText, inst) { 
            var date = $(this).datepicker('getDate');
            startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+1);
            endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+7);
            var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
			$('#startDate').text( monthNames[startDate.getMonth()] + ' ' +  startDate.getDate() +', ' + startDate.getFullYear());
			
			$('#endDate').text( ' - '+  monthNames[endDate.getMonth()] + ' ' +  endDate.getDate() +', ' + endDate.getFullYear() );
			
			selectCurrentWeek();
			
			var Month = startDate.getMonth()+1;
			
			if( Month < 10 ) Month = '0'+Month;

			var theDay = startDate.getDate();
			if ( theDay < 10 )
				theDay = '0' + theDay;

			$( '#begin' ).val(  startDate.getFullYear() +'-'+ Month +'-'+ theDay );
			
			var Month = endDate.getMonth()+1;
			
			if( Month < 10 ) Month = '0'+Month;

			var theDay = endDate.getDate();
			if ( theDay < 10 )
				theDay = '0' + theDay;

			$( '#end' ).val(  endDate.getFullYear() +'-'+ Month +'-'+ theDay );

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
    selectCurrentWeek();

	defFrom = $("#cust_period_from").val();

	defTo = $("#cust_period_to").val();

	var updateEndStart = function( periodoHidden ) {
		var submitForm = false;
		var curDate = new Date();
		var currentYear = curDate.getFullYear();
		var currentMonth = curDate.getMonth() + 1;
		if (currentMonth < 10)
			currentMonth = '0' + currentMonth;
		var currentDay = curDate.getDate();
		if (currentDay < 10)
			currentDay = '0' + currentDay;
		switch(periodoHidden) {
			case '1':	// Month
				$("#cust_period_from").val(currentYear + '-' + currentMonth + '-01');
				$("#cust_period_to").val(currentYear + '-' + currentMonth + '-' + currentDay);
				submitForm = true;
			break;
			case '2':	// Cuatrimestre or Trimestre
				submitForm = true;
				if (selectedRamo == 1) { //  Vida -> Trimestre
					var rank = Math.floor((currentMonth - 1) / 3) + 1;
					switch (rank) {
						case 1:
							$("#cust_period_from").val(currentYear + '-01-01');
							$("#cust_period_to").val(currentYear + '-03-31');
						break;
						case 2:
							$("#cust_period_from").val(currentYear + '-04-01');
							$("#cust_period_to").val(currentYear + '-06-30');
						break;
						case 3:
							$("#cust_period_from").val(currentYear + '-07-01');
							$("#cust_period_to").val(currentYear + '-09-30');
						break;
						case 4:
							$("#cust_period_from").val(currentYear + '-10-01');
							$("#cust_period_to").val(currentYear + '-12-31');
						break;
						default:
							submitForm = false;
						break;
					}
				} else if ((selectedRamo == 2) || (selectedRamo == 3)) { // GMM or Autos -> Cuatrimestre
					var rank = Math.floor((currentMonth -1) / 4) + 1;
					switch (rank) {
						case 1:
							$("#cust_period_from").val(currentYear + '-01-01');
							$("#cust_period_to").val(currentYear + '-04-30');
						break;
						case 2:
							$("#cust_period_from").val(currentYear + '-05-01');
							$("#cust_period_to").val(currentYear + '-08-31');
						break;
						case 3:
							$("#cust_period_from").val(currentYear + '-09-01');
							$("#cust_period_to").val(currentYear + '-12-31');
						break;
						default:
							submitForm = false;
						break;
					}
				} else
					submitForm = false;				
			break;
			case '3':	// Ano
				$("#cust_period_from").val(currentYear + '-01-01');
				$("#cust_period_to").val(currentYear + '-' + currentMonth + '-' + currentDay);
				submitForm = true;
			break;
			case '4':	// Custom
			break;
			case '5':	// Semana
				$("#semana-container").dialog( "open" );
			break;
			default:
			break;
		}
		if (submitForm) {
			updatePeriodSelect("#periodo_form");
			submitTheForm();
		}
//		return false;
	}

	var updatePeriodSelect = function( selectSelector ) {
		defFrom = $("#cust_period_from").val();
		defTo = $("#cust_period_to").val();
		$(selectSelector + " option").each(function () {
			$(this).val($("#periodo").val());
			$(this).html(defFrom + " - " + defTo);
			return false;
		});
	}

	var submitTheForm = function() {
		if (parentForm) {
			parentForm.append(
				'<input type="hidden" name="cust_period_from" value="' + defFrom + '" />' +
				'<input type="hidden" name="cust_period_to" value="' + defTo + '" />');
			$( "#cust_period-form" ).dialog( "close" );
			parentForm.submit();
		}
	}

	updatePeriodSelect("#periodo_form");

	var customDateOptions = {
		changeMonth: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		firstDay:1,
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
			'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
	};
	$( "#cust_period_from" ).datepicker({
		defaultDate: defFrom,
		dateFormat: "yy-mm-dd",
		onClose: function( selectedDate ) {
			$( "#cust_period_to" ).datepicker( "option", "minDate", selectedDate );
		},
		onSelect: function(dateText, inst) {
			updatePeriodSelect("#periodo_form");
		}
	});
	$( "#cust_period_to" ).datepicker({
		defaultDate: defTo,
		dateFormat: "yy-mm-dd",
		onClose: function( selectedDate ) {
			$( "#cust_period_from" ).datepicker( "option", "maxDate", selectedDate );
		},
		onSelect: function(dateText, inst) {
			updatePeriodSelect("#periodo_form");
		}
	});

	jQuery.each(customDateOptions, function(i, val) {
		$( "#cust_period_from" ).datepicker( "option", i, val );
		$( "#cust_period_to" ).datepicker("option", i, val );
	});		

	$( "#cust_period-form" ).dialog({
		autoOpen: false,
		height: 270,
		width: 450,
		modal: true,
		buttons: {
			"Guardar": function() {
				$("#periodo").val(4);
				updatePeriodSelect("#periodo_form");
				submitTheForm();
				$( this ).dialog( "close" );
				return false;
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );
				return false;
			}
		},
		close: function() {
		}
	});

	$( "#semana-container" ).dialog({
		autoOpen: false,
		height: 370,
		width: 300,
		modal: true,
		buttons: {
			"Guardar": function() {
				$("#cust_period_from").val($( '#begin' ).val());
				$("#cust_period_to").val($( '#end' ).val());
				$("#periodo").val(4);
				updatePeriodSelect("#periodo_form");
				submitTheForm();
				$( this ).dialog( "close" );
				return false;
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );
				return false;
			}
		},
		close: function() {
		}
	});

	$("#periodo_form").bind( "click", function(){
		parentForm = $(this).parents("form");
		$( "#cust_period-form" ).dialog( "open" );
		return false;
	})

	$("#periodo-links a").bind( "click", function(){
		var periodoHidden = $(this).attr("tabindex");
		if ((periodoHidden <= 5) && (periodoHidden >= 1)) {
			$("#periodo").val(periodoHidden);
			updateEndStart(periodoHidden);
		}
		return false;
	})
	
	
});