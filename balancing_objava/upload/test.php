<?php

	ini_set('display_errors', '1');
	include '../db.php';

	$sql = "DELETE * FROM balancing_objava WHERE DATE>'2017-12-31'";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
	$sql = "SELECT MAX(DATE) AS MD FROM balancing_objava";
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		echo $r['MD'];
	}        
	
?>