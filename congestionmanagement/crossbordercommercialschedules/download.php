<?php
	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_GET['from']) && !empty($_GET['from'])) or die ("Day not defined!");
	(isset($_GET['format']) && !empty($_GET['format'])) or die ("Format not defined!");
	
	$from = $_GET['from'];
	$format = $_GET['format'];
	$to = (isset($_GET['to']) && !empty($_GET['to'])) ? $_GET['to'] : $from;
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : "";
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

	$whereborder = ($border=="") ? "" : " AND (direction='" . $border . "RS' OR direction='RS" . $border . "')";
	// $sql = "SELECT direction, date, hour, ATC, total_requested, total_allocated, auction_price FROM resultsd WHERE (date BETWEEN '" . $from . "' AND '" . $to . "')" . $whereborder . " ORDER BY date, direction, hour";
	$sql = "SELECT DISTINCT DATUM as DATE,".
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
	" FROM CAX WHERE DATE(DATETIME) = '$from' - INTERVAL 1 DAY ".
    "AND HOUR(DATETIME)='18'".
	"AND MINUTE(DATETIME)>='00'".
	"AND MINUTE(DATETIME)<'04'".		
	"AND DATUM = '$from' ".			
	"ORDER BY field(OUTAREA,'10YHU-MAVIR----U','10YRO-TEL------P','10YCA-BULGARIA-R','10YMK-MEPSO----8','10YAL-KESH-----5','10YCS-CG-TSO---S','10YBA-JPCC-----D','10YHR-HEP------M','10YCS-SERBIATSOV'), field(INAREA,'10YHU-MAVIR----U','10YRO-TEL------P','10YCA-BULGARIA-R','10YMK-MEPSO----8','10YAL-KESH-----5','10YCS-CG-TSO---S','10YBA-JPCC-----D','10YHR-HEP------M','10YCS-SERBIATSOV')";
	// $sql = "SELECT DATETIME, DATUM, OUTAREA, INAREA, SENDER, VER FROM CAX WHERE DATE(DATETIME)='$from' - INTERVAL 1 DAY ".
	// "AND HOUR(DATETIME)='18'".
	// "AND MINUTE(DATETIME)>='00'".
	// "AND MINUTE(DATETIME)<'04'".
	// "AND DATUM = '$from'".
	// "ORDER BY field(OUTAREA,'10YHU-MAVIR----U','10YRO-TEL------P','10YCA-BULGARIA-R','10YMK-MEPSO----8','10YAL-KESH-----5','10YCS-CG-TSO---S','10YBA-JPCC-----D','10YHR-HEP------M','10YCS-SERBIATSOV'), field(INAREA,'10YHU-MAVIR----U','10YRO-TEL------P','10YCA-BULGARIA-R','10YMK-MEPSO----8','10YAL-KESH-----5','10YCS-CG-TSO---S','10YBA-JPCC-----D','10YHR-HEP------M','10YCS-SERBIATSOV')";
	$res = $conn->query($sql);
	if (mysqli_num_rows($res)==0) {
		header("Location: {$_SERVER['HTTP_REFERER']}");	
	}

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
			$csv_txt .= substr($header, 0, -1) . "\r\n";
			while($r = mysqli_fetch_assoc($res)) {
				$line = '';
				foreach ($r as $key => &$value) {
					$line .= $value . $separator;
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
		array_walk_recursive($data, function (&$item, $key) {
			$item = null === $item ? '' : $item;
		});
		if ($download) { header('Content-type: text/json'); }
		echo json_encode($data, JSON_NUMERIC_CHECK);
        break;
    case "XML":
		while($r = mysqli_fetch_assoc($res)) {
			$data[] = $r;
		}
		// $sql = "SELECT CODE, DOMAIN, IDENTIFICATION FROM eic WHERE IDENTIFICATION='" . $rs . "' OR IDENTIFICATION='" . $border . "'";
		// $eic = $conn->query($sql);
		// while($code = mysqli_fetch_assoc($eic)) {
		// 	if ($code['IDENTIFICATION']==$rs) {
		// 		$rs_code = $code['CODE'];
		// 	}
		// 	else {
		// 		$border_code = $code['CODE'];
		// 		$domain = $code['DOMAIN'];
		// 	}
		// }
		$xml_txt = MakeXML($from, $data);
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
	
	function MakeXML($from, $data) {
		$date = $data[0]['DATE'];
		$day_before = date('Y-m-d', strtotime($from . ' -1 day'));
		$hour_start = (date("I", strtotime($from))) ? 22 : 23;
		$hour_publication = (date("I", strtotime($day_before))) ? '8' : '9';
		$ctime = gettimeofday();
		$time_creation = gmdate('Y-m-d\TH:i:s.', $ctime['sec']) . round($ctime['usec']/1000);

		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<Cross-BorderCommercialSchedules>' . "\r\n";
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
				if ($hour == 25) {
					break;
				}
			}		

			$xml_txt .= '        </Period>' . "\r\n";
			$xml_txt .= '	</Direction>' . "\r\n";
		}
		$xml_txt .= '</Cross-BorderCommercialSchedules>';
		return $xml_txt;
		
	}
	
?>