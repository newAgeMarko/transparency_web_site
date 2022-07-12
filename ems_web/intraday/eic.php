<?php
	ini_set('display_errors', '1');

	include 'db.php';
		
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : "all";

	if ($border == "all") {
		$sql = "SELECT * FROM eic WHERE INTRADAY ORDER BY IDENTIFICATION ASC";
	}
	else if ($border == "other") {
		$sql = "SELECT * FROM eic WHERE INTRADAY AND NOT SINGLE ORDER BY IDENTIFICATION ASC";
	}
	else {
		$sql = "SELECT * FROM eic WHERE INTRADAY AND (IDENTIFICATION='RS' OR IDENTIFICATION='" .$border. "') ORDER BY IDENTIFICATION ASC";
	}	
	$res = $conn->query($sql);
	while($r = mysqli_fetch_assoc($res)) {
		$data[] = $r;
	}        
	mysqli_free_result($res);	
	$conn->close();
	
	header("Content-Type: text/html; charset=utf-8");
	echo preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($data));
?>