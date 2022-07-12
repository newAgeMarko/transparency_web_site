<?php
	ini_set('display_errors', '1');
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "lat";
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : "";
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
			<div class="selections" id="select-border">
				<input id="border" type="text" placeholder="<?= _SELECT_DIRECTION ?>"/>
				<label for="border"><?= _DIRECTION ?></label>
				<div class="border-list"></div>	
			</div>	
			<input type="hidden" name="direction" id="direction">
			<input type="hidden" name="day" id="day">
		</div>	
		<div class="content-select">
			<div class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_TABLE ?>"></div>	
			<div class="content-select-item data-chart inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_CHART ?>"></div>	
			<div class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_DOWNLOAD ?>"></div>	
		</div>	
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
			<div class="empty-text"></div>
		</div>
		<div class="page"><h1><?= _DOWNLOAD_DATA ?></h1>
		<div class="download_form">
			<div class="switch">
				<input id="all_borders" type="checkbox">
				<label for="all_borders"><?= _ALL_BORDERS ?></label>
			</div>
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
			<div class="format" id="decimal_separator"><?= _DECIMAL_SEPARATOR ?>
				<div class="format_wrapper" style="margin-top:-5px">
					<input class="radio-tab" name="radioSeparator" value="," id="separator1" type="radio">
					<label for="separator1" style="font-size:150%;padding:0 10px;">,</label>
					<input class="radio-tab" name="radioSeparator" value="." id="separator2" checked type="radio">
					<label for="separator2" style="font-size:150%;padding:0 10px;">.</label>
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
var getdata = false;
var tbodyHTML_1 = '';
var tbodyHTML_2 = '';
var download = false;

$("#decimal_separator").hide();
$("#border").css({'width': '172px', 'cursor':'default'}); 
$("#select-border label").css({'cursor':'default'});
$(".border-list").width(172);
var ul = $('<ul>').appendTo('.border-list');
ul.append('<li data-value="1"><?= $border ?> - RS</li>');
ul.append('<li data-value="2">RS - <?= $border ?></li>');
ul.append('<li data-value="0"><?= _BOTH_DIRECTION ?></li>');
$("#chart_1").css({'margin-top':'20px'});
$("#chart_2").css({'margin-top':'20px'});

$(".border-list ul li").mousedown(function(){
	$("#border").val($(this).text());
	$("#direction").val($(this).attr("data-value"));
	switch($("#direction").val()) {
		case '1':
			$("#data-table").html(tbodyHTML_1);
			$("#chart_1").show();
			$("#chart_2").hide();
			break;
		case '2':
			$("#data-table").html(tbodyHTML_2);
			$("#chart_1").hide();
			$("#chart_2").show();
			break;
		default:
			$("#data-table").html(tbodyHTML_1 + tbodyHTML_2);
			$("#chart_1").show();
			$("#chart_2").show();
	} 
});

$("#border")
	.focusin(function() {
		if (getdata && !download) { $(".border-list").show(); }
		else { $(this).blur(); } 
	})
	.focusout(function() {
		if (getdata && !download) { $(".border-list").hide(); }
});

$(".content-select-item").click(function() {
	if (!$(this).hasClass("inactive")) {
		$(this).addClass("active").siblings().removeClass("active");
		$(".page").eq($(this).index()).show().siblings().hide();
		if ($(this).index()==2) { // Download section
			$("#border").val('<?= _BOTH_DIRECTION ?>');
			download = true;
			$("#select-border label").css({'cursor':'default'});
			$("#border").css({'cursor':'default'});
		}
		else {
			direction = $("li[data-value='" + $("#direction").val() + "']").text();
			$("#border").val(direction);
			download = false;
			$("#select-border label").css({'cursor':'pointer'});
			$("#border").css({'cursor':'pointer'});
		}
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
					$("#date_period").css("border", "2px solid rgba(235, 16, 46, 1)");
					$(".period_error").css("color", "#ccc");
					if (dArray.length > 1) {
						var timeDiff = Math.abs(dArray[1].getTime() - dArray[0].getTime());
						var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; 
						if (diffDays>31) {
							$("#date_period").css("border", "2px solid rgba(207, 0, 15, 1)");
							$(".period_error").css("color", "#cf000f");	
						}
					}
}
});

$("#time_period").click(function() {
	$(".period").slideToggle(300);
});

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
	params.border = $("#all_borders").prop("checked") ? '' : '<?= $border ?>'; 
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
	filename = "ALLOCATION_RESULTS" + ((params.border=='') ? "" : "_" + params.border) + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
    params.filename = filename + "." + params.format.toLowerCase();

	window.location.replace("../../results_daily/download.php?" + $.param(params));
	 
});

