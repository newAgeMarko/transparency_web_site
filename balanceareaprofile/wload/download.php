<?php
	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_GET['from']) && !empty($_GET['from'])) or die ("Day not defined!");
	(isset($_GET['format']) && !empty($_GET['format'])) or die ("Format not defined!");
	
	$from = $_GET['from'];
	$format = $_GET['format'];
	$to = (isset($_GET['to']) && !empty($_GET['to'])) ? $_GET['to'] : $from;
	// $border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : "";
	$download = (isset($_GET['download']) && !empty($_GET['download'])) ? $_GET['download'] : FALSE;
	$filename = (isset($_GET['filename']) && !empty($_GET['filename'])) ? $_GET['filename'] : "download." . strtolower($format);
	$decimal = (isset($_GET['decimal']) && !empty($_GET['decimal'])) ? $_GET['decimal'] : ".";
	$rs = "RS";
	$rs_code = "";

	$pos = strpos($from, '-');
    $god = substr($from, 0, $pos);
    $date = new DateTime($from);
    $sedm = $date->format("W");
    // if ($sedm<10){$sedm='0'.$sedm;}
    $godWsedm = $god.'W'.$sedm;
	$datumSedmice = date('Ymd', strtotime($godWsedm)).'_00';

	$pos2 = strpos($to, '-');
    $god2 = substr($to, 0, $pos2);
    $date2 = new DateTime($to);
    $sedm2 = $date2->format("W");
    // if ($sedm<10){$sedm='0'.$sedm;}
    $godWsedm2 = $god2.'W'.$sedm2;
	$datumSedmice2 = date('Ymd', strtotime($godWsedm2)).'_00';
	
	$wekk_year = $sedm.'-'.$god;
	$wekk_year2 = $sedm2.'-'.$god2;
	
	if ($format == "XML" && ($from != $to)) { 
		$format = "ZIP";
		$filename = str_replace("xml", "zip", $filename); 
	}
	if ($download) { header('Content-Disposition: attachment; filename="' . $filename . '"'); }

	// $whereborder = ($border=="") ? "" : " AND (direction='" . $border . "RS' OR direction='RS" . $border . "')";
	// $sql = "SELECT * FROM load_plan WHERE (datum BETWEEN '" . $from . "' AND '" . $to . "') AND EP='SRBIJA' ORDER BY datum";	
	 // $sql= "SELECT date(time), ROUND(min(value)) AS 'min(value)', ROUND(max(value)) AS 'max(value)' FROM load_forecast_weekly WHERE DATUMVREME >= '".$datumSedmice."' AND DATUMVREME <= '".$datumSedmice2."' GROUP BY DATE(TIME) ORDER BY TIME";


		
		  
		$poslednjasedmica = date('Ymd', strtotime($godWsedm2));
		$prvasedmica = date('Ymd', strtotime($godWsedm));
		$razlika = $poslednjasedmica - $prvasedmica;

	
	if($poslednjasedmica > $prvasedmica){
		
		if($razlika == 7){
			$sql = "(SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$datumSedmice."' GROUP BY DATE(TIME) ORDER BY TIME) UNION ALL (SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$datumSedmice2."' GROUP BY DATE(TIME) ORDER BY TIME)";		
		
		} else if($razlika == 14) {
			$drugasedmica = (date('Ymd', strtotime($godWsedm)) + 7) . '_00';
			$trecasedmica = (date('Ymd', strtotime($godWsedm)) + 14) . '_00';
			$sql = "(SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$datumSedmice."' GROUP BY DATE(TIME) ORDER BY TIME) UNION ALL (SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$drugasedmica."' GROUP BY DATE(TIME) ORDER BY TIME) UNION ALL (SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$trecasedmica."' GROUP BY DATE(TIME) ORDER BY TIME)";

		} else if($razlika == 21) {
			$drugasedmica = (date('Ymd', strtotime($godWsedm)) + 7) . '_00';
			$trecasedmica = (date('Ymd', strtotime($godWsedm)) + 14) . '_00';
			$cetvrtasedmica = (date('Ymd', strtotime($godWsedm)) + 21) . '_00';
			$sql = "(SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$datumSedmice."' GROUP BY DATE(TIME) ORDER BY TIME) UNION ALL (SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$drugasedmica."' GROUP BY DATE(TIME) ORDER BY TIME) UNION ALL (SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$trecasedmica."' GROUP BY DATE(TIME) ORDER BY TIME) UNION ALL (SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$cetvrtasedmica."' GROUP BY DATE(TIME) ORDER BY TIME)";
		}
	} else {		
		$sql = "SELECT date(time), ROUND(min(value)) AS 'min', ROUND(max(value)) AS 'max' FROM load_forecast_weekly WHERE DATUMVREME = '".$datumSedmice."' GROUP BY DATE(TIME) ORDER BY TIME";
	}
	
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
			$i=1;
			while($r = mysqli_fetch_assoc($res)) {				
				$line = '';				
				foreach ($r as $key => &$value) {
					if (mysqli_num_rows($res)%7 != 0 && $i<4) {
						$i++;
						continue;
					}
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

		$total = count((array)$data);
		if ($total%7 != 0) {
			array_shift($data);
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
		$xml_txt = MakeXML($data, $sedm);

		if ($download) { header('Content-type: text/xml'); }
		echo $xml_txt;
        break;
    case "ZIP":
		$zip_ok = FALSE;
		$zip = new ZipArchive;
		$zipName = $filename;
		$tmp_file = tempnam('.','');
		$zip_ok = $zip->open($tmp_file, ZipArchive::CREATE);
		if ($zip_ok === TRUE) {
			while($r = mysqli_fetch_assoc($res)) {
				$data[] = $r;
			}
			echo "<pre>";
			print_r($data);
				// $day_begin = new DateTime($from);
				// $day_end = new DateTime($to);
				// $interval = DateInterval::createFromDateString('1 day');
				// $period = new DatePeriod($day_begin, $interval, $day_end->modify('+1 day'));
				// foreach ($period as $p) {
				// 	$dani.array_push($dani, $p);
				// }
				$x = 1;
				$y = 0;
				$data_weekly = Array();
				foreach($data as $d){
					array_push($data_weekly, $d);
					if($x%7 == 0){					
						$brsedmice = $sedm + $y;
						$xml_txt = MakeXML($data_weekly, $brsedmice);
						if ($xml_txt!="") { $zip->addFromString('LOAD_WEEKLY_RESULTS_' .$brsedmice.  '.xml',$xml_txt); }						
						$data_weekly = Array();
						echo "<pre>";
						print_r($xml_txt);
						$y++;
					}
					$x++;					
				}
				
				// foreach ($data as $d) {
					// $xml_txt = MakeXML($data, $sedm);
					// if ($xml_txt!="") { $zip->addFromString('LOAD_WEEKLY_RESULTS_' .  '.xml',$xml_txt); }
				 //}				

			
			//mysqli_free_result($eic);
			$zip->close();
			if (file_exists($tmp_file)) {
				// header("Pragma: public");
				// header("Expires: 0");
				// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				// header("Cache-Control: public");
				// header("Content-Description: File Transfer");
				// header('Content-Disposition: attachment; filename="' . $filename . '"');
				// header("Content-type: application/zip");
				// header("Content-Transfer-Encoding: binary");
				// header("Content-Length: " . filesize($zipName));				 
				 clearstatcache(); 			
				 readfile($tmp_file);
				 unlink($zipName);
			}
		}
        break;
	default:
        echo "Wrong format!";
	}
	mysqli_free_result($res);	
	$conn->close();
	
	function MakeXML($data, $wekk_year) {		
		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<LoadForecastWeekly>' . "\r\n";
		$xml_txt .= '		<Week v="'.$wekk_year.'"/>' . "\r\n"; 	

		$total = count((array)$data);
		if ($total%7 != 0) {
			array_shift($data);
		}

		foreach ($data as $key => $value) {			
			$xml_txt .= '        <Date>' . "\r\n"; 
			$xml_txt .= '		 	 <Date v="'.$value['date(time)'].'"/>' . "\r\n"; 
			$xml_txt .= '		 	 <MeasurementUnit v="MW"/>' . "\r\n"; 
			$xml_txt .= '        	 <MinimumValue v="' . $value['min'] . '"/>' . "\r\n";
			$xml_txt .= '        	 <MaximumValue v="' . $value['max'] . '"/>' . "\r\n";
			$xml_txt .= '        </Date>' . "\r\n";			
		}
		$xml_txt .= '</LoadForecastWeekly>';	

		return $xml_txt;
	}

?>