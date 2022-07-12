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

	<!-- Highcharts -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>


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
				<h1><?php echo $prekogranicniplanrada ?></h1>
				<label><?php echo $datum; ?></label>
				<input class="datepicker" />
				<div class="tab-group">

					<section id="tab1" title="Tabela">						
						<div id="dvTable">																						
						</div>													
					</section>

					<section id="tab2" title="Grafik">		
						<div class="mapa-srb">
							<div id="rors" class="arrow1"><span>&#171;</span></div>
							<div id="rsro" class="arrow2"><span>&laquo;</span></div>
							<div id="hurs" class="arrow3"><span>&#171;</span></div>
							<div id="rshu" class="arrow4"><span>&#171;</span></div>
							<div id="hrrs" class="arrow5"><span>&#171;</span></div>
							<div id="rshr" class="arrow6"><span>&#171;</span></div>
							<div id="bars" class="arrow7"><span>&#171;</span></div>
							<div id="rsba" class="arrow8"><span>&#171;</span></div>
							<div id="mers" class="arrow9"><span>&#171;</span></div>
							<div id="rsme" class="arrow10"><span>&laquo;</span></div>
							<div id="alrs" class="arrow11"><span>&#171;</span></div>
							<div id="rsal" class="arrow12"><span>&#171;</span></div>
							<div id="mkrs" class="arrow13"><span>&#171;</span></div>
							<div id="rsmk" class="arrow14"><span>&#171;</span></div>
							<div id="bgrs" class="arrow15"><span>&#171;</span></div>
							<div id="rsbg" class="arrow16"><span>&#171;</span></div>
							<img src="images/Blank_map_of_Serbia_named_2.jpg" alt="">						
						</div>
												
							<div id="highchart_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>															
			
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

		<script>			

			var clickedBtnID;
			var dataCountry;
			var direction;
			var i;

				document.addEventListener('DOMContentLoaded', function () {
						
					var options = {
						chart: {
							type: 'column',
							renderTo: 'highchart_container',
						},
						title: {
							text: 'Cross-Border Commercial Schedules'
						},
						
						xAxis: {
							categories: [],
							title: {
								text: '[h]',
								align: 'high'
							}
						},
						yAxis: {
							min: 0,
							title: {
								text: '[mw]',
								align: 'high'
							},
							labels: {
								overflow: 'justify'
							}
						},
						plotOptions: {
							bar: {
								dataLabels: {
									enabled: true
								}
							}
						},
						// legend: {
						// 	layout: 'vertical',
						// 	align: 'right',
						// 	verticalAlign: 'top',
						// 	x: -30,
						// 	y: 20,
						// 	floating: true,
						// 	borderWidth: 1,
						// 	shadow: true
						// },
						credits: {
							enabled: false
						},
						colors: ['#70798C'],
						series: [{							
							data: [[]],
							name: "R -> RS"
						}],
						responsive: {
							rules: [{
								condition: {
								maxWidth: 500
								},
								chartOptions: {
									legend: {
										enabled: false
									},
									chart: {
										className: 'small-chart'
									}
								}
							}]
						}
					};
				
					$.ajax({						
						url: 'http://localhost/stefan_www/transparentnost/data.json',
						success: function(data) {	
							//var data = odaberiData(allData);						
							options.xAxis.categories = data[0];
							options.series[0].data = data[1].map(Number);
							options.series[0].name = 'Romania -> Serbia';
							$('.mapa-srb div:first-child').addClass('clickedDirection');
							var chart = new Highcharts.Chart(options);
						}
					});


					$('.mapa-srb div').click(function(){
						$('.mapa-srb').children().removeClass('clickedDirection');
						$(this).addClass('clickedDirection');
						console.log( $(this).index(this) );
						clickedBtnID = $(this).attr('id');
						console.log(clickedBtnID);

						$.ajax({						
							url: 'http://localhost/stefan_www/transparentnost/data.json',
							success: function(data) {	
								var obj = odaberiData(clickedBtnID);						
								options.xAxis.categories = data[0];
								options.series[0].data = data[obj[0]].map(Number);
								options.series[0].name = obj[1];
								console.log(obj[1]);
								var chart = new Highcharts.Chart(options);
							}
						});
					});

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
