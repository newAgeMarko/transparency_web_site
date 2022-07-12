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

$varDatum_recSetFilter = DATE('Y-m-d');//inicijalna vrednost, pri prvom ucitavanju stranice; danasnji datum yyyy-mm-dd
if (isset($_GET["txtDatum3"])) {
  $varDatum_recSetFilter = $_GET["txtDatum3"];
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
$query_recSetFilter = sprintf("SELECT direction, date, hour, ATC, total_requested,".
					" total_allocated, auction_price".
					" FROM resultsd WHERE date = %s".
								" AND locked = 1".
					" ORDER BY field(direction, 'HURS', 'RORS', 'ALRS', 'BARS', 'BGRS', 'HRRS', 'MERS', 'MKRS', 'RSHU', 'RSRO', 'RSAL', 'RSBA', 'RSBG', 'RSHR', 'RSME', 'RSMK'), date, hour", GetSQLValueString($varDatum_recSetFilter, "text"));
					
$recSetFilter = mysql_query($query_recSetFilter, $baza) or die(mysql_error());
$row_recSetFilter = mysql_fetch_assoc($recSetFilter);
$totalRows_recSetFilter = mysql_num_rows($recSetFilter);

//$DataSet = new pData;//grafik
?>