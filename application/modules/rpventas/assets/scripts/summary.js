var AgentsGraph;
$(document).ready( function(){ 
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
		        {
		            label: "Ventas "+ Y1Title,
		            backgroundColor: Colors[0],
		            borderColor: Colors[0],
		            yAxisID: "y-axis-1",
		            data: V1,
		        },{
		            label: "Ventas "+ Y2Title,
		            backgroundColor: Colors[1],
		            borderColor: Colors[1],
		            yAxisID: "y-axis-1",
		            data: V2,
		        },{
		            label: "Primas "+ Y1Title,
		            backgroundColor: Colors[2],
		            borderColor: Colors[2],
		            yAxisID: "y-axis-1",
		            data: P1,
		        },{
		            label: "Primas "+ Y2Title,
		            backgroundColor: Colors[3],
		            borderColor: Colors[3],
		            yAxisID: "y-axis-1",
		            data: P2,
		        },{
		            label: "Negocios "+ Y1Title,
		            backgroundColor: Colors[4],
		            borderColor: Colors[4],
		            yAxisID: "y-axis-2",
		            data: N1,
		        },{
		            label: "Negocios "+ Y2Title,
		            backgroundColor: Colors[5],
		            borderColor: Colors[5],
		            yAxisID: "y-axis-2",
		            data: N2,
		        },
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
						if(tooltipItem.datasetIndex >= 0 && tooltipItem.datasetIndex <= 3)
							return tooltipLabel + " : $" + number_format(tooltipData, 2);
						else
							return tooltipLabel + " : " + tooltipData;
					}
				}
			},
			scales: {
				yAxes: [{
                    type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: "left",
                    id: "y-axis-1",
                    gridLines: {
                        drawOnChartArea: true
                    },
                    ticks: {
						beginAtZero: true,
						callback: function(value, index, values) {
						  return "$" + number_format(value, 0);
						}
					}
                },{
                    type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                    display: true,
                    position: "right",
                    id: "y-axis-2",
                    gridLines: {
                        drawOnChartArea: false
                    },
                    ticks: {
                    	beginAtZero:true,
			        }
                }],
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
	        	mode: "index",
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
});

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