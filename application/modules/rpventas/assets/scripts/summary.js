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
	var ctx = document.getElementById("ventasContainer").getContext("2d");
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: "bar",
	    // Make responsive
	    responsive: true,
	    // The data for our dataset
	    data: {
	        labels: months,
	        datasets: [
		        /*{
		            label: "Primas "+ Y1Title,
		            backgroundColor: "#f15854",
		            borderColor: "#f15854",
		            data: P1,
		            fill: false
		        },{
		            label: "Primas "+ Y2Title,
		            backgroundColor: "#b276b2",
		            borderColor: "#b276b2",
		            data: P2,
		            fill: false
		        },{
		            label: "Negocios "+ Y1Title,
		            backgroundColor: "#b2912f",
		            borderColor: "#b2912f",
		            data: N1,
		            fill: false
		        },{
		            label: "Negocios "+ Y2Title,
		            backgroundColor: "#f17cB0",
		            borderColor: "#f17cB0",
		            data: N2,
		            fill: false
		        },*/{
		            label: "Ventas "+ Y1Title,
		            backgroundColor: "#0088cc",
		            borderColor: "#0088cc",
		            data: Y1,
		            fill: false
		        },{
		            label: "Ventas "+ Y2Title,
		            backgroundColor: "#f9ab2e",
		            borderColor: "#f9ab2e",
		            data: Y2,
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
			scales: {
		        yAxes: [{
		          ticks: {
		            beginAtZero: true,
		            callback: function(value, index, values) {
		              return "$" + number_format(value, 0);
		            }
		          }
		        }]
		    }
	    }
	});
	var ctx = document.getElementById("productsContainer").getContext("2d");
		var scw = $(window).width()-39;
		if(scw<522){
			var currentWindowHeight = $(window).height();
	        var canvas = document.getElementById("productsContainer")
	        var chartHeight = currentWindowHeight - 220
	        var lineChartParent = document.getElementById('productsCell')
	        canvas.width = lineChartParent.clientWidth;
	        canvas.height = chartHeight;
        }
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: "line",
	    // Make responsive
	    responsive: true,
	    // The data for our dataset
	    data: {
	        labels: months,
	        datasets: ProdDs,
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
						var tooltipTotal = data.datasets[tooltipItem.datasetIndex].totaly;
						var tooltipData = allData[tooltipItem.index];
						return tooltipLabel + " : $" + number_format(tooltipData, 2);
					},
					afterLabel: function(tooltipItem, data) {
						var allData = data.datasets[tooltipItem.datasetIndex].data;
						var tooltipTotal = data.datasets[tooltipItem.datasetIndex].totaly;
						var tooltipData = allData[tooltipItem.index];
						return "Total Anual : $" + number_format(tooltipTotal, 2) ;
					}
				},
				displayColors: false
			},
			scales: {
		        yAxes: [{
		          ticks: {
		            beginAtZero: true,
		            callback: function(value, index, values) {
		              return "$" + number_format(value, 0);
		            }
		          }
		        }]
		    }
	    }
	});
	$(".imprimir").click(function(e){
		e.preventDefault();
		$(".print").removeClass("print");
		var printable = $(this.closest(".printable"))
		printable.addClass("print");

		window.print();
	});
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