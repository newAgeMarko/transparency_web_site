<?php
require_once('konekcija/baza.php'); 
include("graphclass/pData.class");  
include("graphclass/pChart.class");

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";//umesto NULL mora 0 da bi radilo LIMIT u queryju... ili kao sto sam stavio u queryju LIMIT %u umesto LIMIT %s - %u the argument is treated as an integer, and presented as an unsigned decimal number
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$varDatum_recSetFilter = DATE('Y-m-d');//inicijalna vrednost, pri prvom ucitavanju stranice; danasnji datum yyyy-mm-dd
if (isset($_GET["txtDatum"])) {
  $varDatum_recSetFilter = $_GET["txtDatum"];
//date validation
list($yyyy_ch,$mm_ch,$dd_ch)=explode("-",$varDatum_recSetFilter);
if (is_numeric($yyyy_ch) && is_numeric($mm_ch) && is_numeric($dd_ch)){ 
	if (!checkdate($mm_ch,$dd_ch,$yyyy_ch)){
		echo "Wrong date input!<br/>Enter correct date in yyyy-mm-dd format:";
		$varDatum_recSetFilter = DATE('Y-m-d');
	}
}else{
	echo "Wrong date format!<br/>Enter date in yyyy-mm-dd format:";
	$varDatum_recSetFilter = DATE('Y-m-d');
}
//date validation
}

mysql_select_db($database_baza, $baza);
$query_recSetFilter = sprintf("SELECT DATETIME, DATUM, OUTAREA, INAREA, SENDER, VER,".
					" CAST((E0015+E0030+E0045+E0100)/4 AS SIGNED) as H01, CAST((E0115+E0130+E0145+E0200)/4 AS SIGNED) as H02,".
					" CAST((E0215+E0230+E0245+E0300)/4 AS SIGNED) as H03, CAST((E0315+E0330+E0345+E0400)/4 AS SIGNED) as H04,".					
					" CAST((E0415+E0430+E0445+E0500)/4 AS SIGNED) as H05, CAST((E0515+E0530+E0545+E0600)/4 AS SIGNED) as H06,".
					" CAST((E0615+E0630+E0645+E0700)/4 AS SIGNED) as H07, CAST((E0715+E0730+E0745+E0800)/4 AS SIGNED) as H08,".
					" CAST((E0815+E0830+E0845+E0900)/4 AS SIGNED) as H09, CAST((E0915+E0930+E0945+E1000)/4 AS SIGNED) as H10,".
					" CAST((E1015+E1030+E1045+E1100)/4 AS SIGNED) as H11, CAST((E1115+E1130+E1145+E1200)/4 AS SIGNED) as H12,".
					" CAST((E1215+E1230+E1245+E1300)/4 AS SIGNED) as H13, CAST((E1315+E1330+E1345+E1400)/4 AS SIGNED) as H14,".
					" CAST((E1415+E1430+E1445+E1500)/4 AS SIGNED) as H15, CAST((E1515+E1530+E1545+E1600)/4 AS SIGNED) as H16,".
					" CAST((E1615+E1630+E1645+E1700)/4 AS SIGNED) as H17, CAST((E1715+E1730+E1745+E1800)/4 AS SIGNED) as H18,".
					" CAST((E1815+E1830+E1845+E1900)/4 AS SIGNED) as H19, CAST((E1915+E1930+E1945+E2000)/4 AS SIGNED) as H20,".
					" CAST((E2015+E2030+E2045+E2100)/4 AS SIGNED) as H21, CAST((E2115+E2130+E2145+E2200)/4 AS SIGNED) as H22,".
					" CAST((E2215+E2230+E2245+E2300)/4 AS SIGNED) as H23, CAST((E2315+E2330+E2345+E2400)/4 AS SIGNED) as H24".
					" FROM CAX WHERE DATE(DATETIME) = %s - INTERVAL 1 DAY ".
								" AND HOUR(DATETIME) = '18'".
								" AND MINUTE(DATETIME) >= '00'".
								" AND MINUTE(DATETIME) < '04'".
								" AND DATUM = %s".
					" ORDER BY  field(OUTAREA,'10YHU-MAVIR----U','10YRO-TEL------P','10YCA-BULGARIA-R','10YMK-MEPSO----8','10YAL-KESH-----5','10YCS-CG-TSO---S','10YBA-JPCC-----D','10YHR-HEP------M','10YCS-SERBIATSOV'), field(INAREA,'10YHU-MAVIR----U','10YRO-TEL------P','10YCA-BULGARIA-R','10YMK-MEPSO----8','10YAL-KESH-----5','10YCS-CG-TSO---S','10YBA-JPCC-----D','10YHR-HEP------M','10YCS-SERBIATSOV')", GetSQLValueString($varDatum_recSetFilter, "date"), GetSQLValueString($varDatum_recSetFilter, "date"));					
$recSetFilter = mysql_query($query_recSetFilter, $baza) or die(mysql_error());
$row_recSetFilter = mysql_fetch_assoc($recSetFilter);
$totalRows_recSetFilter = mysql_num_rows($recSetFilter);

$DataSet = new pData;//grafik
?>