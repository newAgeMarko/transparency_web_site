<?php
	ini_set('display_errors', '1');
//	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "eng";
//	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : " ";
//	include '../../daily/lng.php';
	include '../../lang.php';
?>
<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="utf-8">
	<title><?= _TITLE ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= _TITLE ?>">
	
	<script type="text/javascript" src="../../js/jquery-1.x-git.min.js"></script> 
	<script type="text/javascript" src="../../js/highcharts.js"></script>
    <script type="text/javascript" src="../../common/datepicker/datepicker.js"></script>

	<link rel="stylesheet" type="text/css" href="../../common/datepicker/datepicker.css"/>
	<link rel="stylesheet" type="text/css" href="../../common/css/hint.css"/>
	<link rel="stylesheet" type="text/css" href="../../common/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="../../common/css/download.css"/>
	<link rel="stylesheet" type="text/css" href="../../common/css/spinner.css"/>
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> -->
	<link rel="stylesheet" href="../../fontawesome/css/all.min.css" />

</head>
<body> 
	<div style="width:1080px">
		<div class="menu">
			<div class="selections-group">
				<div class="selections">
					<input id="datepicker-year" data-language="eng" data-min-view="years" data-view="years" data-date-format="yyyy" placeholder="<?= $_SELECT_YEAR ?>" data-range="false" autocomplete="off" onkeydown="return false;" />
					<label for="datepicker-year"><?= $_YEAR ?></label>
				</div>					
				<input type="hidden" name="year" id="year">
			</div>	
			<!-- <div class="content-select">
				<div class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_TABLE ?>"></div>	
				<div class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_DOWNLOAD ?>"></div>	
			</div>	 -->
			<ul class="content-select">
				<li class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_TABLE ?>">
					<i class="fa fa-table fa-fw"></i>
				</li>	
				<li class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_DOWNLOAD ?>">
					<i class="fa fa-download fa-fw"></i>
				</li>	
			</ul>	
		</div>
		<div class="content">
			<div class="page">
				<table>
					<thead id="data-header">
					</thead>
					<tbody id="data-table">
					</tbody>
				</table>
				<div class="empty-text"></div>
			</div>
			<div class="page"><h1><?= $_DOWNLOAD_DATA ?></h1>
				<div class="download_form">			
					<div class="switch">
						<input id="time_period" type="checkbox">
						<label for="time_period"><?= $_TIME_PERIOD ?></label>
					</div>
					<div class="period">
						<input id="date_period" class="datepicker-here"  data-language="eng" data-min-view="years" data-view="years" data-date-format="yyyy" placeholder="<?= $_SELECT_PERIOD ?>" data-range="true" data-multiple-dates-separator=" - " autocomplete="off" onkeydown="return false;" />						
					</div>
					<div class="format"><?= $_DATA_FORMAT ?>
						<div class="format_wrapper">
							<input type="radio" class="radio-tab" name="radioFormat" value="CSV" id="format1" />
							<label for="format1">CSV</label>
							<input type="radio" class="radio-tab" name="radioFormat" value="JSON" id="format2" />
							<label for="format2">JSON</label>
							<input type="radio" class="radio-tab" name="radioFormat" value="XML" id="format3" checked />
							<label for="format3">XML</label>
						</div>
					</div>
					<div class="format" id="decimal_separator" style="display:none"><?= $_DECIMAL_SEPARATOR ?>
						<div class="format_wrapper" style="margin-top:-5px">
							<input class="radio-tab" name="radioSeparator" value="," id="separator1" type="radio">
							<label for="separator1" style="font-size:150%;padding:0 10px;">,</label>
							<input class="radio-tab" name="radioSeparator" value="." id="separator2" type="radio" checked>
							<label for="separator2" style="font-size:150%;padding:0 10px;">.</label>
						</div>
					</div>
					<a class="btn-class" id="btn_download"><?= $_DOWNLOAD_BUTTON ?></a>
				</div>
			</div>
			<div class="page" id="help-page" style="display: block"><h1><?= $_SELECT_YEAR ?></h1><span id="help-text"><?= $_MSG_SELECT_YEAR ?></span></div>
			<div class="page">
				<div class="spinner_background">
					<div class="spinner_wrapper">
						<div class="sk-fading-circle">
							<div class="sk-circle1 sk-circle"></div>
							<div class="sk-circle2 sk-circle"></div>
							<div class="sk-circle3 sk-circle"></div>
							<div class="sk-circle4 sk-circle"></div>
							<div class="sk-circle5 sk-circle"></div>
							<div class="sk-circle6 sk-circle"></div>
							<div class="sk-circle7 sk-circle"></div>
							<div class="sk-circle8 sk-circle"></div>
							<div class="sk-circle9 sk-circle"></div>
							<div class="sk-circle10 sk-circle"></div>
							<div class="sk-circle11 sk-circle"></div>
							<div class="sk-circle12 sk-circle"></div>
						</div>	
					</div>					
				</div>
			</div>
		</div>
	</div>
 
	<script>
	var rs_code;
	var filename;
	var dataStr;
	var getData = false;
	var tbodyHTML = '';
	var download = false;
	var m_from;
	var y_from;

	$(".content-select-item").click(function() {
		if (!$(this).hasClass("inactive")) {
			$(this).addClass("active").siblings().removeClass("active");
				$(".page").eq($(this).index()).show().siblings().hide();
				if ($(this).index()==1) { // Download section
					download = true;
				}
				else {
					download = false;
				}	
		}		
	});		

	$("#datepicker-year").datepicker({		
		autoClose: true,
		onRenderCell: function(date) {
			var startdate = new Date('2012');
			if (date < startdate) {
				return {
					disabled: true
				}
			}
		},
		onSelect: function(dy){  	
			$('#year').val(dy);
			CheckInput();
		}
	});

	var click_num = 0;
	$("#date_period").datepicker({ 	
		autoClose: true,
		onRenderCell: function(date) {
			var startdate = new Date('2012');
			if (date < startdate) {
				return {
					disabled: true
				}
			}
		},
		onSelect: function(dp, dArray){  
			
		}
	});

	$("#time_period").click(function() {
		$(".period").slideToggle(300);
	});

	$("input[type=radio][name='radioFormat']").click(function() {
		$("#decimal_separator").toggle($("input[type=radio][name='radioFormat']:checked").val()=="CSV"); 
	});

	function CheckInput() {
		$('#help-text').html("");
		if ($('#year').val()) {
			GetData($('#year').val()); 			
		} else {
			$('#help-text').html('$_MSG_SELECT_YEAR');
		}
	}

	function GetData(y_from) {  

		$('.content-select > .content-select-item').each(function (){			
			$(this).removeClass("active"); 
			$(this).addClass("inactive"); 
		});
		$(".page").eq(3).show();
		$.getJSON("get_results.php", {year: y_from}, function (result) { 
			$('#data-header').html();
			$('#data-table').html();
			if (result == null) {
				$('.empty-text').each(function(i, obj) {
					$(obj).html('<?= $_NO_DATA ?>'+$('#year').val());
				});
			} 
			else {
				$('.empty-text').each(function(i, obj) {
					$(obj).html('');
				});
				var theaderHTML = '<tr class="subtitle bold"><td class="hour"><?= $_DIRECTION ?></td><td><?= $_ATC ?></td><td><?= $_AUCTION_PERIOD_FROM ?></td><td><?= $_AUCTION_PERIOD_TILL ?></td><td><?= $_REQUESTED_TABLE ?></td><td><?= $_ALLOCATED_TABLE ?></td><td><?= $_NUM_AUCTION_PARTICIPANTS ?></td><td><?= $_NUM_AUCTION_PARTICIPANTS_NON_ZERO ?></td><td><?= $_NUMBER_OF_BIDS ?></td><td><?= $_MARGINAL_PRICE ?></td><td><?= $_CONGESTION ?><?= $_CONGESTION_Y_N ?></td></tr>';
				$('#data-header').html(theaderHTML);
				var line = '<tr><td colspan="11" style="height:1px; margin:0; padding:0; background-color:#9C9990;"></td></tr>';
				tbodyHTML = line;

				for (var i in result) {		
					var zagusenje = result[i].zagusenje == 1 ? "<?= $_YES ?>" : "<?= $_NO ?>";
					tbodyHTML += '<tr><td class="hour">' + result[i].granica_smer + '</td><td class="hour">' + result[i].ATC + '</td><td class="hour">' + result[i].period_od + '</td><td class="hour">' + result[i].period_do + '</td><td class="hour">' + result[i].zahtevani_kapacitet + '</td><td class="hour">' + result[i].dodeljeni_kapacitet + '</td><td class="hour">' + result[i].ucesnici_podneli_zahtev + '</td><td class="hour">' + result[i].ucesnici_dobili_kapacitet + '</td><td class="hour">' + result[i].broj_ponuda + '</td><td class="hour">' + result[i].cena + '</td><td class="hour">' + zagusenje + '</td></tr>';
				}
				$('#data-table').html(tbodyHTML);

				$(".content-select > .content-select-item").each(function () { 
					$(this).removeClass("inactive"); 
					if ($(this).index() == 0) { $(this).click();}
				});

			}
		});
	}

	$("input[type=radio][name='radioFormat']").click(function() {
		$("#decimal_separator").toggle($("input[type=radio][name='radioFormat']:checked").val()=="CSV"); 
	});

	$("#btn_download").click(function() {
		if (($(".period_error").css("color")=="rgb(207, 0, 15)" && $("#time_period").prop("checked"))) {
			$("#date_period").focus();
			return;
		}	
		var params = {};
		params.download = true;
		params.format = $("input[type=radio][name='radioFormat']:checked").val();
		params.decimal = $("input[type=radio][name='radioSeparator']:checked").val();
	//	var month = $('#datepicker-month').datepicker({dateFormat: 'MM yy'}).data('datepicker');

		var year = $('#year').val();
		var year_to = "";
		
		if ($('#time_period').prop("checked")) { 
			var selected_period = $('#date_period').datepicker({dateFormat: 'yyyy'}); 	

			if (selected_period.length === 1) { 				
				year = selected_period[0].value.split("-")[0].split(" ")[0];				
				year_to = selected_period[0].value.split("-")[1].split(" ")[1];							
				params.year_to = year_to;
			}
		} 	
		params.year = year;
		
		filename = "ALLOCATION_RESULTS";
		params.filename = filename + "_" + params.year + "_" + (params.hasOwnProperty("year_to") ? params.year_to : "") + "." + params.format.toLowerCase();
			
		window.location.replace("download.php?" + $.param(params));		
	});


	</script>

</body>
</html>