Highcharts.setOptions({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        zoomType: 'xy',
        style: {
            fontFamily: 'Arial'
        }		
    },
	subtitle: {
		text: '',
		style: {
			display: 'none'
		}
	},		
	credits: {
		enabled: false
	},
	legend: {
            useHTML: true   
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
	},
    xAxis: [{
        title: {
            text: '<?= _HOUR ?>',
        }
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value} MW',
        },
        title: {
            text: '<?= _ALLOCATED ?>',
        },
		min: 0
    }, { // Secondary yAxis
        title: {
            text: '<?= _PRICE ?>',
        },
        labels: {
            format: '{value} EUR/Mwh',
        },
		min: 0,
        opposite: true
    }],
    tooltip: {
        shared: true,
		borderColor: '#CCCCCC',
		useHTML: true,
		headerFormat: '<span style="font-size: 11px; font-weight: bold"><?= _HOUR ?>: {point.key}</span><br/>'
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

	$(".content-select > .content-select-item").each(function () { 
															$(this).removeClass("active"); 
															$(this).addClass("inactive"); 
													});
	$(".page").eq(4).show();
	$.getJSON("../../results_daily/get_results.php", { border: "<?= $border ?>", day: d }, function(result) {
														$("#data-header").html('');
														$("#data-table").html('');
														$("#chart_1").hide();
														$("#chart_2").hide();
														$('.border-select').html('');														
														if(result == null) {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('<?= _NO_DATA ?>' + $("#date").val());															
															});
														}
														else {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('');															
															});
															var theaderHTML = '<tr class="subtitle bold"><td class="hour"><?= _DIRECTION ?></td><td class="hour"><?= _HOUR ?></td><td class="hour">ATC [MW]</td><td class="hour"><?= _REQUESTED ?> [MW]</td><td class="hour"><?= _ALLOCATED ?> [MW]</td><td class="hour"><?= _PRICE ?> [EUR/MWh]</td></tr>';
															var line = '<tr><td colspan="6" style="height:1px; margin:0; padding:0; background-color:#EB102E;"></td></tr>';
															tbodyHTML_1 = line;
															tbodyHTML_2 = line;
															var n_data = CheckDST(d);
															for (var i in result) {
																if (result[i].direction=='<?= $border ?>RS') {
																	tbodyHTML_1 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';
																}
																else {
																	tbodyHTML_2 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';																	
																}	
															}
															$("#data-header").html(theaderHTML);
//															$("#data-header tr:last").addClass("underline");
															tbodyHTML_1 += line;
															tbodyHTML_2 += line;
															$("#data-table").html(tbodyHTML_1 + tbodyHTML_2);
//															$("#data-table tr:last").addClass("underline");

															var categories_1 = [];
															var categories_2 = [];
															var total_allocated_1 = [];
															var total_allocated_2 = [];
															var auction_price_1 = [];
															var auction_price_2 = [];
															var chartdata_1 = $(result).filter(function (i,n){return n.direction==='<?= $border ?>RS'});
															var chartdata_2 = $(result).filter(function (i,n){return n.direction==='RS<?= $border ?>'});
															$.each(chartdata_1, function () {
																categories_1.push(this.hour);
																total_allocated_1.push(this.total_allocated);
																auction_price_1.push(this.auction_price);
															});
															Highcharts.chart('chart_1', {
																title: {
																	text: '<?= _DIRECTION ?>: <?= $border ?> - RS'
																},
															    xAxis: {
																	categories: categories_1
																},
																series: [{
																	name: '<?= _ALLOCATED ?>',
																	data: total_allocated_1,
																	color: '#5C6873',
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= _PRICE ?>',
																	data: auction_price_1,
																	yAxis: 1,
																	color: '#EB102E',
																	type: 'line',
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
																	}
																}]
															});
															$.each(chartdata_2, function () {
																categories_2.push(this.hour);
																total_allocated_2.push(this.total_allocated);
																auction_price_2.push(this.auction_price);
															});
															Highcharts.chart('chart_2', {
																title: {
																	text: '<?= _DIRECTION ?>: RS - <?= $border ?>'
																},
															    xAxis: {
																	categories: categories_2
																},
																series: [{
																	name: '<?= _ALLOCATED ?>',
																	data: total_allocated_2,
																	color: '#5C6873',
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= _PRICE ?>',
																	data: auction_price_2,
																	yAxis: 1,
																	color: '#EB102E',
																	type: 'line',
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
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
														$("#select-border label").css({'cursor':'pointer'});
														$("#border").css({'cursor':'pointer'});
														$("#border").val('<?= _BOTH_DIRECTION ?>');
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