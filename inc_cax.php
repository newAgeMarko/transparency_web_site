<div id="tabs">
	<ul>
		<li><a href="#tabs-1"><?php echo $tabs_tabela__;?></a></li>
		<li><a href="#tabs-2"><?php echo $tabs_xml__;?></a></li>
		<li><a href="#tabs-3"><span class='download'><?php echo $tabs_preuzimanje__;?></span></a></li>
	</ul>
	<div id="tabs-1">
		<?php if ($totalRows_recSetFilter > 0 ) { // Show if recordset not empty ?>
		<table id="box-table-a">
		<thead>
		<tr>
			<th colspan = "2"><?php echo $smer__;?></th>
			<!--<th></th>-->
			<th>H01 MW</th>
			<th>H02 MW</th>
			<th>H03 MW</th>
			<th>H04 MW</th>
			<th>H05 MW</th>
			<th>H06 MW</th>
			<th>H07 MW</th>
			<th>H08 MW</th>
			<th>H09 MW</th>
			<th>H10 MW</th>
			<th>H11 MW</th>
			<th>H12 MW</th>
			<th>H13 MW</th>
			<th>H14 MW</th>
			<th>H15 MW</th>
			<th>H16 MW</th>
			<th>H17 MW</th>
			<th>H18 MW</th>
			<th>H19 MW</th>
			<th>H20 MW</th>
			<th>H21 MW</th>
			<th>H22 MW</th>
			<th>H23 MW</th>
			<th>H24 MW</th>
		</tr>
		</thead>
		<tbody>
			<?php do { ?>
			<tr>
				<?php switch ($row_recSetFilter['OUTAREA']){
					case '10YCS-CG-TSO---S':
					$out = $smer_skraceno01;
					break;
					case '10YBA-JPCC-----D':
					$out = $smer_skraceno02;
					break;
					case '10YMK-MEPSO----8':
					$out = $smer_skraceno03;
					break;
					case '10YRO-TEL------P':
					$out = $smer_skraceno04;
					break;
					case '10YHU-MAVIR----U':
					$out = $smer_skraceno05;
					break;
					case '10YAL-KESH-----5':
					$out = $smer_skraceno06;
					break;
					case '10YCS-SERBIATSOV':
					$out = $smer_skraceno07;
					break;
					case '10YHR-HEP------M':
					$out = $smer_skraceno08;
					break;
					case '10YCA-BULGARIA-R':
					$out = $smer_skraceno09;
					break;
					case '10YGR-HTSO-----Y':
					$out = $smer_skraceno10;
					break;
					default:
					$out = 'problem!';
					}
				?>
				<?php switch ($row_recSetFilter['INAREA']){
					case '10YCS-CG-TSO---S':
					$in = $smer_skraceno01;
					break;
					case '10YBA-JPCC-----D':
					$in = $smer_skraceno02;
					break;
					case '10YMK-MEPSO----8':
					$in = $smer_skraceno03;
					break;
					case '10YRO-TEL------P':
					$in = $smer_skraceno04;
					break;
					case '10YHU-MAVIR----U':
					$in = $smer_skraceno05;
					break;
					case '10YAL-KESH-----5':
					$in = $smer_skraceno06;
					break;
					case '10YCS-SERBIATSOV':
					$in = $smer_skraceno07;
					break;
					case '10YHR-HEP------M':
					$in = $smer_skraceno08;
					break;
					case '10YCA-BULGARIA-R':
					$in = $smer_skraceno09;
					break;
					case '10YGR-HTSO-----Y':
					$in = $smer_skraceno10;
					break;
					default:
					$in = 'problem!';
					}
				?>
				<td align="right"><span id="box-table-a-left"><?php echo $out; ?></span></td>
				<td align="left"> <span id="box-table-a-left"><?php echo $in; ?></span></td>
				<td><?php echo $row_recSetFilter['H01']; ?></td>
				<td><?php echo $row_recSetFilter['H02']; ?></td>
				<td><?php echo $row_recSetFilter['H03']; ?></td>
				<td><?php echo $row_recSetFilter['H04']; ?></td>
				<td><?php echo $row_recSetFilter['H05']; ?></td>
				<td><?php echo $row_recSetFilter['H06']; ?></td>
				<td><?php echo $row_recSetFilter['H07']; ?></td>
				<td><?php echo $row_recSetFilter['H08']; ?></td>
				<td><?php echo $row_recSetFilter['H09']; ?></td>
				<td><?php echo $row_recSetFilter['H10']; ?></td>
				<td><?php echo $row_recSetFilter['H11']; ?></td>
				<td><?php echo $row_recSetFilter['H12']; ?></td>
				<td><?php echo $row_recSetFilter['H13']; ?></td>
				<td><?php echo $row_recSetFilter['H14']; ?></td>
				<td><?php echo $row_recSetFilter['H15']; ?></td>
				<td><?php echo $row_recSetFilter['H16']; ?></td>
				<td><?php echo $row_recSetFilter['H17']; ?></td>
				<td><?php echo $row_recSetFilter['H18']; ?></td>
				<td><?php echo $row_recSetFilter['H19']; ?></td>
				<td><?php echo $row_recSetFilter['H20']; ?></td>
				<td><?php echo $row_recSetFilter['H21']; ?></td>
				<td><?php echo $row_recSetFilter['H22']; ?></td>
				<td><?php echo $row_recSetFilter['H23']; ?></td>
				<td><?php echo $row_recSetFilter['H24']; ?></td>
			</tr>		
			<?php } while ($row_recSetFilter = mysql_fetch_assoc($recSetFilter)); ?>	
		</tbody>     
		</table>
		<?php } // Show if recordset not empty
		else { // Show if recordset is empty ?>
			<p><?php echo $podaci_nedostupni;?></p>
		<?php } // Show if recordset is empty ?>
	</div>
	
	
	<div id="tabs-2">
		<div id="xmlview">
		<p>
		<?php
		$recSetFilter = mysql_query($query_recSetFilter, $baza) or die(mysql_error());
		if ($totalRows_recSetFilter != 0) {
			$_xmlview ="&lt?xml version=\"1.0\" encoding=\"UTF-8\" ?&gt \n";
			$_xmlview .="&ltCross-BorderCommercialSchedules&gt \n";
			$_xmlview .="\t&ltDate v=\"<span class='xmlviewvalue'>" . $varDatum_recSetFilter . "</span>\" /&gt \n";
			while ($rowview = mysql_fetch_assoc($recSetFilter)) {
			switch ($rowview['OUTAREA']){
					case '10YCS-CG-TSO---S':$out = 'ME';break;
					case '10YBA-JPCC-----D':$out = 'BA';break;
					case '10YMK-MEPSO----8':$out = 'MK';break;
					case '10YRO-TEL------P':$out = 'RO';break;
					case '10YHU-MAVIR----U':$out = 'HU';break;
					case '10YAL-KESH-----5':$out = 'AL';break;
					case '10YCS-SERBIATSOV':$out = 'RS';break;
					case '10YHR-HEP------M':$out = 'HR';break;
					case '10YCA-BULGARIA-R':$out = 'BG';break;
					case '10YGR-HTSO-----Y':$out = 'GR';break;
					default:$out = 'problem!';
					}
				switch ($rowview['INAREA']){
					case '10YCS-CG-TSO---S':$in = 'ME';break;
					case '10YBA-JPCC-----D':$in = 'BA';break;
					case '10YMK-MEPSO----8':$in = 'MK';break;
					case '10YRO-TEL------P':$in = 'RO';break;
					case '10YHU-MAVIR----U':$in = 'HU';break;
					case '10YAL-KESH-----5':$in = 'AL';break;
					case '10YCS-SERBIATSOV':$in = 'RS';break;
					case '10YHR-HEP------M':$in = 'HR';break;
					case '10YCA-BULGARIA-R':$in = 'BG';break;
					case '10YGR-HTSO-----Y':$in = 'GR';break;
					default:$in = 'problem!';
					}
				$_xmlview .="\t&ltDirection&gt \n";
				$_xmlview .="\t\t&ltIn v=\"<span class='xmlviewvalue'>" . $in . "</span>\" /&gt \n";
				$_xmlview .="\t\t&ltOut v=\"<span class='xmlviewvalue'>" . $out . "</span>\" /&gt \n";
				$_xmlview .="\t\t&ltMeasurementUnit v=\"<span class='xmlviewvalue'>MW</span>\" /&gt \n";
				$_xmlview .="\t\t&ltPeriod&gt \n";
				$_xmlview .="\t\t\t&ltDate v=\"<span class='xmlviewvalue'>" .$varDatum_recSetFilter. "</span>\" /&gt \n";
				$_xmlview .="\t\t\t&ltResolution v=\"<span class='xmlviewvalue'>1H</span>\" /&gt \n";
				for ($i = 1; $i <= 24; $i++) {
					$_xmlview .="\t\t\t&ltInterval&gt \n";
					$_xmlview .="\t\t\t\t&ltHour v=\"<span class='xmlviewvalue'>" . $i . "</span>\" /&gt \n";
					if ($i < 10){ 
						$temp="H0".$i;}
					else{
						$temp="H".$i;}
					$_xmlview .="\t\t\t\t&ltQuantity v=\"<span class='xmlviewvalue'>" . $rowview[$temp] . "</span>\" /&gt \n";	
					$_xmlview .="\t\t\t&lt/Interval&gt \n";
				}
				$_xmlview .="\t\t&lt/Period&gt \n";				
				$_xmlview .="\t&lt/Direction&gt \n";
			}			
			$_xmlview .="&lt/Cross-BorderCommercialSchedules&gt";
			echo '<pre>';//iskoristiti za divove po segmentima xml-a!!!
			echo $_xmlview;
			echo '</pre>';
		} 
		else {
			echo "--------------------";
		}		
		?>
		</p>
		</div>
	</div>
	
			
	<div id="tabs-3">
		<p>
			<img src="pics/xmlpic.png" width="190" height="40" alt="" border='0'/>
		</p>
		<p>
		<?php
		$recSetFilter = mysql_query($query_recSetFilter, $baza) or die(mysql_error());
		$filename = "download/cax/xml_export".$varDatum_recSetFilter.".xml";
		if (!file_exists($filename)) {
		if ($totalRows_recSetFilter != 0) {
			$file= fopen("download/cax/xml_export".$varDatum_recSetFilter.".xml", "w");
			$_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";
			$_xml .="<Cross-BorderCommercialSchedules>\r\n";
			$_xml .="\t<Date v=\"" . $varDatum_recSetFilter . "\" />\r\n";
			while ($row = mysql_fetch_assoc($recSetFilter)) {
				switch ($row['OUTAREA']){
					case '10YCS-CG-TSO---S':$out = 'ME';break;
					case '10YBA-JPCC-----D':$out = 'BA';break;
					case '10YMK-MEPSO----8':$out = 'MK';break;
					case '10YRO-TEL------P':$out = 'RO';break;
					case '10YHU-MAVIR----U':$out = 'HU';break;
					case '10YAL-KESH-----5':$out = 'AL';break;
					case '10YCS-SERBIATSOV':$out = 'RS';break;
					case '10YHR-HEP------M':$out = 'HR';break;
					case '10YCA-BULGARIA-R':$out = 'BG';break;
					case '10YGR-HTSO-----Y':$out = 'GR';break;
					default:$out = 'problem!';
					}
				switch ($row['INAREA']){
					case '10YCS-CG-TSO---S':$in = 'ME';break;
					case '10YBA-JPCC-----D':$in = 'BA';break;
					case '10YMK-MEPSO----8':$in = 'MK';break;
					case '10YRO-TEL------P':$in = 'RO';break;
					case '10YHU-MAVIR----U':$in = 'HU';break;
					case '10YAL-KESH-----5':$in = 'AL';break;
					case '10YCS-SERBIATSOV':$in = 'RS';break;
					case '10YHR-HEP------M':$in = 'HR';break;
					case '10YCA-BULGARIA-R':$in = 'BG';break;
					case '10YGR-HTSO-----Y':$in = 'GR';break;
					default:$in = 'problem!';
					}
			if ($row["DATETIME"]) {
				$_xml .="\t<Direction>\r\n";
				$_xml .="\t\t<In v=\"" . $in . "\" />\r\n";
				$_xml .="\t\t<Out v=\"" . $out . "\" />\r\n";
				$_xml .="\t\t<MeasurementUnit v=\"MW\" />\r\n";
				$_xml .="\t\t<Period>\r\n";
				$_xml .="\t\t\t<Date v=\"" .$varDatum_recSetFilter. "\" />\r\n";
				$_xml .="\t\t\t<Resolution v=\"1H\" />\r\n";
				for ($i = 1; $i <= 24; $i++) {
					$_xml .="\t\t\t<Interval>\r\n";
					$_xml .="\t\t\t\t<Hour v=\"" . $i . "\" />\r\n";
					if ($i < 10){ 
						$temp="H0".$i;}
					else{
						$temp="H".$i;}
					$_xml .="\t\t\t\t<Quantity v=\"" . $row[$temp] . "\" />\r\n";	
					$_xml .="\t\t\t</Interval>\r\n";
				}
				$_xml .="\t\t</Period>\r\n";				
				$_xml .="\t</Direction>\r\n";
				} 
			else {
				$_xml .="\t<DATE TIME=\"Nothing Returned\">\r\n";
				$_xml .="\t\t<OUTAREA>none</OUTAREA>\r\n";
				$_xml .="\t</DATE>\r\n"; 
				} 
			}			
			$_xml .="</Cross-BorderCommercialSchedules>";
			fwrite($file, $_xml);
			fclose($file);
			echo "XML :  <a href=\"download/cax/xml_export".$varDatum_recSetFilter.".xml\"><span class='download'>$tabs_preuzimanje__ $desni_klik__</span></a>";
		} 
		else {
			echo $podaci_nedostupni;
		}
		}
		else {
			echo "XML :  <a href=\"download/cax/xml_export".$varDatum_recSetFilter.".xml\"><span class='download'>$tabs_preuzimanje__ $desni_klik__</span></a>";
		}
				
		?>
		</p>

		<br />
		<br />
		<p>
			<img src="pics/csvpic.png" width="190" height="40" alt="" border='0'/>
		</p>
		<p>
		<?php		
		$recSetFilter = mysql_query($query_recSetFilter, $baza) or die(mysql_error());
		$filename = "download/cax/csv/csv_export".$varDatum_recSetFilter.".csv";
		if (!file_exists($filename)){	
			if ($totalRows_recSetFilter != 0){
				$datoteka = fopen("download/cax/csv/csv_export".$varDatum_recSetFilter.".csv","w");
				$naslov = array("date","from","to","H01","H02","H03","H04","H05","H06","H07","H08","H09","H10","H11","H12","H13","H14","H15","H16","H17","H18","H19","H20","H21","H22","H23","H24");
				fputcsv($datoteka,$naslov);
				while ($red = mysql_fetch_assoc($recSetFilter)){
					switch ($red['OUTAREA']){
						case '10YCS-CG-TSO---S':$red['OUTAREA'] = 'ME';break;
						case '10YBA-JPCC-----D':$red['OUTAREA'] = 'BA';break;
						case '10YMK-MEPSO----8':$red['OUTAREA'] = 'MK';break;
						case '10YRO-TEL------P':$red['OUTAREA'] = 'RO';break;
						case '10YHU-MAVIR----U':$red['OUTAREA'] = 'HU';break;
						case '10YAL-KESH-----5':$red['OUTAREA'] = 'AL';break;
						case '10YCS-SERBIATSOV':$red['OUTAREA'] = 'RS';break;
						case '10YHR-HEP------M':$red['OUTAREA'] = 'HR';break;
						case '10YCA-BULGARIA-R':$red['OUTAREA'] = 'BG';break;
						case '10YGR-HTSO-----Y':$red['OUTAREA'] = 'GR';break;
						default:$red['OUTAREA'] = 'out -problem!';
						}
					switch ($red['INAREA']){
						case '10YCS-CG-TSO---S':$red['INAREA'] = 'ME';break;
						case '10YBA-JPCC-----D':$red['INAREA'] = 'BA';break;
						case '10YMK-MEPSO----8':$red['INAREA'] = 'MK';break;
						case '10YRO-TEL------P':$red['INAREA'] = 'RO';break;
						case '10YHU-MAVIR----U':$red['INAREA'] = 'HU';break;
						case '10YAL-KESH-----5':$red['INAREA'] = 'AL';break;
						case '10YCS-SERBIATSOV':$red['INAREA'] = 'RS';break;
						case '10YHR-HEP------M':$red['INAREA'] = 'HR';break;
						case '10YCA-BULGARIA-R':$red['INAREA'] = 'BG';break;
						case '10YGR-HTSO-----Y':$red['INAREA'] = 'GR';break;
						default:$red['INAREA'] = 'in -problem!';
						}
					unset($red['DATETIME']);
					unset($red['SENDER']);
					unset($red['VER']);
					fputcsv($datoteka,$red);
				}
				fclose($datoteka);
				echo "CSV :  <a href=\"download/cax/csv/csv_export".$varDatum_recSetFilter.".csv\"><span class='download'>$tabs_preuzimanje__</span></a>";
			} 
			else{
				echo $podaci_nedostupni;
			}
		}
		else{
			echo "CSV :  <a href=\"download/cax/csv/csv_export".$varDatum_recSetFilter.".csv\"><span class='download'>$tabs_preuzimanje__</span></a>";
		}		
		?>
		</p>
		
		<br />
		<br />
		<p>
			<img src="pics/jsonpic.png" width="190" height="40" alt="" border='0'/>
		</p>
		<p>
		<?php		
		if (file_exists($filename)){
			$datoteka = fopen($filename,"r");
			$niz = array ();
			while(($linija=fgetcsv($datoteka,0,","))!==false){
				$niz[]=$linija;
			}
			$json_vrednosti = json_encode($niz);
			file_put_contents("download/cax/json/json_export".$varDatum_recSetFilter.".json",$json_vrednosti);
			echo "JSON :  <a href=\"download/cax/json/json_export".$varDatum_recSetFilter.".json\"><span class='download'>$tabs_preuzimanje__</span></a>";
		}
		else{
			echo $podaci_nedostupni;
		}
		?>
		</p>
	</div>
</div>