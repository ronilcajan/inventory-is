'use strict';

/* Chart.js docs: https://www.chartjs.org/ */

window.chartColors = {
	red: '#FF0000',
	green: '#75c181',
	blue: '#5b99ea', // rgba(91,153,234, 1)
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
		let this_year = new Date().getFullYear();
		let last_year = new Date().getFullYear()-1;
		var barChartConfig = {
			type: 'bar',
			data: {
				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets: [{
					label: this_year+' Sales',
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
				},
				{
					label: last_year+' Sales',
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					borderWidth: 1,
					maxBarThickness: 16,
					
					data: [
						response.last_jan,
						response.last_feb,
						response.last_mar,
						response.last_apr,
						response.last_may,
						response.last_jun,
						response.last_jul,
						response.last_aug,
						response.last_sep,
						response.last_oct,
						response.last_nov,
						response.last_dec
					]
				}
			]
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
					text: 'Annual Sales Summary'
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
								return '₱ ' + (value.toFixed(2));   //Ref: https://stackoverflow.com/questions/38800226/chart-js-add-commas-to-tooltip-and-y-axis
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

$.ajax({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
    type: "POST",
    url: '/admin/dashboard/delivery',
	success: function(response) {
		console.log(response)
		
		var doughnutChartConfig = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						response.delivered, 
						response.pending,
					],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.blue,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Delivered',
					'Pending',
				]
			},
			options: {
				responsive: true,
				legend: {
					display: true,
					position: 'bottom',
					align: 'center',
				},
		
				tooltips: {
					titleMarginBottom: 10,
					bodySpacing: 10,
					xPadding: 16,
					yPadding: 16,
					borderColor: window.chartColors.border,
					borderWidth: 1,
					backgroundColor: '#fff',
					bodyFontColor: window.chartColors.text,
					titleFontColor: window.chartColors.text,
					
					animation: {
						animateScale: true,
						animateRotate: true
					},
				},
			}
		};

		var doughnutChart = document.getElementById('chart-doughnut').getContext('2d');
		window.myDoughnut = new Chart(doughnutChart, doughnutChartConfig);
	}
});