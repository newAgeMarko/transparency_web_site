<?php

	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_REQUEST['year']) && !empty($_REQUEST['year'])) or die ("Year is missing!");
	$year = $_REQUEST['year'];

	$data = null;
	
	$sql = "SELECT * FROM resultsy WHERE YEAR(period_od) = $year ORDER BY field(granica_smer, 'HURS', 'RORS', 'ALRS', 'BARS', 'BGRS', 'HRRS', 'MERS', 'MKRS', 'RSHU', 'RSRO', 'RSAL', 'RSBA', 'RSBG', 'RSHR', 'RSME', 'RSMK')";
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