<?php

	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_REQUEST['day']) && !empty($_REQUEST['day'])) or die ("Day is missing!");
	$day = $_REQUEST['day'];
	
	$data = null;

	$sql = "SELECT * FROM resultsd WHERE date='" . $day . "' ORDER BY hour";
	// $sql = "SELECT * FROM resultsd WHERE date='2019-03-01' ORDER BY hour";
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$data[] = $r;
	}	 

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