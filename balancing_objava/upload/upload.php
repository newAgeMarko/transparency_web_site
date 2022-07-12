<?php

	ini_set('display_errors', '1');
	include '../db.php';

	$sql_file = fopen("upload.sql", "r");
	$i = 0;	
	if ($sql_file) {
		while (($line = fgets($sql_file)) !== false) {
			if ($conn->query($line) === TRUE) {
				$i++;
			} 
			else {
				echo "Error: " . $line . "<br>" . $conn->error;
			}
		}
		fclose($sql_file);
		$conn->close();
		echo "Uspešno dodato: $i podataka.";
	} 
	else {
		exit('GREŠKA: ne postoji fajl upload.sql!');
	} 
	
?>