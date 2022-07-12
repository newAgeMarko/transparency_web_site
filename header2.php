<!-- Ovaj Header se odnosi na sve strane osim naslovne -->
<?php

	$naslov;

	switch ( basename($_SERVER['PHP_SELF']) ) {
		case 'dload.php':
			$naslov = $SYSTEM_VERTICAL_LOAD;
			break;
		case 'wload.php':
			$naslov = $_WEEKLY_FORECAST;
			break;	
		case 'crossborder.php':
			$naslov = $_CROSS_BORDER;
			break;
		case 'planedschedule.php':
			$naslov = $_PLANED_SCHEDULE_EVOLUTION;
			break;
		case 'ntcm.php':
			$naslov = $_AVALIABLE_TRANSFER_CAPACITY_MONTHLY;
			break;
		case 'ntcy.php':
			$naslov = $_AVALIABLE_TRANSFER_CAPACITY_YEARLY;
			break;
		case 'resdailyauc.php':
			$naslov = $_DAILY_AUC_ATC_RES;
			break;
		case 'resmonthlyauc.php':
			$naslov = $_MONTHLY_AUCTION_TITLE;
			break;
		case 'resyearlyauc.php':
			$naslov = $_YEARLY_AUCTION_TITLE;
			break;

		default:
			# code...
			break;
	}
	
?>


<header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">
		<div class="c-navbar">
		<div class="container">
			<!-- BEGIN: BRAND -->
			<div class="c-navbar-wrapper clearfix">
				<div class="c-brand c-pull-left">
					<img src="../../images/logo-2.png" alt="">
					<div>
						<a href="../../index.php" class="c-logo">					
							<span>T</span><?= $transparentnost ?>
						</a>
						<span><?= $_PLAFORM ?></span>
					</div>					
					<button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
					<span class="c-line"></span>
					<span class="c-line"></span>
					<span class="c-line"></span>
					</button>
					<button class="c-topbar-toggler" type="button">
						<i class="fa fa-ellipsis-v"></i>
					</button>
				</div>
				<!-- END: BRAND -->				
				<!-- BEGIN: QUICK SEARCH -->
				<form class="c-quick-search" action="#">
					<input type="text" name="query" placeholder="Type to search..." value="" class="form-control" autocomplete="off">
					<span class="c-theme-link">×</span>
				</form>
				<!-- END: QUICK SEARCH -->	
				<!-- BEGIN: HOR NAV -->
				<!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->
