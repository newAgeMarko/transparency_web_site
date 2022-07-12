<?php
include_once 'lang.php';
?>

<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $faviconText ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by GetTemplates.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="GetTemplates.co" />

	<link rel="shortcut icon" type="image/png" href="./images/favicon_ems_8.1.ico"/>
	<link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i|Roboto+Mono" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
	<!-- <link rel="stylesheet" href="css/magnific-popup.css"> -->
	<!-- Theme style  -->
	<link rel="stylesheet" href="sass/style.css">
	<!-- slider-novosti -->
	<!-- <link rel="stylesheet" href="css/slider-novosti.css"> -->
	<!-- Font Awesome -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> -->
	<link rel="stylesheet" href="fontawesome/css/all.min.css" />
	<!-- <script src="font_awesome/js/all.min.js"></script> -->
	<!-- Modernizr JS -->
	<!-- <script src="js/modernizr-2.6.2.min.js"></script> -->
    <link rel="stylesheet" href="common/css/download.css">
	<link rel="stylesheet" href="common/css/hint.css">
    <link rel="stylesheet" href="common/css/spinner.css">
	<link rel="stylesheet" href="common/css/style.css">
	<link rel="stylesheet" href="common/css/components.css">
	<link rel="stylesheet" href="common/css/plugins.css">
	<link rel="stylesheet" href="common/css/default.css">
	<link rel="stylesheet" href="common/css/stefan.css">	
	
	

