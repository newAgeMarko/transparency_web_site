<?php

	ini_set('display_errors', '1');

	$myObj->UNIQUE_DOC_NAME	= "BUY-EE-2018-04-16-0001";
	$myObj->DISPLAY_NAME = "2018_Base_Q3_180418_1";
	$myObj->BID_DATE = "18.04.2018.";
	$myObj->REQUESTED_QUANTITY = "44020";
	$myObj->AWARD_QUANTITY = "44020";
	$myObj->BID_PRICE = "45.17";
	
	$data[] = $myObj;

	header("content-type: application/json"); 

	$results->sEcho = 1;
	$results->iTotalRecords = count($data);
	$results->iTotalDisplayRecords = count($data);
	$results->aaData = $data;

	echo json_encode($results); 
	
?>