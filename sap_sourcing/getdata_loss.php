<?php

	include 'db.php';
	ini_set('display_errors', '1');

	$sql = "SELECT UNIQUE_DOC_NAME, DISPLAY_NAME, DATE_FORMAT(BID_STARTDATE_DATETIME,'%d.%m.%Y.') AS BID_DATE, ROUND(QUANTITY_REQUESTED_QUANTITY) AS REQUESTED_QUANTITY, ROUND(AWARD_QUANTITY_QUANTITY) AS AWARD_QUANTITY, ROUND(BID_PRICE_PRICE,2) AS BID_PRICE FROM SAPSOURCING WHERE INTERNAL_CAT_OBJECT_NAME='EEE-0010'";
	$res = $conn->query($sql);
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