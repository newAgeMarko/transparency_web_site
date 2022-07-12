<?php
	ini_set('display_errors', '1');
	//$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "eng";
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : " ";
	//include 'lng.php';
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
	<link rel="stylesheet" type="text/css" href="../../common/css/components.css"/>
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> -->
	<link rel="stylesheet" href="../../fontawesome/css/all.min.css" />

</head>
<body> 
	<div style="width:1080px">
		<div class="menu">
			<div class="selections-group">
				<div class="selections">
					<input id="date" class="datepicker-here" placeholder="<?= $_SELECT_DAY ?>" data-range="false" onkeydown="return false;" autocomplete="off"/>
					<label for="date"><?= $_DAY ?></label>
				</div>	
				<div class="selections" id="select-border">
					<input id="border" type="text" placeholder="<?= $_SELECT_DIRECTION ?>" autocomplete="off"/>
					<label for="border"><?= $_DIRECTION ?></label>
					<div class="border-list"></div>	
				</div>	
				<input type="hidden" name="direction" id="direction">
				<input type="hidden" name="day" id="day">
			</div>	
			<!-- <div class="content-select">
				<div class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_TABLE ?>"></div>	
				<div class="content-select-item data-chart inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_CHART ?>"></div>	
				<div class="content-select-item data-download inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_DOWNLOAD ?>"></div>	
			</div>	 -->
			<ul class="content-select">
				<li class="content-select-item data-table inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_TABLE ?>">
					<i class="fa fa-table fa-fw"></i>
				</li>	
				<li class="content-select-item data-chart inactive hint--bottom hint--rounded hint--delay" data-hint="<?= $_HINT_CHART ?>">
					<i class="fa fa-chart-bar fa-fw"></i>
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
			<div class="page">
				<div id="chart_1"></div>
				<div id="chart_2"></div>
				<div id="chart_3"></div>
				<div id="chart_4"></div>
				<div id="chart_5"></div>
				<div id="chart_6"></div>
				<div class="empty-text"></div>
			</div>
			<div class="page"><h1><?= $_DOWNLOAD_DATA ?></h1>
				<div class="download_form">
					<div class="switch">
						<input id="all_borders" type="checkbox">
						<label for="all_borders"><?= $_ALL_BORDERS ?></label>
					</div>
					<div class="switch">
						<input id="time_period" type="checkbox">
						<label for="time_period"><?= $_TIME_PERIOD ?></label>
					</div>
					<div class="period">
						<input id="date_period" class="datepicker-here" placeholder="<?= $_SELECT_PERIOD ?>" data-range="true" data-multiple-dates-separator=" - " onkeydown="return false;"  autocomplete="off" />
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
			<div class="page" id="help-page" style="display: block"><h1><?= $_SELECT_DAY ?></h1><span id="help-text"><?= $_MSG_SELECT_DAY ?></span></div>
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
	var tbodyHTML_3 = '';
	var tbodyHTML_4 = '';
	var tbodyHTML_5 = '';
	var tbodyHTML_6 = '';
	var download = false;

	$("#decimal_separator").hide();
	$("#border").css({'width':'172px', 'cursor':'default'});
	$('#select-border label').css({'cursor':'default'});
	$('.border-list').width(172);
	var ul = $('<ul>').appendTo('.border-list');
		ul.append('<li data-value="0"><?= $_ALL_DIRECTION ?></li>');
	ul.append('<li data-value="1">HU - RS</li>');
	ul.append('<li data-value="2">RS - HU</li>');
	ul.append('<li data-value="3">RO - RS</li>');
	ul.append('<li data-value="4">RS - RO</li>');
	ul.append('<li data-value="5">MK - RS</li>');
	ul.append('<li data-value="6">RS - MK</li>');	
	$("#chart_1").css({'margin-top':'20px'});
	$("#chart_2").css({'margin-top':'20px'});
	$("#chart_3").css({'margin-top':'20px'});
	$("#chart_4").css({'margin-top':'20px'});
	$("#chart_5").css({'margin-top':'20px'});
	$("#chart_6").css({'margin-top':'20px'});

	$(".border-list ul li").mousedown(function(){ 
		$("#border").val($(this).text());         
			getBorder($(this).text());
		$("#direction").val($(this).attr("data-value"));
		switch ($("#direction").val()) {
			case '1':
				$("#data-table").html(tbodyHTML_1);
				$("#chart_1").show();
				$("#chart_2").hide();
				$("#chart_3").hide();
				$("#chart_4").hide();
				$("#chart_5").hide();
				$("#chart_6").hide();
				break;
			case '2':
				$("#data-table").html(tbodyHTML_2);
				$("#chart_1").hide();
				$("#chart_2").show();
				$("#chart_3").hide();
				$("#chart_4").hide();
				$("#chart_5").hide();
				$("#chart_6").hide();
				break;
			case '3':
				$("#data-table").html(tbodyHTML_3);
				$("#chart_1").hide();
				$("#chart_2").hide();
				$("#chart_3").show();
				$("#chart_4").hide();
				$("#chart_5").hide();
				$("#chart_6").hide();
				break;
			case '4':
				$("#data-table").html(tbodyHTML_4);
				$("#chart_1").hide();
				$("#chart_2").hide();
				$("#chart_3").hide();
				$("#chart_4").show();
				$("#chart_5").hide();
				$("#chart_6").hide();
				break;
			case '5':
				$("#data-table").html(tbodyHTML_5);
				$("#chart_1").hide();
				$("#chart_2").hide();
				$("#chart_3").hide();
				$("#chart_4").hide();
				$("#chart_5").show();
				$("#chart_6").hide();
				break;
			case '6':
				$("#data-table").html(tbodyHTML_6);
				$("#chart_1").hide();
				$("#chart_2").hide();
				$("#chart_3").hide();
				$("#chart_4").hide();
				$("#chart_5").hide();
				$("#chart_6").show();
				break;
			default:
				$("#data-table").html(tbodyHTML_1 + tbodyHTML_2 + tbodyHTML_3 + tbodyHTML_4 + tbodyHTML_5 + tbodyHTML_6);
				$("#chart_1").show();
				$("#chart_2").show();
				$("#chart_3").show();
				$("#chart_4").show();
				$("#chart_5").show();
				$("#chart_6").show();
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
					$("#border").val('<?= $_ALL_DIRECTION ?>');
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
	language: '<?= $_DATEPICKER_LANG ?>',
		autoClose: true,
		onRenderCell: function(date, cellType){ 
			var nH = CheckDST(date);
			var tomorrow = new Date();
			tomorrow.setDate(new Date().getDate()+1);
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
			tomorrow.setDate(new Date().getDate()+1);
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
		onSelect: function(dp, dArray){  
						$("#date_period").css("border", "2px solid ");
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

	var smer ="";
	$("#btn_download").click(function() {
		if (($(".period_error").css("color")=="rgb(207, 0, 15)" && $("#time_period").prop("checked"))) {
			$("#date_period").focus();
			return;
		}			
		var params = {};
		params.download = true;
		params.format = $("input[type=radio][name='radioFormat']:checked").val();
		params.decimal = $("input[type=radio][name='radioSeparator']:checked").val();
		// params.border = $("#all_borders").prop("checked") ? '' : borderDwn; 
		//borderDwn = "";

		if ($("#all_borders").prop("checked") && borderDwn == "") {
			params.border = '';
		} else if ($("#all_borders").prop("checked") && borderDwn !== "") {
			params.border = ''; 
			smer = '';
		}
		if (!$("#all_borders").prop("checked") && borderDwn !== "") {
			params.border = borderDwn;
			smer = direction;
		}

		console.log($('#date').datepicker().data('datepicker').selectedDates[0]);

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
		filename = "ALLOCATION_RESULTS" + "_" + smer + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
		params.filename = filename + "." + params.format.toLowerCase();
		
		window.location.replace("download.php?" + $.param(params));		
		
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
	colors: ['#F25F5C','#c3c3c3'],
    xAxis: [{
        title: {
            text: '<?= $_HOUR ?>',
		},
		crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
			format: '{value} MW',
			style: {
                color: '#F25F5C'
            }
        },
        title: {
			text: '<?= $_ALLOCATED ?>',
			style: {
                color: '#F25F5C'
            }
        },
		min: 0
    }, { // Secondary yAxis
        title: {
			text: '<?= $_PRICE ?>',
			style: {
                color: '#c3c3c3'
            }
        },
        labels: {
			format: '{value} EUR/Mwh',
			style: {
                color: '#c3c3c3'
            }
        },
		min: 0,
        opposite: true
    }],
    tooltip: {
        shared: true,
		borderColor: '#CCCCCC',
		useHTML: true,
		headerFormat: '<span style="font-size: 11px; font-weight: bold"><?= $_HOUR ?>: {point.key}</span><br/>'
    }	
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

function getBorder (dir) { // uzima smer iz padajuce liste i dodeljuje ga promenljivoj koja se koristi u download.php i za getData 
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
	$.getJSON("get_results.php", { day: d }, function(result) {  console.log('Rezultat: '+ result[0][0]);
														$("#data-header").html('');
														$("#data-table").html('');
														$("#chart_1").hide();
														$("#chart_2").hide();
														$("#chart_3").hide();
														$("#chart_4").hide();
														$("#chart_5").hide();
														$("#chart_6").hide();
														$('.border-select').html('');														
														if(result == null) {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('<?= $_NO_DATA ?>' + $("#date").val());															
															});
														}
														else {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('');															
															});
															var theaderHTML = '<tr class="subtitle bold"><td class="hour"><?= $_DIRECTION ?></td><td class="hour"><?= $_HOUR ?></td><td class="hour">ATC [MW]</td><td class="hour"><?= $_REQUESTED ?> [MW]</td><td class="hour"><?= $_ALLOCATED ?> [MW]</td><td class="hour"><?= $_PRICE ?> [EUR/MWh]</td></tr>';
															var line = '<tr><td colspan="6" style="height:1px; margin:0; padding:0; background-color:#9C9990;"></td></tr>';
															tbodyHTML_1 = line;
															tbodyHTML_2 = line;
															tbodyHTML_3 = line;
															tbodyHTML_4 = line;
															tbodyHTML_5 = line;
															tbodyHTML_6 = line;
															var n_data = CheckDST(d);
															for (var i in result) {
																if (result[i].direction=='HURS') {
																	tbodyHTML_1 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';
																}
																else if (result[i].direction=='RSHU') {
																	tbodyHTML_2 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';																	
																}
																else if (result[i].direction=='RORS') {
																	tbodyHTML_3 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';
																} 
																else if (result[i].direction=='RSRO') {
																	tbodyHTML_4 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';
																}
																else if (result[i].direction=='MKRS') {
																	tbodyHTML_5 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';
																}
																else if (result[i].direction=='RSMK') {
																	tbodyHTML_6 += '<tr><td class="hour">' + result[i].direction + '</td><td>' + result[i].hour + '</td><td>' + result[i].ATC + '</td><td>' + result[i].total_requested + '</td><td>' + result[i].total_allocated + '</td><td>' + result[i].auction_price + '</td></tr>';
																}
															}
															$("#data-header").html(theaderHTML);
//															$("#data-header tr:last").addClass("underline");
															tbodyHTML_1 += line;
															tbodyHTML_2 += line;
															tbodyHTML_3 += line;
															tbodyHTML_4 += line;
															tbodyHTML_5 += line;
															tbodyHTML_6 += line;
															$("#data-table").html(tbodyHTML_1 + tbodyHTML_2 + tbodyHTML_3 + tbodyHTML_4 + tbodyHTML_5 + tbodyHTML_6);
//															$("#data-table tr:last").addClass("underline");
																	
															var categories_1 = [];
															var categories_2 = [];
															var categories_3 = [];
															var categories_4 = [];
															var categories_5 = [];
															var categories_6 = [];
															var total_allocated_1 = [];
															var total_allocated_2 = [];
															var total_allocated_3 = [];
															var total_allocated_4 = [];
															var total_allocated_5 = [];
															var total_allocated_6 = [];
															var auction_price_1 = [];
															var auction_price_2 = [];
															var auction_price_3 = [];
															var auction_price_4 = [];
															var auction_price_5 = [];
															var auction_price_6 = [];
															var chartdata_1 = $(result).filter(function (i,n){return n.direction==='HURS'});															
															var chartdata_2 = $(result).filter(function (i,n){return n.direction==='RSHU'});
															var chartdata_3 = $(result).filter(function (i,n){return n.direction==='RORS'});															
															var chartdata_4 = $(result).filter(function (i,n){return n.direction==='RSRO'});
															var chartdata_5 = $(result).filter(function (i,n){return n.direction==='MKRS'});															
															var chartdata_6 = $(result).filter(function (i,n){return n.direction==='RSMK'});
													
															$.each(chartdata_1, function () {
																categories_1.push(this.hour+'h');
																total_allocated_1.push(this.total_allocated);
																auction_price_1.push(this.auction_price);
															});               
															Highcharts.chart('chart_1', {
																chart: {
																	width: 1080
																},
																title: {
																	text: '<?= $_DIRECTION ?>: <?= $HU_RS ?>'
																},
															    xAxis: {
																	categories: categories_1
																},
																series: [{
																	name: '<?= $_ALLOCATED ?>',
																	data: total_allocated_1,
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= $_PRICE ?>',
																	data: auction_price_1,
																	type: 'spline',
																	yAxis: 1,
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
																	}
																}]
															});
															$.each(chartdata_2, function () {
																categories_2.push(this.hour+'h');
																total_allocated_2.push(this.total_allocated);
																auction_price_2.push(this.auction_price);
															});
															Highcharts.chart('chart_2', {
																chart: {
																	width: 1080
																},
																title: {
																	text: '<?= $_DIRECTION ?>: <?= $RS_HU ?>'
																},
															    xAxis: {
																	categories: categories_2
																},
																series: [{
																	name: '<?= $_ALLOCATED ?>',
																	data: total_allocated_2,
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= $_PRICE ?>',
																	data: auction_price_2,
																	yAxis: 1,
																	type: 'spline',
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
																	}
																}]
															});
															$.each(chartdata_3, function () {
																categories_3.push(this.hour+'h');
																total_allocated_3.push(this.total_allocated);
																auction_price_3.push(this.auction_price);
															});               
															Highcharts.chart('chart_3', {
																chart: {
																	width: 1080
																},
																title: {
																	text: '<?= $_DIRECTION ?>: <?= $RO_RS ?>'
																},
															    xAxis: {
																	categories: categories_3
																},
																series: [{
																	name: '<?= $_ALLOCATED ?>',
																	data: total_allocated_3,
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= $_PRICE ?>',
																	data: auction_price_3,
																	yAxis: 1,
																	type: 'spline',
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
																	}
																}]
															});
															$.each(chartdata_4, function () {
																categories_4.push(this.hour+'h');
																total_allocated_4.push(this.total_allocated);
																auction_price_4.push(this.auction_price);
															});               
															Highcharts.chart('chart_4', {
																chart: {
																	width: 1080
																},
																title: {
																	text: '<?= $_DIRECTION ?>: <?= $RS_RO ?>'
																},
															    xAxis: {
																	categories: categories_4
																},
																series: [{
																	name: '<?= $_ALLOCATED ?>',
																	data: total_allocated_4,
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= $_PRICE ?>',
																	data: auction_price_4,
																	yAxis: 1,
																	type: 'spline',
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
																	}
																}]
															});
															$.each(chartdata_5, function () {
																categories_5.push(this.hour+'h');
																total_allocated_5.push(this.total_allocated);
																auction_price_5.push(this.auction_price);
															});
															Highcharts.chart('chart_5', {
																chart: {
																	width: 1080
																},
																title: {
																	text: '<?= $_DIRECTION ?>: <?= $MK_RS ?>'
																},
															    xAxis: {
																	categories: categories_5
																},
																series: [{
																	name: '<?= $_ALLOCATED ?>',
																	data: total_allocated_5,
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= $_PRICE ?>',
																	data: auction_price_5,
																	yAxis: 1,
																	type: 'spline',
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
																	}
																}]
															});
															$.each(chartdata_6, function () {
																categories_6.push(this.hour+'h');
																total_allocated_6.push(this.total_allocated);
																auction_price_6.push(this.auction_price);
															});
															Highcharts.chart('chart_6', {
																chart: {
																	width: 1080
																},
																title: {
																	text: '<?= $_DIRECTION ?>: <?= $RS_MK ?>'
																},
															    xAxis: {
																	categories: categories_6
																},
																series: [{
																	name: '<?= $_ALLOCATED ?>',
																	data: total_allocated_6,
																	type: 'column',
																	pointWidth: 20,
																	tooltip: {
																		valueSuffix: ' MW'
																	}
																},{
																	name: '<?= $_PRICE ?>',
																	data: auction_price_6,
																	yAxis: 1,
																	type: 'spline',
																	tooltip: {
																		valueSuffix: ' EUR/MWh'
																	}
																}]
															});
															$("#chart_1").show();
															$("#chart_2").show();
															$("#chart_3").show();
															$("#chart_4").show();
															$("#chart_5").show();
															$("#chart_6").show();
														}	
														$(".content-select > .content-select-item").each(function () { 
															$(this).removeClass("inactive"); 
															if ($(this).index() == 0) { $(this).click();}
														});
														getdata = true; 
														$("#select-border label").css({'cursor':'pointer'});
														$("#border").css({'cursor':'pointer'});
														$("#border").val('<?= $_ALL_DIRECTION ?>');
														$("#direction").val(0); 																										
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