var Colors = ["#4d4d4d","#5da5da","#faa43a","#60bd68","#f17cB0","#b2912f","#b276b2","#decf3f","#f15854"];
var ColorsExtended = randomColor({
	count: 40,
	luminosity: 'bright',
	seed: 'gus'
})
var AgentsGraph;
$(document).ready( function(){ 
	$(".toggleTable").on("click", function(e){
					e.preventDefault();
					var target = $(this).attr("data-target");
					var resize_target = $(this).attr("data-resize");
					var itag = $(this).find("i");
					itag.toggleClass("icon-signal");
					itag.toggleClass("icon-list-alt");

					var resize_cell = $(this).closest(".row").find(resize_target);
					resize_cell.toggle("fast");
					$(target).toggle("fast");

				});
				var ctx = document.getElementById("agentsContainer").getContext("2d");
				var chart = new Chart(ctx, {
				    // The type of chart we want to create
				    type: "line",
				    // Make responsive
				    responsive: true,
				    // The data for our dataset
				    data: {
				        labels: months,
				        datasets: [
					        {
					            label: "Ventas "+ Y1Title,
					            backgroundColor: "#0088cc",
					            borderColor: "#0088cc",
					            data: Y1.map(obj => obj.amount),
					            fill: false
					        },{
					            label: "Ventas "+ Y2Title,
					            backgroundColor: "#f9ab2e",
					            borderColor: "#f9ab2e",
					            data: Y2.map(obj => obj.amount),
					            fill: false
					        }
				        ],
				        legend: {
					        display: true,
					        labels: {
					            fontColor: "#999999"
					        }
					    }
				    },
				    // Configuration options go here
				    options: {
						tooltips: {
				            mode: "index"
				        },
				        tooltips: {
							callbacks: {
								label: function(tooltipItem, data) {
									var allData = data.datasets[tooltipItem.datasetIndex].data;
									var tooltipLabel = data.datasets[tooltipItem.datasetIndex].label;
									var tooltipData = allData[tooltipItem.index];
									return tooltipLabel + " : $" + number_format(tooltipData, 2);
								}
							}
						},
						scaleLabel: function (valuePayload) {
						    return number_format(valuePayload, 2);
						}
				    }
				});
	var agentsHeight
	$(".imprimir").click(function(e){
		e.preventDefault();
		$(".print").removeClass("print");
		var printable = $(this.closest(".printable"))
		printable.addClass("print");

		if(printable.attr("id") == "AgentsSection"){
			canvas = printable.find("canvas")[0];
			AgentsGraph.update();
			AgentsGraph.render();
			var dataUrl = AgentsGraph.toBase64Image();
			chartImage = new Image();
			chartImage.onload = function(){
				//printable.find("table").css("margin-top", chartImage.height+"px");
				window.print();
			}
	      	chartImage.src = dataUrl;
	      	chartImage.id = "waitLoad";
	      	$(canvas).css("display", "none");
	      	$(canvas).parent().append(chartImage);
		}
		else
			window.print();
	});
	$(".tab-content").on("click", ".popup", function(e){
		e.preventDefault();
		var search_obj = {};
		search_obj.search = $(this).attr("data-search");
		search_obj.value = $(this).attr("data-value");
		solicitudes_popup(search_obj);
	});
	$(window).on("resize", function(){
		$(".tfoot").css("display", "none")
		var activeTab = $(".nav-tabs .active").index();
		if(activeTab == 0){
			var table = $("#tablesorted");
			$(".tfoot").css({
				"left" : table.offset().left+"px",
				"width": table.width()+"px",
			});
			table.find("thead tr th").each(function(i, val){
				$(".tfoot tr th").eq(i).width($(val).width());
			});
			$(".tfoot").css("display", "table-footer-group");
		}
	});
	$(window).trigger("resize");
});

function dynamicSort(property) {
    var sortOrder = 1;
    if(property[0] === "-") {
        sortOrder = -1;
        property = property.substr(1);
    }
    return function (a,b) {
    	a[property] = parseFloat(a[property]);
    	b[property] = parseFloat(b[property]);
        var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
        return result * sortOrder;
    }
}

var beforePrint = function() {
};
var afterPrint = function() {
	var printable = $(".printable");
    if(printable.attr("id") == "AgentsSection"){
    	canvas = printable.find("canvas")[0];
    	table = printable.find("table")[0];
    	$(canvas).css("display", "block");
		$(canvas).parent().find("img").remove();
	}
};

if (window.matchMedia) {
    var mediaQueryList = window.matchMedia('print');
    mediaQueryList.addListener(function(mql) {
        if (mql.matches) {
            beforePrint();
        } else {
            afterPrint();
        }
    });
}

window.onbeforeprint = beforePrint;
window.onafterprint = afterPrint;

function number_format(number, decimals){
	number = parseFloat(Math.round(number * 100) / 100).toFixed(decimals);
	number = number.toString();
    x = number.split(".");
	x1 = x[0];
	x2 = x.length > 1 ? "." + x[1] : "";
    x1 = x1.split(/(?=(?:...)*$)/);
    // Convert the array to a string and format the output
    number = x1.join(",");
    number = number+x2;
    return number;
}

function changeUrl(){
	var selected_tab = $(".nav-tabs .active a").attr("href").substr(1);
	var selected_order = $(".sorter").attr("data-sort-by");
	var newUrl = Config.base_url()+"solicitudes/summary/"+selected_tab+"/"+selected_order+".html";
	$("#ot-form").attr("action", newUrl);
	history.replaceState({}, null, newUrl);
}

function solicitudes_popup(search_obj){
	var url = Config.base_url()+"solicitudes/popup";
	$.fancybox.showLoading();
	$.post(url, search_obj,function(data)
    { 
        if(data)
        {
            $.fancybox({
              content:data
        	});    
        	$("#tableajax").tablesorter({theme : "default", widthFixed: true, widgets: ["zebra"]});
            return false;
        }
    })
    .fail(function() {
	    $.fancybox({
              content: "Ha ocurrido un error, intente mas tarde"
        });    
	});
}