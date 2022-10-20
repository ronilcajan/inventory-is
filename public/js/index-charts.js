'use strict';

/* Chart.js docs: https://www.chartjs.org/ */

window.chartColors = {
	green: '#75c181',
	gray: '#a9b5c9',
	text: '#252930',
	border: '#e7e9ed'
};

// Chart.js Bar Chart Example 
$.ajax({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
    type: "POST",
    url: '/admin/dashboard/yearlySales',
	success: function(response) {
		console.log(response.jan)
		
		var barChartConfig = {
			type: 'bar',
			data: {
				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets: [{
					label: 'Sales',
					backgroundColor: window.chartColors.green,
					borderColor: window.chartColors.green,
					borderWidth: 1,
					maxBarThickness: 16,
					
					data: [
						response.jan,
						response.feb,
						response.mar,
						response.apr,
						response.may,
						response.jun,
						response.jul,
						response.aug,
						response.sep,
						response.oct,
						response.nov,
						response.dec
					]
				}]
			},
			options: {
				responsive: true,
				aspectRatio: 1.5,
				legend: {
					position: 'bottom',
					align: 'end',
				},
				title: {
					display: true,
					text: 'Monthly Sales'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
					titleMarginBottom: 10,
					bodySpacing: 10,
					xPadding: 16,
					yPadding: 16,
					borderColor: window.chartColors.border,
					borderWidth: 1,
					backgroundColor: '#fff',
					bodyFontColor: window.chartColors.text,
					titleFontColor: window.chartColors.text,

				},
				scales: {
					xAxes: [{
						display: true,
						gridLines: {
							drawBorder: false,
							color: window.chartColors.border,
						},

					}],
					yAxes: [{
						display: true,
						gridLines: {
							drawBorder: false,
							color: window.chartColors.borders,
						},
						ticks: {
							beginAtZero: true,
							userCallback: function(value, index, values) {
								return '₱' + value.toLocaleString();   //Ref: https://stackoverflow.com/questions/38800226/chart-js-add-commas-to-tooltip-and-y-axis
							}
						},
						
					}]
				}
			}
			
		}
		var barChart = document.getElementById('canvas-barchart').getContext('2d');
		window.myBar = new Chart(barChart, barChartConfig);
	}
	});

	
