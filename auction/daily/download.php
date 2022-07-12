<?php
	//ini_set('display_errors', '1');


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
	
	if ($format == "XML" && ($from != $to || $border == "")) { 
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
		$sql = "SELECT CODE, DOMAIN, IDENTIFICATION FROM eic WHERE IDENTIFICATION='" . $rs . "' OR IDENTIFICATION='" . $border . "'";
		$eic = $conn->query($sql);
		while($code = mysqli_fetch_assoc($eic)) {
			if ($code['IDENTIFICATION']==$rs) {
				$rs_code = $code['CODE'];
			}
			else {
				$border_code = $code['CODE'];
				$domain = $code['DOMAIN'];
			}
		}
		$xml_txt = MakeXML($from, $border, $border_code, $domain, $data);
		mysqli_free_result($eic);

		if ($download) { header('Content-type: text/xml'); }
		echo $xml_txt;
        break;
    case "ZIP":
		$zip_ok = FALSE;
		$zip = new ZipArchive;
		$zipName = $filename;
		$tmp_file = tempnam('.','');
		$zip_ok = $zip->open($tmp_file, ZIPARCHIVE::CREATE);
		if ($zip_ok === TRUE) {
			while($r = mysqli_fetch_assoc($res)) {
				$data[] = $r;
			}
				echo "<pre>";
				print_r($data);
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
						if ($xml_txt!="") { $zip->addFromString('ALLOCATION_RESULTS_' . $border . '_' . $d->format("Ymd") .  '.xml',$xml_txt); }
					}
				}
			}
			
			mysqli_free_result($eic);
			$zip->close();
			

		//	if (file_exists($zipName)) {
			 header("Content-Length: " . filesize($zipName));
				 header("Content-Description: File Transfer");
				 header("Content-type: application/zip");
				// header("Pragma: public");
				// header("Expires: 0");
				// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				// header("Cache-Control: public");				 
				// header('Content-Disposition: attachment; filename="' . $filename . '"');
				// header("Content-type: application/octet-stream");				 
				// header("Content-Transfer-Encoding: binary");				 		
				//clearstatcache(); 			
				readfile($tmp_file);
				//unlink($zipName);
		//	}
		}
        break;
	default:
        echo "Wrong format!";
	}
	mysqli_free_result($res);	
	$conn->close();
	
	function MakeXML($from, $border, $border_code, $domain, $data) {
		
		global $rs, $rs_code;

		$dir_in = $border . $rs;
		$data_in = array_filter($data, function ($var) use ($dir_in, $from) {
			return ($var['direction'] == $dir_in && $var['date'] == $from);
		});
		$dir_out = $rs . $border;
		$data_out = array_filter($data, function ($var) use ($dir_out, $from) {
			return ($var['direction'] == $dir_out && $var['date'] == $from);
		});
		if (empty($data_in) || empty($data_out)) { return ""; }	
		
		$day_before = date('Y-m-d', strtotime($from . ' -1 day'));
		$hour_start = (date("I", strtotime($from))) ? 22 : 23;
		$hour_publication = (date("I", strtotime($day_before))) ? '8' : '9';
		$ctime = gettimeofday();
		$time_creation = gmdate('Y-m-d\TH:i:s.', $ctime['sec']) . round($ctime['usec']/1000);

		$xml_txt = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\r\n";
		$xml_txt .= '<ExplicitAllocationResultsDocument DtdVersion="6" DtdRelease="0">' . "\r\n";
		$xml_txt .= '	<DocumentIdentification v="ALLOCATION_RESULTS_' . $border . $rs . '_' . date('Ymd', strtotime($from)) . '"/>' . "\r\n";
		$xml_txt .= '	<DocumentVersion v="1"/>' . "\r\n";
		$xml_txt .= '	<DocumentType v="A25"/>' . "\r\n";
		$xml_txt .= '	<SenderIdentification v="10XCS-SERBIATSO8" codingScheme="A01"/>' . "\r\n";
		$xml_txt .= '	<SenderRole v="A07"/>' . "\r\n";
		$xml_txt .= '	<ReceiverIdentification v="10XCS-SERBIATSO8" codingScheme="A01"/>' . "\r\n";
		$xml_txt .= '	<ReceiverRole v="A07"/>' . "\r\n";
		$xml_txt .= '	<CreationDateTime v="' . $time_creation . 'Z"/>' . "\r\n";
		$xml_txt .= '	<PublicationTimeInterval v="' . $day_before . 'T0' . $hour_publication . ':15:00.000Z"/>' . "\r\n";			
		$xml_txt .= '	<Domain v="' . $domain . '" codingScheme="A01"/>' . "\r\n";
		$xml_txt .= '	<ResultTimeSeries>' . "\r\n";
		$xml_txt .= '        <TimeSeriesIdentification v="' . $dir_in . '_' . date('Ymd', strtotime($from)) . '"/>' . "\r\n"; 
		$xml_txt .= '        <BusinessType v="A25"/>' . "\r\n"; 
		$xml_txt .= '        <InArea v="' . $rs_code . '" codingScheme="A01"/>' . "\r\n"; 
		$xml_txt .= '        <OutArea v="' . $border_code . '" codingScheme="A01"/>' . "\r\n"; 
		$xml_txt .= '		 <ContractType v="A01"/>' . "\r\n"; 
		$xml_txt .= '        <MeasureUnitQuantity v="MAW"/>' . "\r\n"; 
		$xml_txt .= '		 <Currency v="EUR"/>' . "\r\n"; 
		$xml_txt .= '		 <MeasureUnitPrice v="MWH"/>' . "\r\n"; 
		$xml_txt .= '        <Period>' . "\r\n"; 
		$xml_txt .= '            <TimeInterval v="' . $day_before . 'T' . $hour_start . ':00Z/' . $from . 'T' . $hour_start . ':00Z" />' . "\r\n";
		$xml_txt .= '            <Resolution v="PT1H"/>' . "\r\n"; 

		usort($data_in, function($a, $b) {
			return $a['hour'] - $b['hour'];
		});
		foreach ($data_in as $d) {
			$xml_txt .= '            <Interval>'  . "\r\n"; 
			$xml_txt .= '                <Pos v="' . $d['hour'] . '"/>' . "\r\n";
			$xml_txt .= '                <Qty v="' . $d['ATC'] . '"/>' . "\r\n";
			$xml_txt .= '                <TRC v="' . $d['total_requested'] . '"/>' . "\r\n";
			$xml_txt .= '                <TAC v="' . $d['total_allocated'] . '"/>' . "\r\n";
			$xml_txt .= '                <Price v="' . $d['auction_price'] . '"/>' . "\r\n";
			$xml_txt .= '            </Interval>' . "\r\n";
		}

		$xml_txt .= '        </Period>' . "\r\n";
		$xml_txt .= '	</ResultTimeSeries>' . "\r\n";
		$xml_txt .= '	<ResultTimeSeries>' . "\r\n";
		$xml_txt .= '        <TimeSeriesIdentification v="' . $dir_out . '_' . date('Ymd', strtotime($from)) . '"/>' . "\r\n"; 
		$xml_txt .= '        <BusinessType v="A25"/>' . "\r\n"; 
		$xml_txt .= '        <InArea v="' . $border_code . '" codingScheme="A01"/>' . "\r\n"; 
		$xml_txt .= '        <OutArea v="' . $rs_code . '" codingScheme="A01"/>' . "\r\n"; 
		$xml_txt .= '		 <ContractType v="A01"/>' . "\r\n"; 
		$xml_txt .= '        <MeasureUnitQuantity v="MAW"/>' . "\r\n"; 
		$xml_txt .= '		 <Currency v="EUR"/>' . "\r\n"; 
		$xml_txt .= '		 <MeasureUnitPrice v="MWH"/>' . "\r\n"; 
		$xml_txt .= '        <Period>' . "\r\n"; 
		$xml_txt .= '            <TimeInterval v="' . $day_before . 'T' . $hour_start . ':00Z/' . $from . 'T' . $hour_start . ':00Z" />' . "\r\n";
		$xml_txt .= '            <Resolution v="PT1H"/>' . "\r\n"; 

		usort($data_out, function($a, $b) {
			return $a['hour'] - $b['hour'];
		});
		foreach ($data_out as $d) {
			$xml_txt .= '            <Interval>'  . "\r\n"; 
			$xml_txt .= '                <Pos v="' . $d['hour'] . '"/>' . "\r\n";
			$xml_txt .= '                <Qty v="' . $d['ATC'] . '"/>' . "\r\n";
			$xml_txt .= '                <TRC v="' . $d['total_requested'] . '"/>' . "\r\n";
			$xml_txt .= '                <TAC v="' . $d['total_allocated'] . '"/>' . "\r\n";
			$xml_txt .= '                <Price v="' . $d['auction_price'] . '"/>' . "\r\n";
			$xml_txt .= '            </Interval>' . "\r\n";
		}

		$xml_txt .= '        </Period>' . "\r\n";
		$xml_txt .= '	</ResultTimeSeries>' . "\r\n";
		$xml_txt .= '</ExplicitAllocationResultsDocument>';
		return $xml_txt;
		
	}
	
?>