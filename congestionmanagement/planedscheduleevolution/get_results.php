<?php

	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_REQUEST['day']) && !empty($_REQUEST['day'])) or die ("Day is missing!");
	$day = $_REQUEST['day'];

	(isset($_REQUEST['border']) && !empty($_REQUEST['border'])) or die ("Border is missing!");
	$border = $_REQUEST['border'];

	$outarea;
	$inarea;

	switch ($border) {
		case 1:
			$outarea = '10YHU-MAVIR----U';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 2:
			$outarea = '10YRO-TEL------P';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 3:
			$outarea = '10YCA-BULGARIA-R';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 4:
			$outarea = '10YMK-MEPSO----8';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 5:
			$outarea = '10YAL-KESH-----5';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 6:
			$outarea = '10YCS-CG-TSO---S';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 7:
			$outarea = '10YBA-JPCC-----D';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 8:
			$outarea = '10YHR-HEP------M';
			$inarea = '10YCS-SERBIATSOV';
			break;
		case 9:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YHU-MAVIR----U';
			break;
		case 10:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YRO-TEL------P';
			break;
		case 11:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YCA-BULGARIA-R';
			break;
		case 12:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YMK-MEPSO----8';
			break;
		case 13:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YAL-KESH-----5';
			break;
		case 14:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YCS-CG-TSO---S';
			break;
		case 15:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YBA-JPCC-----D';
			break;
		case 16:
			$outarea = '10YCS-SERBIATSOV';
			$inarea = '10YHR-HEP------M';
			break;
		
		default:
			# code...
			break;
	}
	
	$data = null;

	
	$sql="SELECT DATETIME, HOUR(DATETIME) as CURRENT_HOUR, DATE_FORMAT(datetime, '%H:%i') as HOUR, DATUM, OUTAREA, INAREA, SENDER, VER,".
	" CAST((E0015+E0030+E0045+E0100)/4 AS SIGNED) as H01, CAST((E0115+E0130+E0145+E0200)/4 AS SIGNED) as H02,".
	" CAST((E0215+E0230+E0245+E0300)/4 AS SIGNED) as H03, CAST((E0315+E0330+E0345+E0400)/4 AS SIGNED) as H04,".					
	" CAST((E0415+E0430+E0445+E0500)/4 AS SIGNED) as H05, CAST((E0515+E0530+E0545+E0600)/4 AS SIGNED) as H06,".
	" CAST((E0615+E0630+E0645+E0700)/4 AS SIGNED) as H07, CAST((E0715+E0730+E0745+E0800)/4 AS SIGNED) as H08,".
	" CAST((E0815+E0830+E0845+E0900)/4 AS SIGNED) as H09, CAST((E0915+E0930+E0945+E1000)/4 AS SIGNED) as H10,".
	" CAST((E1015+E1030+E1045+E1100)/4 AS SIGNED) as H11, CAST((E1115+E1130+E1145+E1200)/4 AS SIGNED) as H12,".
	" CAST((E1215+E1230+E1245+E1300)/4 AS SIGNED) as H13, CAST((E1315+E1330+E1345+E1400)/4 AS SIGNED) as H14,".
	" CAST((E1415+E1430+E1445+E1500)/4 AS SIGNED) as H15, CAST((E1515+E1530+E1545+E1600)/4 AS SIGNED) as H16,".
	" CAST((E1615+E1630+E1645+E1700)/4 AS SIGNED) as H17, CAST((E1715+E1730+E1745+E1800)/4 AS SIGNED) as H18,".
	" CAST((E1815+E1830+E1845+E1900)/4 AS SIGNED) as H19, CAST((E1915+E1930+E1945+E2000)/4 AS SIGNED) as H20,".
	" CAST((E2015+E2030+E2045+E2100)/4 AS SIGNED) as H21, CAST((E2115+E2130+E2145+E2200)/4 AS SIGNED) as H22,".
	" CAST((E2215+E2230+E2245+E2300)/4 AS SIGNED) as H23, CAST((E2315+E2330+E2345+E2400)/4 AS SIGNED) as H24".
	" FROM CAX WHERE ((DATE(DATETIME) = '$day' - INTERVAL 1 DAY ".
				" AND (HOUR(DATETIME) = '18'))".
				" OR".
				" (DATE(DATETIME) = '$day' ".
				" AND FIND_IN_SET(HOUR(DATETIME), '0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23')))".
				" AND MINUTE(DATETIME) >= '00'".
				" AND MINUTE(DATETIME) < '04'".
				" AND DATUM = '$day'".
				" AND OUTAREA ='$outarea'".
				" AND INAREA = '$inarea'".
	" ORDER BY DATETIME";
	
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