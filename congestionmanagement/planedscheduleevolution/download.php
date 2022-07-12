<?php
	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_GET['from']) && !empty($_GET['from'])) or die ("Day not defined!");
	(isset($_GET['format']) && !empty($_GET['format'])) or die ("Format not defined!");
	(isset($_GET['border']) && !empty($_GET['border'])) or die ("Border not defined!");
	
	$from = $_GET['from'];
	$format = $_GET['format'];
	$to = (isset($_GET['to']) && !empty($_GET['to'])) ? $_GET['to'] : $from;
	$border = $_GET['border'];
	$download = (isset($_GET['download']) && !empty($_GET['download'])) ? $_GET['download'] : FALSE;
	$filename = (isset($_GET['filename']) && !empty($_GET['filename'])) ? $_GET['filename'] : "download." . strtolower($format);
	$decimal = (isset($_GET['decimal']) && !empty($_GET['decimal'])) ? $_GET['decimal'] : ".";
	$rs = "RS";
	$rs_code = "";
	
	if ($format == "XML" && ($from != $to)) { 
		$format = "ZIP";
		$filename = str_replace("xml", "zip", $filename); 
	}
	if ($download) { header('Content-Disposition: attachment; filename="' . $filename . '"'); }


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

	// $whereborder = ($border=="") ? "" : " AND (direction='" . $border . "RS' OR direction='RS" . $border . "')";
	// $sql = "SELECT direction, date, hour, ATC, total_requested, total_allocated, auction_price FROM resultsd WHERE (date BETWEEN '" . $from . "' AND '" . $to . "')" . $whereborder . " ORDER BY date, direction, hour";
	$sql = "SELECT DATETIME, DATE_FORMAT(datetime, '%H:%i') as HOUR, DATUM,". 
	"CASE WHEN OUTAREA = '10YCA-BULGARIA-R' THEN 'BG'".
		 "WHEN OUTAREA = '10YCS-CG-TSO---S' THEN 'ME'".
		 "WHEN OUTAREA = '10YCS-SERBIATSOV' THEN 'RS'".
		 "WHEN OUTAREA = '10YHU-MAVIR----U' THEN 'HU'".
		 "WHEN OUTAREA = '10YRO-TEL------P' THEN 'RO'".
		 "WHEN OUTAREA = '10YMK-MEPSO----8' THEN 'MK'".
		 "WHEN OUTAREA = '10YAL-KESH-----5' THEN 'AL'".
		 "WHEN OUTAREA = '10YBA-JPCC-----D' THEN 'BA'".
		 "WHEN OUTAREA = '10YHR-HEP------M' THEN 'HR' END AS 'FROM',".
	"CASE WHEN INAREA = '10YCA-BULGARIA-R' THEN 'BG'".
		 "WHEN INAREA = '10YCS-CG-TSO---S' THEN 'ME'".
		 "WHEN INAREA = '10YCS-SERBIATSOV' THEN 'RS'".
		 "WHEN INAREA = '10YHU-MAVIR----U' THEN 'HU'".
		 "WHEN INAREA = '10YRO-TEL------P' THEN 'RO'".
		 "WHEN INAREA = '10YMK-MEPSO----8' THEN 'MK'".
		 "WHEN INAREA = '10YAL-KESH-----5' THEN 'AL'".
		 "WHEN INAREA = '10YBA-JPCC-----D' THEN 'BA'".
		 "WHEN INAREA = '10YHR-HEP------M' THEN 'HR' END AS 'TO',".	
	" VER,".
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
	" FROM CAX WHERE ((DATE(DATETIME) = '$from' - INTERVAL 1 DAY ".
				" AND (HOUR(DATETIME) = '18'))".
				" OR".
				" (DATE(DATETIME) = '$from'".
				" AND FIND_IN_SET(HOUR(DATETIME), '0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23')".
				"AND HOUR(DATETIME) = (SELECT MAX(HOUR(DATETIME)) FROM CAX WHERE DATE(DATETIME)= '$from')))".
				" AND MINUTE(DATETIME) >= '00'".
				" AND MINUTE(DATETIME) < '04'".
				" AND DATUM = '$from'".
				" AND OUTAREA ='$outarea'".
				" AND INAREA = '$inarea'".
	" ORDER BY DATETIME";
	
	$res = $conn->query($sql);
	if (mysqli_num_rows($res)==0) {
		header("Location: {$_SERVER['HTTP_REFERER']}");	
	}

	$sql1 = "SELECT max(HOUR(DATETIME)) as CurrentHour FROM CAX WHERE DATE(DATETIME) = '$from'";
	$res1 = $conn->query($sql1);
	
	$valRes1 = null;
