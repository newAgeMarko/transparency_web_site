<?php

	ini_set('display_errors', '1');

	include 'db.php';

	(isset($_REQUEST['day']) && !empty($_REQUEST['day'])) or die ("Day is missing!");
	$day = $_REQUEST['day'];

	$currentDate = date("Y-m-d");
	$currentDateName = date("l", strtotime($currentDate)); 
	
    $pos = strpos($day, '-');
    $god = substr($day, 0, $pos);
    $date = new DateTime($day);
    $sedm = $date->format("W");
    // if ($sedm<10){$sedm='0'.$sedm;}
    $godWsedm = $god.'W'.$sedm;
    $datumSedmice = date('Ymd', strtotime($godWsedm)).'_00';
	
	if($day=='2019-12-30' || $day=='2019-12-31'){
		$datumSedmice = '20191230_00';
	}

	// redni broj tekuceg dana nedelji - npr: cetvrtak - 4
	$numDayOfTheCurrentWeek = date('w', strtotime($currentDate));
	
   $firstDayOfTheWeek = date('Y-m-d', strtotime($godWsedm));
   $lastDayOfTheWeek = date('Y-m-d', strtotime("+6 day",strtotime($godWsedm)));
   
   $firstDayOfTheCurrentWeekFormated = date('Ymd', strtotime("this week")).'_00'; 
   $lastDayOfTheCurrentWeek = Date('Y-m-d', StrToTime("Next Sunday"));
   
 //  $dayOfTheWeek = date('w', strtotime($day));
   	
	$data = null;

	
	
	if(($day > $lastDayOfTheCurrentWeek && $currentDateName=='Friday') || ($day > $lastDayOfTheCurrentWeek && $currentDateName=='Saturday') || ($day > $lastDayOfTheCurrentWeek && $currentDateName=='Sunday')){
	
		switch ($numDayOfTheCurrentWeek) {			
			case 5:
				$friday = date("Ymd", strtotime($currentDate)).'_00';
				$friday2 = $currentDate;
				$firstDayOfTheNextWeek = date('Y-m-d', strtotime($currentDate . ' +3 day'));
				$nextThursday = date('Y-m-d', strtotime($currentDate . ' +6 day'));
				$nextFriday = date('Y-m-d', strtotime($currentDate . ' +7 day'));
				break;
			case 6:
				$friday = date('Ymd', strtotime($currentDate . ' -1 day')).'_00';
				$friday2 = date('Y-m-d', strtotime($currentDate . ' -1 day'));
				$firstDayOfTheNextWeek = date('Y-m-d', strtotime($currentDate . ' +2 day'));
				$nextThursday = date('Y-m-d', strtotime($currentDate . ' +5 day'));
				$nextFriday = date('Y-m-d', strtotime($currentDate . ' +6 day'));
				break;
			case 0:
				$friday = date('Ymd', strtotime($currentDate . ' -2 day')).'_00';
				$friday2 = date('Y-m-d', strtotime($currentDate . ' -2 day'));
				$firstDayOfTheNextWeek = date('Y-m-d', strtotime($currentDate . ' +1 day'));
				$nextThursday = date('Y-m-d', strtotime($currentDate . ' +4 day'));
				$nextFriday = date('Y-m-d', strtotime($currentDate . ' +5 day'));
				break;
			case 4:
				$friday = date('Ymd', strtotime($currentDate . ' +1 day')).'_00';
				$friday2 = date('Y-m-d', strtotime($currentDate . ' +1 day'));
				$firstDayOfTheNextWeek = date('Y-m-d', strtotime($currentDate . ' +4 day'));
				$nextThursday = date('Y-m-d', strtotime($currentDate . ' +7 day'));
				$nextFriday = date('Y-m-d', strtotime($currentDate . ' +8 day'));
				break;
			case 3:
				$friday = date('Ymd', strtotime($currentDate . ' +2 day')).'_00';
				$friday2 = date('Y-m-d', strtotime($currentDate . ' +2 day'));
				$firstDayOfTheNextWeek = date('Y-m-d', strtotime($currentDate . ' +5 day'));
				$nextThursday = date('Y-m-d', strtotime($currentDate . ' +8 day'));
				$nextFriday = date('Y-m-d', strtotime($currentDate . ' +9 day'));
				break;
			case 2:
				$friday = date('Ymd', strtotime($currentDate . ' +3 day')).'_00';
				$friday2 = date('Y-m-d', strtotime($currentDate . ' +3 day'));
				$firstDayOfTheNextWeek = date('Y-m-d', strtotime($currentDate . ' +6 day'));
				$nextThursday = date('Y-m-d', strtotime($currentDate . ' +9 day'));
				$nextFriday = date('Y-m-d', strtotime($currentDate . ' +10 day'));
				break;
			case 1:
				$friday = date('Ymd', strtotime($currentDate . ' +4 day')).'_00';
				$friday2 = date('Y-m-d', strtotime($currentDate . ' +4 day'));
				$firstDayOfTheNextWeek = date('Y-m-d', strtotime($currentDate . ' +7 day'));
				$nextThursday = date('Y-m-d', strtotime($currentDate . ' +10 day'));
				$nextFriday = date('Y-m-d', strtotime($currentDate . ' +11 day'));
				break;
			// ...
			// default:
				// code to be executed if n is different from all labels;
		}		
  		
		$sql = "(SELECT date(time), min(value), max(value) FROM load_forecast_weekly WHERE DATUMVREME='".$friday."' 
					AND DATE(time)>='".$firstDayOfTheNextWeek."' AND  DATE(time)<='".$nextThursday."'   GROUP BY DATE(TIME) ORDER BY TIME)
				UNION ALL
				(SELECT date(time), min(value), max(value) FROM load_forecast_weekly WHERE DATUMVREME='".$firstDayOfTheCurrentWeekFormated."'
					AND DATE(time)>='".$friday2."'  AND  DATE(time)<='".$lastDayOfTheCurrentWeek."'   GROUP BY DATE(TIME) ORDER BY TIME)";
					
		$res = $conn->query($sql);
		while($r = mysqli_fetch_assoc($res)) {
			$data[] = $r;
		}	 
		mysqli_free_result($res);	
		$conn->close();
		
		$data[4]['date(time)'] = $nextFriday;
		$data[5]['date(time)'] = date('Y-m-d', strtotime($nextFriday . ' +1 day'));
		$data[6]['date(time)'] = date('Y-m-d', strtotime($nextFriday . ' +2 day'));
				
	} else if($day <= $lastDayOfTheCurrentWeek){ // A OVAJ QUERY SE UZIMA KADA SU IZASLI KONACNI REZULTATI ZA TEKUCU NEDELJU, A SLUCAJ KADA NEMAMO REZULTATE ZA SL.NEDELJU  - TO JE SLUCAJ KADA JE ISPUNJEN USLOV GORE
	
		// $sql ="SELECT date(time), min(value), max(value) FROM load_forecast_weekly WHERE DATUMVREME='".$firstDayOfTheCurrentWeekFormated."' AND date(time)>='".$firstDayOfTheWeek."' AND date(time)<='".$lastDayOfTheWeek."' GROUP BY DATE(TIME) ORDER BY TIME";			
		
		$sql ="SELECT date(time), min(value), max(value) FROM load_forecast_weekly WHERE DATUMVREME='".$datumSedmice."' GROUP BY DATE(TIME) ORDER BY TIME";		
		
		$res = $conn->query($sql);
		while($r = mysqli_fetch_assoc($res)) {
			$data[] = $r;
		}
		mysqli_free_result($res);	
		$conn->close();
	} 
	
