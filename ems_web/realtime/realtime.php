<?php
	ini_set('display_errors', '1');
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "cir";
	$loader = (isset($_GET['loader']) && !empty($_GET['loader'])) ? $_GET['loader'] : 0;
	$time = (isset($_GET['time']) && !empty($_GET['time'])) ? $_GET['time'] : 60;
	$prnt = (isset($_GET['p']) && !empty($_GET['p'])) ? $_GET['p'] : "ems.rs";
	if ($time < 10) { $time = 10; }
//	include 'lng.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>EMS - Real time data</title>
<META charset="UTF-8"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<?php
	if ($prnt == "ems.rs") {
		echo '<link rel="stylesheet" href="./css/style.ems.rs.css">';
	}
	else {
		echo '<link rel="stylesheet" href="./css/style.transparency.css">';
	}
?>
<script>

var granica = ["HU", "RO", "BG", "MK", "AL", "CG", "BH", "HR"]; 
var c_granica = ["Мађарска", "Румунија", "Бугарска", "Северна Македонија", "Албанија", "Црна Гора", "Босна и Херцеговина", "Хрватска"]; 
var l_granica = ["Mađarska", "Rumunija", "Bugarska", "Severna Makedonija", "Albanija", "Crna Gora", "Bosna i Hercegovina", "Hrvatska"]; 
var e_granica = ["Hungary", "Romania", "Bulgaria", "North Macedonia", "Albania", "Montenegro", "Bosnia and Herzegovina", "Croatia"]; 
var c_lbl = ["Србија - Регулациона грешка","Потрошња у ЕЕС Србије","Ажурирано: "," у ","ЕМС - Регулациона грешка","Потрошња регулационе области ЕМС","Фреквенција"];
var l_lbl = ["Srbija - Regulaciona greška","Potrošnja u EES Srbije","Ažurirano: "," u ","EMS - Regulaciona greška","Potrošnja regulacione oblasti EMS","Frekvencija"];
var e_lbl = ["Serbia - Area Control Error","Load of Serbian Power System","Last update: "," ","EMS - Area Control Error", "Load of EMS CA", "Frequency"];
var lng;
var txt_lbl;

function init() {

 	var params = {};

	var query = window.location.search.substring(1).split("&");
	for (var i = 0, max = query.length; i < max; i++)
	{
		if (query[i] === "") continue;
		var param = query[i].split("=");
		params[decodeURIComponent(param[0])] = decodeURIComponent(param[1] || "");
	}

    lng = '<?= $lng ?>';
	lng = lng.substring(0, 1);
	time = <?= $time ?>;
	loader = <?= $loader ?>;
	
	var txt_granica = window[lng + "_granica"];
	txt_lbl = window[lng + "_lbl"];
	for (i = 0; i < granica.length; i++) {
	    document.getElementById(granica[i]+'_drzava').innerHTML = txt_granica[i]; 
	} 
	document.getElementById('reg_greska_lbl').innerHTML = txt_lbl[0]; 
	document.getElementById('reg_greska_EMS_lbl').innerHTML = txt_lbl[4]; 
	document.getElementById('potrosnja_lbl').innerHTML = txt_lbl[1]; 
	document.getElementById('potrosnja_lbl_ems').innerHTML = txt_lbl[5]; 
	document.getElementById('frekvenca_lbl').innerHTML = txt_lbl[6]; 
	document.getElementById('preload').style.display = 'block';
	loadData();
	if (time>0) window.setInterval(loadData, time*1000);

}

