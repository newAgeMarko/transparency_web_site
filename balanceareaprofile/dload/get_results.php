<?php

	//ini_set('display_errors', '1');

	include 'db.php';

	(isset($_REQUEST['day']) && !empty($_REQUEST['day'])) or die ("Day is missing!");
	$day = $_REQUEST['day'];
	
	$data1 = null;
	$data2 = null;
	$data = null;

	$sql = "SELECT S01,S02,S03,S04,S05,S06,S07,S08,S09,S10,S11,S12,S13,S14,S15,S16,S17,S18,S19,S20,S21,S22,S23,S24 FROM load_forecast_DACF WHERE datum='$day'";
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$data1[] = $r;
	}	 
	$data = $data1;

	mysqli_free_result($res);	

	$sql = "SELECT S01,S02,S03,S04,S05,S06,S07,S08,S09,S10,S11,S12,S13,S14,S15,S16,S17,S18,S19,S20,S21,S22,S23,S24 FROM load_realized WHERE datum='$day'";
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$data2[] = $r;
	}	

	array_push($data, $data2);

	mysqli_free_result($res);	
	$conn->close();
	
	if (is_array($data)) {
		array_walk_recursive($data, function (&$item, $key) {
			$item = null === $item ? '' : $item;
		});
	}	

	//	header("content-type: application/json"); 
	echo json_encode($data, JSON_NUMERIC_CHECK);
	
?>