<?php

	include 'db.php';

	(isset($_POST['border']) && !empty($_POST['border'])) or die ("Border is missing!");
	(isset($_POST['day']) && !empty($_POST['day'])) or die ("Day is missing!");
		
    $border = $_POST['border'];
    $day = $_POST['day'];
	
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