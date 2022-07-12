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
	<title>
		< ?=_TITLE ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="< ?= _TITLE ?>">

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
	<div style=" width:1210px">
		<div class="menu">
			<div class="selections-group">
				<div class="selections">
					<input id="date" class="datepicker-here" placeholder="<?= $_SELECT_DAY ?>" data-range="false"
						onkeydown="return false;" autocomplete="off" />
					<label for="date"><?= $_DAY ?></label>
				</div>
				<input type="hidden" name="direction" id="direction">
				<input type="hidden" name="day" id="day">
				<div class="selections" id="select-border2">
					<input id="border" type="text" placeholder="<?= $_SELECT_DIRECTION ?>" autocomplete="off" />
					<label for="border"><?= $_DIRECTION ?></label>
					<div class="border-list"></div>
				</div>
			</div>
			<!-- <div class="content-select">
					<div class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_TABLE ?>"></div>	
					<div class="content-select-item data-chart inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_CHART ?>"></div>	
					<div class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_DOWNLOAD ?>"></div>	
				</div>	 -->
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
				<div id="chart"></div>
				<div class="empty-text"></div>
			</div>
			<div class="page">
				<h1><?= $_DOWNLOAD_DATA ?></h1>
				<div class="download_form">
					<!-- <div class="switch">
							<input id="time_period" type="checkbox">
							<label for="time_period"><?= $_TIME_PERIOD ?></label>
						</div>
						<div class="period">
							<input id="date_period" class="datepicker-here" placeholder="<?= $_SELECT_PERIOD ?>" data-range="true" data-multiple-dates-separator=" - " onkeydown="return false;"  autocomplete="off" />
							<div class="period_error"><?= $_MSG_TIME_PERIOD ?></div>
						</div> -->
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
		var tbodyHTML = '';
		var download = false;

		$("#decimal_separator").hide();
		$("#border").css({ 'width': '172px', 'cursor': 'default' });
		$('#select-border label').css({ 'cursor': 'default' });
		$('.border-list').width(172);
		var ul = $('<ul>').appendTo('.border-list');
		// ul.append('<li data-value="0"><?= $_ALL_DIRECTION ?></li>');
		ul.append('<li data-value="1">HU - RS</li>');
		ul.append('<li data-value="2">RO - RS</li>');
		ul.append('<li data-value="3">BG - RS</li>');
		ul.append('<li data-value="4">MK - RS</li>');
		ul.append('<li data-value="5">AL - RS</li>');
		ul.append('<li data-value="6">ME - RS</li>');
		ul.append('<li data-value="7">BA - RS</li>');
		ul.append('<li data-value="8">HR - RS</li>');
		ul.append('<li data-value="9">RS - HU</li>');
		ul.append('<li data-value="10">RS - RO</li>');
		ul.append('<li data-value="11">RS - BG</li>');
		ul.append('<li data-value="12">RS - MK</li>');
		ul.append('<li data-value="13">RS - AL</li>');
		ul.append('<li data-value="14">RS - ME</li>');
		ul.append('<li data-value="15">RS - BA</li>');
		ul.append('<li data-value="16">RS - HR</li>');
		$("#chart").css({ 'margin-top': '20px' });


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
				if ($(this).index() == 1) {
					$('#select-border2').css('display', 'inline-block');
				} else {
					$('#select-border2').css('display', 'none');
				}
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
			filename = "CROSS-BORDER_RESULTS" + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
			params.filename = filename + "." + params.format.toLowerCase();

			window.location.replace("download.php?" + $.param(params));
		});


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

		var res = [];
		var chartdata = [];

		$(".border-list ul li").mousedown(function () {
			chartdata = [];
			var direction = $("#border").val($(this).text());
			$("#direction").val($(this).attr("data-value"));
			switch ($(this).attr("data-value")) {
				case '1':
					populateChartData(0);
					break;
				case '2':
					populateChartData(1, direction);
					break;
				case '3':
					populateChartData(2);
					break;
				case '4':
					populateChartData(3);
					break;
				case '5':
					populateChartData(4);
					break;
				case '6':
					populateChartData(5);
					break;
				case '7':
					populateChartData(6);
					break;
				case '8':
					populateChartData(7);
					break;
				case '9':
					populateChartData(8);
					break;
				case '10':
					populateChartData(9);
					break;
				case '11':
					populateChartData(10);
					break;
				case '12':
					populateChartData(11);
					break;
				case '13':
					populateChartData(12);
					break;
				case '14':
					populateChartData(13);
					break;
				case '15':
					populateChartData(14);
					break;
				case '16':
					populateChartData(15);
					break;
				case '17':
					populateChartData(16);
					break;
				case '18':
					populateChartData(17);
					break;
				case '19':
					populateChartData(18);
					break;
				case '20':
					populateChartData(19);
					break;
				case '21':
					populateChartData(20);
					break;
				case '22':
					populateChartData(21);
					break;
				case '23':
					populateChartData(22);
					break;
				case '24':
					populateChartData(23);
					break;

				default:
					populateChartData(0);
			}
		});

		function populateChartData(i, direction) {
			chartdata.push(res[i].H01);
			chartdata.push(res[i].H02);
			chartdata.push(res[i].H03);
			chartdata.push(res[i].H04);
			chartdata.push(res[i].H05);
			chartdata.push(res[i].H06);
			chartdata.push(res[i].H07);
			chartdata.push(res[i].H08);
			chartdata.push(res[i].H09);
			chartdata.push(res[i].H10);
			chartdata.push(res[i].H11);
			chartdata.push(res[i].H12);
			chartdata.push(res[i].H13);
			chartdata.push(res[i].H14);
			chartdata.push(res[i].H15);
			chartdata.push(res[i].H16);
			chartdata.push(res[i].H17);
			chartdata.push(res[i].H18);
			chartdata.push(res[i].H19);
			chartdata.push(res[i].H20);
			chartdata.push(res[i].H21);
			chartdata.push(res[i].H22);
			chartdata.push(res[i].H23);
			chartdata.push(res[i].H24);
			console.log(chartdata);
			makeChart(chartdata, direction);
		}


		function GetData(d) {
			$(".content-select > .content-select-item").each(function () {
				$(this).removeClass("active");
				$(this).addClass("inactive");
			});
			$(".page").eq(4).show();
			$.getJSON("get_results.php", { day: d }, function (result) {
				chartdata = [];
				res = result;
				$("#data-header").html('');
				$("#data-table").html('');
				$("#chart").hide();
				$('.border-select').html('');
				if (result == null) {
					$('.empty-text').each(function (i, obj) {
						$(obj).html('<?= $_NO_DATA ?>' + $("#date").val());
					});
				}
				else {
					$('.empty-text').each(function (i, obj) {
						$(obj).html('');
					});
					var theaderHTML = '<tr class="subtitle bold"><td class="hour"><?= $_DIRECTION ?></td><td class="hour">H01<br>[MW]</td><td class="hour">H02<br>[MW]</td><td class="hour">H03<br>[MW]</td><td class="hour">H04<br>[MW]</td><td class="hour">H05<br>[MW]</td><td class="hour">H06<br>[MW]</td><td class="hour">H07<br>[MW]</td><td class="hour">H08<br>[MW]</td><td class="hour">H09<br>[MW]</td><td class="hour">H10<br>[MW]</td><td class="hour">H11<br>[MW]</td><td class="hour">H12<br>[MW]</td><td class="hour">H13<br>[MW]</td><td class="hour">H14<br>[MW]</td><td class="hour">H15<br>[MW]</td><td class="hour">H16<br>[MW]</td><td class="hour">H17<br>[MW]</td><td class="hour">H18<br>[MW]</td><td class="hour">H19<br>[MW]</td><td class="hour">H20<br>[MW]</td><td class="hour">H21<br>[MW]</td><td class="hour">H22<br>[MW]</td><td class="hour">H23<br>[MW]</td><td class="hour">H24<br>[MW]</td></tr>';
					var line = '<tr><td colspan="25" style="height:1px; margin:0; padding:0; background-color:#9C9990;"></td></tr>';
					tbodyHTML = line;
					var n_data = CheckDST(d);
					var smer_out;
					var smer_in;
					var smer = '';
					for (var i in result) {
						var smer_out = result[i].OUTAREA;
						var smer_in = result[i].INAREA;
						var smer = '';
						if (smer_in == '10YCS-SERBIATSOV') {
							switch (smer_out) {
								case '10YHU-MAVIR----U':
									smer = 'HURS';
									break;
								case '10YRO-TEL------P':
									smer = 'RORS';
									break;
								case '10YCA-BULGARIA-R':
									smer = 'BGRS';
									break;
								case '10YMK-MEPSO----8':
									smer = 'MKRS';
									break;
								case '10YAL-KESH-----5':
									smer = 'ALRS';
									break;
								case '10YCS-CG-TSO---S':
									smer = 'MERS';
									break;
								case '10YBA-JPCC-----D':
									smer = 'BARS';
									break;
								case '10YHR-HEP------M':
									smer = 'HRRS';
									break;
								default:
									break;
							}
						} else if (smer_out == '10YCS-SERBIATSOV') {
							switch (smer_in) {
								case '10YHU-MAVIR----U':
									smer = 'RSHU';
									break;
								case '10YRO-TEL------P':
									smer = 'RSRO';
									break;
								case '10YCA-BULGARIA-R':
									smer = 'RSBG';
									break;
								case '10YMK-MEPSO----8':
									smer = 'RSMK';
									break;
								case '10YAL-KESH-----5':
									smer = 'RSAL';
									break;
								case '10YCS-CG-TSO---S':
									smer = 'RSME';
									break;
								case '10YBA-JPCC-----D':
									smer = 'RSBA';
									break;
								case '10YHR-HEP------M':
									smer = 'RSHR';
									break;
								default:
									break;
							}
						}

						console.log(result[i].OUTAREA + ' --> ' + result[i].INAREA);
						tbodyHTML += '<tr><td class="hour">' + smer + '</td><td>' + result[i].H01 + '</td><td>' + result[i].H02 + '</td><td>' + result[i].H03 + '</td><td>' + result[i].H04 + '</td><td>' + result[i].H05 + '</td><td>' + result[i].H06 + '</td><td>' + result[i].H07 + '</td><td>' + result[i].H08 + '</td><td>' + result[i].H09 + '</td><td>' + result[i].H10 + '</td><td>' + result[i].H11 + '</td><td>' + result[i].H12 + '</td>'
							+ '<td>' + result[i].H13 + '</td><td>' + result[i].H14 + '</td><td>' + result[i].H15 + '</td><td>' + result[i].H16 + '</td><td>' + result[i].H17 + '</td><td>' + result[i].H18 + '</td><td>' + result[i].H19 + '</td><td>' + result[i].H20 + '</td><td>' + result[i].H21 + '</td><td>' + result[i].H22 + '</td><td>' + result[i].H23 + '</td><td>' + result[i].H24 + '</td></tr>';
					}

					$("#data-header").html(theaderHTML);
					//															$("#data-header tr:last").addClass("underline");
					tbodyHTML += line;
					$("#data-table").html(tbodyHTML);
					//															$("#data-table tr:last").addClass("underline");

					populateChartData(0, direction);

				}
				$(".content-select > .content-select-item").each(function () {
					$(this).removeClass("inactive");
					if ($(this).index() == 0) { $(this).click(); }
				});
				getdata = true;
				$("#select-border label").css({ 'cursor': 'pointer' });
				$("#border").css({ 'cursor': 'pointer' });
				$("#border").val('<?= $_ALL_DIRECTION ?>');
				$("#direction").val(1);
			});
		}

		function makeChart(chartdata) {
			Highcharts.chart('chart', {
				chart: {
					width: 1210
				},
				title: {
					text: '<?= $prekogranicniplanrada ?>'
				},
				yAxis: { // Primary yAxis
					labels: {
						format: '{value} MW',
						style: {
							// color: '#F25F5C'
						}
					},
					title: {
						text: '<?= $_CAPACITY ?>',
						style: {
							// color: '#F25F5C'
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
							radius: 2,
							lineColor: '#F25F5C',
							lineWidth: 1
						}
					}
				},
				colors: ['#F25F5C'],
				series: [{
					name: '<?= $_CAPACITY ?>',
					data: chartdata,
					type: 'spline',
					pointWidth: 6,
					tooltip: {
						valueSuffix: ' MW'
					}
				}]
			});

			$("#chart").show();

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