<?php
	ini_set('display_errors', '1');
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "eng";
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
	<script type="text/javascript" src="../../js/highcharts.js"></script>
	<script type="text/javascript" src="../../common/datepicker/datepicker.js"></script>

	<link rel="stylesheet" type="text/css" href="../../common/datepicker/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="../../common/css/hint.css" />
	<link rel="stylesheet" type="text/css" href="../../common/css/style.css" />
	<link rel="stylesheet" type="text/css" href="../../common/css/download.css" />
	<link rel="stylesheet" type="text/css" href="../../common/css/spinner.css" />
	<link rel="stylesheet" type="text/css" href="../../common/css/components.css" />
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> -->
	<link rel="stylesheet" href="../../fontawesome/css/all.min.css" />
	
</head>
<body> 
	<div style="width:1200px">
	<div class="menu">
		<div class="selections-group">
			<div class="selections">
				<input id="date" class="datepicker-here" placeholder="<?= $_SELECT_DAY ?>" data-range="false"
					onkeydown="return false;" autocomplete="off" />
				<label for="date"><?= $_DAY ?></label>
			</div>
			<div class="selections" id="select-border">
				<input id="border" type="text" placeholder="<?= $_SELECT_DIRECTION ?>" autocomplete="off" />
				<label for="border"><?= $_DIRECTION ?></label>
				<div class="border-list"></div>
			</div>
			<input type="hidden" name="direction" id="direction" value="1">
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
			<div class="empty-text"></div>
		</div>
		<div class="page">
			<div id="chart_1"></div>
			<div id="chart_2"></div>
			<div id="chart_3"></div>
			<div id="chart_4"></div>
			<div id="chart_5"></div>
			<div id="chart_6"></div>
			<div class="empty-text"></div>
		</div>
		<div class="page">
			<h1><?= $_DOWNLOAD_DATA ?></h1>
			<div class="download_form">
				<!-- <div class="switch">
						<input id="all_borders" type="checkbox">
						<label for="all_borders"><?= $_ALL_BORDERS ?></label>
					</div>
					<div class="switch">
						<input id="time_period" type="checkbox">
						<label for="time_period"><?= $_TIME_PERIOD ?></label>
					</div> -->
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
						<input class="radio-tab" name="radioSeparator" value="." id="separator2" type="radio" checked>
						<label for="separator2" style="font-size:150%;padding:0 10px;">.</label>
					</div>
				</div>
				<a class="btn-class" id="btn_download"><?= $_DOWNLOAD_BUTTON ?></a>
			</div>
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
		var download = false;

		$("#decimal_separator").hide();
		$("#border").css({ 'width': '172px', 'cursor': 'default' });
		$('#select-border label').css({ 'cursor': 'default' });
		$('.border-list').width(220);
		var ul = $('<ul>').appendTo('.border-list');
		ul.append('<li data-value="1"><?= $_HURS ?></li>');
		ul.append('<li data-value="2"><?= $_RORS ?></li>');
		ul.append('<li data-value="3"><?= $_BGRS ?></li>');
		ul.append('<li data-value="4"><?= $_MKRS ?></li>');
		ul.append('<li data-value="5"><?= $_ALRS ?></li>');
		ul.append('<li data-value="6"><?= $_MERS ?></li>');
		ul.append('<li data-value="7"><?= $_BARS ?></li>');
		ul.append('<li data-value="8"><?= $_HRRS ?></li>');
		ul.append('<li data-value="9"><?= $_RSHU ?></li>');
		ul.append('<li data-value="10"><?= $_RSRO ?></li>');
		ul.append('<li data-value="11"><?= $_RSBG ?></li>');
		ul.append('<li data-value="12"><?= $_RSMK ?></li>');
		ul.append('<li data-value="13"><?= $_RSAL ?></li>');
		ul.append('<li data-value="14"><?= $_RSME ?></li>');
		ul.append('<li data-value="15"><?= $_RSBA ?></li>');
		ul.append('<li data-value="16"><?= $_RSHR ?></li>');
		$("#chart_1").css({ 'margin-top': '20px' });

		$(".border-list ul li").mousedown(function () {
			$("#border").val($(this).text());
			getBorder($(this).text());
			$("#direction").val($(this).attr("data-value"));
			switch ($("#direction").val()) {
				case '1':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '2':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '3':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '4':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '5':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '6':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '7':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '8':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '9':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '10':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '11':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '12':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '13':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '14':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '15':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				case '16':
					CheckInput();
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
					break;
				default:
					$("#data-table").html(tbodyHTML_1);
					$("#chart_1").show();
			}
		});

		$("#border")
			.focusin(function () {
				if (getdata && !download) { $(".border-list").show(); }
				else { $(this).blur(); }
			})
			.focusout(function () {
				if (getdata && !download) { $(".border-list").hide(); }
			});

		$(".content-select-item").click(function () {
			if (!$(this).hasClass("inactive")) {
				$(this).addClass("active").siblings().removeClass("active");
				$(".page").eq($(this).index()).show().siblings().hide();
				if ($(this).index() == 2) { // Download section

					$("#border").val($("li").attr("data-value").val());

					// $("#border").val('<?= $_ALL_DIRECTION ?>');
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
				$("#date_period").css("border", "2px solid rgba(1, 109, 182, 1)");
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

		$("#time_period").click(function () {
			$(".period").slideToggle(300);
		});

		$("input[type=radio][name='radioFormat']").click(function () {
			$("#decimal_separator").toggle($("input[type=radio][name='radioFormat']:checked").val() == "CSV");
		});


		$("#btn_download").click(function () {
			if (($(".period_error").css("color") == "rgb(207, 0, 15)" && $("#time_period").prop("checked"))) {
				$("#date_period").focus();
				return;
			}
			var params = {};
			params.download = true;
			params.format = $("input[type=radio][name='radioFormat']:checked").val();
			params.decimal = $("input[type=radio][name='radioSeparator']:checked").val();
			// params.border = $("#all_borders").prop("checked") ? '' : borderDwn; 
			//borderDwn = "";

			// if ($("#all_borders").prop("checked") && borderDwn == "") {
			// 	params.border = '';
			// } else if ($("#all_borders").prop("checked") && borderDwn !== "") {
			// 	params.border = ''; 
			// 	smer = '';
			// }
			// if (!$("#all_borders").prop("checked") && borderDwn !== "") {
			// 	params.border = borderDwn;
			// 	smer = direction;
			// }

			params.border = $("#direction").val();

			console.log(params.border);

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
			filename = "PLANED_SCHEDULE_EVOLUTION_RESULTS" + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
			params.filename = filename + "." + params.format.toLowerCase();

			window.location.replace("download.php?" + $.param(params));
		});


		function CheckInput() {
			$("#help-text").html("");
			if ($("#day").val()) {
				console.log($("#direction").val());
				GetData($("#day").val(), $("#direction").val());
			}
			else {
				$("#help-text").html('<?= $_MSG_SELECT_DAY ?>');
			}
			return;
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

		function GetData(d, b) {
			$(".content-select > .content-select-item").each(function () {
				$(this).removeClass("active");
				$(this).addClass("inactive");
			});
			$(".page").eq(4).show();
			$.getJSON("get_results.php", { day: d, border: b }, function (result) {  console.log('Rezultat: '+result);
				console.log(result);
				$("#data-header").html('');
				$("#data-table").html('');
				$("#chart_1").hide();
				$('.border-select').html('');
				if (result == null || result == undefined) {
					$('.empty-text').each(function (i, obj) {
						$(obj).html('<?= $_NO_DATA ?>' + $("#date").val());
					});
				}
				else {
					$('.empty-text').each(function (i, obj) {
						$(obj).html('');
					});
					var theaderHTML = '<tr class="subtitle bold"><td class="hour">Gates</td><td class="hour">H01<br>[MW]</td><td class="hour">H02<br>[MW]</td><td class="hour">H03<br>[MW]</td><td class="hour">H04<br>[MW]</td><td class="hour">H05<br>[MW]</td><td class="hour">H06<br>[MW]</td><td class="hour">H07<br>[MW]</td><td class="hour">H08<br>[MW]</td><td class="hour">H09<br>[MW]</td><td class="hour">H10<br>[MW]</td><td class="hour">H11<br>[MW]</td><td class="hour">H12<br>[MW]</td><td class="hour">H13<br>[MW]</td><td class="hour">H14<br>[MW]</td><td class="hour">H15<br>[MW]</td><td class="hour">H16<br>[MW]</td><td class="hour">H17<br>[MW]</td><td class="hour">H18<br>[MW]</td><td class="hour">H19<br>[MW]</td><td class="hour">H20<br>[MW]</td><td class="hour">H21<br>[MW]</td><td class="hour">H22<br>[MW]</td><td class="hour">H23<br>[MW]</td><td class="hour">H24<br>[MW]</td></tr>';
					var line = '<tr><td colspan="25" style="height:1px; margin:0; padding:0; background-color:#9C9990"></td></tr>';
					tbodyHTML_1 = line;
					var n_data = CheckDST(d);
					var index = result.length - 1;

					var lastHour = result[result.length - 1].CURRENT_HOUR;
					// for (var i in result) {

					tbodyHTML_1 += '<tr><td class="hour">' + '<?= $_DAY_BEFORE ?>' + '</td><td>' + result[0].H01 + '</td><td>' + result[0].H02 + '</td><td>' + result[0].H03 + '</td><td>' + result[0].H04 + '</td><td>' + result[0].H05 + '</td><td>' + result[0].H06 + '</td><td>' + result[0].H07 + '</td><td>' + result[0].H08 + '</td><td>' + result[0].H09 + '</td><td>' + result[0].H10 + '</td><td>' + result[0].H11 + '</td><td>' + result[0].H12 + '</td>'
						+ '<td>' + result[0].H13 + '</td><td>' + result[0].H14 + '</td><td>' + result[0].H15 + '</td><td>' + result[0].H16 + '</td><td>' + result[0].H17 + '</td><td>' + result[0].H18 + '</td><td>' + result[0].H19 + '</td><td>' + result[0].H20 + '</td><td>' + result[0].H21 + '</td><td>' + result[0].H22 + '</td><td>' + result[0].H23 + '</td><td>' + result[0].H24 + '</td></tr>';

					tbodyHTML_1 += '<tr class="frau"><td class="hour">' + result[index].HOUR + '</td><td>' + result[index].H01 + '</td><td>' + result[index].H02 + '</td><td>' + result[index].H03 + '</td><td>' + result[index].H04 + '</td><td>' + result[index].H05 + '</td><td>' + result[index].H06 + '</td><td>' + result[index].H07 + '</td><td>' + result[index].H08 + '</td><td>' + result[index].H09 + '</td><td>' + result[index].H10 + '</td><td>' + result[index].H11 + '</td><td>' + result[index].H12 + '</td>'
						+ '<td>' + result[index].H13 + '</td><td>' + result[index].H14 + '</td><td>' + result[index].H15 + '</td><td>' + result[index].H16 + '</td><td>' + result[index].H17 + '</td><td>' + result[index].H18 + '</td><td>' + result[index].H19 + '</td><td>' + result[index].H20 + '</td><td>' + result[index].H21 + '</td><td>' + result[index].H22 + '</td><td>' + result[index].H23 + '</td><td>' + result[index].H24 + '</td></tr>';

					// }														

					$("#data-header").html(theaderHTML);
					//															$("#data-header tr:last").addClass("underline");
					// tbodyHTML_1 += line;
					$("#data-table").html(tbodyHTML_1);

					var remainHours = lastHour - 24;

					$("#data-table .frau").find("td:gt(" + remainHours + ")").html('-');

					var D1_Forecast_data = [];
					var realised_load_data = [];

					D1_Forecast_data.push(result[0].H01);
					D1_Forecast_data.push(result[0].H02);
					D1_Forecast_data.push(result[0].H03);
					D1_Forecast_data.push(result[0].H04);
					D1_Forecast_data.push(result[0].H05);
					D1_Forecast_data.push(result[0].H06);
					D1_Forecast_data.push(result[0].H07);
					D1_Forecast_data.push(result[0].H08);
					D1_Forecast_data.push(result[0].H09);
					D1_Forecast_data.push(result[0].H10);
					D1_Forecast_data.push(result[0].H11);
					D1_Forecast_data.push(result[0].H12);
					D1_Forecast_data.push(result[0].H13);
					D1_Forecast_data.push(result[0].H14);
					D1_Forecast_data.push(result[0].H15);
					D1_Forecast_data.push(result[0].H16);
					D1_Forecast_data.push(result[0].H17);
					D1_Forecast_data.push(result[0].H18);
					D1_Forecast_data.push(result[0].H19);
					D1_Forecast_data.push(result[0].H20);
					D1_Forecast_data.push(result[0].H21);
					D1_Forecast_data.push(result[0].H22);
					D1_Forecast_data.push(result[0].H23);
					D1_Forecast_data.push(result[0].H24);

					realised_load_data.push(result[index].H01);
					realised_load_data.push(result[index].H02);
					realised_load_data.push(result[index].H03);
					realised_load_data.push(result[index].H04);
					realised_load_data.push(result[index].H05);
					realised_load_data.push(result[index].H06);
					realised_load_data.push(result[index].H07);
					realised_load_data.push(result[index].H08);
					realised_load_data.push(result[index].H09);
					realised_load_data.push(result[index].H10);
					realised_load_data.push(result[index].H11);
					realised_load_data.push(result[index].H12);
					realised_load_data.push(result[index].H13);
					realised_load_data.push(result[index].H14);
					realised_load_data.push(result[index].H15);
					realised_load_data.push(result[index].H16);
					realised_load_data.push(result[index].H17);
					realised_load_data.push(result[index].H18);
					realised_load_data.push(result[index].H19);
					realised_load_data.push(result[index].H20);
					realised_load_data.push(result[index].H21);
					realised_load_data.push(result[index].H22);
					realised_load_data.push(result[index].H23);
					realised_load_data.push(result[index].H24);

					absoluteRemainHours = -remainHours;
					while (absoluteRemainHours > 1) {
						realised_load_data.pop();
						absoluteRemainHours--;
					}

					Highcharts.chart('chart_1', {
						chart: {
							width: 1200
						},
						title: {
							text: '<?= $_PLANED_SCHEDULE_EVOLUTION ?>'
						},
						yAxis: { // Primary yAxis
							labels: {
								format: '{value} MW',
								style: {
									// color: Highcharts.getOptions().colors[0]
								}
							},
							title: {
								text: 'MW',
								style: {
									// color: '#00A7E1'
								}
							},
							min: 0
						},
						xAxis: {
							categories: ['H01', 'H02', 'H03', 'H04', 'H05', 'H06', 'H07', 'H08', 'H09', 'H10', 'H11', 'H12', 'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
						},
						tooltip: {
							crosshairs: true,
							shared: true
						},
						credits: {
							enabled: false
						},
						plotOptions: {
							spline: {
								marker: {
									radius: 4,
									lineColor: '#666666'
									// lineWidth: 1
								}
							}
						},
						colors: ['#c3c3c3', '#F25F5C'],
						series: [{
							name: 'Realised',
							data: realised_load_data,
							lineWidth: 5,
							tooltip: {
								valueSuffix: ' MW'
							}
						}, {
							name: 'D1-Forecast',
							data: D1_Forecast_data,
							lineWidth: 1,
							tooltip: {
								valueSuffix: ' MW'
							}
						}]
					});


					$("#chart_1").show();
				}
				$(".content-select > .content-select-item").each(function () {
					$(this).removeClass("inactive");
					if ($(this).index() == 0) { $(this).click(); }
				});
				getdata = true;
				$("#select-border label").css({ 'cursor': 'pointer' });
				$("#border").css({ 'cursor': 'pointer' });
				// $("#border").val('<?= $_HURS ?>');
				// $("#direction").val(1); 																										
			});
			return;
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