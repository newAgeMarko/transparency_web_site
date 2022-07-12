<?php

	ini_set('display_errors', '1');
	//include '../../lang.php';
	//include 'cyrillic_code.php';
	

	(isset($_REQUEST['month']) && !empty($_REQUEST['month'])) or die ("Month is missing!");
	$month = $_REQUEST['month'];

	// $monthString = explode(" ", $month)[0];
	// $yearString = explode(" ", $month)[1];
	// if ($lang == 'rs') {
		// $monthString = ConvertMonthsToNumbers($monthString);
		// $month = $monthString.' '.$yearString;
	// } 
	
	
	// $m = new DateTime($month);
//	prvi ponedeljak u datom mesecu
    // $firstMondayOfTheMonth = $m->modify('first monday')->format('Y-m-d');

//	poslednji datum u datom mesecu
	// $lastDayOfTheMonth = date('Y-m-t', strtotime($month));


 

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
$api_path = "https://transparency.entsoe.eu/api?securityToken=40b2e8f8-4cb7-498c-90a2-da96e735572b&documentType=A65&processType=A32&outBiddingZone_Domain=10YCS-SERBIATSOV&TimeInterval=2020-3-2/2020-3-31";
$get_xml = curlGetPageContent($api_path);

$xml_to_json = json_encode((array)simplexml_load_string($get_xml));

header( "Content-type: application/json" );
echo $xml_to_json;


?>