<!-- BEGIN: MEGA MENU -->
<!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
<nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
	<ul class="nav navbar-nav c-theme-nav"> 
						<li>
							<a onclick="location.href='../../index.php'" class="c-link dropdown-toggle"><?= $_HOME ?><span class="c-arrow c-toggler"></span></a>									
							<div class="dropdown-menu c-menu-type-mega c-menu-type-fullwidth" style="min-width: auto">
							</div>																	
						</li>
						<li class="c-menu-type-classic manu-link" id="navigation">
							<a href="javascript:;" class="c-link dropdown-toggle"><?php echo $upravljanjezagusenjima ?><span class="c-arrow c-toggler"></span></a>				
							<ul class="dropdown-menu c-menu-type-classic c-pull-left">
								<li class="dropdown-submenu">
									<a onclick="location.href='../../congestionmanagement/crossbordercommercialschedules/crossborder.php'"><?php echo $prekogranicniplanrada ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a onclick="location.href='../../congestionmanagement/planedscheduleevolution/planedschedule.php'"><?php echo $promeneprekogranicnihplanovarada ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a onclick="location.href='../../networkcapacity/monthahead/ntcm.php'"><?php echo $mesecunapred ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a onclick="location.href='../../networkcapacity/yearahead/ntcy.php'"><?php echo $godinaunapred ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a onclick="location.href='../../auction/daily/resdailyauc.php'"><?php echo $rezultatidnevnihauk ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a onclick="location.href='../../auction/monthly/resmonthlyauc.php'"><?php echo $rezultatimesecnihauk ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a onclick="location.href='../../auction/yearly/resyearlyauc.php'"><?php echo $rezultatigodisnjihauk ?><span class="c-arrow c-toggler"></span></a> 
								</li>
							</ul>							
						</li>
						<li class="c-menu-type-classic manu-link" id="navigation">
							<a href="javascript:;" class="c-link dropdown-toggle"><?php echo $balansiranjeipotrosnja ?><span class="c-arrow c-toggler"></span></a>				
							<ul class="dropdown-menu c-menu-type-classic c-pull-left">
								<li class="dropdown-submenu">
									<a onclick="location.href='../../balanceareaprofile/dload/dload.php'"><?php echo $ostvarenapotrosnja ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a onclick="location.href='../../balanceareaprofile/wload/wload.php'"><?php echo $prognozapotrosnjesedmicna ?><span class="c-arrow c-toggler"></span></a> 
								</li>
							</ul>							 
						</li>
						<!--<li class="c-menu-type-classic manu-link" id="navigation">
							<a href="javascript:;" class="c-link dropdown-toggle"><?php echo $prenosnikapacitet ?><span class="c-arrow c-toggler"></span></a>				
							<ul class="dropdown-menu c-menu-type-classic c-pull-left">
								<li class="dropdown-submenu">
									<a href="../../networkcapacity/monthahead/ntcm.php"><?php echo $mesecunapred ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a href="../../networkcapacity/yearahead/ntcy.php"><?php echo $godinaunapred ?><span class="c-arrow c-toggler"></span></a> 
								</li>
							</ul>							
						</li>-->
						
						<!--<li class="c-menu-type-classic manu-link" id="navigation">
							<a href="javascript:;" class="c-link dropdown-toggle"><?php echo $aukcije ?><span class="c-arrow c-toggler"></span></a>				
							<ul class="dropdown-menu c-menu-type-classic c-pull-left">
								<li class="dropdown-submenu">
									<a href="../../auction/daily/resdailyauc.php"><?php echo $rezultatidnevnihauk ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a href="../../auction/monthly/resmonthlyauc.php"><?php echo $rezultatimesecnihauk ?><span class="c-arrow c-toggler"></span></a> 
								</li>
								<li class="dropdown-submenu">
									<a href="../../auction/yearly/resyearlyauc.php"><?php echo $rezultatigodisnjihauk ?><span class="c-arrow c-toggler"></span></a> 
								</li>
							</ul>							
						</li>-->
						<li>
							<ul class="Jezici">
								<li id="lang">
									<!-- <i class="fas fa-globe-europe"></i> -->
									<a href="?lang=en"><?php echo $en ?></a>
								</li>                
								<li id="lang2">
									<a href="?lang=rs"><?php echo $rs ?></a>
								</li>
							</ul>
						</li>
                    
			</ul>
</nav>
<!-- END: MEGA MENU --><!-- END: LAYOUT/HEADERS/MEGA-MENU -->
				<!-- END: HOR NAV -->		
			</div>			
			<!-- BEGIN: LAYOUT/HEADERS/QUICK-CART -->
<!-- BEGIN: CART MENU -->
<div class="c-cart-menu">
	<div class="c-cart-menu-title">
		<p class="c-cart-menu-float-l c-font-sbold">2 item(s)</p>
		<p class="c-cart-menu-float-r c-theme-font c-font-sbold">$79.00</p>
	</div>
	<ul class="c-cart-menu-items">
		<li>
			<div class="c-cart-menu-close">
				<a href="#" class="c-theme-link">×</a>
			</div>
			<img src="../../assets/base/img/content/shop2/24.jpg">
			<div class="c-cart-menu-content">
				<p>1 x <span class="c-item-price c-theme-font">$30</span></p>
				<a href="shop-product-details-2.html" class="c-item-name c-font-sbold">Winter Coat</a>
			</div>
		</li>
		<li>
			<div class="c-cart-menu-close">
				<a href="#" class="c-theme-link">×</a>
			</div>
			<img src="../../assets/base/img/content/shop2/12.jpg">
			<div class="c-cart-menu-content">
				<p>1 x <span class="c-item-price c-theme-font">$30</span></p>
				<a href="shop-product-details.html" class="c-item-name c-font-sbold">Sports Wear</a>
			</div>
		</li>
	</ul> 
	<div class="c-cart-menu-footer">
		<a href="shop-cart.html" class="btn btn-md c-btn c-btn-square c-btn-grey-3 c-font-white c-font-bold c-center c-font-uppercase">View Cart</a>
		<a href="shop-checkout.html" class="btn btn-md c-btn c-btn-square c-theme-btn c-font-white c-font-bold c-center c-font-uppercase">Checkout</a>
	</div>
</div>
<!-- END: CART MENU --><!-- END: LAYOUT/HEADERS/QUICK-CART -->
		</div>
	</div>
</header>



<header id="gtco-header2" class="gtco-cover" role="banner" data-stellar-background-ratio="0.5">
	<img class="cover2" src="../../images/cover2.1.jpg">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="display-t">

					<h1 class="mb30"><?php echo $naslov ?></h1>


				</div>
			</div>
		</div>
	</div>
</header>

<script>


	
</script>