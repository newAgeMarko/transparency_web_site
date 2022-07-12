<?php

 function ConvertMonthsToNumbers($mon) {
		switch ($mon) {
		case 'Јануар':
			$english_month = 'January';
			break;
		case 'Фебруар':
			$english_month = 'February';
			break;
		case 'Март':
			$english_month = 'March';
			break;
		case 'Април':
			$english_month = 'April';
			break;
		case 'Мај':
			$english_month = 'May';
			break;
		case 'Јун':
			$english_month = 'June';
			break;
		case 'Јул':
			$english_month = 'July';
			break;
		case 'Август':
			$english_month = 'August';
			break;
		case 'Септембар':
			$english_month = 'September';
			break;
		case 'Октобар':
			$english_month = 'October';
			break;
		case 'Новембар':
			$english_month = 'November';
			break;
		case 'Децембар':
			$english_month = 'December';
			break;
			
		}
		
		return $english_month;
	}
 
?>