</head>
<body class="c-layout-header-fixed c-layout-header-mobile-fixed c-layout-header-fullscreen c-layout-header-topbar">
	
	<div class="gtco-loader"></div>
	
	<div id="page">

		<?php require 'header.php'; ?>
		
		<div id="gtco-main">
			<div id="sekcija-uvod" class="col-md-12">
				<div class="container">
					<div class="row row-pb-md">						
						<h1><?php echo $transparentnostsat ?></h1>
						<h3><?= $TRANSPARENCY_OF_DATA ?></h3>
						<p><?= $TRANSPARENCY_OF_DATA_TEXT ?></p>						
					</div>					
				</div>
			</div>
			
			<div id="sekcija-o-nama" class="col-md-12"> 
				<div class="container">
					<div class="row row-pb-md">
						<h3><?= $THE_TRANSPARENCY_PLATFORM_PROVIDES ?></h3>
						<ul>
							<li class="col-md-4 col-xs-11">
								<i class="fa fa-chart-bar"></i>
								<div class="text-part">
									<h5><?= $ADVANCED_VISUALISATION ?></h5>
									<p><?= $DISPLAYING_DATA ?></p>
								</div>
							</li>
							<li class="col-md-4 col-xs-11">
								<i class="fa fa-sync-alt"></i>
								<div class="text-part">
									<h5><?= $REGULAR_UPDATE ?></h5>
									<p><?= $REGULAR_PUBLISHING_DATA ?></p>
								</div>
							</li>
							<li class="col-md-4 col-xs-11">
								<i class="fa fa-download" aria-hidden="true"></i>
								<div class="text-part">
									<h5><?= $DOWNLOADING_DATA ?></h5>
									<p><?= $ABILITY_TO_DOWNLOAD_DATA ?></p>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div id="grafik">
				<div class="container">
					<div class="row">
						<p style="text-align:center;">
							<iframe height="840px" width="840px" scrolling="yes" src="realtime/realtime.php?lng=e&time=60&p=transparency" style="border:none;margin-top:60px;">
							</iframe>
						</p>
					</div>
				</div>
			</div>

			<div id="sekcija-accordion" class="col-md-12">
				<div class="container">
					<div class="row">				
						<h3><?= $AVALIABLE_DATA ?></h3>	
						<div class="accordion">
							<div class="accordion-item active">
								<a href="#" class="heading">
									<div class="icon"></div>
									<div class="title"><?= $_NETWORK_CAPACITY_EXPLICIT_AUCTIONS ?></div>
								</a>

								<div class="content" style="display:block;">
									<div class="text">
										<p><?= $_NETWORK_CAPACITY ?></p>
										<p><?= $_EXPLICIT_AUCTIONS ?></p>
									</div>									
									<img src="images/NTC_results_front.png" alt="">
								</div>
							</div>

							<div class="accordion-item">
								<a href="#" class="heading">
									<div class="icon"></div>
									<div class="title"><?= $_SYSTEM_VERTICAL_LOAD ?></div>
								</a>

								<div class="content">
									<div class="text">
										<p><?= $_SYSTEM_VERTICAL_LOAD_TEXT ?></p>
									</div>				
									<img src="images/System_vertical_load_graph.png" alt="">					
								</div>
							</div>

							<div class="accordion-item">
								<a href="#" class="heading">
									<div class="icon"></div>
									<div class="title"><?= $_SYSTEM_VERTICAL_LOAD_GRAPH ?></div>
								</a>

								<div class="content">
									<div class="text">
										<p><?= $_SYSTEM_VERTICAL_LOAD_TEXT_GRAPH ?></p>
									</div>	
									<img src="images/System_vertical_load.png" alt="">								
								</div>
							</div>

							<div class="accordion-item">
								<a href="#" class="heading">
									<div class="icon"></div>
									<div class="title"><?= $_PLANED_SCHEDULE_EVOLUTION ?></div>
								</a>

								<div class="content">
									<div class="text">
										<p><?= $_PLANED_SCHEDULE_EVOLUTION_TEXT ?></p>
									</div>		
									<img src="images/Planned_schedule_evolution.png" alt="">							
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
	
			
			<!-- <div id="sekcija-slider" class="col-md-12">
				
				<div class="container">
					<div class="row">
						<div class="sekcija-slider-okvir  col-xs-10 col-xs-offset-1">
							<h3>Новости:</h3>
							<div class="crsl-items" data-navigation="NAV-ID">
								<div class="crsl-wrap">
									<figure class="crsl-item col-sm-6">
										<h2>17.09.2014</h2>
										<a href="#">Објављени подаци - Нето прекогранични преносни капацитет - дневни (у подменију Преносни капацитет)</a>							
									</figure>
									<figure class="crsl-item col-sm-6">
										<h2>17.09.2014</h2>
										<a href="#">Објављени подаци - Нето прекогранични преносни капацитет - дневни (у подменију Преносни капацитет)</a>							
									</figure>
									<figure class="crsl-item col-sm-6">
										<h2>17.09.2014</h2>
										<a href="#">Објављени подаци - Нето прекогранични преносни капацитет - дневни (у подменију Преносни капацитет)</a>							
									</figure>
									<figure class="crsl-item col-sm-6">
										<h2>17.09.2014</h2>
										<a href="#">Објављени подаци - Нето прекогранични преносни капацитет - дневни (у подменију Преносни капацитет)</a>							
									</figure>
									<figure class="crsl-item col-sm-6">
										<h2>17.09.2014</h2>
										<a href="#">Објављени подаци - Нето прекогранични преносни капацитет - дневни (у подменију Преносни капацитет)</a>							
									</figure>
								</div>
								
								<div id="NAV-ID" class="crsl-nav">
									<a href="#" class="previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
									<a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
								</div>
							</div>	
							
						</div>
					</div>
				</div>
			</div>							
		</div> -->


		<?php require 'footer_homepage.php' ?>
		

		<script src="js/components.js"></script>
		<!-- jQuery -->
		<!-- <script src="js/jquery-3.4.1.min.js"></script> -->
		<script src="js/jquery-1.x-git.min.js"></script>
		
		<!-- <script src="js/jquery-migrate-1.4.1.min.js"></script> -->
		
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
		<!-- Responsive Caurasel slider -->
		<script src="js/responsiveCarousel.js"></script>
		
		

		
		<script>
			jQuery(document).ready(function($){
				$('.crsl-items').carousel({visible: 2});
			});

			jQuery(document).ready(function($){
				$(".arrow-wrapper").click(function(e) {
					e.preventDefault();
					$('**html, body**').animate({
						scrollTop: $("#sekcija-uvod").offset().top-50},
					800);
				});
			});


			$(document).ready(function(){
				$(".arrow-wrapper").animate({bottom: "2%"}, {
					duration: 800       
				});
			});
						
		</script>

	</body>
</html>

