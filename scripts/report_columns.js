// JavaScript Document
/*

  Author		
  Site:			
  Twitter:		
  Facebook:		
  Github:		
  Email:		
  Skype:		
  Location:		Mexíco
 	
*/
$( document ).ready(function() {

	var showPagadas = true;
	var showTramite = true;
	var showPendientes = true;

	function initShowCols() {
		var colToShow = $.cookie('colToShow');
		if ((typeof colToShow !== "undefined") && (colToShow != null)) {
			var showArray = colToShow.split('_');
			if (showArray.length >= 3) {
				showPagadas = (showArray[0] === 'true');
				showTramite = (showArray[1] === 'true');
				showPendientes = (showArray[2] === 'true');
				if (!showPagadas)
					$('#box-pagadas').prop('checked', false);
				if (!showTramite)
					$('#box-tramite').prop('checked', false);
				if (!showPendientes)
					$('#box-pendientes').prop('checked', false);
			}
		} else {
		}
	}
	function showHideCols() {
		$('#select-columns-display :checkbox').each(function(index){
			switch ($(this).val()) {
				case 'pagadas':
					showPagadas = $(this).is(':checked');
					if (showPagadas) {
						$('#total_negocio').show();
						$('#total_negocio_pai').show();
						$('#total_primas_pagadas').show();
						$('.celda_gris').show();
						$('.pagadas-recap').show();
					} else {
						$('#total_negocio').hide();
						$('#total_negocio_pai').hide();
						$('#total_primas_pagadas').hide();
						$('.celda_gris').hide();
						$('.pagadas-recap').hide();
					}
					break;
				case 'tramite':
					showTramite = $(this).is(':checked');
					if (showTramite) {
						$('#total_negocios_tramite').show();
						$('#total_primas_tramite').show();
						$('.celda_roja').show();
						$('.tramite-recap').show();
					} else {
						$('#total_negocios_tramite').hide();
						$('#total_primas_tramite').hide();
						$('.celda_roja').hide();
						$('.tramite-recap').hide();
					}
					break;
				case 'pendientes':
					showPendientes = $(this).is(':checked');
					if (showPendientes) {
						$('#total_negocio_pendiente').show();
						$('#total_primas_pendientes').show();
						$('.celda_amarilla').show();
						$('.pendientes-recap').show();
					} else {
						$('#total_negocio_pendiente').hide();
						$('#total_primas_pendientes').hide();
						$('.celda_amarilla').hide();
						$('.pendientes-recap').hide();
					}
					break;
				default:
					break;
			}
		});
		var colToShow = showPagadas.toString() + '_' + 
			showTramite.toString() + '_' + showPendientes.toString();
//		$.cookie('colToShow', colToShow);
		$.cookie('colToShow', colToShow , { expires: 7 });

		var negociosTotal = 0;
		var primasTotal = 0;
		var negociosProyectados;
		var primasProyectadas;
		var currentValue = 0;
		$('.tbody tr').each(function( iii ) {
			$(this).children().each(function(index) {
				if (index == 0) {
					negociosProyectados = 0;
					primasProyectadas = 0;
				}
				currentValue = $(this).children('.numeros').eq(0).text();
				if (showPagadas) {
					if ($(this).hasClass('celda_gris')) {
						if ($(this).hasClass('prima')) {
							currentValue = parseFloat(currentValue.replace(/\$|\,/g, ''));
							primasProyectadas += currentValue;
						} else {
							currentValue = parseInt(currentValue, 10);
							if (currentValue)
								negociosProyectados += currentValue;
						}
					}
				}

				if (showTramite) {
					if ($(this).hasClass('celda_roja')) {
						if ($(this).hasClass('prima')) {
							currentValue = parseFloat(currentValue.replace(/\$|\,/g, ''));
							primasProyectadas += currentValue;
						} else {
							currentValue = parseInt(currentValue, 10);
							if (currentValue)
								negociosProyectados += currentValue;
						}
					}
				}

				if (showPendientes) {
					if ($(this).hasClass('celda_amarilla')) {
						if ($(this).hasClass('prima')) {
							currentValue = parseFloat(currentValue.replace(/\$|\,/g, ''));
							primasProyectadas += currentValue;
						} else {
							currentValue = parseInt(currentValue, 10);
							if (currentValue)
								negociosProyectados += currentValue;
						}
					}
				}

				if ($(this).hasClass('celda_verde')) {
					if ($(this).hasClass('prima')) {	
						$(this).children('.numeros').eq(0).text('$' + primasProyectadas.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
						primasTotal += primasProyectadas;
					} else {
						$(this).children('.numeros').eq(0).text(negociosProyectados);
						negociosTotal += negociosProyectados;
					}
				}
			});
		});
// totals:
		$('#negocio-recap').text(negociosTotal);
		$('#prima-recap').text('$' + primasTotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
	}

	$('#select-columns-display :checkbox').change(function() {
		showHideCols();
	});

	$('#link-columns-display').click(function() {
		$('#select-columns-display').toggle();
		return false;
	});

	initShowCols();
	showHideCols();
});
