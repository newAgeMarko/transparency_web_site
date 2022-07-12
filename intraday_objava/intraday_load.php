<?php

	include 'db.php';

	(isset($_GET['border']) && !empty($_GET['border'])) or die ("Border is missing!");
	(isset($_GET['day']) && !empty($_GET['day'])) or die ("Day is missing!");
		
    $border = $_GET['border'];
    $day = $_GET['day'];
	
	$sql = "SELECT * FROM intraday_objava WHERE DATUM='" . $day . "' AND OUT_AREA='" . $border . "'";
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$data[] = $r;
	}        
	$sql = "SELECT * FROM intraday_objava WHERE DATUM='" . $day . "' AND IN_AREA='" . $border . "'";
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$data[] = $r;
	}        

	mysqli_free_result($res);	
	$conn->close();
	
	array_walk_recursive($data, function (&$item, $key) {
		$item = null === $item ? '' : $item;
	});

//	header("content-type: application/json"); 
	echo json_encode($data, JSON_NUMERIC_CHECK);
	
?>