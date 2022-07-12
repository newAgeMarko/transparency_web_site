<?php

	$hostName = "";
	$databaseName = "";
	$username = "";
	$password = "";	

	$conn = new mysqli($hostName, $username, $password, $databaseName);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'";
	$conn->query($sql);

?>