$remainHours = null;
			while ($a = mysqli_fetch_assoc($res1)) {
				foreach ($a as $key => &$value) {
					$valRes1 = $value;
				}
			}

			$remainHours = 60-(24-$valRes1);


	switch ($format) {
		case "CSV":
		    //  $csv_txt = 'sep=,' . "\r\n";
			if ($decimal==',') { $csv_txt = 'sep=;' . "\r\n"; } 
			if ($decimal=='.') { $csv_txt = 'sep=,' . "\r\n"; } 			
			$header = '';
			$separator = '';
			$separator = ($decimal==".") ? "," : ";";
			$fields = mysqli_num_fields($res);
			for ($i = 0; $i<$fields; $i++) {
				$fieldname = mysqli_fetch_field_direct($res, $i)->name;
				$header .= $fieldname . $separator; 
			}
// $valRes1 = null;
// $remainHours = null;
// 			while ($a = mysqli_fetch_assoc($res1)) {
// 				foreach ($a as $key => &$value) {
// 					$valRes1 = $value;
// 				}
// 			}

// 			$remainHours = 60-(24-$valRes1);

			$csv_txt .= substr($header, 0, -1) . "\r\n";
			while($r = mysqli_fetch_assoc($res)) {
				$line = '';			
			
				foreach ($r as $key => &$value) {
					$line .= $value . $separator;					
					if ($remainHours == 0) {
						break;
					}
					// printf("valRes1: ".$remainHours."\n");
					$remainHours--;
				}
				$csv_txt .= substr($line, 0, -1) . "\r\n";
			}
			if ($download) { header('Content-type: application/csv'); }
			if ($decimal==',') { $csv_txt = str_replace(".", ",", $csv_txt); }	
			echo $csv_txt;
        break;
    case "JSON":
		while($r = mysqli_fetch_assoc($res)) {
			$data[] = $r;
		} 		
	$j = 0;
			if ($valRes1 < 24) {
				foreach ($data[1] as $key => $product) {
					if($j > (6+$valRes1)) {		
						unset($data[1][$key]);		
					}
					$j++;					
				}
			}
			
				

		array_walk_recursive($data, function (&$item, $key) {
			$item = null === $item ? '' : $item;
		});
		// $data.pop();
		if ($download) { header('Content-type: text/json'); }
		echo json_encode($data, JSON_NUMERIC_CHECK);
        break;
    case "XML":
		while($r = mysqli_fetch_assoc($res)) {
			$data[] = $r;
		}

		$j = 0;
			if ($valRes1 < 24) {
				foreach ($data[1] as $key => $product) {
					if($j > (6+$valRes1)) {		
						unset($data[1][$key]);		
					}
					$j++;					
				}
			}

		$xml_txt = MakeXML($from, $data, $valRes1);
		// mysqli_free_result($eic);

		if ($download) { header('Content-type: text/xml'); }
		echo $xml_txt;
        break;
    case "ZIP":
		$zip_ok = FALSE;
		$zip = new ZipArchive;
		$zipName = $filename;
		$zip_ok = $zip->open($zipName, ZipArchive::CREATE);
		if ($zip_ok === TRUE) {
			while($r = mysqli_fetch_assoc($res)) {
				$data[] = $r;
			}
					$day_begin = new DateTime($from);
					$day_end = new DateTime($to);
					$interval = DateInterval::createFromDateString('1 day');
					$period = new DatePeriod($day_begin, $interval, $day_end->modify('+1 day'));
					foreach ($period as $d) {
						$xml_txt = MakeXML($d->format("Y-m-d"), $border, $border_code, $domain, $data);
						if ($xml_txt!="") { $zip->addFromString('ALLOCATION_RESULTS_' . $border . '_' . $d->format("Ymd") .  '.xml',$xml_txt); }
					}
				
			}
			
			$zip->close();
			if (file_exists($zipName)) {
				// header("Pragma: public");
				// header("Expires: 0");
				// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				// header("Cache-Control: public");
				// header("Content-Description: File Transfer");
				// header('Content-Disposition: attachment; filename="' . $filename . '"');
				// header("Content-type: application/octet-stream");
				// header("Content-Transfer-Encoding: binary");
				// header("Content-Length: " . filesize($zipName));				 
				clearstatcache(); 			
				readfile($zipName);
				unlink($zipName);
			}
		
        break;
	default:
        echo "Wrong format!";
	}
	mysqli_free_result($res);	
	$conn->close();
	
	function MakeXML($from, $data, $currentHour) {
		$date = $data[0]['DATUM'];
		$day_before = date('Y-m-d', strtotime($from . ' -1 day'));
		$hour_start = (date("I", strtotime($from))) ? 22 : 23;
		$hour_publication = (date("I", strtotime($day_before))) ? '8' : '9';
		$ctime = gettimeofday();
		$time_creation = gmdate('Y-m-d\TH:i:s.', $ctime['sec']) . round($ctime['usec']/1000);

		$ii = 1;

		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<PlannedScheduleEvolution>' . "\r\n";
		$xml_txt .= '	<Date v="'.$date.'"/>' . "\r\n";
		foreach ($data as $d) {
			$xml_txt .= '	<Direction>' . "\r\n";
			$xml_txt .= '        <In v="'.$d['TO'].'"/>' . "\r\n"; 
			$xml_txt .= '        <Out v="'.$d['FROM'].'"/>' . "\r\n"; 
			$xml_txt .= '		 <MeasurementUnit v="MW"/>' . "\r\n"; 
			$xml_txt .= '        <Period>' . "\r\n"; 
			$xml_txt .= '			 <Date v="'.$date.'"/>' . "\r\n";
			$xml_txt .= '            <Resolution v="1H"/>' . "\r\n"; 

			// usort($data_in, function($a, $b) {
			// 	return $a['hour'] - $b['hour'];
			// });
			$hour = 1;
			foreach ($d as $dd) {
				if ($hour<10) {
					$time = 'H'.sprintf("%02d", $hour);
				} else {
					$time = "H".$hour;
				}
				$xml_txt .= '            <Interval>'  . "\r\n"; 
				$xml_txt .= '                <Hour v="' . $hour++ . '"/>' . "\r\n";
				$xml_txt .= '                <Quantity v="' . $d[$time] . '"/>' . "\r\n";
				$xml_txt .= '            </Interval>' . "\r\n";

				if ($ii==2) {
					if ($hour == ($currentHour+2)) {
						break;
					}
				} else {
					if ($hour == 25) {
						break;
					}
				}
			}		

			$xml_txt .= '        </Period>' . "\r\n";
			$xml_txt .= '	</Direction>' . "\r\n";

			$ii++;
		}
		$xml_txt .= '</PlannedScheduleEvolution>';
		return $xml_txt;
		
	}
	
?>