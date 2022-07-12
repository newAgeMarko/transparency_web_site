<?php
	ini_set('display_errors', '1');
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "lat";
	include 'lng.php';
?>
<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="utf-8">
	<title><?= _TITLE ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= _TITLE ?>">
	
	<script type="text/javascript" src="../common/jquery/jquery-1.11.1.min.js"></script> 
	<script type="text/javascript" src="../common/charts/highcharts.js"></script>
    <script type="text/javascript" src="../common/datepicker/datepicker.js"></script>

	<link rel="stylesheet" type="text/css" href="../common/datepicker/datepicker.css"/>
	<link rel="stylesheet" type="text/css" href="../common/css/hint.css"/>
	<link rel="stylesheet" type="text/css" href="../common/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="../common/css/download.css"/>
	<link rel="stylesheet" type="text/css" href="../common/css/spinner.css"/>

</head>
<body> 
<div style="width:860px;">
	<div class="menu">
		<div class="selections-group">
			<div class="selections">
				<input id="date" class="datepicker-here" placeholder="<?= _SELECT_DAY ?>" data-range="false" onkeydown="return false;" />
				<label for="date"><?= _DAY ?></label>
			</div>	
			<input type="hidden" name="day" id="day">
		</div>	
		<div class="content-select">
			<div class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_TABLE ?>"></div>	
			<div class="content-select-item data-chart inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_CHART ?>"></div>	
			<div class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_DOWNLOAD ?>"></div>	
		</div>	
	</div>
	<div class="content">
		<div class="page"><h1><?= _IDATC ?></h1>
		<table>
			<thead id="data-header">
			</thead>
			<tbody id="data-table">
			</tbody>
		</table>
		<span id="empty-text"></span>
		</div>
		<div class="page">
			<div class="border-select"></div>
			<h1><?= _IDATC ?></h1>
			<div id="container"></div>
			<span id="empty-text"></span>
		</div>
		<div class="page"><h1><?= _DOWNLOAD_DATA ?></h1>
		<div class="download_form">
			<div class="switch">
				<input id="time_period" type="checkbox">
				<label for="time_period"><?= _TIME_PERIOD ?></label>
			</div>
			<div class="period">
				<input id="date_period" class="datepicker-here" placeholder="<?= _SELECT_PERIOD ?>" data-range="true" data-multiple-dates-separator=" - " onkeydown="return false;" />
				<div class="period_error"><?= _MSG_TIME_PERIOD ?></div>
			</div>
			<div class="format"><?= _DATA_FORMAT ?>
				<div class="format_wrapper">
					<input type="radio" class="radio-tab" name="radioFormat" value="CSV" id="format1" />
					<label for="format1">CSV</label>
					<input type="radio" class="radio-tab" name="radioFormat" value="JSON" id="format2" />
					<label for="format2">JSON</label>
					<input type="radio" class="radio-tab" name="radioFormat" value="XML" id="format3" checked />
					<label for="format3">XML</label>
				</div>
			</div>
			<a class="btn-class" id="btn_download"><?= _DOWNLOAD_BUTTON ?></a>
		</div>
		</div>
		<div class="page" id="help-page" style="display: block"><h1><?= _TITLE_2 ?></h1><span id="help-text"><?= _MSG_SELECT_DAY ?></span></div>
		<div class="page">
			<div class="spinner_background">
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

<script>
var rs_code;
var filename;
var dataStr;
var single = false;

$(".content-select-item").click(function() {
	if (!$(this).hasClass("inactive")) {
		$(this).addClass("active").siblings().removeClass("active");
		$(".page").eq($(this).index()).show().siblings().hide();
	}	
});

