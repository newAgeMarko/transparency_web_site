<?php
include_once 'includes/languages.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<?php include_once("includes/error_handler.php");?>

<head>
<title>JP EMS Transparency platform</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/stil.css" />
<link rel="stylesheet" href="css/stil_tabele.css" type="text/css" />

<!--1menu-->
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js">

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<!--menu1-->
<!--jquery /pocetak-->
<link rev="stylesheet" href="css/custom-theme/jquery-ui-1.8.24.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.24.custom.min.js" ></script>
<!--jquery/kraj-->
<!--2menu-->
<?php
include_once 'includes/menu_lng.php';
?>
<!--menu2-->
<?php include_once("includes/jqueryfunc.php"); ?>
</head>
<?php
include_once 'includes/translate.php';
?>

<body>
<div id="okvir"> <!--okvir stranice-->
	<?php include_once("includes/hedrmenu.php"); ?>
	<!--<div id="glavnajpg">
		<img src="pics/glavna01.jpg" alt="" />
	</div>-->
	<div id="strana">
		<div id="levibar">
			<div class="okvir2">
				<?php include("includes/incbase_resultsd.php"); ?>
				<?php include("includes/incfilt_resultsd.php"); ?>
			</div>
		</div>
	
		<div id="sadrzaj">		
			<div class="okvir2">
				<?php echo $sadrzajokvir2__06;?>
			</div>
			<br />
			<br />
				<div class="page_desc">
					<h4>
					<?php
					if ($lang == 'sr'){
						echo $pagedesc__06."<b>".date('d.m.Y.', strtotime($varDatum_recSetFilter))."</b>";
					}else{
						echo $pagedesc__06."<b>".date('F jS, Y.', strtotime($varDatum_recSetFilter))."</b>";
					}	
					?>
					</h4>
				</div>
						
			<br style="clear:both" />
		</div>
		<div class="okvir2spec" id="sadrzaj-1spec">
			<?php include("includes/inc_resultsd.php"); ?>
		</div>
		
		<br style="clear:both" />		
	</div>
	<?php include_once("includes/futr.php"); ?>
</div>
</body>
</html>