<?php
	ini_set('display_errors', '1');
	include '../../lang.php';
	//include 'db.php';
ob_end_clean();
	(isset($_GET['month']) && !empty($_GET['month'])) or die ("Month not defined!");	
	(isset($_GET['format']) && !empty($_GET['format'])) or die ("Format not defined!");
	
	$month = $_GET['month'];	
	$format = $_GET['format'];
	// $month_to = (isset($_GET['month_to']) && !empty($_GET['month_to'])) ? $_GET['month_to'] : $month;
	// $year = $_GET['year'];
	// $year_to = (isset($_GET['year_to']) && !empty($_GET['year_to'])) ? $_GET['year_to'] : $year;	
	// $download = (isset($_GET['download']) && !empty($_GET['download'])) ? $_GET['download'] : FALSE;
	// $filename = (isset($_GET['filename']) && !empty($_GET['filename'])) ? $_GET['filename'] : "download." . strtolower($format);
	// $decimal = (isset($_GET['decimal']) && !empty($_GET['decimal'])) ? $_GET['decimal'] : ".";



	$monthString = explode(" ", $month)[0];
	$yearString = explode(" ", $month)[1];
	if ($lang == 'rs') {
		switch ($monthString) {
			case 'Јануар':
				$month = 'January '.$yearString;
				break;
			case 'Март':
				$month = 'March '.$yearString;
				break;
			case 'Април':
				$month = 'April '.$yearString;
				break;
			case 'Мај':
				$month = 'May '.$yearString;
				break;
			case 'Јун':
				$month = 'June '.$yearString;
				break;
			case 'Јул':
				$month = 'July '.$yearString;
				break;
			case 'Август':
				$month = 'August '.$yearString;
				break;
			case 'Септембар':
				$month = 'September '.$yearString;
				break;
			case 'Октобар':
				$month = 'October '.$yearString;
				break;
			case 'Новембар':
				$month = 'November '.$yearString;
				break;
			case 'Децембар':
				$month = 'December '.$yearString;
				break;
			default:
				$month = 'February '.$yearString;
				break;
		}	
	} 
	
	
	$m = new DateTime($month);
	// prvi ponedeljak u datom mesecu
    $firstMondayOfTheMonth = $m->modify('first monday')->format('Y-m-d');

	// poslednji datum u datom mesecu
	$lastDayOfTheMonth = date('Y-m-t', strtotime($month)); 
	


function curlGetPageContent($path,$auth = '') {

    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_USERPWD => $auth,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $path,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_FOLLOWLOCATION => true
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    if(curl_errno($curl)){
        $result = 'Error';

    } else {
        // check the HTTP status code of the request
        $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($resultStatus == 200) {
            // everything went better than expected
            $result = $resp;
        } else {
            // the request did not complete as expected. common errors are 4xx
            // (not found, bad request, etc.) and 5xx (usually concerning
            // errors/exceptions in the remote script execution)
            $result = $resultStatus;
        }
    }
    // Close request to clear up some resources
    curl_close($curl);

    return $result;
}
$api_path = "https://transparency.entsoe.eu/api?securityToken=40b2e8f8-4cb7-498c-90a2-da96e735572b&documentType=A65&processType=A32&outBiddingZone_Domain=10YCS-SERBIATSOV&TimeInterval=$firstMondayOfTheMonth/$lastDayOfTheMonth";
$get_xml = curlGetPageContent($api_path);

$xml_to_json = json_encode((array)simplexml_load_string($get_xml));

$movies = new SimpleXMLElement($get_xml);




	switch ($format) {
		case "XML":
			header('Content-Disposition: attachment; filename="LOAD_MONTHLY.xml"');
			header('Content-type: text/xml'); 

			echo $get_xml;			
        break;
    	case "JSON": 
			header('Content-Disposition: attachment; filename="LOAD_MONTHLY.json"');
			header('Content-type: text/json'); 

			echo $xml_to_json;	
        break;
    
	}

	
	