function loadData() {
	
	var xhttp;    
	if (window.XMLHttpRequest) {
		xhttp=new XMLHttpRequest();
	} else {  
		xhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
  
	xhttp.onreadystatechange = function() {
     	if (loader==1) document.getElementById('preload').style.display = 'block';
		if (this.readyState == 4 && this.status == 200) {
			dispData(this.responseText);
		}
	};
	
	xhttp.open("POST", "xmldata.php", true);
	xhttp.send();

}

function dispData(xml) {
 
	if (window.DOMParser) {
		parser=new DOMParser();
		xmlDoc = parser.parseFromString(xml,"text/xml");
	} else {
		xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async=false;
		xmlDoc.loadXML(xml);
	}

	var x, i, id, r;	
	x = xmlDoc.getElementsByTagName('border'); 
	for (i = 0; i < x.length; i++) {
	    id = x[i].getAttribute('id');
		r = x[i].childNodes[0].nodeValue;
		var strelica = (r<0) ? "url(css/strelica+.png)" : ((r>0) ? "url(css/strelica-.png)" : "url(css/strelica0.png)");
		document.getElementById(id+'_razmena').innerHTML = Math.abs(Math.round(r)) + " MW"; 
		document.getElementById(id+'_strelica').style.backgroundImage=strelica;  
    }
	document.getElementById('reg_greska').innerHTML = Math.round(xmlDoc.getElementsByTagName("ace")[0].childNodes[0].nodeValue) + " MW";
	document.getElementById('reg_greska_EMS').innerHTML = Math.round(xmlDoc.getElementsByTagName("ace_ems")[0].childNodes[0].nodeValue) + " MW";
	document.getElementById('potrosnja').innerHTML = Math.round(xmlDoc.getElementsByTagName("load")[0].childNodes[0].nodeValue) + " MW";
	document.getElementById('potrosnja_ems').innerHTML = Math.round(xmlDoc.getElementsByTagName("load_ems")[0].childNodes[0].nodeValue) + " MW";
	document.getElementById('frekvenca').innerHTML = xmlDoc.getElementsByTagName("freq")[0].childNodes[0].nodeValue + " Hz";
	document.getElementById('vreme').innerHTML = txt_lbl[2] + xmlDoc.getElementsByTagName("date")[0].childNodes[0].nodeValue + txt_lbl[3] + xmlDoc.getElementsByTagName("time")[0].childNodes[0].nodeValue;
    document.getElementById('preload').style.display = 'none';

}

</script>
</head>
<body onload="init();">

<div class="mapa">
	<div class="preload" id="preload"></div>
	<div class="granica HU">
		<div class="strelica" id="HU_strelica"></div>
		<div class="labela gore">
			<div class="podatak drzava" id="HU_drzava"></div>
			<div class="podatak razmena" id="HU_razmena"> </div>
		</div>
	</div>
	<div class="granica RO">
		<div class="strelica" id="RO_strelica"></div>
		<div class="labela desno">
			<div class="podatak drzava" id="RO_drzava"></div>
			<div class="podatak razmena" id="RO_razmena"></div>
		</div>
	</div>
	<div class="granica BG">
		<div class="strelica" id="BG_strelica"></div>
		<div class="labela desno">
			<div class="podatak drzava" id="BG_drzava"></div>
			<div class="podatak razmena" id="BG_razmena"></div>
		</div>
	</div>
	<div class="granica MK">
		<div class="strelica" id="MK_strelica"></div>
		<div class="labela dole">
			<div class="podatak drzava" id="MK_drzava"></div>
			<div class="podatak razmena" id="MK_razmena"></div>
		</div>
	</div>
	<div class="granica AL">
		<div class="strelica" id="AL_strelica"></div>
		<div class="labela levo">
			<div class="podatak drzava" id="AL_drzava"></div>
			<div class="podatak razmena" id="AL_razmena"></div>
		</div>
	</div>
	<div class="granica CG">
		<div class="strelica" id="CG_strelica"></div>
		<div class="labela levo">
			<div class="podatak drzava" id="CG_drzava"></div>
			<div class="podatak razmena" id="CG_razmena"></div>
		</div>
	</div>
	<div class="granica BH">
		<div class="strelica" id="BH_strelica"></div>
		<div class="labela levo">
			<div class="podatak drzava" id="BH_drzava"></div>
			<div class="podatak razmena" id="BH_razmena"></div>
		</div>
	</div>
	<div class="granica HR">
		<div class="strelica" id="HR_strelica"></div>
		<div class="labela levo">
			<div class="podatak drzava" id="HR_drzava"></div>
			<div class="podatak razmena" id="HR_razmena"></div>
		</div>
	</div>
    <div class="labela regulacija"> 
		    <div class="podatak naziv" id="reg_greska_lbl"></div>
			<div class="podatak razmena cw" id="reg_greska"></div>
			<div class="podatak naziv btop" id="reg_greska_EMS_lbl"></div>
			<div class="podatak razmena cw btop" id="reg_greska_EMS"></div>
			<div class="podatak naziv btop" id="potrosnja_lbl"></div>
			<div class="podatak razmena cw btop" id="potrosnja"></div>
			<div class="podatak naziv btop" id="potrosnja_lbl_ems"></div>
			<div class="podatak razmena cw btop" id="potrosnja_ems"></div>
			<div class="podatak naziv btop" id="frekvenca_lbl"></div>
			<div class="podatak razmena cw btop" id="frekvenca"></div>
	</div>
    <div class="vreme" id="vreme"></div>
</div>

</body>
</html> 