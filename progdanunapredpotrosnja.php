<?php
include_once 'lang.php';
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $faviconText ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by GetTemplates.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="GetTemplates.co" />

	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link rel="shortcut icon" type="image/png" href="./images/favicon_ems_8.1.ico"/>

	<link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i|Roboto+Mono" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="sass/style.css">

	<!-- Tabela style  -->
	<link rel="stylesheet" href="sass/table.css">

	<!-- slider-novosti -->
	<link rel="stylesheet" href="css/slider-novosti.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://www.highcharts.com/media/com_demo/css/highslide.css" />

	<!-- Highcharts -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<!-- Datepicker -->
	

	<link rel="stylesheet" href="css/classic.css">
	<link rel="stylesheet" href="css/classic.date.css">
	<link rel="stylesheet" href="css/classic.time.css">
	
	<!-- FOR IE9 below -->
<!--[if lt IE 9]>
<script src="js/respond.min.js"></script>
<![endif]-->	

</head>
<body>

	<div id="page">

		<?php include 'header2.php' ?>

		<div id="prekogranicni-plan-rada">			
			<div class="container">
				<h1><?php echo $naslov ?></h1>
				<label><?php echo $datum; ?></label>
				<input class="datepicker" />
				<div class="tab-group">

					<section id="tab1" title="Tabela">						
						<div id="dvTable">																						
						</div>													
					</section>

					<section id="tab2" title="Grafik">		
						
												
							<div id="highchart_container2" style="min-width: 310px; max-width: 900px; height: 400px; margin: 0"></div>															
			
					</section>

					<section id="tab3" title="XML">
						<h3>
							Content 3
						</h3>
						<p>
							Vivamus sem odio, mattis vel dui aliquet, iaculis lacinia nibh. Vestibulum tincidunt, lacus vel semper pretium, nulla sapien blandit massa, et tempor turpis urna eu mi.
						</p>
					</section>

					<section id="tab4" title="Preuzimanje">
						<h3>
							Content 4
						</h3>

					</section>			
				</div>
			</div>
			
		</div>

		<?php include 'footer.php' ?>



			<!-- jQuery -->
		<script src="js/jquery-3.3.1.min.js"></script>
			<!-- jQuery Easing -->
		<script src="js/jquery.easing.1.3.js"></script>
			<!-- Bootstrap -->
		<script src="js/bootstrap.min.js"></script>
			<!-- Waypoints -->
		<script src="js/jquery.waypoints.min.js"></script>
			<!-- Stellar -->
		<script src="js/jquery.stellar.min.js"></script>
			<!-- Main -->
		<script src="js/main.js"></script>
			<!-- Table -->
		<script src="js/table.js"></script>
			<!-- Responsive Caurasel slider -->
		<script src="js/responsiveCarousel.js"></script>

			<!-- Datepicker -->
		<script src="js/picker.js"></script>
		<script src="js/picker.date.js"></script>
		<script src="js/picker.time.js"></script>
		<script src="js/legacy.js"></script>

			<!-- Highcharts -->
			<script src="https://code.highcharts.com/modules/data.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<!-- Additional files for the Highslide popup effect -->
<script src="https://www.highcharts.com/media/com_demo/js/highslide-full.min.js"></script>
<script src="https://www.highcharts.com/media/com_demo/js/highslide.config.js" charset="utf-8"></script>

		<script>			

			var clickedBtnID;
			var dataCountry;
			var direction;
			var i;

				document.addEventListener('DOMContentLoaded', function () {
						
					
					Highcharts.chart('highchart_container2', {

						chart: {
							scrollablePlotArea: {
								minWidth: 900
							}
						},

						data: {
							csvURL: 'https://cdn.rawgit.com/highcharts/highcharts/' +
								'057b672172ccc6c08fe7dbb27fc17ebca3f5b770/samples/data/analytics.csv',
							beforeParse: function (csv) {
								return csv.replace(/\n\n/g, '\n');
							}
						},

						title: {
							text: 'Daily sessions at www.highcharts.com'
						},

						subtitle: {
							text: 'Source: Google Analytics'
						},

						xAxis: {
							tickInterval: 7 * 24 * 3600 * 1000, // one week
							tickWidth: 0,
							gridLineWidth: 1,
							labels: {
								align: 'left',
								x: 3,
								y: -3
							}
						},

						yAxis: [{ // left y axis
							title: {
								text: null
							},
							labels: {
								align: 'left',
								x: 3,
								y: 16,
								format: '{value:.,0f}'
							},
							showFirstLabel: false
						}, { // right y axis
							linkedTo: 0,
							gridLineWidth: 0,
							opposite: true,
							title: {
								text: null
							},
							labels: {
								align: 'right',
								x: -3,
								y: 16,
								format: '{value:.,0f}'
							},
							showFirstLabel: false
						}],

						legend: {
							align: 'left',
							verticalAlign: 'top',
							borderWidth: 0
						},

						tooltip: {
							shared: true,
							crosshairs: true
						},

						plotOptions: {
							series: {
								cursor: 'pointer',
								point: {
									events: {
										click: function (e) {
											hs.htmlExpand(null, {
												pageOrigin: {
													x: e.pageX || e.clientX,
													y: e.pageY || e.clientY
												},
												headingText: this.series.name,
												maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) + ':<br/> ' +
													this.y + ' sessions',
												width: 200
											});
										}
									}
								},
								marker: {
									lineWidth: 1
								}
							}
						},

						series: [{
							name: 'All sessions',
							lineWidth: 4,
							marker: {
								radius: 4
							}
						}, {
							name: 'New users'
						}]
						});				
				
					// $.ajax({						
					// 	url: 'http://localhost/stefan_www/transparentnost/progdanunapredpotros.json',
					// 	success: function(data) {	
					// 		//var data = odaberiData(allData);						
					// 		options.xAxis.categories = data[0];
					// 		options.series[0].data = data[1].map(Number);
					// 		options.series[0].name = 'Romania -> Serbia';
					// 		$('.mapa-srb div:first-child').addClass('clickedDirection');
					// 		var chart = new Highcharts.Chart(options);
					// 	}
					// });


					// $('.mapa-srb div').click(function(){
					// 	$('.mapa-srb').children().removeClass('clickedDirection');
					// 	$(this).addClass('clickedDirection');
					// 	console.log( $(this).index(this) );
					// 	clickedBtnID = $(this).attr('id');
					// 	console.log(clickedBtnID);

					// 	$.ajax({						
					// 		url: 'http://localhost/stefan_www/transparentnost/data.json',
					// 		success: function(data) {	
					// 			var obj = odaberiData(clickedBtnID);						
					// 			options.xAxis.categories = data[0];
					// 			options.series[0].data = data[obj[0]].map(Number);
					// 			options.series[0].name = obj[1];
					// 			console.log(obj[1]);
					// 			var chart = new Highcharts.Chart(options);
					// 		}
					// 	});
					// });

					function odaberiData(i) {
						if (i == 'rors') {
							return ["1", "Romania -> Serbia"];
						} else if (i == 'rsro') {
							return ["2", "Serbia -> Romania"];
						}
					}

				

				});


			

			$(document).ready(function(){
				$('.datepicker').pickadate({
					
				});
			});

		</script>

	</body>
	</html>
