<?php

	ini_set('display_errors', '1');

	include 'db.php';
	include 'cyrillic_code.php';
	include '../../lang.php';

	if (isset($_GET['month'])) {
		$month = $_GET['month'];
	} else {
		$month = " ";
	}
	if (isset($_GET['year'])) {
		$year = $_GET['year'];
	} else {
		$year = " ";
	}

	// daj mi redni broj meseca u godini
	$number_month = date("m",strtotime($month));
	
	$month = explode(" ",$month);
	switch ($month[0]) {
		case 'January':
			$number_month = '01';
			break;
		case 'February':
			$number_month = '02';
			break;
		case 'March':
			$number_month = '03';
			break;
		case 'April':
			$number_month = '04';
			break;
		case 'May':
			$number_month = '05';
			break;
		case 'June':
			$number_month = '06';
			break;
		case 'July':
			$number_month = '07';
			break;
		case 'August':
			$number_month = '08';
			break;
		case 'September':
			$number_month = '09';
			break;
		case 'October':
			$number_month = '10';
			break;
		case 'November':
			$number_month = '11';
			break;
		case 'December':
			$number_month = '12';
			break;

		}	
	
	
	// daj mi prvi string - mesec 
	//$month = explode(" ",$month);
	

	//Umesto naziva meseca u stringovima za cirilicu uzimamo redni broj meseca koji se kasnije koristi u query-ju
	if($number_month=='01' && $lang=='rs'){	
		$number_month = ConvertMonthsToNumbers($month);	
	}

	$data = null;
	
	// $sql = "SELECT * FROM resultsm WHERE MONTH(period_od) = $month AND YEAR(period_od) = $year";
	$sql = "SELECT granica_smer,ATC,period_od,period_do,zahtevani_kapacitet,dodeljeni_kapacitet,ucesnici_podneli_zahtev,ucesnici_dobili_kapacitet,broj_ponuda,cena,zagusenje FROM resultsm WHERE MONTH(period_od) = $number_month AND YEAR(period_od) = $year ORDER BY field(granica_smer, 'HURS', 'RORS', 'ALRS', 'BARS', 'BGRS', 'HRRS', 'MERS', 'MKRS', 'RSHU', 'RSRO', 'RSAL', 'RSBA', 'RSBG', 'RSHR', 'RSME', 'RSMK')";
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