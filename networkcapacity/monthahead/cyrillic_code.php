<?php

 function ConvertMonthsToNumbers($mon) {
		switch ($mon[0]) {
		case 'Јануар':
			$number_month = '01';
			break;
		case 'Фебруар':
			$number_month = '02';
			break;
		case 'Март':
			$number_month = '03';
			break;
		case 'Април':
			$number_month = '04';
			break;
		case 'Мај':
			$number_month = '05';
			break;
		case 'Јун':
			$number_month = '06';
			break;
		case 'Јул':
			$number_month = '07';
			break;
		case 'Август':
			$number_month = '08';
			break;
		case 'Септембар':
			$number_month = '09';
			break;
		case 'Октобар':
			$number_month = '10';
			break;
		case 'Новембар':
			$number_month = '11';
			break;
		case 'Децембар':
			$number_month = '12';
			break;
			
		}
		
		return $number_month;
	}
 
?>