// U PETAK SE CITAJU PRELIMINARNI PODACI ZA SLEDECU NEDELJU - IMAMO PODATKE OD PON-CET, ZA OSTALA 3 DANA SE PRIPISUJU PODACI IZ PRETHODNE NEDELJE
	// if($dayOfTheWeek>=5 || $dayOfTheWeek==0){
		// switch ($dayOfTheWeek) {
			// case 5:
				// $friday = date("Ymd", strtotime($day)).'_00';
				// $friday2 = $day;
				// $firstDayOfTheNextWeek = date('Y-m-d', strtotime($day . ' +3 day'));
				// $nextThursday = date('Y-m-d', strtotime($day . ' +6 day'));
				// $nextFriday = date('Y-m-d', strtotime($day . ' +7 day'));
				// break;
			// case 6:
				// $friday = date('Ymd', strtotime($day . ' -1 day')).'_00';
				// $friday2 = date('Y-m-d', strtotime($day . ' -1 day'));
				// $firstDayOfTheNextWeek = date('Y-m-d', strtotime($day . ' +2 day'));
				// $nextThursday = date('Y-m-d', strtotime($day . ' +5 day'));
				// $nextFriday = date('Y-m-d', strtotime($day . ' +6 day'));
				// break;
			// case 0:
				// $friday = date('Ymd', strtotime($day . ' -2 day')).'_00';
				// $friday2 = date('Y-m-d', strtotime($day . ' -2 day'));
				// $firstDayOfTheNextWeek = date('Y-m-d', strtotime($day . ' +1 day'));
				// $nextThursday = date('Y-m-d', strtotime($day . ' +4 day'));
				// $nextFriday = date('Y-m-d', strtotime($day . ' +5 day'));
				// break;

		// }		
		
		// $sql = "(SELECT date(time), min(value), max(value) FROM transparency.load_forecast_weekly WHERE DATUMVREME='".$friday."' 
					// AND DATE(time)>='".$firstDayOfTheNextWeek."' AND  DATE(time)<='".$nextThursday."'   GROUP BY DATE(TIME) ORDER BY TIME)
				// UNION ALL
				// (SELECT date(time), min(value), max(value) FROM transparency.load_forecast_weekly WHERE DATUMVREME='".$datumSedmice."'
					// AND DATE(time)>='".$friday2."'  AND  DATE(time)<='".$lastDayOfTheWeek."'   GROUP BY DATE(TIME) ORDER BY TIME)";
					
		// $res = $conn->query($sql);
		// while($r = mysqli_fetch_assoc($res)) {
			// $data[] = $r;
		// }	 
		
		// $data[4]['date(time)'] = $nextFriday;
		// $data[5]['date(time)'] = date('Y-m-d', strtotime($nextFriday . ' +1 day'));
		// $data[6]['date(time)'] = date('Y-m-d', strtotime($nextFriday . ' +2 day'));
				
	// } else { // A OVAJ QUERY SE UZIMA KADA SU IZASLI KONACNI REZULTATI ZA TEKUCU NEDELJU, A REZULTATE ZA SL.NEDELJU JOS NEMAMO(IZACI CE U PETAK - TO JE SLUCAJ KADA JE ISPUNJEN USLOV GORE)
		// $sql ="SELECT date(time), min(value), max(value) FROM load_forecast_weekly WHERE DATUMVREME='".$datumSedmice."' AND date(time)>='".$firstDayOfTheWeek."' AND date(time)<='".$lastDayOfTheWeek."' GROUP BY DATE(TIME) ORDER BY TIME";
		
		// $res = $conn->query($sql);
		// while($r = mysqli_fetch_assoc($res)) {
			// $data[] = $r;
		// }
	// }
	
	
	
	
	
	


	
	
	if (is_array($data)) {
		array_walk_recursive($data, function (&$item, $key) {
			$item = null === $item ? '' : $item;
		});
	}	

	//	header("content-type: application/json"); 
	echo json_encode($data, JSON_NUMERIC_CHECK);
	
?>