$("#date").datepicker({
	language: '<?= $lng ?>',
	autoClose: true,
	onRenderCell: function (date, cellType) {
        var nH = CheckDST(date);
		var tomorrow = new Date();
		tomorrow.setDate(new Date().getDate()+1);
		var startdate = new Date('2013-06-30');
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
	language: '<?= $lng ?>',
	autoClose: true,
	onRenderCell: function (date, cellType) {
        var nH = CheckDST(date);
		var tomorrow = new Date();
		tomorrow.setDate(new Date().getDate()+1);
		var startdate = new Date('2013-06-30');
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
    onSelect: function(dp, dArray){
					$("#date_period").css("border", "2px solid rgba(1, 109, 182, 1)");
					$(".period_error").css("color", "#ccc");
					if (dArray.length > 1) {
						var timeDiff = Math.abs(dArray[1].getTime() - dArray[0].getTime());
						var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; 
						if (diffDays>10) {
							$("#date_period").css("border", "2px solid rgba(207, 0, 15, 1)");
							$(".period_error").css("color", "#cf000f");	
						}
					}
}
});

$("#time_period").click(function() {
	$(".period").slideToggle(300);
});

$("#btn_download").click(function() {
	if (($(".period_error").css("color")=="rgb(207, 0, 15)" && $("#time_period").prop("checked"))) {
		$("#date_period").focus();
		return;
	}	
	var params = {};
    params.download = true;
	params.daily = true;
	params.format = $("input[type=radio]:checked").val();
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
	filename = params.from.replace(/\-/g, '') + "_" + (params.hasOwnProperty("to") ? params.to.replace(/\-/g, '') +  "_" : "") + rs_code;
    params.filename = filename + "." + params.format.toLowerCase();

	window.location.replace("../../intraday_objava/download.php?" + $.param(params));
	 
});

Highcharts.setOptions({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
    },
	subtitle: {
		text: '',
		style: {
			display: 'none'
		}
	},		
	lang: { thousandsSep: '' },
	plotOptions: {
        series: {
            lineWidth: 3,
            states: {
                hover: {
                    enabled: true,
                    lineWidth: 3
                }
            }
		}	
	}		
});
	
function CheckInput() {
	$("#help-text").html("");
	if ($("#day").val()) {
		GetData($("#day").val());
	}
	else {
		$("#help-text").html('<?= _MSG_SELECT_DAY ?>');
	}
} 	

function GetData(d) {

var start = performance.now();
	var nH = CheckDST(d);

	$(".content-select > .content-select-item").each(function () { 
															$(this).removeClass("active"); 
															$(this).addClass("inactive"); 
													});
	$(".page").eq(4).show();
	$.getJSON("../../intraday_objava/idatc.php", { day: d }, function(result) {
var stop = performance.now();
console.log("Rezultati učitani za: " + Math.round(stop - start) + " milisekundi.");	
														$("#data-header").html('');
														$("#data-table").html('');
														$('#container').html('');	
														$('.border-select').html('');														
														if(result == null) {
															$('#empty-text').each(function(i, obj) {
																$(obj).html('<?= _NO_DATA ?>' + $("#date").val());															
															});
														}
														else {
															rs_code = (result[0].ID_ID.substr(0, 2) == "RS") ? rs_code = result[0].OUT_AREA	: result[0].IN_AREA;															
															$('#empty-text').each(function(i, obj) {
																$(obj).html('');															
															});
															var theaderHTML_1 = '<tr class="subtitle"><td class="hour"><?= _DIRECTION ?></td>';
															var theaderHTML_2 = '<tr class="subtitle underline"><td class="hour"><?= _HOUR ?></td>';
															var arrbodyHTML = [];
															var h = '';
															var h_1 = '';
															var categories = [];
															var chartdata = {
																 "datasets": []
															};
															var n_data = CheckDST(d);
															for (var i in result) {
																var idatc_data = {};
																idatc_data.name = result[i].ID_ID;
																idatc_data.title = (idatc_data.name.replace("RS","")).replace("-","");
																idatc_data.unit = "MW";
																idatc_data.hour = [];
																theaderHTML_1 += '<td>' + result[i].ID_ID + '</td>'; 
																theaderHTML_2 += '<td>MW</td>'; 
																for (var n = 0; n < n_data; n++) { 
																	h = ('0' + n.toString()).slice(-2);
																	h_1 = ('0' + (n+1).toString()).slice(-2);
																	if (n_data == 23 && n > 1) {
																		categories[n] = ('0' + (n+1).toString()).slice(-2) + '-' + ('0' + (n+2).toString()).slice(-2);																	
																	}
																	else if (n_data == 25 && n > 2) {
																		categories[n] = ('0' + (n-1).toString()).slice(-2) + '-' + ('0' + n.toString()).slice(-2);																	
																	}	
																	else {
																		categories[n] = h + '-' + h_1;
																	}
																	if (typeof arrbodyHTML[n] == 'undefined') { arrbodyHTML[n] = '<tr><td class="hour">' + categories[n] + '</td>'; }
																	arrbodyHTML[n] += '<td>' + ((typeof result[i]['H'+h_1] == 'undefined') ? '---' : result[i]['H'+h_1]) + '</td>';
																	idatc_data.hour.push((typeof result[i]['H'+h_1] == 'undefined') ? null : result[i]['H'+h_1]);
																}
																chartdata.datasets.push(idatc_data);
															}
															$("#data-header").html(theaderHTML_1 + '</tr>' + theaderHTML_2 + '</tr>');
															var tbodyHTML = '';
															$.each(arrbodyHTML, function (index, value) {
																tbodyHTML += value + '</tr>';
															});
															$("#data-table").html(tbodyHTML);
															$("#data-table tr:last").addClass("underline");
							
															var lastChart;
															$('#container').bind('mouseleave mouseout ', function(e) {
																var chart,
																	point,
																	i,
																	event;
																for (i = 0; i < Highcharts.charts.length; i = i + 1) {
																	chart = Highcharts.charts[i];
																	event = chart.pointer.normalize(e.originalEvent);
																	point = chart.series[0].searchPoint(event, true);

																	point.onMouseOut(); 
																	chart.tooltip.hide(point);
																	chart.xAxis[0].hideCrosshair(); 
																}
															});
															$('#container').bind('mousemove touchmove touchstart', function(e) {
																var chart,
																	points,
																	i;
																for (i = 0; i < Highcharts.charts.length; i++) {
																	chart = Highcharts.charts[i];
																	e = chart.pointer.normalize(e); // Find coordinates within the chart
																	points = [chart.series[0].searchPoint(e, true), chart.series[1].searchPoint(e, true)]; // Get the hovered point

																	if (points[0] && points[1]) {
																		points[0].onMouseOver(); // Show the hover marker
																		points[1].onMouseOver(); // Show the hover marker
																		chart.tooltip.refresh(points); // Show the tooltip
																		chart.xAxis[0].drawCrosshair(e, points[0]); // Show the crosshair
																	}
																}
															});

															Highcharts.Pointer.prototype.reset = function () {}; // Override the reset function, we don't need to hide the tooltips and crosshairs.

															function syncExtremes(e) { // Synchronize zooming through the setExtremes event handler.
																var thisChart = this.chart;

																Highcharts.each(Highcharts.charts, function (chart) {
																	if (chart !== thisChart) {
																		if (chart.xAxis[0].setExtremes) { // It is null while updating
																			chart.xAxis[0].setExtremes(e.min, e.max);
																		}
																	}
																});
															}
	
															$.each(chartdata.datasets, function (i, dataset) {
																if (i%2 == 0) { //first series of chart
																	$('<div class="border-select-item border-on">' + dataset.title + '</div>').appendTo('.border-select');
																	$('<div class="chart">')
																		.appendTo('#container')
																		.highcharts({
																		chart: {
																			marginLeft: 50, // Keep all charts left aligned
																			spacingTop: 20,
																			spacingBottom: 20
																			// zoomType: 'x'
																			// pinchType: null // Disable zoom on touch devices
																		},
																		title: {
																			text: dataset.title,
																			align: 'left',
																			margin: 0,
																			x: 30
																		},
																		credits: {
																			enabled: false
																		},
																		legend: {
																			enabled: false
																		},
																		xAxis: {
																			categories: categories,
																			crosshair: true,
																			events: {
																				setExtremes: syncExtremes
																			}
																		},
																		yAxis: {
																			title: {
																				text: null
																			},
																			labels: {
																				format: '{value}'
																			}
																		},
																		tooltip: {
																			shared: true,
																			positioner: function () {
																				return {
																					x: this.chart.chartWidth - 124, // right aligned
																					y: 5 // align to title
																				};
																			},
																			borderWidth: 0,
																			backgroundColor: 'none',
																			pointFormat: '{series.name}: {point.y}<br>',
																			headerFormat: '',
																			shadow: false,
																			style: {
																				fontSize: '12px'
																			}
																		},
																		series: [{
																			data: dataset.hour,
																			name: dataset.name,
																			type: "line",
																			color: '#016DB6',
																			fillOpacity: 0.3,
																			tooltip: {
																				valueSuffix: ' ' + dataset.unit
																			}
																		}]
																	});
																}	 
																else { //second series of chart
																	lastChart = Highcharts.charts[Highcharts.charts.length-1];
																	lastChart.addSeries({
																		data: dataset.hour,
																		name: dataset.name,
																		type: "line",
																		color: '#FFA000',
																		fillOpacity: 0.3,
																		tooltip: {
																			valueSuffix: ' ' + dataset.unit
																		}
																	});
																}
															});

															$(".border-select-item").click(function() {
																var index = $(".border-select-item").index(this);
																var c = $(".chart").eq(index);
																
																if ($(this).hasClass("border-off")) {
																	$(this).removeClass("border-off");
																	$(this).addClass("border-on");
																}
																else {
																	$(this).removeClass("border-on");
																	$(this).addClass("border-off");
																} 
																c.fadeToggle(300);		
															});
														}	
														$(".content-select > .content-select-item").each(function () { 
															$(this).removeClass("inactive"); 
															if ($(this).index() == 0) { $(this).click(); }
														});
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