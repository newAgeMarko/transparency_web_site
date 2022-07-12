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
	
	if ($format == "XML" && ($from != $to )) { 
		$format = "ZIP";
		$filename = str_replace("xml", "zip", $filename); 
	}
	if ($download) { header('Content-Disposition: attachment; filename="' . $filename . '"'); }

	$whereborder = ($border=="") ? "" : " AND (direction='" . $border . "RS' OR direction='RS" . $border . "')";
	$sql = "SELECT direction, date, hour, ATC, total_requested, total_allocated, auction_price FROM resultsd WHERE (date BETWEEN '" . $from . "' AND '" . $to . "')" . $whereborder . " ORDER BY date, direction, hour";
	$res = $conn->query($sql);
	if (mysqli_num_rows($res)==0) {
		header("Location: {$_SERVER['HTTP_REFERER']}");	
	}

	switch ($format) {
		case "CSV":
		    $csv_txt = 'sep=;' . "\r\n";
			$header = '';
			$fields = mysqli_num_fields($res);
			for ($i = 0; $i<$fields; $i++) {
				$fieldname = mysqli_fetch_field_direct($res, $i)->name;
				$header .= $fieldname . ";"; 
			}
			$csv_txt .= substr($header, 0, -1) . "\r\n";
			while($r = mysqli_fetch_assoc($res)) {
				$line = '';
				foreach ($r as $key => &$value) {
					$line .= $value . ';';
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

		$xml_txt = MakeXML($from, $border, $data); 

		if ($download) { header('Content-type: text/xml'); }
		echo $xml_txt;
        break;
    case "ZIP":
		$zip_ok = FALSE;
		$zip = new ZipArchive;
		$zipName = './zip/' . $filename;
		$zip_ok = $zip->open($zipName, ZipArchive::CREATE);
		if ($zip_ok === TRUE) {
			while($r = mysqli_fetch_assoc($res)) {
				$data[] = $r;
			}
			$where = ($border=="") ? "" : " WHERE IDENTIFICATION='" . $rs . "' OR IDENTIFICATION='" . $border . "'";
			$sql = "SELECT CODE, DOMAIN, IDENTIFICATION FROM eic" . $where;
			$eic = $conn->query($sql);
			while($code = mysqli_fetch_assoc($eic)) {
				if ($code['IDENTIFICATION']==$rs) {
					$rs_code = $code['CODE'];
				}
				else {
					$border_code = $code['CODE'];
					$domain = $code['DOMAIN'];
					$border = $code['IDENTIFICATION'];
					$day_begin = new DateTime($from);
					$day_end = new DateTime($to);
					$interval = DateInterval::createFromDateString('1 day');
					$period = new DatePeriod($day_begin, $interval, $day_end->modify('+1 day'));
					foreach ($period as $d) {
						$xml_txt = MakeXML($d->format("Y-m-d"), $border, $border_code, $domain, $data);
						if ($xml_txt!="") { $zip->addFromString('ALLOCATION_RESULTS_' . $border . '_' . $d->format("Ymd") . '.xml',$xml_txt); }
					}
				}
			}
			mysqli_free_result($eic);
			$zip->close();
			if (file_exists($zipName)) {
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header('Content-Disposition: attachment; filename="' . $filename . '"');
				header("Content-type: application/octet-stream");
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: " . filesize($zipName));
				clearstatcache(); 
				readfile($zipName); 
				unlink($zipName);
			}
		}
        break;
	default:
        echo "Wrong format!";
	}
	mysqli_free_result($res);	
	$conn->close();
	
	function MakeXML($from, $border, $data) {

		// $data_in = array_filter($data, function ($var) use ($dir_in, $from) {
		// 	return ($var['direction'] == $dir_in && $var['date'] == $from);
		// });

		if (empty($data_in) || empty($data_out)) { return ""; }	
		

		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<DailyAuctionsATCandResults DtdVersion="6" DtdRelease="0">' . "\r\n";
		$xml_txt .= '	<Date v="' . $from . '/>' . "\r\n";

		foreach ($data as $d) {
			$xml_txt .= '            <Interval>'  . "\r\n"; 
			$xml_txt .= '                <Direction v="' . $d['direction'] . '"/>' . "\r\n";
			$xml_txt .= '                <Date v="' . $d['date'] . '"/>' . "\r\n";
			$xml_txt .= '                <Hour v="' . $d['hour'] . '"/>' . "\r\n";
			$xml_txt .= '                <ATC v="' . $d['ATC'] . '"/>' . "\r\n";
			$xml_txt .= '                <TotalRequestedCapacity v="' . $d['total_requested'] . '"/>' . "\r\n";
			$xml_txt .= '                <TotalAllocatedCapacity v="' . $d['total_allocated'] . '"/>' . "\r\n";
			$xml_txt .= '                <AuctionPrice v="' . $d['auction_price'] . '"/>' . "\r\n";
			$xml_txt .= '            </Interval>' . "\r\n";
		}

		$xml_txt .= '</DailyAuctionsATCandResults>';
		return $xml_txt;
		
	}
	
?>