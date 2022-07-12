<?php
	ini_set('display_errors', '0');
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "lat";
	include 'lng.php';
	error_reporting = E_ALL;
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
	<link rel="stylesheet" type="text/css" href="../common/css/spinner.css"/>

	<style>	

	table {
		font-size: 60%;
		color: #333333;
		border-width: 1px;
		border-color: #ccc;
		border-collapse: collapse;
	}
	table th {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #ccc;
		background-color: #fff;
		font-weight: bold;
		color: #EB102E;
	}
	table tr:nth-child(even) td {
		background-color: #f9f9f9;
	}
	table td {
		font-size: 120%;
		border-width: 1px;
		padding: 8px;
		border-color: #ccc;
		border-style: solid;
		background-color: #fff;
	}
	.double-right {
		border-right:4px double #ccc;
	}
	.align-center {
		text-align: center;
	}
	.align-right {
		text-align: right;
	}
	.align-left {
		text-align: left;
	}
	.interval {
		color: #EB102E;
	}
	table tr td.space {
		border-right: 0px;
		border-left: 0px;
		border-bottom: 0px;
		background-color: #fff;
	}
	table tr td.sum {
		background-color: #fff;
		font-weight: bold;
	}
	#note {
		margin-top: 16px;
		font-size: 80%;
		line-height: 1.6;
	}
</style>	
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
				<input id="report" type="text" placeholder="<?= _SELECT_REPORT ?>"/>
				<label for="report"><?= _REPORT ?></label>
				<div class="border-list">
					<ul>
						<li data-value="0"><?= _TYPE_PRELIMINARY ?></li>
						<li data-value="1"><?= _TYPE_FINAL ?></li>
					<ul>				
				</div>	
			</div>	
			<input type="hidden" name="report_type" id="report_type">
			<input type="hidden" name="day" id="day">
		</div>	
		<div class="content-select">
			<div class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_TABLE ?>"></div>	
			<div class="content-select-item data-chart inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_CHART ?>"></div>	
			<div class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay" data-hint="<?= _HINT_DOWNLOAD ?>"></div>	
		</div>	
	</div>
	<div class="content">
		<div class="page"><h1><?= _RESULTS ?></h1>
		<table>
			<thead id="data-header">
			</thead>
			<tbody id="data-table">
			</tbody>
		</table>
		<div class="empty-text"></div>
		<div id="note"></div>
		</div>
		<div class="page">
			<h1><?= _RESULTS ?></h1>
			<div id="chart_1"></div>
			<div id="chart_2"></div>
			<div class="empty-text"></div>
		</div>
		<div class="page"><h1><?= _DOWNLOAD_DATA ?></h1>
		<div class="empty-text"></div>
		</div>
		<div class="page" id="help-page" style="display: block"><h1><?= _TITLE_1 ?></h1><span id="help-text"></span></div>
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
var dataStr;
var interval = [];
var isData = false;

$("#help-text").html("<?= _MSG_SELECT_DAY ?>");
$("#report").css({'width': '172px'}); 
$(".border-list").width(172);

$(".border-list ul li").mousedown(function(){
	$("#report").val($(this).text());
	$("#report_type").val($(this).attr("data-value"));
	CheckInput();
});

$("#report")
	.focusin(function() {
		$(".border-list").show(); 
	})
	.focusout(function() {
		$(".border-list").hide(); 
});

$(".content-select-item").click(function() {
	if ($(this).hasClass("data-download") && isData==true) {
		var params = {};
		params.date = $("#day").val();
		params.type = $("#report_type").val();
		params.lng = '<?= $lng ?>';
		params.hours = CheckDST($("#day").val());
		window.location.replace("http://transparency.ems.rs/balancing_objava/download.php?" + $.param(params));
	}
	else if (!$(this).hasClass("inactive")) {
		$(this).addClass("active").siblings().removeClass("active");
		$(".page").eq($(this).index()).show().siblings().hide();
	}	
});

