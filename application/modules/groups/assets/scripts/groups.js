$( document ).ready(function() {
	var currentMiembro = null;
	$( '#form' ).validate({
		 submitHandler: function(form) {
			// some other code
			// maybe disabling submit button
			// then:
			$( '#actions-buttons-forms' ).html( '<img src="'+Config.base_url()+'images/ajax-loaders/ajax-loader-5.gif">' );
			form.submit();
		  }		
	});

	$(".miembros-container").on("click", ".add-agent",function(e){
		e.preventDefault();
		$this = $(this);
		var newMiembro = $this.parent().parent().clone();
		if(newMiembro.find(".add-agent").length){
			var addClientButton = newMiembro.find(".add-agent");
			addClientButton.addClass("remove-agent").removeClass("add-agent");
			addClientButton.find("i").removeClass("icon-plus").addClass("icon-minus");
		}
		newMiembro.find("label").html("");
		newMiembro.find(".miembro-text").val("");
		newMiembro.find(".miembro-hidden").val("");
		$(".miembros-container").append(newMiembro);
	});

	$(".miembros-container").on("click", ".remove-agent", function(e){
		e.preventDefault();
		$(this).parent().parent().remove();
	});

	$(".miembros-container").on("click", ".search-agent", function(e){
		e.preventDefault();
		currentMiembro = $(this).parent().parent();
		$("#search-modal").modal("show")
	});

	$("#search-button").on("click",function(){
		var url = Config.base_url()+"groups/searchAgent";
		var search = $("#search-query").val().trim();

		if(search != ""){
			var agent_ids = $("input[name^='miembros']").map(function (idx, ele) {
			   return $(ele).val();
			}).get();

			$.ajax(url, {
				method: "POST",
				data: {
					name: search,
					agents: agent_ids
				},
				dataType: "html",

				success: function(data){
					$(".result").html(data);
				}
			});
		} 
	});

	$("#add-button").on("click", function(e){
		e.preventDefault();
		var agents = $("input[name^='agent_id']:checked").map(function (idx, ele) {
		   return $(ele).val();
		}).get();

		$.each(agents, function(i, agent){
			if(i == 0){
				var miembroName = $("td[data-name="+agent+"]").html()+" "+$("td[data-last-name="+agent+"]").html();
				currentMiembro.find(".miembro-hidden").val(agent);
				currentMiembro.find(".miembro-text").val(miembroName);
			}
			else{
				var newMiembro = currentMiembro.clone();
				var miembroName = $("td[data-name="+agent+"]").html()+" "+$("td[data-last-name="+agent+"]").html();
				newMiembro.find("label").html("");
				newMiembro.find(".miembro-hidden").val(agent);
				newMiembro.find(".miembro-text").val(miembroName);
				if(newMiembro.find(".add-agent").length){
					var addClientButton = newMiembro.find(".add-agent");
					addClientButton.addClass("remove-agent").removeClass("add-agent");
					addClientButton.find("i").removeClass("icon-plus").addClass("icon-minus");
				}
				currentMiembro.after(newMiembro);
				currentMiembro = newMiembro;
			}
		});
		$("#search-modal").modal("hide");
	});

	$("#search-modal").modal({
		"show": false
	})

	$('#search-modal').on('hidden', function () {
	  	$("#search-modal .result").html("");
		$("#search-query").val("");
	})
});