<?php
	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_GET['from']) && !empty($_GET['from'])) or die ("Day not defined!");
	(isset($_GET['format']) && !empty($_GET['format'])) or die ("Format not defined!");
	
	$from = $_GET['from'];
	$to = (isset($_GET['to']) && !empty($_GET['to'])) ? $_GET['to'] : $_GET['from'];
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? " AND (i.OUT_AREA ='" . $_GET['border'] . "' OR i.IN_AREA='" . $_GET['border'] . "')" : "";
	$download = (isset($_GET['download']) && !empty($_GET['download'])) ? $_GET['download'] : FALSE;
	$filename = (isset($_GET['filename']) && !empty($_GET['filename'])) ? $_GET['filename'] : "download." . strtolower($_GET['format']);
	$daily = (isset($_GET['daily']) && !empty($_GET['daily'])) ? $_GET['daily'] : FALSE;

	if ($download) { header('Content-Disposition: attachment; filename="' . $filename . '"'); }
    if ($daily) {
		$sql = "SELECT CONCAT(e1.IDENTIFICATION,'-', e2.IDENTIFICATION) AS ID_ID, i.* FROM intraday_objava i INNER JOIN eic e1 ON (i.OUT_AREA = e1.CODE) INNER JOIN eic e2 ON (i.IN_AREA = e2.CODE) WHERE (i.DATUM BETWEEN '" . $from . "' AND '" . $to . "') AND TIP=1 ORDER BY DATUM ASC, ID_ID ASC";		
	}
	else {
		$sql = "SELECT CONCAT(e1.IDENTIFICATION,'-', e2.IDENTIFICATION) AS ID_ID, i.* FROM intraday_objava i INNER JOIN eic e1 ON (i.OUT_AREA = e1.CODE) INNER JOIN eic e2 ON (i.IN_AREA = e2.CODE) WHERE (i.DATUM BETWEEN '" . $from . "' AND '" . $to . "')" . $border . " ORDER BY DATUM ASC, ID_ID ASC, TIP DESC";
	}	
	$res = $conn->query($sql);

	switch ($_GET['format']) {
		case "CSV":
		    $csv_txt = 'sep=,' . "\r\n";
			while($r = mysqli_fetch_assoc($res)) {
				$line = '';
				foreach ($r as $key => &$value) {
					if ($key=='TIP') {
						$line .= ($value==1) ? 'offered capacity,' : 'allocated capacity,';
					}
					else {
						if ($key!='ID' && $key!='DATETIME') {$line .= $value . ',';}			
					}	
				}
				$csv_txt .= substr($line, 0, -1) . "\r\n";
			}
			if ($download) { header('Content-type: application/csv'); }
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
		$day_before = date('Y-m-d', strtotime($from . ' -1 day'));
		$hour_start_from = (date("I", strtotime($from))) ? 22 : 23;
		$hour_start_to = (date("I", strtotime($to))) ? 22 : 23;
		$xml_txt = '<?xml version="1.0" encoding="utf-8"?>' . "\r\n";
		$xml_txt .= '<CapacityDocument>' . "\r\n";
		$xml_txt .= '	<CapacityTimeInterval v="' . $day_before . 'T' . $hour_start_from . ':00Z/' . $to . 'T' . $hour_start_to . ':00Z" />' . "\r\n";
		$xml_txt .= '	<Domain v="10YCS-SERBIATSOV" codingScheme="A01" />' . "\r\n";

		while($r = mysqli_fetch_assoc($res)) {
			$xml_txt .= '	<CapacityTimeSeries>' . "\r\n";
			$xml_txt .= '		<TimeSeriesIdentification v="' . $r["ID_ID"] . '" />' . "\r\n";
			$xml_txt .= '		<BusinessType v="' . $r["TIP"] . '" />' . "\r\n";
			$xml_txt .= '		<InArea v="' . $r["IN_AREA"] . '" />' . "\r\n";
			$xml_txt .= '		<OutArea v="' . $r["OUT_AREA"] . '" />' . "\r\n";
			$xml_txt .= '		<MeasureUnit v="MAW" />' . "\r\n";
			$xml_txt .= '		<Period>' . "\r\n";
			$day = $r['DATUM'];
			$day_before = date('Y-m-d', strtotime($day . ' -1 day'));
			$hour_start = (date("I", strtotime($day))) ? 22 : 23;
			$xml_txt .= '			<TimeInterval v="' . $day_before . 'T' . $hour_start . ':00Z/' . $day . 'T' . $hour_start . ':00Z" />' . "\r\n";
			$xml_txt .= '			<Resolution v="PT60M" />' . "\r\n";
			for ($i = 1; $i < 24; $i++) {
				$xml_txt .= '			<Interval>' . "\r\n";
				$xml_txt .= '				<Pos v="' . $i . '" />' . "\r\n";
				$xml_txt .= '				<Qty v="' . number_format($r["H" . str_pad($i, 2, '0', STR_PAD_LEFT)], 3, '.', '') . '" />' . "\r\n";
				$xml_txt .= '			</Interval>' . "\r\n";
			}
			for ($i = 24; $i < 26; $i++) {
				if (!is_null($r["H" . $i])) {
					$xml_txt .= '			<Interval>' . "\r\n";
					$xml_txt .= '				<Pos v="' . $i . '" />' . "\r\n";
					$xml_txt .= '				<Qty v="' . number_format($r["H" . $i], 3, '.', '') . '" />' . "\r\n";
					$xml_txt .= '			</Interval>' . "\r\n";
				}
			}	
			$xml_txt .= '		</Period>' . "\r\n";
			$xml_txt .= '	</CapacityTimeSeries>' . "\r\n";
		}        
		$xml_txt .= '</CapacityDocument>';
		if ($download) { header('Content-type: text/xml'); }
		echo $xml_txt;
        break;
    default:
        echo "Wrong format!";
	}
	mysqli_free_result($res);	
	$conn->close();
	
?>