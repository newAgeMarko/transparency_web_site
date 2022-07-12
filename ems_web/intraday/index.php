<?php
	ini_set('display_errors', '1');
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "lat";
	include 'lng.php';
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : "all";
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
			<div class="selections">
				<input id="border" type="text" placeholder="<?= _SELECT_BORDER ?>"/>
				<label for="border"><?= _BORDER ?></label>
				<div class="border-list"></div>	
			</div>	
			<input type="hidden" name="bcode" id="bcode">
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
			<thead>
				<tr>
					<th></th>
					<th colspan="2" class="group"><?= _IDATC ?></th>
					<th colspan="2" class="group"><?= _SUM ?></th>
				</tr>
				<tr class="subtitle">
					<td class="hour bold"><?= _OUT_AREA ?></td>
					<td class="rs_code"></td>
					<td class="border_code"></td>
					<td class="rs_code"></td>
					<td class="border_code"></td>
				</tr>
				<tr class="subtitle">
					<td class="hour bold"><?= _IN_AREA ?></td>
					<td class="border_code"></td>
					<td class="rs_code"></td>
					<td class="border_code"></td>
					<td class="rs_code"></td>
				</tr>
				<tr class="subtitle bold underline">
					<td class="hour"><?= _HOUR ?></td>
					<td>MW</td>
					<td>MW</td>
					<td>MW</td>
					<td>MW</td>
				</tr>
			</thead>
			<tbody id="data-table">
			</tbody>
		</table>
		</div>
		<div class="page">
			<h1><?= _IDATC ?></h1>
			<div id="chart_1"></div>
			<h1><?= _SUM ?></h1>
			<div id="chart_0"></div>
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
			<a class="btn-class" id="btn_download"><?= _DOWNLOAD_BUTTON ?></a>
		</div>
		</div>
		<div class="page" id="help-page" style="display: block"><h1><?= _TITLE_1 ?></h1><span id="help-text"><?= _MSG_SELECT_DAY ?></span></div>
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

var ul = $('<ul>').appendTo('.border-list');
$.getJSON("eic.php", { border: "<?= $border ?>" }, function(result) {
	for (var i in result) {
		if (result[i].IDENTIFICATION == "RS") { rs_code = result[i].CODE }
		else {
			country = "COUNTRY_<?= strtoupper($lng) ?>";	
            if (result.length==2) {
				$("#border").val(result[i][country]);
				$("#bcode").val(result[i].CODE);
				single = true;
			}
			else {
				ul.append('<li data-value="' + result[i].CODE + '">' + result[i][country] + '</li>');
			}	
		}
	}
	$(".border-list ul li").mousedown(function(){
	$("#border").val($(this).text());
	$("#bcode").val($(this).attr("data-value"));
	CheckInput();
	});
});

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
					$("#date_period").css("border", "2px solid rgba(235, 16, 46, 1)");
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

$("#border")
	.focusin(function() {
		if (!single) { $(".border-list").show(); }
		else { $(this).blur(); } 
	})
	.focusout(function() {
		if (!single) { $(".border-list").hide(); }
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
	params.format = $("input[type=radio]:checked").val();
	if (!($("#all_borders").prop("checked"))) { params.border = $("#bcode").val(); }
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
	filename = params.from.replace(/\-/g, '') + "_" + (params.hasOwnProperty("to") ? params.to.replace(/\-/g, '') +  "_" : "") + (params.hasOwnProperty("border") ? params.border : rs_code);
    params.filename = filename + "." + params.format.toLowerCase();

	window.location.replace("../../intraday_objava/download.php?" + $.param(params));
	 
});

Highcharts.setOptions({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
    },
	title: {
		text: '',
		style: {
			display: 'none'
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
	tooltip: {
            shared: true,
            crosshairs: true,
            useHTML: true,
			valueSuffix: ' MW',
			borderColor: '#ccc',
			hideDelay: 0	
    },
	yAxis: {
        title: { text: 'MW' }
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
	if ($("#day").val() && $("#bcode").val()) {
		GetData($("#day").val(),$("#bcode").val());
	}
	else {
		if (!$("#day").val() && $("#bcode").val()) {
			$("#help-text").html('<?= _BORDER_SELECTED ?>' + $("#border").val() + ' (' + $("#bcode").val() + ')<br><br><?= _MSG_SELECT_DAY ?>');
		}
		else if($("#day").val() && !$("#bcode").val()) {
			$("#help-text").html('<?= _DAY_SELECTED ?>' + $("#date").val() + '<br><br><?= _MSG_SELECT_BORDER ?>');		
		}
		else {
			$("#help-text").html("Click on \"Day\" to select date.");
		}
	}
} 	

function GetData(d,b) {

    var start = performance.now();
	var nH = CheckDST(d);
	$(".rs_code").text(rs_code);												
	$(".border_code").text(b);	
	
	$(".content-select > .content-select-item").each(function () { 
															$(this).removeClass("active"); 
															$(this).addClass("inactive"); 
													});
	$(".page").eq(4).show();
	$.getJSON("../../intraday_objava/intraday_load.php", { border: b, day: d }, function(result) {
		var stop = performance.now();
console.log("Rezultati učitani za: " + Math.round(stop - start) + " milisekundi.");		
															var idx = [];
															for (var i in result) {
																if (result[i].OUT_AREA == rs_code && result[i].TIP == 1) { idx[0] = i } 
																else if (result[i].OUT_AREA == rs_code && result[i].TIP == 0) { idx[2] = i }
																else if (result[i].IN_AREA == rs_code && result[i].TIP == 1) { idx[1] = i }
																else { idx[3] = i }
															}
															var tbodyHTML = '';
															var h = '';
															var h_1 = '';
															var categories = [];
															var chartdata = []; 
															var n_data = CheckDST(d);
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
																tbodyHTML += '<tr><td class="hour">' + categories[n] + '</td>';
																for (var p = 0; p < 4; p++) {	
																	tbodyHTML += '<td>' + ((typeof idx[p] =='undefined') ? '---' : result[idx[p]]['H'+h_1]) + '</td>';
																	if (!chartdata[p]) { chartdata[p] = []; }
																		chartdata[p].push([n, ((typeof idx[p] =='undefined') ? null : result[idx[p]]['H'+h_1])]);
																	}	
																tbodyHTML += '</tr>';
															}
															$("#data-table").html(tbodyHTML);
															$("#data-table tr:last").addClass("underline");
															
															Highcharts.chart('chart_1', {
															    xAxis: {
																	categories: categories
																},
																series: [{
																	name: rs_code + ' &#9654;' + b,
																	data: chartdata[0],
																	color: '#EB102E'
																},{
																	name: b + ' &#9654;' + rs_code,
																	data: chartdata[1],
																	color: '#5C6873'
																}]
															});

															Highcharts.chart('chart_0', {
															    xAxis: {
																	categories: categories
																},
																series: [{
																	name: rs_code + ' &#9654;' + b,
																	data: chartdata[2],
																	color: '#EB102E'
																},{
																	name: b + ' &#9654;' + rs_code,
																	data: chartdata[3],
																	color: '#5C6873'
																}]
															});		
															
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