$("#date").datepicker({
	language: '<?= $lng ?>',
	autoClose: true,
	onRenderCell: function (date, cellType) {
        var nH = CheckDST(date);
		var yesterday = new Date();
		yesterday.setDate(new Date().getDate()-1);
		var startdate = new Date('2016-01-01');
		if (cellType == 'day') {
			if (date < startdate || date > yesterday) {
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
	filename = params.from.replace(/\-/g, '') + "_" + (params.hasOwnProperty("to") ? params.to.replace(/\-/g, '') +  "_" : "") + "DailyAuctionResults" + params.border;
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
		enabled: false
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
    tooltip: {
		borderColor: '#CCCCCC',
		useHTML: true
    }	
});
	
function CheckInput() {
	$("#help-text").html("");
	if ($("#day").val() && $("#report_type").val()) {
		GetData($("#day").val(),$("#report_type").val());
	}
	else {
		if (!$("#day").val() && $("#report_type").val()) {
			$("#help-page h1").html('<?= _TITLE_2 ?>');
			$("#help-text").html('<?= _REPORT_SELECTED ?>' + $("#report").val() + '<br><br><?= _MSG_SELECT_DAY ?>');
		}
		else if($("#day").val() && !$("#report_type").val()) {
			$("#help-page h1").html('<?= _TITLE_3 ?>');
			$("#help-text").html('<?= _DAY_SELECTED ?>' + $("#date").val() + '<br><br><?= _MSG_SELECT_REPORT ?>');		
		}
		else {
			$("#help-text").html("Click on \"Day\" to select date.");
		}
	}
} 	

function GetData(d,f) {

	$(".content-select > .content-select-item").each(function () { 
															$(this).removeClass("active"); 
															$(this).addClass("inactive"); 
													});
	$(".page").eq(4).show();
	$.getJSON("../../balancing_objava/get_data.php", { final: f, day: d }, function(result) {
														$("#data-header").html('');
														$("#data-table").html('');
														$("#note").html('');
														$("#chart_1").hide();
														$("#chart_2").hide();
														isData = false;
														if(result == null) {
															$('.empty-text').each(function(i, obj) {
<?php if ($lng=="eng") { ?>																
																$(obj).html($("#report").val() + '<?= _NO_DATA_PREF ?>' + $("#date").val() + '<?= _NO_DATA_SUF ?>');															
<?php } else { ?>																
																$(obj).html('<?= _NO_DATA_PREF ?> ' + $("#report").val() + '<?= _NO_DATA_SUF ?>' + $("#date").val() + '.');															
<?php } ?>
															});
														}
														else {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('');															
															});
															var theaderHTML = '<tr><th colspan="2" rowspan="2" class="double-right"><?= _INTERVAL ?></th><th colspan="2" class="double-right"><?= _ENERGY_SECONDARY ?></th><th colspan="2" class="double-right"><?= _ENERGY_TERTIARY ?></th><th colspan="2" class="double-right"><?= _ENERGY_ACCIDENTAL ?></th><th colspan="2" rowspan="2"><?= _PRICE_SETTLEMENT ?></th></tr>';
															theaderHTML += '<tr><th><?= _SUM ?></th><th class="double-right"><?= _PRICE ?></th><th><?= _SUM ?></th><th class="double-right"><?= _PRICE_WEIGHTED ?></th><th><?= _SUM ?></th><th class="double-right"><?= _PRICE ?></th></tr>';
															theaderHTML += '<tr><th width=60><?= _INTERVAL_BEGIN ?></th><th width=60 class="double-right"><?= _INTERVAL_END ?></th><th width=80>MWh</th><th width=80 class="double-right">EUR/MWh</th><th width=80>MWh</th><th width=80 class="double-right">EUR/MWh</th><th width=80>MWh</th><th width=80 class="double-right">EUR/MWh</th><th>EUR/MWh</th></tr>';
															var n_data = CheckDST(d);
															console.log(n_data);
															var tbodyHTML = '';
															var interval_begin = '';
															var interval_end = '';
															var sum_energy_s_minus = 0;
															var sum_energy_s_plus = 0;
															var sum_energy_t_minus = 0;
															var sum_energy_t_plus = 0;
															var sum_energy_h_minus = 0;
															var sum_energy_h_plus = 0;
															var sum_energy = 0;
															var sum_energy_hour = [];
															var categories = [];
															var price_settlement = [];
															interval = [];
															for (var i in result) {
																sum_energy = 0;
																if (n_data == 23 && i > 1) {
																	interval_begin = ('0' + result[i].HOUR.toString()).slice(-2) + ':00';
																	interval_end = ('0' + (parseInt(result[i].HOUR)+1).toString()).slice(-2) + ':00';
																	console.log(interval_begin);
																	console.log(interval_end);
																}
																else if (n_data == 25 && i > 2) {
																	interval_begin = ('0' + (parseInt(result[i].HOUR)-2).toString()).slice(-2) + ':00';
																	interval_end = ('0' + (parseInt(result[i].HOUR)-1).toString()).slice(-2) + ':00';
																	console.log(interval_begin);
																console.log(interval_end);
																	
																}	
																else {
																	interval_begin = ('0' + (parseInt(result[i].HOUR)-1).toString()).slice(-2) + ':00';
																	interval_end = ('0' + result[i].HOUR.toString()).slice(-2) + ':00';
																	console.log(interval_begin);
																console.log(interval_end);
																}
																
																tbodyHTML += '<tr><td class="interval">' + interval_begin + '</td><td class="interval double-right">' + interval_end + '</td><td class="align-right">' + (result[i].ENERGY_S==0 ? '' : result[i].ENERGY_S.toFixed(2)) + '</td><td class="align-right double-right">' + (result[i].PRICE_S==0 ? '' : result[i].PRICE_S.toFixed(2)) + '</td><td class="align-right">' + (result[i].ENERGY_T==0 ? '' : result[i].ENERGY_T.toFixed(2)) + '</td><td class="align-right double-right">' + (result[i].PRICE_T==0 ? '' : result[i].PRICE_T) + '</td><td class="align-right">' + (result[i].ENERGY_H==0 ? '' : result[i].ENERGY_H) + '</td><td class="align-right double-right">' + (result[i].PRICE_H==0 ? '' : result[i].PRICE_H) + '</td><td class="align-right">' + (result[i].PRICE_SETTLEMENT==0 ? '0.00' : result[i].PRICE_SETTLEMENT) + '</td></tr>';
																if (result[i].ENERGY_S!='') {
																	if (result[i].ENERGY_S<0) { sum_energy_s_minus += result[i].ENERGY_S}
																	else { sum_energy_s_plus += result[i].ENERGY_S }
																	sum_energy += result[i].ENERGY_S; 
																}	
																if (result[i].ENERGY_T!='') {
																	if (result[i].ENERGY_T<0) { sum_energy_t_minus += result[i].ENERGY_T}
																	else { sum_energy_t_plus += result[i].ENERGY_T }
																	sum_energy += result[i].ENERGY_T; 
																}
																if (result[i].ENERGY_H!='') {
																	if (result[i].ENERGY_H<0) { sum_energy_h_minus += result[i].ENERGY_H}
																	else { sum_energy_h_plus += result[i].ENERGY_H }
																	sum_energy += result[i].ENERGY_H; 
																}
																interval.push(interval_begin + ' - ' + interval_end);
																sum_energy_hour.push(sum_energy);
																categories.push(result[i].HOUR);
																price_settlement.push(result[i].PRICE_SETTLEMENT);
															}
															tbodyHTML += '<tr><td colspan="9" class="space"></td></tr>';
															tbodyHTML += '<tr><td colspan="2" class="interval double-right sum align-left">&#931; <?= _UPWARD ?></td><td class="align-right sum">' + (sum_energy_s_plus==0 ? '' : sum_energy_s_plus.toFixed(2)) + '</td><td class="double-right sum"></td><td class="align-right sum">' + (sum_energy_t_plus==0 ? '' : sum_energy_t_plus.toFixed(2)) + '</td><td class="double-right sum"></td><td class="align-right sum">' + (sum_energy_h_plus==0 ? '' : sum_energy_h_plus.toFixed(2)) + '</td><td class="double-right sum"></td><td class="sum"></td></tr>';
															tbodyHTML += '<tr><td colspan="2" class="interval double-right sum align-left">&#931; <?= _DOWNWARD ?></td><td class="align-right sum">' + (sum_energy_s_minus==0 ? '' : sum_energy_s_minus.toFixed(2)) + '</td><td class="double-right sum"></td><td class="align-right sum">' + (sum_energy_t_minus==0 ? '' : sum_energy_t_minus.toFixed(2)) + '</td><td class="double-right sum"></td><td class="align-right sum">' + (sum_energy_h_minus==0 ? '' : sum_energy_h_minus.toFixed(2)) + '</td><td class="double-right sum"></td><td class="sum"></td></tr>';
															$("#data-header").html(theaderHTML);
 															$("#data-table").html(tbodyHTML);
 															$("#note").html('<?= _NOTE ?>');
															Highcharts.chart('chart_1', {
																title: {
																	text: '<?= _CHART_1_TITLE ?>'
																},
															    xAxis: {
																	categories: categories
																},
																yAxis: { 
																	title: {
																		text: '<?= _CHART_1_TITLE ?> [MWh]',
																	},
																	plotBands: [{
																		from: -10000000,
																		to: 0,
																		color: 'rgba(213, 213, 213, 0.2)'
																	}]
																},
																series: [{
																	name: '<?= _CHART_1_TITLE ?>',
																	data: sum_energy_hour,
																	color: '#EB102E',
																	type: 'line'
																}],
																tooltip: {
																	formatter: function () {
																		return '<span style="font-size: 11px; font-weight: bold"><?= _HOUR ?>: ' + this.x + ' (' + interval[this.point.x] + ')</span><br/><span style="color:' + this.point.color + '">\u25CF</span> ' + this.series.name + ': <b>' + this.point.y + ' MWh</b><br/>';
																	}	
																}
															});
															Highcharts.chart('chart_2', {
																title: {
																	text: '<?= _CHART_2_TITLE ?>'
																},
															    xAxis: {
																	categories: categories
																},
																yAxis: { 
																	title: {
																		text: '<?= _CHART_2_TITLE ?> [EUR/MWh]',
																	}
																},
																tooltip: {
																	formatter: function () {
																		return '<span style="font-size: 11px; font-weight: bold"><?= _HOUR ?>: ' + this.x + ' (' + interval[this.point.x] + ')</span><br/><span style="color:' + this.point.color + '">\u25CF</span> ' + this.series.name + ': <b>' + this.point.y + ' EUR/MWh</b><br/>';
																	}	
																},
																series: [{
																	name: '<?= _CHART_2_TITLE ?>',
																	data: price_settlement,
																	color: '#5C6873',
																	type: 'line'
																}]
															});
															$("#chart_1").show();
															$("#chart_2").show();
															isData = true;
														}	
														$(".content-select > .content-select-item").each(function () { 
															$(this).removeClass("inactive"); 
															if ($(this).index() == 0) { $(this).click(); }
														});
														getdata = true;
														$("#select-border label").css({'cursor':'pointer'});
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