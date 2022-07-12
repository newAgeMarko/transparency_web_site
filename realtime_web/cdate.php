<?php

$servername = "192.168.25.33";
$username = "IMP";
$password = "IMP28022017@.";
$dbname = "transparency";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT DATE_FORMAT(CURDATE(), '%d.%m.%Y.') AS D";
$res = $conn->query($sql);
$r = mysqli_fetch_assoc($res); 

echo $r['D'];    

?>