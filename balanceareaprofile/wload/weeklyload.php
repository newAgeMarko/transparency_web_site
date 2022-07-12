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
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title><?= _TITLE ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= _TITLE ?>">
	
	<script type="text/javascript" src="../../js/jquery-1.x-git.min.js"></script> 
	<script type="text/javascript" src="../../js/highcharts.js"></script>
	<script type="text/javascript" src="../../common/datepicker/datepicker.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

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

	<script src="../../js/components.js" ></script>


</head>
<body> 
	<div style="width:700px">
		<div class="menu">
			<div class="selections-group">
				<div class="selections">
					<input id="date" class="datepicker-here" placeholder="<?= $_SELECT_DAY ?>" data-range="false" onkeydown="return false;" autocomplete="off"/>
					<label for="date"><?= $_DAY ?></label>
				</div>	
				<input type="hidden" name="day" id="day">
			</div>	
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
				<div id="chart"></div>
				<div class="empty-text"></div>
			</div>
			<div class="page"><h1><?= $_DOWNLOAD_DATA ?></h1>
				<div class="download_form">
					<h3><?= $_WEEKLY_FORECAST ?></h3>
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
	var tbodyHTML = '';
	var download = false;

	$("#decimal_separator").hide();
	$("#border").css({'width':'172px', 'cursor':'default'});
	$("#chart").css({'margin-top':'20px'});



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
		format: 'yyyy-mm-dd',
		autoClose: true,
		onRenderCell: function(date, cellType){ 
			var nH = CheckDST(date);
			var sevenDaysFromToday = new Date();
			sevenDaysFromToday.setDate(new Date().getDate()+7);
			var startdate = new Date('2013-05-31');
			if (cellType == 'day') {
				 if (date < startdate || date > sevenDaysFromToday) {
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
		console.log(11111111111111111111111111111);
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
		filename = "LOAD_WEEKLY" + "_" + params.from.replace(/\-/g, '') + (params.hasOwnProperty("to") ? "_" + params.to.replace(/\-/g, '') : "");
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
	$.getJSON("get_results.php", { day: d }, function(result) {   // console.log(result);
		if(result != null){
			if (result.length==8) {
				console.log('8 dana');
				result.shift();
			}
		}		
														var Maximum_total_load = [];																	
														var Minimum_total_load = [];
														$("#data-header").html('');
														$("#data-table").html('');
														$("#chart").hide();
														$('.border-select').html('');														
														if(result == null || result == undefined) {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('<?= $_NO_DATA_FOR_SELECTED_WEEK ?>' + $("#date").val());															
															});
														}
														else {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('');															
															});

															
															var theaderHTML = '<tr class="subtitle bold"><td class="hour"><?= $_DATE ?></td><td class="hour"><?= $_MIN_VALUE ?></td><td class="hour"><?= $_MAX_VALUE ?></td></tr>';															
															var line = '<tr><td colspan="3" style="height:1px; margin:0; padding:0; background-color:#9C9990;"></td></tr>';														
															tbodyHTML = line;									
															var n_data = CheckDST(d);															
															result.forEach(obj => {
																	var ValuesOfObject = Object.values(obj)
																	console.log(ValuesOfObject);
																	tbodyHTML += '<tr height="35"><td>' + ValuesOfObject[0] + '</td><td>' + Math.round(ValuesOfObject[1]) + '</td><td>' + Math.round(ValuesOfObject[2]) + '</td></tr>';																																																					
																	Maximum_total_load.push(ValuesOfObject[2]);
																	Minimum_total_load.push(ValuesOfObject[1]);
															});
															
															$("#data-header").html(theaderHTML);
//															$("#data-header tr:last").addClass("underline");
															tbodyHTML += line;
															$("#data-table").html(tbodyHTML);
//															$("#data-table tr:last").addClass("underline");

																Highcharts.chart('chart', {
																	chart: {
																		type: 'spline',
																		width: 700
																	},
																	title: {
																		text: '<?= $_WEEKLY_FORECAST_GRAPH ?>'
																	},
																	subtitle: {
																		// text: 'Source: WorldClimate.com'
																	},
																	credits: {
																		enabled: false
																	},
																	xAxis: {
																		categories: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']
																	},
																	yAxis: {
																		title: {
																			text: 'Total Load Forecast [MW]'
																		},
																		labels: {
																			formatter: function () {
																				return this.value + 'MW';
																			}
																		}
																	},
																	tooltip: {
																		crosshairs: true,
																		shared: true
																		// formatter(tooltip) {
																		// 	const header = `<span style="color: blue;">${this.xAxis[categories]}</span><br/>`;
        
        																// 	return header + (tooltip.bodyFormatter(this.points).join(''));
																		// }
																	},
																	plotOptions: {
																		spline: {
																			marker: {
																				radius: 4,
																				// lineColor: '#666666',
																				lineWidth: 1
																			}
																		}
																	},
																	colors: ['#F25F5C','#c3c3c3'],
																	series: [{
																		name: 'Max total load',
																		data: Maximum_total_load,
																		tooltip: {
																			valueSuffix: ' MW'
																		}
																	}, {
																		name: 'Min total load',
																		data: Minimum_total_load,
																		tooltip: {
																			valueSuffix: ' MW'
																		}
																	}]
																});
																																						
														
															$("#chart").show();
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