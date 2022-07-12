<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $timeout = 20;
	$postArray = array();
	foreach ($_GET as $key => $value) { 
		if ($key != 'url') {
			$postArray[$key] = $value;	
		}
	}
    $ch = curl_init();
	$ch_config = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POSTFIELDS => $postArray
    );
    curl_setopt_array($ch, $ch_config);
    $data = curl_exec($ch);
    curl_close($ch);
    echo $data;
}