<?php

	$hostName = "";
	$databaseName = "";
	$username = "";
	$password = "";	

	$conn = new mysqli($hostName, $username, $password, $databaseName);
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

?>
