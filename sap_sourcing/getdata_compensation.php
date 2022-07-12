<?php

	include 'db.php';
	ini_set('display_errors', '1');

	$sql = "SELECT UNIQUE_DOC_NAME, DISPLAY_NAME, DATE_FORMAT(BID_STARTDATE_DATETIME,'%d.%m.%Y.') AS BID_DATE, ROUND(QUANTITY_REQUESTED_QUANTITY) AS ENERGY_LOT,(CASE WHEN (UNIQUE_DOC_NAME LIKE 'BUY%') THEN ROUND(QUANTITY_REQUESTED_QUANTITY) ELSE NULL END) AS PURCHASED_QUANTITY, (CASE WHEN (UNIQUE_DOC_NAME LIKE 'SELL%') THEN ROUND(QUANTITY_REQUESTED_QUANTITY) ELSE NULL END) AS SOLD_QUANTITY, ROUND(BID_PRICE_PRICE,2) AS BID_PRICE FROM SAPSOURCING WHERE INTERNAL_CAT_OBJECT_NAME='EEE-0020'";
	$res = $conn->query($sql);
	$data = array();
	while($r = mysqli_fetch_assoc($res)) {
		$data[] = $r;
	}        

	mysqli_free_result($res);	
	$conn->close();
	
	header("content-type: application/json"); 
	$results->sEcho = 1;
	$results->iTotalRecords = count($data);
	$results->iTotalDisplayRecords = count($data);
	$results->aaData = $data;

	echo json_encode($results); 
	
?>