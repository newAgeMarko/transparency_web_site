<?php
//	ini_set('display_errors', '1');

	include 'db.php';
	ob_end_clean();
	(isset($_GET['month']) && !empty($_GET['month'])) or die ("Month not defined!");	
	(isset($_GET['year']) && !empty($_GET['year'])) or die ("Year not defined!");	
	(isset($_GET['format']) && !empty($_GET['format'])) or die ("Format not defined!");
	
	$month = $_GET['month'];	
	$month_to = (isset($_GET['month_to']) && !empty($_GET['month_to'])) ? $_GET['month_to'] : $month;
	$year = $_GET['year'];
	$year_to = (isset($_GET['year_to']) && !empty($_GET['year_to'])) ? $_GET['year_to'] : $year;
	$format = $_GET['format'];
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? $_GET['border'] : "";
	$download = (isset($_GET['download']) && !empty($_GET['download'])) ? $_GET['download'] : FALSE;
	$filename = (isset($_GET['filename']) && !empty($_GET['filename'])) ? $_GET['filename'] : "download." . strtolower($format);
	$decimal = (isset($_GET['decimal']) && !empty($_GET['decimal'])) ? $_GET['decimal'] : ".";
	$rs = "RS";
	$rs_code = "";	
//	$dataArr = array();
//	$res = null;
//	$data = array();

	$month = date("m",strtotime($month));
	$month_to = date("m",strtotime($month_to));	   
	
	
	if ($format == "XML" && (($month != $month_to) || ($year != $year_to))) { 
		$format = "ZIP";
		$filename = str_replace("xml", "zip", $filename); 
		$result = addMonthsToArray($year, $year_to, $month, $month_to, $conn, $res);
		$res = $result[0];
		$dataArr = $result[1];		
		if (mysqli_num_rows($res)==0) {  // Ukoliko je $res == 0 vrati se na stranicu monthly.php
			header("Location: {$_SERVER['HTTP_REFERER']}");	
		}
	} else {
		$sql = "SELECT to_granica_smer, TTC, TRM, NTC, yAAC, mAAC, ATC, period_od, period_do, casovi FROM NTCm WHERE period_od >= CONCAT(($year), '-$month-01') AND period_od <= CONCAT(($year_to),'-$month_to-30') ORDER BY year(period_od), month(period_od), field(granica_smer, 'HURS', 'RORS', 'ALRS', 'BARS', 'BGRS', 'HRRS', 'MERS', 'MKRS', 'RSHU', 'RSRO', 'RSAL', 'RSBA', 'RSBG', 'RSHR', 'RSME', 'RSMK'), period_od";
		$res = $conn->query($sql);
		if (mysqli_num_rows($res)==0) {  // Ukoliko je $res == 0 vrati se
			header("Location: {$_SERVER['HTTP_REFERER']}");	
		}
	}
	if ($download) { header('Content-Disposition: attachment; filename="' . $filename . '"'); }


	function addMonthsToArray($year, $year_to, $month, $month_to, $conn, $res) {
		while ($year <= $year_to) {  
			if ($year==$year_to) {
				for ($j=$month; $j<=$month_to; $j++) { 
					$sql = "SELECT to_granica_smer, TTC, TRM, NTC, yAAC, mAAC, ATC, period_od, period_do, casovi FROM NTCm WHERE month(period_od) = $j AND year(period_od) = $year ORDER BY year(period_od), month(period_od), field(granica_smer, 'HURS', 'RORS', 'ALRS', 'BARS', 'BGRS', 'HRRS', 'MERS', 'MKRS', 'RSHU', 'RSRO', 'RSAL', 'RSBA', 'RSBG', 'RSHR', 'RSME', 'RSMK'), period_od";	
					$res = $conn->query($sql);	
					while ($r = mysqli_fetch_assoc($res)) {
						$data[] = $r;						
					}				
					$dataArr[] = $data; 
					$data = array();
					//unset($data);	
				}				
			} else {
				for ($j=$month; $j<=12; $j++) { 
					$sql = "SELECT to_granica_smer, TTC, TRM, NTC, yAAC, mAAC, ATC, period_od, period_do, casovi FROM NTCm WHERE month(period_od) = $j AND year(period_od) = $year ORDER BY year(period_od), month(period_od), field(granica_smer, 'HURS', 'RORS', 'ALRS', 'BARS', 'BGRS', 'HRRS', 'MERS', 'MKRS', 'RSHU', 'RSRO', 'RSAL', 'RSBA', 'RSBG', 'RSHR', 'RSME', 'RSMK'), period_od";						
					$res = $conn->query($sql);		
					while ($r = mysqli_fetch_assoc($res)) {
						$data[] = $r;
					}				
					$dataArr[] = $data;
					$data = array();
					//unset($data);		
				}				
			}		
			$month = 1;
			$year++;
		}
		return Array($res, $dataArr); 
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

		$xml_txt = MakeXML($border, $year, $month, $data);

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
						
			foreach ($dataArr as $value) {			
				$xml_txt = MakeXML($border, $year, $month, $value);
				if ($xml_txt!="") { $zip->addFromString('ALLOCATION_RESULTS_' . $month . $year . '.xml',$xml_txt); }
				if ($month == 12 && ($year != $year_to)) {					
					$month = 1;
					$month = sprintf("%02d", $month);
					$year++;
				} else if ($month == 12) {
					$month = 1;
					$month = sprintf("%02d", $month);
				}
				else {
					$month++;
					$month = sprintf("%02d", $month);
				}				
			}
			
			$zip->close();
			if (file_exists($tmp_file)) {
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header('Content-Disposition: attachment; filename="' . $filename . '"');
				header("Content-type: application/xml");
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: " . filesize($zipName));
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
	
	function MakeXML($border, $year, $month, $value) {
			
		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<AvailableTransferCapacity>' . "\r\n";
		$xml_txt .= '	<Year v="' . $year . '"/>' . "\r\n";
		$xml_txt .= '	<Month v="' . $month . '"/>' . "\r\n";

		foreach ($value as $d) {
			$xml_txt .= '	<Direction>'  . "\r\n"; 
			$xml_txt .= '		<Direction v="' . $d['to_granica_smer'] . '"/>' . "\r\n";
			$xml_txt .= '		<MeasurementUnit v="MW"/>' . "\r\n";
			$xml_txt .= '		<TTC v="' . $d['TTC'] .'"/>' . "\r\n";
			$xml_txt .= '		<TRM v="' . $d['TRM'] .'"/>' . "\r\n";
			$xml_txt .= '		<NTC v="' . $d['NTC'] .'"/>' . "\r\n";			
			$xml_txt .= '		<AAC_yearly v="' . $d['yAAC'] .'"/>' . "\r\n";			
			$xml_txt .= '		<AAC_monthly v="' . $d['mAAC'] .'"/>' . "\r\n";
			$xml_txt .= '		<ATC v="' . $d['ATC'] . '"/>' . "\r\n";
			$xml_txt .= '		<period_from v="' . $d['period_od'] . '"/>' . "\r\n";
			$xml_txt .= '		<period_to v="' . $d['period_do'] . '"/>' . "\r\n";
			$xml_txt .= '		<Hours_of_possible_use v="' . $d['casovi'] . '"/>' . "\r\n";
			$xml_txt .= '	</Direction>' . "\r\n";
		}

		$xml_txt .= '</AvailableTransferCapacity>';
		return $xml_txt;		
	}