<?php 

$servername = "192.168.25.33";
$username = "IMP";
$password = "IMP28022017@.";
$dbname = "transparency";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

	$sql = "SELECT 
			DATE_FORMAT(FROM_UNIXTIME(time), '%H') AS H,
			DATE_FORMAT(FROM_UNIXTIME(time), '%i') AS M, 
			DATE_FORMAT(FROM_UNIXTIME(time), '%s') AS S, 
			MAX(IF(keyn = 'SMM.ACE_SSK_KOMP', value, NULL)) AS ACE, 
			MAX(IF(keyn = 'SMM.SRB.ACE', value, NULL)) AS ACE_EMS
			FROM realtime_web
			GROUP BY time
			ORDER BY time DESC
			LIMIT 1";
$res = $conn->query($sql);
$r = $res->fetch_array();


// Set the JSON header
header("Content-type: text/json");

$rows = array($r['H'].":".$r['M'].":".$r['S'], $r['ACE'], $r['ACE_EMS']);

// Create a PHP array and echo it as JSON
echo json_encode($rows, JSON_NUMERIC_CHECK);
?>