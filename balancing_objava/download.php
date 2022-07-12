<?php

	ini_set('display_errors', '1');
	include 'db.php';
	include_once "./excel/eiseXLSX.php";
	
	(isset($_GET['date']) && !empty($_GET['date'])) or die ("Day not defined!");
	$date = $_GET['date'];
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "lat";
	$type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : 0;
	$hours = (isset($_GET['hours']) && !empty($_GET['hours'])) ? $_GET['hours'] : 24;
	
	switch ($lng) {
    case 'lat':
        $title[0] = 'Preliminarni';
        $title[1] = 'Konačni';
        $title[2] = 'PRELIMINARNI';
        $title[3] = 'KONACNI';		
        break;
    case 'cir':
        $title[0] = 'Прелиминарни';
        $title[1] = 'Коначни';
        $title[2] = 'PRELIMINARNI';
        $title[3] = 'KONACNI';		
        break;
    case 'eng':
        $title[0] = 'Preliminary';
        $title[1] = 'Final';
        $title[2] = 'PRELIMINARY';
        $title[3] = 'FINAL';		
        break;
	}
	
	$template_dir = "./excel/templates/";		// folder sa template XLSX fajlovima - izveštajima
	$template_file = $hours . "_" . strtoupper($lng) . '.xlsx';
	
	if (!is_dir($template_dir)) { exit('GREŠKA: Nedostupan folder "' . $directory . '" sa template XLSX fajlovima!'); }

	try { $xlsx = new eiseXLSX($template_dir . $template_file); } 
	catch(eiseXLSX_Exception $e) { die($e->getMessage()); }

	$xlsx->data('R1C2', $title[$type] . ' ' . $xlsx->data('R1C2')); 
	$xlsx->data('R3C5', date("d.m.Y.", strtotime($date))); 
	
	$sum_sr_up = 0;
	$sum_sr_dn = 0;
	$sum_tr_up = 0;
	$sum_tr_dn = 0;
	$sum_hr_up = 0;
	$sum_hr_dn = 0;
	
	$sql = "SELECT * FROM balancing_objava WHERE DATE='" . $date . "' AND FINAL=" . $type . " ORDER BY HOUR";
	$res = $conn->query($sql);
	while($data = mysqli_fetch_assoc($res)) {
		$r = $data['HOUR'] + 7;
		$xlsx->data("R" . $r . "C5", ($data['ENERGY_S']===null || $data['ENERGY_S']==0) ? "" : $data['ENERGY_S']);
		$xlsx->data("R" . $r . "C6", ($data['PRICE_S']===null || $data['PRICE_S']==0) ? "" : $data['PRICE_S']);
		$xlsx->data("R" . $r . "C8", ($data['ENERGY_T']===null || $data['ENERGY_T']==0) ? "" : $data['ENERGY_T']);
		$xlsx->data("R" . $r . "C9", ($data['PRICE_T']===null || $data['PRICE_T']==0) ? "" : $data['PRICE_T']);
		$xlsx->data("R" . $r . "C11", ($data['ENERGY_H']===null || $data['ENERGY_H']==0) ? "" : $data['ENERGY_H']);
		$xlsx->data("R" . $r . "C12", ($data['PRICE_H']===null || $data['PRICE_H']==0) ? "" : $data['PRICE_H']);
		$xlsx->data("R" . $r . "C14", ($data['PRICE_SETTLEMENT']===null) ? 0 : $data['PRICE_SETTLEMENT']);
		$sum_sr_up = ($data['ENERGY_S']===null) ? $sum_sr_up : (($data['ENERGY_S']>0) ? $sum_sr_up+$data['ENERGY_S'] : $sum_sr_up);
		$sum_sr_dn = ($data['ENERGY_S']===null) ? $sum_sr_dn : (($data['ENERGY_S']<0) ? $sum_sr_dn-$data['ENERGY_S'] : $sum_sr_dn);
		$sum_tr_up = ($data['ENERGY_T']===null) ? $sum_tr_up : (($data['ENERGY_T']>0) ? $sum_tr_up+$data['ENERGY_T'] : $sum_tr_up);
		$sum_tr_dn = ($data['ENERGY_T']===null) ? $sum_tr_dn : (($data['ENERGY_T']<0) ? $sum_tr_dn-$data['ENERGY_T'] : $sum_tr_dn);
		$sum_hr_up = ($data['ENERGY_H']=='NULL') ? $sum_hr_up : (($data['ENERGY_H']>0) ? $sum_hr_up+$data['ENERGY_H'] : $sum_hr_up);
		$sum_hr_dn = ($data['ENERGY_H']=='NULL') ? $sum_hr_dn : (($data['ENERGY_H']<0) ? $sum_hr_dn-$data['ENERGY_H'] : $sum_hr_dn);	
	}        
	mysqli_free_result($res);	
	$conn->close();

	$xlsx->data("R" . ($r+2) . "C5", $sum_sr_up);
	$xlsx->data("R" . ($r+3) . "C5", $sum_sr_dn);
	$xlsx->data("R" . ($r+2) . "C8", $sum_tr_up);
	$xlsx->data("R" . ($r+3) . "C8", $sum_tr_dn);
	$xlsx->data("R" . ($r+2) . "C11", $sum_hr_up);
	$xlsx->data("R" . ($r+3) . "C11", $sum_hr_dn);
	$xlsx->Output(date("Ymd", strtotime($date)) . '_' . $title[$type+2] . '.xlsx', 'D');
	
?>