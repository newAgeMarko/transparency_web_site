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
	
	if ($format == "XML" && ($from != $to)) { 
		$format = "ZIP";
		$filename = str_replace("xml", "zip", $filename); 
	}
	if ($download) { header('Content-Disposition: attachment; filename="' . $filename . '"'); }

	// $whereborder = ($border=="") ? "" : " AND (direction='" . $border . "RS' OR direction='RS" . $border . "')";
	$sql = "SELECT * FROM load_realized WHERE (datum BETWEEN '" . $from . "' AND '" . $to . "') AND EP='SRBIJA' ORDER BY datum";
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
		$xml_txt = MakeXML_2($data);

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
				$day_begin = new DateTime($from);
				$day_end = new DateTime($to);
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($day_begin, $interval, $day_end->modify('+1 day'));
				$dani = array();
				foreach ($period as $p) {
					$dani.array_push($dani, $p);
				}
				$x = 0;
				foreach ($data as $d) {
					$xml_txt = MakeXML($d);
					if ($xml_txt!="") { $zip->addFromString('LOAD_REALIZED' . '_' . $dani[$x]->format("Ymd") . '.xml',$xml_txt); }
					$x++;
				}				

			
			mysqli_free_result($eic);
			$zip->close();
			if (file_exists($tmp_file)) {
				// header("Pragma: public");
				// header("Expires: 0");
				// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				// header("Cache-Control: public");
				// header("Content-Description: File Transfer");
				// header('Content-Disposition: attachment; filename="' . $filename . '"');
				// header("Content-type: application/octet-stream");
				// header("Content-Transfer-Encoding: binary");
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
	
	function MakeXML($data) {				
		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<SystemVerticalLoad-Realized>' . "\r\n";
		$xml_txt .= '		 <Date v="'.$data['DATUM'].'"/>' . "\r\n"; 
		$xml_txt .= '		 <MeasurementUnit v="MW"/>' . "\r\n"; 
		$xml_txt .= '        <Period>' . "\r\n"; 
		$xml_txt .= '		 	 <Date v="'.$data['DATUM'].'"/>' . "\r\n"; 
		$xml_txt .= '		 	 <Resolution v="1H"/>' . "\r\n"; 

		$i = 0;
	
		while ($i<24) {
			$i++;
			if ($i<10) {
				$time = 'S0'.$i;
			} else {
				$time = 'S'.$i;
			}
	
			$xml_txt .= '            <Interval>'  . "\r\n"; 
			$xml_txt .= '                <Hour v="' . $i . '"/>' . "\r\n";
			$xml_txt .= '                <Quantity v="' . $data[$time] . '"/>' . "\r\n";
			$xml_txt .= '            </Interval>' . "\r\n";
		}		

		$xml_txt .= '        </Period>' . "\r\n";
		$xml_txt .= '</SystemVerticalLoad-Realized>';
		return $xml_txt;		
	}
	
	function MakeXML_2($data) {				
		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<SystemVerticalLoad-Realized>' . "\r\n";
		foreach ($data as $value) {	
		$xml_txt .= '		 <Date v="'.$value['DATUM'].'"/>' . "\r\n"; 
		$xml_txt .= '		 <MeasurementUnit v="MW"/>' . "\r\n"; 
		$xml_txt .= '        <Period>' . "\r\n"; 
		$xml_txt .= '		 	 <Date v="'.$value['DATUM'].'"/>' . "\r\n"; 
		$xml_txt .= '		 	 <Resolution v="1H"/>' . "\r\n"; 	
		}
		
		$i = 0;

		foreach ($data as $value) {		
			while ($i<24) {
				$i++;
				if ($i<10) {
					$time = 'S0'.$i;
				} else {
					$time = 'S'.$i;
				}

				$xml_txt .= '            <Interval>'  . "\r\n"; 
				$xml_txt .= '                <Hour v="' . $i . '"/>' . "\r\n";
				$xml_txt .= '                <Quantity v="' . $value[$time] . '"/>' . "\r\n";
				$xml_txt .= '            </Interval>' . "\r\n";	
			}
		}

		$xml_txt .= '        </Period>' . "\r\n";
		$xml_txt .= '</SystemVerticalLoad-Realized>';	

		return $xml_txt;
	}
	
?>