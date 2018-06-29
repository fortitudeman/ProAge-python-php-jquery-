(function(){
	var imports = {
		init: function(){
			this.cacheDom();
			this.binder();
			this.render();
		},
        
        showLoadingScreen: function(){
            document.getElementsByClassName('row-fluid sortable')[0].style.visibility = 'hidden';
            document.getElementsByClassName('loading-message')[0].style.visibility = 'block';
        },
		cacheDom: function() {
			this.$formDelete = $("#import-delete");
			this.$product = $("#product-type-delete");
			this.$selectedMonth =this.$formDelete.find("#month-delete");
			this.$month = $('#month-delete').find('option:selected').val();
			this.$selectedYear = this.$formDelete.find("#year-delete");
			this.$btnDelete = this.$formDelete.find("#delete-submit");
			this.$importPayment = $('#formfile');
			this.$btnImport = this.$importPayment.find("#btnImport");
			this.$dialog = $("#dialog-form");
			this.$control = $("#control").val(this.id);
			this.$btnOpen = $(".create-user");
		},
		binder: function(){
			this.$btnDelete.on('click', this.deletePayments.bind(this));
			this.$btnOpen.on('click', this.openDialog.bind(this));
			//this.$importPayment.on('submit',this.importPayments.bind(this));
		},
		render: function(){
			this.$dialog.dialog({
				autoOpen: false,
				height: 600,
				width: 800,
				modal: true,
				buttons: {
					Cerrar: function() {
						$( this ).dialog( "close" );
						$.ajax({

							url: Config.base_url()+'ot/getSelectAgents.html',
							type: "POST",
							cache: false,
							async: false,
							success: function(data){
								var option = this.$control.val();

								option = option.split('-');

								$( '.options-'+option[1] ).html(data);
							}
						});
					}
				}
			});
		},
		deletePayments: function(){
			swal({
				title: "¿Esta seguro que desea eliminar estos pagos?",
				text: "Una vez realizada la operación, no se podrá deshacer.",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					url = Config.base_url() + 'ot/delete_payments.html';
					$.ajax({
						url: url,
						type: 'POST',
						data: $( "#import-delete").serialize(),
						dataType : 'json',
						beforeSend: function(){
							$( "#delete-submit").hide();
						},
						success: function(response){
							console.log(this.$month);
							$( "#delete-submit").show();
							switch (response) {
								case '-1':
								swal ('No se pudo borrar los pagos. Informe a su administrador.');
								break;
								case '-2':
								swal ('Ocurrio un error, no se pudo borrar los pagos, consulte a su administrador.');
								break;
								case '0':
								swal ('No hay pagos para el mes - año - producto seleccionados.');
								break;
								default:
								swal("La operación se ha realizado con exito!", {
									icon: "success",
								});
								break;
							}
						}
					});
				}
			});
			return false;
		},
		importPayments: function(){
			$.ajax({
				url:Config.base_url() +"ot/import_payments",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
				beforeSend:function(){
					this.$btnImport.html('Importando...');
				},
				success:function(data)
				{
					this.$importPayment.reset();
					this.$btnImport.attr('disabled', false);
					this.$btnImport.html('Importar');
					swal("La importación se ha realizado con exito!", {
						icon: "success",
					});
				}
			})
			return false;
		},
		openDialog: function() {
			this.render();
			this.$dialog.dialog( "open" );
		}
	};
	imports.init();
})()

  	$( "#dialog-form" ).dialog({
  		autoOpen: false,
  		height: 600,
  		width: 800,
  		modal: true,
  		buttons: {
  			Cerrar: function() {
  				$( this ).dialog( "close" );
  				$.ajax({

  					url:  Config.base_url()+'ot/getSelectAgents.html',
  					type: "POST",
  					cache: false,
  					async: false,
  					success: function(data){
  						var option = $( '#control' ).val();

  						option = option.split('-');

  						$( '.options-'+option[1] ).html(data);
  					}
  				});
  			}
  		}
  	});
