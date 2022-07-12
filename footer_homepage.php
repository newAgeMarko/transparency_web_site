<footer id="gtco-footer" role="contentinfo">
	<div class="container">		
		<div class="row copyright">
			<div class="col-md-12 text-center">					
				<p id="contact-mail"><i class="fas fa-envelope"></i>&nbsp;<?php echo $_KONTAKT_MAIL ?>&nbsp;<a href="mailto:transparency.support@ems.rs">  transparency.support@ems.rs</a></p>
				<p>
					<ul class="gtco-social-icons">
						<li>
							<?php if ($_SERVER['REQUEST_URI'] == '/stefan_www/transparentnost/index.php') { ?>
								<a onclick="location.href='index.php'"><?php echo $_HOME ?></a>
								<?php } else { ?>
									<a onclick="location.href='index.php'"><?php echo $_HOME ?></a>
								<?php } ?>								
						</li>
						<li>
							<?php if ($_SERVER['REQUEST_URI'] == '/stefan_www/transparentnost/index.php') { ?>
								<a onclick="location.href='congestionmanagement/crossbordercommercialschedules/crossborder.php'"><?php echo $upravljanjezagusenjima ?></a>
								<?php } else { ?>
									<a onclick="location.href='congestionmanagement/crossbordercommercialschedules/crossborder.php'"><?php echo $upravljanjezagusenjima ?></a>
								<?php } ?>	
						</li>
						<li>
							<?php if ($_SERVER['REQUEST_URI'] == '/stefan_www/transparentnost/index.php') { ?>
								<a onclick="location.href='balanceareaprofile/dload/dload.php'"><?php echo $balansiranjeipotrosnja ?></a>
								<?php } else { ?>
									<a onclick="location.href='balanceareaprofile/dload/dload.php'"><?php echo $balansiranjeipotrosnja ?></a>
								<?php } ?>
						</li>
						<li>
							<?php if ($_SERVER['REQUEST_URI'] == '/stefan_www/transparentnost/index.php') { ?>
								<a onclick="location.href='networkcapacity/monthahead/ntcm.php'"><?php echo $prenosnikapacitet ?></a>
								<?php } else { ?>
									<a onclick="location.href='networkcapacity/monthahead/ntcm.php'"><?php echo $prenosnikapacitet ?></a>
								<?php } ?>	
						</li>
						<li>
							<?php if ($_SERVER['REQUEST_URI'] == '/stefan_www/transparentnost/index.php') { ?>
								<a onclick="location.href='auction/daily/resdailyauc.php'"><?php echo $aukcije ?></a>
								<?php } else { ?>
									<a onclick="location.href='auction/daily/resdailyauc.php'"><?php echo $aukcije ?></a>
								<?php } ?>
						</li>
					</ul>
				</p>
				<p>
					<small class="block"><?php echo $_COPYRIGHT ?> <?php echo $svapravazadrzana ?>.</small>
				</p>
			</div>
		</div>
	</div>
</footer>

<div class="gototop js-top">
	<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
</div>			