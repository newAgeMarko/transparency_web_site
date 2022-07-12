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
	
		<!-- Ovo na localhoost ispod treba da se zakomentarise kako bi radio datepicker -->
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->

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
					<input id="datepicker-month" data-min-view="months" data-view="months" data-date-format="MM yyyy" class="datepicker-here" placeholder="<?= $_SELECT_MONTH ?>" data-range="false" onkeydown="return false;" autocomplete="off"/>
					<label for="datepicker-month"><?= $_MONTH ?></label>
				</div>	
				<input type="hidden" name="month" id="month">
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
					<h3><?= $_MONTHLY_FORECAST ?></h3>
			<!-- 		<div class="switch">
						<input id="time_period" type="checkbox">
						<label for="time_period"><?= $_TIME_PERIOD ?></label>
					</div> -->
					<div class="period">
						<input id="date_period" class="datepicker-here" placeholder="<?= $_SELECT_PERIOD ?>" data-range="true" data-multiple-dates-separator=" - " onkeydown="return false;"  autocomplete="off" />
						<div class="period_error"><?= $_MSG_TIME_PERIOD ?></div>
					</div>
					<div class="format"><?= $_DATA_FORMAT ?>
						<div class="format_wrapper">
							<!-- <input type="radio" class="radio-tab" name="radioFormat" value="CSV" id="format1" /> -->
							<!-- <label for="format1">CSV</label> -->
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
			<div class="page" id="help-page" style="display: block"><h1><?= $_SELECT_MONTH ?></h1><span id="help-text"><?= $_MSG_SELECT_MONTH ?></span></div>
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
	
	var date=new Date();
	var year=date.getFullYear();
	var month=date.getMonth();
	
	$("#datepicker-month").datepicker({		
		language: '<?= $_DATEPICKER_LANG ?>',
		format: "MM yyyy",
		autoClose: true,
		onRenderCell: function(date) {
			var startdate = new Date('2012');
			if (date < startdate) {
				return {
					disabled: true
				}
			}
			//var enddate = new Date(year, month, '31');
			var enddate = new Date(year, month);
			if (date > enddate) {
				return {
					disabled: true
				}
			}
		},
		onSelect: function(mesec_godina){  				
			$('#month').val(mesec_godina);
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
	//	var month = $('#datepicker-month').datepicker({dateFormat: 'MM yy'}).data('datepicker');
		// var month = $('#month').val().split(" ")[0];	
		var month = $('#month').val()
		var month_to = "";
		var year = $('#month').val().split(" ")[1];
		var year_to = "";
		
		if ($('#time_period').prop("checked")) { 
			var selected_period = $('#date_period').datepicker({dateFormat: 'MM yyyy'}); 	

			if (selected_period.length === 1) { 
				month = selected_period[0].value.split("-")[0].split(" ")[0];
				year = selected_period[0].value.split("-")[0].split(" ")[1];
				month_to = selected_period[0].value.split("-")[1].split(" ")[1];
				year_to = selected_period[0].value.split("-")[1].split(" ")[2];				
				params.month_to = month_to;				
				params.year_to = year_to;
			}
		} 	
		params.month = month; 
		params.year = year;
		
		filename = "LOAD_MONTHLY";
		params.filename = filename + "_" + "_" + params.month + "_" + params.year + "_" + (params.hasOwnProperty("month_to") ? params.month_to : "") + "_" + (params.hasOwnProperty("year_to") ? params.year_to : "") + "." + params.format.toLowerCase();
			
		window.location.replace("download_2.php?" + $.param(params));		
	});


function CheckInput() {
	$("#help-text").html("");
	if ($("#month").val()) {
		var weekNumber = getWeekNumber($("#month").val()); // redni broj sedmice sa prvim ponedeljkom u mesecu
		GetData($("#month").val(), weekNumber);
	}
	else {
		$("#help-text").html('<?= $_MSG_SELECT_MONTH ?>');
	}
}

function getWeekNumber(monthYear){ //funkcija koja vraca redni broj prve sedmice u datom mesecu(ovde je to sedmica koja sadrzi prvi ponedeljak u mesecu)	
	var month = monthYear.split(" ")[0];
	var year = monthYear.split(" ")[1];
	var monthYear;
	switch(month) { // ovde se string za mesece prebaca u engleski jezik jer za srpsku cirilicu ne rade funkcije
	  case 'Јануар':
	    monthYear = 'January '+year;
	    break;
	  case 'Фебруар':
	    monthYear = 'February '+year;
	    break;
	  case 'Март':
	    monthYear = 'March '+year;
	    break;
	  case 'Април':
	    monthYear = 'April '+year;
	    break;
	  case 'Мај':
	    monthYear = 'May '+year;
	    break;
	  case 'Јун':
	    monthYear = 'Juny '+year;
	    break;
	  case 'Јул':
	    monthYear = 'July '+year;
	    break;
	  case 'Август':
	    monthYear = 'August '+year;
	    break;
	  case 'Септембар':
	    monthYear = 'September '+year;
	    break;
	  case 'Октобар':
	    monthYear = 'October '+year;
	    break;
	  case 'Новембар':
	    monthYear = 'November '+year;
	    break;
	  case 'Децембар':
	    monthYear = 'December '+year;
	    break;
	  default:
	    // monthYear = monthYear;
	    // break;
	}
		    monthYear = monthYear;

	var d = new Date(monthYear);
    d.setDate(1);
    // Get the first Monday in the month
    while (d.getDay() !== 1) {
        d.setDate(d.getDate() + 1);
    }
    
    Date.prototype.getWeek = function() {
	  	var onejan = new Date(this.getFullYear(),0,1);
	  return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
	}

	var weekNumber = d.getWeek();
	//console.log('week number '+weekNumber); // Returns the week number as an integer	

    return weekNumber;
}


function GetData(m, weekNumber) {  
	$(".content-select > .content-select-item").each(function () { 
		$(this).removeClass("active"); 
		$(this).addClass("inactive"); 
	});
	$(".page").eq(4).show();  

	console.log(m);
	console.log('Week Number: '+weekNumber);
	$.getJSON("get_results.php", { month: m }, function(result) {   
	console.log(result);
		var obj =  result['TimeSeries'];
		 console.log(obj);

														var Maximum_total_load = [];																	
														var Minimum_total_load = [];
														
														$("#data-header").html('');
														$("#data-table").html('');
														$("#chart").hide();
														$('.border-select').html('');														
														if(result == null || result == undefined) {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('<?= $_NO_DATA_FOR_SELECTED_MONTH ?>' + $("#month").val());															
															});
														}
														else {
															$('.empty-text').each(function(i, obj) {
																$(obj).html('');															
															});

															obj[0]['Period']['Point'].forEach(element => {
															Minimum_total_load.push(element['quantity']);
															});
															 console.log(Minimum_total_load);
															obj[1]['Period']['Point'].forEach(element => {
																Maximum_total_load.push(element['quantity']);
															});
															 console.log(Maximum_total_load);
															var theaderHTML = '<tr class="subtitle bold"><td class="hour"><?= $_WEEK ?></td><td class="hour"><?= $_MIN_VALUE ?></td><td class="hour"><?= $_MAX_VALUE ?></td></tr>';															
															var line = '<tr><td colspan="3" style="height:1px; margin:0; padding:0; background-color:#9C9990;"></td></tr>';		
															tbodyHTML = line;									
															var n_data = CheckDST(m);
															
															Minimum_total_load.forEach(function(item, index, arr){
																tbodyHTML += '<tr height="35"><td>' + '<?= $_WEEK ?> ' +(weekNumber++) + '</td><td>' + Minimum_total_load[index] + '</td><td>' + Maximum_total_load[index] + '</td></tr>';
															});
															
															Minimum_total_load = Minimum_total_load.map( Number );
															Maximum_total_load = Maximum_total_load.map(Number);
															

															$("#data-header").html(theaderHTML);
//															$("#data-header tr:last").addClass("underline");
															tbodyHTML += line;
															$("#data-table").html(tbodyHTML);
															$("#data-table tr:last").addClass("underline");

																Highcharts.chart('chart', {
																	chart: {
																		type: 'spline',
																		width: 700
																	},
																	title: {
																		text: '<?= $_MONTHLY_FORECAST_GRAPH ?>'
																	},
																	subtitle: {
																		// text: 'Source: WorldClimate.com'
																	},
																	credits: {
																		enabled: false
																	},
																	xAxis: {
																		categories: ['Week 1','Week 2','Week 3','Week 4','Week 5']
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
																// console.log(Minimum_total_load);																						
														
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