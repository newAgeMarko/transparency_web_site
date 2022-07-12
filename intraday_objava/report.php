<?php
	ini_set('display_errors', '1');

	include 'db.php';
	include_once "./excel/eiseXLSX.php";

	(isset($_GET['from']) && !empty($_GET['from'])) or die ("Day not defined!");
	
	$from = $_GET['from'];
	$to = (isset($_GET['to']) && !empty($_GET['to'])) ? $_GET['to'] : $_GET['from'];
	$border = (isset($_GET['border']) && !empty($_GET['border'])) ? " AND (i.OUT_AREA ='" . $_GET['border'] . "' OR i.IN_AREA='" . $_GET['border'] . "')" : "";
	$download = (isset($_GET['download']) && !empty($_GET['download'])) ? $_GET['download'] : FALSE;
	$filename = (isset($_GET['filename']) && !empty($_GET['filename'])) ? $_GET['filename'] : "report.xlsx";

	$data = array();
	$idx = array();
	if ($download) { header('Content-Disposition: attachment; filename="' . $filename . '"'); }
	$sql = "SELECT * FROM eic WHERE IDENTIFICATION<>'RS' ORDER BY IDENTIFICATION";
	$tsos = $conn->query($sql);
	if (mysqli_num_rows($tsos) != 0) { 
		while($b = mysqli_fetch_assoc($tsos)) {
			$tso[] = $b;
		}
		mysqli_free_result($tsos);	
		$sql = "SELECT *, DATE_FORMAT(DATUM, '%d.%m.%Y') AS DATUM_DMY FROM intraday_objava WHERE (DATUM BETWEEN '" . $from . "' AND '" . $to . "')" . $border . " ORDER BY DATUM ASC, TIP DESC";
		$res = $conn->query($sql);
		
		$begin = new DateTime($from);
		$end = new DateTime($to);
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		$hrs_24 = array("00:00 - 01:00","01:00 - 02:00","02:00 - 03:00","03:00 - 04:00","04:00 - 05:00","05:00 - 06:00","06:00 - 07:00","07:00 - 08:00","08:00 - 09:00","09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00","19:00 - 20:00","20:00 - 21:00","21:00 - 22:00","22:00 - 23:00","23:00 - 00:00");
		$hrs_23 = array("00:00 - 01:00","01:00 - 02:00","03:00 - 04:00","04:00 - 05:00","05:00 - 06:00","06:00 - 07:00","07:00 - 08:00","08:00 - 09:00","09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00","19:00 - 20:00","20:00 - 21:00","21:00 - 22:00","22:00 - 23:00","23:00 - 00:00");
		$hrs_25 = array("00:00 - 01:00","01:00 - 02:00","02:00 - 03:00","02:00 - 03:00","03:00 - 04:00","04:00 - 05:00","05:00 - 06:00","06:00 - 07:00","07:00 - 08:00","08:00 - 09:00","09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00","19:00 - 20:00","20:00 - 21:00","21:00 - 22:00","22:00 - 23:00","23:00 - 00:00");
		$id = 0;
		foreach ($period as $dt) {
			$n_hrs = 24;
			if ($dt->format('n')==3) {
				$dt_23 = date('d.m.Y', strtotime('last sunday of ' . $dt->format('F') . ' ' . $dt->format('Y')));
				if ($dt->format("d.m.Y")==$dt_23) { $n_hrs = 23; }
			}
			else if ($dt->format('n')==10) {
				$dt_25 = date('d.m.Y', strtotime('last sunday of ' . $dt->format('F') . ' ' . $dt->format('Y')));
				if ($dt->format("d.m.Y")==$dt_25) { $n_hrs = 25; }
			}
			$idx[] = array("DATUM" => $dt->format("d.m.Y"), "INDEX" => $id, "N" => $n_hrs);
			
			switch ($n_hrs) {
				case 23:
					for ($x = 0; $x < $n_hrs; $x++) {
						$data[] = array("DATUM" => $dt->format("d.m.Y"), "SAT" => $hrs_23[$x]);
						$id++;
					}	
					break;
				case 25:
        			for ($x = 0; $x < $n_hrs; $x++) {
						$data[] = array("DATUM" => $dt->format("d.m.Y"), "SAT" => $hrs_25[$x]);
						$id++;
					}	
					break;
				default:
					for ($x = 0; $x < 24; $x++) {
						$data[] = array("DATUM" => $dt->format("d.m.Y"), "SAT" => $hrs_24[$x]);
						$id++;
					}	
			}
		}

 		while($r = mysqli_fetch_assoc($res)) {
			$col = -1;
			if (searchArray($r['IN_AREA'], 'CODE', $tso)===null) {
				if (searchArray($r['OUT_AREA'], 'CODE', $tso)!==null) {
					$col = abs($r['TIP']-1) + searchArray($r['OUT_AREA'], 'CODE', $tso)*4;
				}
			} 
			else {
				$col = abs($r['TIP']-1) + searchArray($r['IN_AREA'], 'CODE', $tso)*4 + 2;
			}
			$row = searchArray($r['DATUM_DMY'], 'DATUM', $idx);
			if (($col != -1) && $row!==null) {
				for ($i = 0; $i < $idx[$row]['N']; $i++) {
					$podaci[$idx[$row]['INDEX']+$i][$col] = $r["H" . str_pad($i+1, 2, '0', STR_PAD_LEFT)];
				}
			}
		}
		

		try { $xlsx = new eiseXLSX("./excel/templates/blank.xlsx"); } 
		catch(eiseXLSX_Exception $e) { die($e->getMessage()); }

 		$c = 3;
		foreach ($tso as $t) {
			$xlsx->data('R1C' . $c, $t['IDENTIFICATION'] . ' - ' . 'RS');	
			$xlsx->data('R2C' . $c, 'Intraday ATC');	
			$xlsx->data('R3C' . $c, '[MW]');
			$c++;
			$xlsx->data('R2C' . $c, 'Alocated capacity');	
			$xlsx->data('R3C' . $c, '[MW]');
			$c++;
			$xlsx->data('R1C' . $c, 'RS' . ' - ' . $t['IDENTIFICATION']);	
			$xlsx->data('R2C' . $c, 'Intraday ATC');	
			$xlsx->data('R3C' . $c, '[MW]');
			$c++;
			$xlsx->data('R2C' . $c, 'Alocated capacity');	
			$xlsx->data('R3C' . $c, '[MW]');
			$c++;
		}	
		for ($j = 0; $j < count($data); $j++) {
			$xlsx->data('R' . ($j+4) . 'C1', $data[$j]['DATUM']);
			$xlsx->data('R' . ($j+4) . 'C2', $data[$j]['SAT']);
			for ($p = 0; $p < $c; $p++) {
				if (array_key_exists($p, $podaci[$j])) {
					$xlsx->data('R' . ($j+4) . 'C' . ($p+3), $podaci[$j][$p]);
				}		
			}	

		}	

 		$xlsx->Output($filename, 'D');
	
	}

	mysqli_free_result($res);	
	$conn->close();
	
	function searchArray($v, $col, $array) {
		foreach ($array as $key => $val) {
			if ($val[$col] === $v) {
				return $key;
			}
		}
		return null;
	}
	
?>