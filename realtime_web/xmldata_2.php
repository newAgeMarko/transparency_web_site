<?php

$servername = "192.168.25.33";
$username = "IMP";
$password = "IMP28022017@.";
$dbname = "transparency";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

date_default_timezone_set("Europe/Belgrade");

$brds = array("HU","RO","BG","MK","AL","CG","BH","HR");
$keys = array("KONZUM.MER","KONZUM.SRB","SMM.ACE_SSK","SMM.SRB.ACE","SMM.SRB_HUN.R.WEB","SMM.SRB_RUM.R.WEB","SMM.SRB_BUG.R.WEB","SMM.SRB_MAK.R.WEB","SMM.SRB_ALB.R.WEB","SMM.SRB_CG.R.WEB","SMM.SRB_BIH.R.WEB","SMM.SRB_HRV.R.WEB");

$sql = "SELECT time FROM realtime_web ORDER BY time DESC LIMIT 1";
$res = $conn->query($sql);
$row = $res->fetch_array();
$time = $row['time']; 
$vals = array();

for($x = 0; $x < count($keys); $x++) {
	$sql = "SELECT value FROM realtime_web WHERE keyn='" . $keys[$x] . "' AND time=" . $time;
	$res = $conn->query($sql);
	$row = $res->fetch_array();
	$vals[] = $row['value'];
}

$xml = new XMLWriter();

$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

$xml->startElement('real_time_data');
	$xml->startElement("date");
		$xml->writeRaw(date("d.m.Y.", $time));
	$xml->endElement();
	$xml->startElement("time");
		$xml->writeRaw(date("H:i:s", $time));
	$xml->endElement();
	$xml->startElement("load");
		$xml->writeRaw($vals[0]);
	$xml->endElement();
	$xml->startElement("load_ems");
		$xml->writeRaw($vals[1]);
	$xml->endElement();
	$xml->startElement("ace");
		$xml->writeRaw($vals[2]);
	$xml->endElement();
	$xml->startElement("ace_ems");
		$xml->writeRaw($vals[3]);
	$xml->endElement();
	$xml->startElement("borders");
	for($x = 0; $x < count($brds); $x++) {
		$xml->startElement("border");
			$xml->writeAttribute('id', $brds[$x]);
			$xml->writeRaw($vals[$x+4]);
		$xml->endElement();
	}
	$xml->endElement();
$xml->endElement();

header('Content-type: text/xml');
$xml->flush();
?>