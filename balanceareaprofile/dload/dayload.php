<?php
	ini_set('display_errors', '1');
	//$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "eng";
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : " ";
	// include 'lng.php';
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
	<script type="text/javascript" src="../../js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../../js/highcharts.js"></script>
	<script type="text/javascript" src="../../common/datepicker/datepicker.js"></script>

	<link rel="stylesheet" href="../../common/datepicker/datepicker.css">

	<link rel="stylesheet" href="../../common/css/download.css">
	<link rel="stylesheet" href="../../common/css/hint.css">
	<link rel="stylesheet" href="../../common/css/spinner.css">
	<link rel="stylesheet" href="../../common/css/style.css">
	<link rel="stylesheet" href="../../common/css/components.css">
	<link rel="stylesheet" href="../../common/css/plugins.css">
	<link rel="stylesheet" href="../../common/css/default.css">
	<link rel="stylesheet" href="../../common/css/stefan.css">
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> -->
	<link rel="stylesheet" href="../../fontawesome/css/all.min.css" />


	<script src="../../js/components.js"></script>


</head>

<body>
	<div style="width:1080px">
		<div class="menu">
			<div class="selections-group">
				<div class="selections">
					<input id="date" class="datepicker-here" placeholder="<?= $_SELECT_DAY ?>" data-range="false"
						onkeydown="return false;" autocomplete="off" />
					<label for="date"><?= $_DAY ?></label>
				</div>
				<input type="hidden" name="day" id="day">
			</div>
			<ul class="content-select">
				<li class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay"
					data-hint="<?= $_HINT_TABLE ?>">
					<i class="fa fa-table fa-fw"></i>
				</li>
				<li class="content-select-item data-chart inactive hint--bottom hint--rounded hint--delay"
					data-hint="<?= $_HINT_CHART ?>">
					<i class="fa fa-chart-bar fa-fw"></i>
				</li>
				<li class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay"
					data-hint="<?= $_HINT_DOWNLOAD ?>">
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
				<table style="margin-top:50px;">
					<thead id="data-header2">
					</thead>
					<tbody id="data-table2">
					</tbody>
				</table>
				<div class="empty-text"></div>
			</div>
			<div class="page">
				<div id="chart_1"></div>
				<div id="chart_2"></div>
				<div class="empty-text"></div>
			</div>
			<div class="page">
				<h1><?= $_DOWNLOAD_DATA ?></h1>
				<div class="download_form">
					<!-- <h3><?= $_D1_FORECAST ?></h3> -->
					<div class="custom-control custom-radio">
						<label><input id="radio_1" type="radio" name="optradio" checked><?= $_D1_FORECAST ?></label>
					</div>
					<div class="custom-control custom-radio">
						<label><input id="radio_2" type="radio" name="optradio"><?= $_REALISED_LOAD ?></label>
					</div>
					<div class="switch">
						<input id="time_period" type="checkbox">
						<label for="time_period"><?= $_TIME_PERIOD ?></label>
					</div>
					<div class="period">
						<input id="date_period" class="datepicker-here" placeholder="<?= $_SELECT_PERIOD ?>"
							data-range="true" data-multiple-dates-separator=" - " onkeydown="return false;"
							autocomplete="off" />
						<div class="period_error"><?= $_MSG_TIME_PERIOD ?></div>
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
					<div class="format" id="decimal_separator"><?= $_DECIMAL_SEPARATOR ?>
						<div class="format_wrapper" style="margin-top:-5px">
							<input class="radio-tab" name="radioSeparator" value="," id="separator1" type="radio">
							<label for="separator1" style="font-size:150%;padding:0 10px;">,</label>
							<input class="radio-tab" name="radioSeparator" value="." id="separator2" type="radio"
								checked>
							<label for="separator2" style="font-size:150%;padding:0 10px;">.</label>
						</div>
					</div>
					<a class="btn-class" id="btn_download"><?= $_DOWNLOAD_BUTTON ?></a>
				</div>
				<!-- <div class="download_form">
					<h3><?= $_REALISED_LOAD ?></h3>
					<div class="switch">
						<input id="time_period_2" type="checkbox">
						<label for="time_period_2"><?= $_TIME_PERIOD ?></label>
					</div>
					<div class="period_2">
						<input id="date_period_2" class="datepicker-here" placeholder="<?= $_SELECT_PERIOD ?>" data-range="true" data-multiple-dates-separator=" - " onkeydown="return false;"  autocomplete="off" />
						<div class="period_error"><?= $_MSG_TIME_PERIOD ?></div>
					</div>
					<div class="format"><?= $_DATA_FORMAT ?>
						<div class="format_wrapper">
							<input type="radio" class="radio-tab_2" name="radioFormat_2" value="CSV" id="format4" />
							<label for="format4">CSV</label>
							<input type="radio" class="radio-tab_2" name="radioFormat_2" value="JSON" id="format5" />
							<label for="format5">JSON</label>
							<input type="radio" class="radio-tab_2" name="radioFormat_2" value="XML" id="format6" checked />
							<label for="format6">XML</label>
						</div>
					</div>
					<div class="format" id="decimal_separator_2"><?= $_DECIMAL_SEPARATOR ?>
						<div class="format_wrapper" style="margin-top:-5px">
							<input class="radio-tab_2" name="radioSeparator_2" value="," id="separator3" type="radio">
							<label for="separator3" style="font-size:150%;padding:0 10px;">,</label>
							<input class="radio-tab_2" name="radioSeparator_2" value="," id="separator4" type="radio" checked>
							<label for="separator4" style="font-size:150%;padding:0 10px;">.</label>
						</div>
					</div>
					<a class="btn-class" id="btn_download_2"><?= $_DOWNLOAD_BUTTON ?></a>
				</div> -->
			</div>
			<div class="page" id="help-page" style="display: block">
				<h1><?= $_SELECT_DAY ?></h1><span id="help-text"><?= $_MSG_SELECT_DAY ?></span>
			</div>
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
		var tbodyHTML_1 = '';
		var tbodyHTML_2 = '';
		var download = false;

		$("#decimal_separator").hide();
		$("#decimal_separator_2").hide();
		$("#border").css({ 'width': '172px', 'cursor': 'default' });
		// $('#select-border label').css({'cursor':'default'});
		// $('.border-list').width(172);
		// var ul = $('<ul>').appendTo('.border-list');
		// 	ul.append('<li data-value="0"><?= $_ALL_DIRECTION ?></li>');
		// ul.append('<li data-value="1">HU - RS</li>');
		// ul.append('<li data-value="2">RS - HU</li>');
		// ul.append('<li data-value="3">RO - RS</li>');
		// ul.append('<li data-value="4">RS - RO</li>');
		// ul.append('<li data-value="5">MK - RS</li>');
		// ul.append('<li data-value="6">RS - MK</li>');	
		$("#chart_1").css({ 'margin-top': '20px' });
		$("#chart_2").css({ 'margin-top': '20px' });



		$(".content-select-item").click(function () {
			if (!$(this).hasClass("inactive")) {
				$(this).addClass("active").siblings().removeClass("active");
				$(".page").eq($(this).index()).show().siblings().hide();
				if ($(this).index() == 2) { // Download section
					$("#border").val('<?= $_ALL_DIRECTION ?>');
					download = true;
					$("#select-border label").css({ 'cursor': 'default' });
					$("#border").css({ 'cursor': 'default' });
				}
				else {
					direction = $("li[data-value='" + $("#direction").val() + "']").text();
					$("#border").val(direction);
					download = false;
					$("#select-border label").css({ 'cursor': 'pointer' });
					$("#border").css({ 'cursor': 'pointer' });
				}
			}
		});


		$("#date").datepicker({
			language: '<?= $_DATEPICKER_LANG ?>',
			autoClose: true,
			onRenderCell: function (date, cellType) {
				var nH = CheckDST(date);
				var tomorrow = new Date();
				tomorrow.setDate(new Date().getDate() + 1);
				var startdate = new Date('2013-05-31');
				if (cellType == 'day') {
					if (date < startdate || date > tomorrow) {
						return {
							disabled: true
						}
					}
					if (nH != 24) {
						// var mark = '<span style="color:' + ((nH == 25) ? '#80D8FF">&#10053;' : '#FB8C00">&#9728;') + '</span>';
						var mark = '<span style="color:' + ((nH == 25) ? '#80D8FF">&#10053;' : '#FB8C00">&#9728;') + '</span>';

						return {
							html: date.getDate() + mark
						}
					}
				}
			},
			onSelect: function (fd) {
				d = fd.split(".");
				$("#day").val(d[2] + "-" + d[1] + "-" + d[0]);
				CheckInput();
			}
		});

		$("#date_period").datepicker({
			language: '<?= $_DATEPICKER_LANG ?>',
			autoClose: true,
			onRenderCell: function (date, cellType) {
				var nH = CheckDST(date);
				var tomorrow = new Date();
				tomorrow.setDate(new Date().getDate()-1);
				var startdate = new Date('2013-05-31');
				if (cellType == 'day') {
					if (date < startdate || date > tomorrow) {
						return {
							disabled: true
						}
					}
					if (nH != 24) {
						var mark = '<span style="color:' + ((nH == 25) ? '#80D8FF">&#10053;' : '#FB8C00">&#9728;') + '</span>';
						return {
							html: date.getDate() + mark
						}
					}
				}
			},
			onSelect: function (dp, dArray) {
				$("#date_period").css("border", "2px solid ");
				$(".period_error").css("color", "#ccc");
				if (dArray.length > 1) {
					var timeDiff = Math.abs(dArray[1].getTime() - dArray[0].getTime());
					var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
					if (diffDays > 31) {
						$("#date_period").css("border", "2px solid rgba(207, 0, 15, 1)");
						$(".period_error").css("color", "#cf000f");
					}
				}
			}
		});

		$("#date_period_2").datepicker({
			autoClose: true,
			onRenderCell: function (date, cellType) {
				var nH = CheckDST(date);
				var tomorrow = new Date();
				tomorrow.setDate(new Date().getDate() + 1);
				var startdate = new Date('2013-05-31');
				if (cellType == 'day') {
					if (date < startdate || date > tomorrow) {
						return {
							disabled: true
						}
					}
					if (nH != 24) {
						var mark = '<span style="color:' + ((nH == 25) ? '#80D8FF">&#10053;' : '#FB8C00">&#9728;') + '</span>';
						return {
							html: date.getDate() + mark
						}
					}
				}
			},
			onSelect: function (dp, dArray) {
				$("#date_period_2").css("border", "2px solid ");
				$(".period_error").css("color", "#ccc");
				if (dArray.length > 1) {
					var timeDiff = Math.abs(dArray[1].getTime() - dArray[0].getTime());
					var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
					if (diffDays > 31) {
						$("#date_period_2").css("border", "2px solid ");
						$(".period_error").css("color", "#cf000f");
					}
				}
			}
		});

		$("#time_period").click(function () {
			$(".period").slideToggle(300);
		});

		$("#time_period_2").click(function () {
			$(".period_2").slideToggle(300);
		});

		$("input[type=radio][name='radioFormat']").click(function () {
			$("#decimal_separator").toggle($("input[type=radio][name='radioFormat']:checked").val() == "CSV");
		});

		$("input[type=radio][name='radioFormat_2']").click(function () {
			$("#decimal_separator_2").toggle($("input[type=radio][name='radioFormat_2']:checked").val() == "CSV");
		});

		var smer = "";
		$("#btn_download").click(function () {
			if (($(".period_error").css("color") == "rgb(207, 0, 15)" && $("#time_period").prop("checked"))) {
				$("#date_period").focus();
				return;
			}
			var params = {};
			params.download = true;
			params.format = $("input[type=radio][name='radioFormat']:checked").val();
			params.decimal = $("input[type=radio][name='radioSeparator']:checked").val();

			var df = ($('#date').datepicker().data('datepicker').selectedDates[0]);

			if ($("#time_period").prop("checked")) {
				var dp = $('#date_period').datepicker().data('datepicker').selectedDates;
				if (dp.length !== 0) {
					df = dp[0];
				}
				if (dp.length === 2) {
					params.to = dp[1].getFullYear() + '-' + ('0' + (dp[1].getMonth() + 1)).slice(-2) + '-' + ('0' + dp[1].getDate()).slice(-2);
				}
			}
			params.from = df.getFullYear() + '-' + ('0' + (df.getMonth() + 1)).slice(-2) + '-' + ('0' + df.getDate()).slice(-2);
			filename_loadplan = "LOAD_PLAN" + "_" + smer + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
			filename_realized = "LOAD_REALIZED" + "_" + smer + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
			// params.filename = filename + "." + params.format.toLowerCase();

			if ($('#radio_1').is(':checked') === true) {
				params.filename = filename_loadplan + "." + params.format.toLowerCase();
				window.location.replace("download.php?" + $.param(params));
			} else if ($('#radio_2').is(':checked') === true) {
				params.filename = filename_realized + "." + params.format.toLowerCase();
				window.location.replace("download_realized.php?" + $.param(params));
			}

		});

		// $("#btn_download_2").click(function () {
		// 	if (($(".period_error").css("color") == "rgb(207, 0, 15)" && $("#time_period_2").prop("checked"))) {
		// 		$("#date_period_2").focus();
		// 		return;
		// 	}
		// 	var params = {};
		// 	params.download = true;
		// 	params.format = $("input[type=radio][name='radioFormat_2']:checked").val();
		// 	params.decimal = $("input[type=radio][name='radioSeparator_2']:checked").val();

		// 	var df = ($('#date').datepicker().data('datepicker').selectedDates[0]);

		// 	if ($("#time_period_2").prop("checked")) {
		// 		var dp = $('#date_period_2').datepicker().data('datepicker').selectedDates;
		// 		if (dp.length !== 0) {
		// 			df = dp[0];
		// 		}
		// 		if (dp.length === 2) {
		// 			params.to = dp[1].getFullYear() + '-' + ('0' + (dp[1].getMonth() + 1)).slice(-2) + '-' + ('0' + dp[1].getDate()).slice(-2);
		// 		}
		// 	}
		// 	params.from = df.getFullYear() + '-' + ('0' + (df.getMonth() + 1)).slice(-2) + '-' + ('0' + df.getDate()).slice(-2);
		// 	filename = "LOAD_REALIZED" + "_" + smer + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
		// 	params.filename = filename + "." + params.format.toLowerCase();

		// 	window.location.replace("download_realized.php?" + $.param(params));
		// });


		function CheckInput() {
			$("#help-text").html("");
			if ($("#day").val()) {
				GetData($("#day").val());
			}
			else {
				$("#help-text").html('<?= $_MSG_SELECT_DAY ?>');
			}
		}

		var borderDwn = "";
		var direction = "";

		function getBorder(dir) { // uzima smer iz padajuce liste i dodeljuje ga promenljivoj koja se koristi u download.php i za getData 
			direction = dir;
			switch (dir) {
				case "HU - RS":
					borderDwn = 'HU'
					break;
				case "RS - HU":
					borderDwn = 'HU'
					break;
				case "RO - RS":
					borderDwn = 'RO'
					break;
				case "RS - RO":
					borderDwn = 'RO'
					break;
				case "MK - RS":
					borderDwn = 'MK'
					break;
				case "RS - MK":
					borderDwn = 'MK'
					break;
				default:
					borderDwn = '';
					break;
			}
		}

		function GetData(d) {
			$(".content-select > .content-select-item").each(function () {
				$(this).removeClass("active");
				$(this).addClass("inactive");
			});
			$(".page").eq(4).show();
			$.getJSON("get_results.php", { day: d }, function (result) {  console.log('Rezultat: '+result);
				//console.log(Object.values(result[0]));
				//console.log(Object.values(result[1]));
				$("#data-header").html('');
				$("#data-table").html('');
				$("#data-header2").html('');
				$("#data-table2").html('');
				$("#chart_1").hide();
				$('.border-select').html('');
				if (result === null || result === undefined) { 
					$('.empty-text').each(function (i, obj) {
						$(obj).html('<?= $_NO_DATA ?>' + $("#date").val());
					});
				}
				else {
					$('.empty-text').each(function (i, obj) {
						$(obj).html('');
					});
					var theaderHTML_1 = '<tr class="subtitle bold"><td class="hour" colspan="25" ><?= $_D1_FORECAST ?></td></tr>';
					var line = '<tr><td colspan="25" style="height:1px; margin:0; padding:0; background-color:#9C9990;"></td></tr>';
					theaderHTML_1 += line;
					var n_data = CheckDST(d);
					tbodyHTML_1 = '<tr height="35"><td class="hour"><?= $_TIME ?></td><td>H01</td><td>H02</td><td>H03</td><td>H04</td><td>H05</td><td>H06</td><td>H07</td><td>H08</td><td>H09</td><td>H10</td><td>H11</td><td>H12</td><td>H13</td><td>H14</td><td>H15</td><td>H16</td><td>H17</td><td>H18</td><td>H19</td><td>H20</td><td>H21</td><td>H22</td><td>H23</td><td>H24</td></tr>';
					tbodyHTML_1 += '<tr height="35"><td class="hour">MW:</td><td>' + Math.round(result[0].S01 * 1.168338983) + '</td><td>' + Math.round(result[0].S02 * 1.168338983) + '</td><td>' + Math.round(result[0].S03 * 1.168338983) + '</td><td>' + Math.round(result[0].S04 * 1.168338983) + '</td><td>' + Math.round(result[0].S05 * 1.168338983) + '</td><td>' + Math.round(result[0].S06 * 1.168338983) + '</td><td>' + Math.round(result[0].S07 * 1.168338983) + '</td><td>' + Math.round(result[0].S08 * 1.168338983) + '</td><td>' + Math.round(result[0].S09 * 1.168338983) + '</td><td>' + Math.round(result[0].S10 * 1.168338983) + '</td><td>' + Math.round(result[0].S11 * 1.168338983) + '</td><td>' + Math.round(result[0].S12 * 1.168338983) + '</td><td>' + Math.round(result[0].S13 * 1.168338983) + '</td><td>' + Math.round(result[0].S14 * 1.168338983) + '</td><td>' + Math.round(result[0].S15 * 1.168338983) + '</td><td>' + Math.round(result[0].S16 * 1.168338983) + '</td><td>' + Math.round(result[0].S17 * 1.168338983) + '</td><td>' + Math.round(result[0].S18 * 1.168338983) + '</td><td>' + Math.round(result[0].S19 * 1.168338983) + '</td><td>' + Math.round(result[0].S20 * 1.168338983) + '</td><td>' + Math.round(result[0].S21 * 1.168338983) + '</td><td>' + Math.round(result[0].S22 * 1.168338983) + '</td><td>' + Math.round(result[0].S23 * 1.168338983) + '</td><td>' + Math.round(result[0].S24 * 1.168338983) + '</td></tr>';
					$("#data-header").html(theaderHTML_1);
					//															$("#data-header tr:last").addClass("underline");
					tbodyHTML_1 += line;
					$("#data-table").html(tbodyHTML_1);
					//															$("#data-table tr:last").addClass("underline");

					var D1_Forecast_data = [];
					var realised_load_data = [];

					//console.log(result[2][0]);
					if (result[1][0] != undefined) {
						var theaderHTML_2 = '<tr class="subtitle bold"><td class="hour" colspan="25" ><?= $_REALISED_LOAD ?></td></tr>';
						theaderHTML_2 += line;
						tbodyHTML_2 = '<tr height="35"><td class="hour"><?= $_TIME ?></td><td>H01</td><td>H02</td><td>H03</td><td>H04</td><td>H05</td><td>H06</td><td>H07</td><td>H08</td><td>H09</td><td>H10</td><td>H11</td><td>H12</td><td>H13</td><td>H14</td><td>H15</td><td>H16</td><td>H17</td><td>H18</td><td>H19</td><td>H20</td><td>H21</td><td>H22</td><td>H23</td><td>H24</td></tr>';
						tbodyHTML_2 += '<tr height="35"><td class="hour">MW:</td><td>' + result[1][0].S01 + '</td><td>' + result[1][0].S02 + '</td><td>' + result[1][0].S03 + '</td><td>' + result[1][0].S04 + '</td><td>' + result[1][0].S05 + '</td><td>' + result[1][0].S06 + '</td><td>' + result[1][0].S07 + '</td><td>' + result[1][0].S08 + '</td><td>' + result[1][0].S09 + '</td><td>' + result[1][0].S10 + '</td><td>' + result[1][0].S11 + '</td><td>' + result[1][0].S12 + '</td><td>' + result[1][0].S13 + '</td><td>' + result[1][0].S14 + '</td><td>' + result[1][0].S15 + '</td><td>' + result[1][0].S16 + '</td><td>' + result[1][0].S17 + '</td><td>' + result[1][0].S18 + '</td><td>' + result[1][0].S19 + '</td><td>' + result[1][0].S20 + '</td><td>' + result[1][0].S21 + '</td><td>' + result[1][0].S22 + '</td><td>' + result[1][0].S23 + '</td><td>' + result[1][0].S24 + '</td></tr>';
						$("#data-header2").html(theaderHTML_2);
						tbodyHTML_2 += line;
						$("#data-table2").html(tbodyHTML_2);

						//D1_Forecast_data = Object.values(result[0]);
						//D1_Forecast_data = Object.keys(result[0]).map(itm => result[0][itm]); 
						
						D1_Forecast_data = Object.keys(result[0]).map(function(e) { return result[0][e]})
						realised_load_data = Object.values(result[1][0]);
					} else {
						D1_Forecast_data = Object.values(result[0]);
						realised_load_data = [];
						$("#data-header2").html("<?= $_REALISED_LOAD_NOT_AVALIABLE ?>");
					}


					Highcharts.chart('chart_1', {
						chart: {
							type: 'spline',
							width: 1080
						},
						title: {
							text: 'System vertical load'
						},
						subtitle: {
							// text: 'Source: WorldClimate.com'
						},
						xAxis: {
							categories: ['H01', 'H02', 'H03', 'H04', 'H05', 'H06', 'H07', 'H08', 'H09', 'H10', 'H11', 'H12', 'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24']
						},
						yAxis: {
							title: {
								text: 'MW'
							},
							labels: {
								formatter: function () {
									return this.value + 'MW';
								}
							}
						},
						credits: {
							enabled: false
						},
						tooltip: {
							crosshairs: true,
							shared: true
						},
						plotOptions: {
							spline: {
								marker: {
									radius: 4,
									lineColor: '#666666',
									// lineWidth: 1
								}
							}
						},
						colors: ['#F25F5C', '#c3c3c3'],
						series: [{
							name: 'D1-Forecast',
							data: D1_Forecast_data,
							tooltip: {
								valueSuffix: ' MW'
							}
						}, {
							name: 'Realised load',
							data: realised_load_data,
							tooltip: {
								valueSuffix: ' MW'
							}
						}]
					});


					$("#chart_1").show();
					$("#chart_2").show();
				}
				$(".content-select > .content-select-item").each(function () {
					$(this).removeClass("inactive");
					if ($(this).index() == 0) { $(this).click(); }
				});
				getdata = true;
				$("#select-border label").css({ 'cursor': 'pointer' });
				$("#border").css({ 'cursor': 'pointer' });
				$("#border").val('<?= $_ALL_DIRECTION ?>');
				$("#direction").val(0);
			});
		}

		function CheckDST(d) {

			var datum = new Date(d)
			var day = datum.getDate();
			var d_idx = datum.getDay();
			var m = datum.getMonth() + 1;
			var nH = 24;

			if (d_idx == 0) {
				if ((m == 3) && (day > 24 && day < 32)) { nH = 23; }
				else if ((m == 10) && (day > 24 && day < 32)) { nH = 25; }
			}
			return nH;

		}

	</script>

</body>

</html>