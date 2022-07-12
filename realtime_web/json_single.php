<?php 

$servername = "192.168.25.33";
$username = "IMP";
$password = "IMP28022017@.";
$dbname = "transparency";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if (empty($_GET["data"])) {
    $nameErr = "Name is required";
} 
else {
    switch ($_GET["data"]) {
    case "KONZUM":
        $d = "KONZUM.MER";
        break;
    case "ACE":
        $d = "SMM.ACE_SSK";
        break;
    case "HU":
        $d = "SMM.SRB_HUN.R.WEB";
        break;
    case "RO":
        $d = "SMM.SRB_RUM.R.WEB";
        break;
    case "BG":
        $d = "SMM.SRB_BUG.R.WEB";
        break;
    case "MK":
        $d = "SMM.SRB_MAK.R.WEB";
        break;
    case "AL":
        $d = "SMM.SRB_ALB.R.WEB";
        break;
    case "CG":
        $d = "SMM.SRB_CG.R.WEB";
        break;
    case "BH":
        $d = "SMM.SRB_BIH.R.WEB";
        break;
    case "HR":
        $d = "SMM.SRB_HRV.R.WEB";
        break;
    default:
        $nameErr = "Name is invalid";
	}
}

$sql = "SELECT DATE_FORMAT(FROM_UNIXTIME(time), '%k') AS H, DATE_FORMAT(FROM_UNIXTIME(time), '%i') AS M, DATE_FORMAT(FROM_UNIXTIME(time), '%s') AS S, value FROM realtime_web WHERE DATE(FROM_UNIXTIME(time)) = DATE(NOW()) AND keyn='" . $d . "' ORDER BY time DESC LIMIT 1";
$res = $conn->query($sql);
$r = $res->fetch_array();


// Set the JSON header
header("Content-type: text/json");

$rows = array($r['H']*60*60*1000+$r['M']*60*1000+$r['S']*1000 , $r['value']);

// Create a PHP array and echo it as JSON
echo json_encode($rows, JSON_NUMERIC_CHECK);
?>