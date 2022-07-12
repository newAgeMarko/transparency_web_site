<?php

	include 'db.php';

	(isset($_REQUEST ['day']) && !empty($_REQUEST ['day'])) or die ("Day is missing!");
		
    $day = $_REQUEST ['day'];
	
	$sql = "SELECT CONCAT(e1.IDENTIFICATION,'-', e2.IDENTIFICATION) AS ID_ID, i.* FROM intraday_objava i INNER JOIN eic e1 ON (i.OUT_AREA = e1.CODE) INNER JOIN eic e2 ON (i.IN_AREA = e2.CODE) WHERE i.DATUM='$day' AND TIP=1 ORDER BY REPLACE(ID_ID,'RS-','')";
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$data[] = $r;
	}        
	mysqli_free_result($res);	
	$conn->close();
	
	array_walk_recursive($data, function (&$item, $key) {
		$item = null === $item ? '' : $item;
	});

	echo json_encode($data, JSON_NUMERIC_CHECK);
	
?>