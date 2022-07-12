<?php
require_once('konekcija/baza.php'); 
//include("graphclass/pData.class");  
//include("graphclass/pChart.class");

if (!function_exists("GetSQLValueString")) {//ako f-ja nije definisana ovde je definisemo
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
  if (PHP_VERSION < 6){
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

$varSedmica_recSetFilter = DATE('W').'-'.DATE('Y');//inicijalna vrednost, pri prvom ucitavanju stranice; trenutna sedmica-trenutna godina
if (isset($_GET["txtSedmica"])) {
  $varSedmica_recSetFilter = $_GET["txtSedmica"];
//sedmica validation
$pos = strpos($varSedmica_recSetFilter, '-');
$sedmica = substr($varSedmica_recSetFilter, 0, $pos);
$godina = substr($varSedmica_recSetFilter, $pos+1);
if (!(is_numeric($sedmica) && ($sedmica>0) && ($sedmica<54) && is_numeric($godina) && ($godina>=2013) && ($godina<=DATE('Y')))){
	echo "Wrong week-year input!<br/>Enter correct week-year:";
	$varSedmica_recSetFilter = DATE('W').'-'.DATE('Y');
}
}
$pos2 = strpos($varSedmica_recSetFilter, '-');
$sedm = substr($varSedmica_recSetFilter, 0, $pos2);
if ($sedm<10){$sedm='0'.$sedm;}
$god = substr($varSedmica_recSetFilter, $pos2+1);
$godWsedm = $god.'W'.$sedm;
$datumSedmice = date('Ymd', strtotime("-2 day", strtotime($godWsedm))).'_00';

mysql_select_db($database_baza, $baza);
//$query_recSetFilter = sprintf("SELECT datetime, datumvreme, time, value".
//					" FROM load_forecast_weekly WHERE datumvreme = %s".
//					" ORDER BY time", GetSQLValueString($datumSedmice, "text"));
$query_recSetFilter = sprintf("SELECT date(time), min(value), max(value)".
					" FROM load_forecast_weekly WHERE datumvreme = %s".
					" GROUP BY date(time)".					
					" ORDER BY time", GetSQLValueString($datumSedmice, "text"));
					
$recSetFilter = mysql_query($query_recSetFilter, $baza) or die(mysql_error());
$row_recSetFilter = mysql_fetch_assoc($recSetFilter);
$totalRows_recSetFilter = mysql_num_rows($recSetFilter);

//$DataSet = new pData;//grafik
?>