<?php
	ini_set('display_errors', '1');
	$lng = (isset($_GET['lng']) && !empty($_GET['lng'])) ? $_GET['lng'] : "lat";
	include 'lng.php';
?>
<!DOCTYPE html>
<html lang="sr">
<head>
	<meta charset="utf-8">
	<title><?= _TITLE ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= _TITLE ?>">
	
	<script type="text/javascript" src="../common/jquery/jquery-1.11.1.min.js"></script> 
	<script type="text/javascript" src="../common/tables/datatables.js"></script> 

	<link rel="stylesheet" type="text/css" href="../common/tables/datatables.css"/>
	<link rel="stylesheet" type="text/css" href="./css/style.css"/>
	<style media="all" type="text/css">
		.sText { font-size: 88%; }
	</style>

</head>
<body> 
<div style="width:860px;">
	<h1><?= _H1 ?></h1>
	<table id="results" class="cell-border stripe" style="width:100%">
		<thead>
			<tr>
				<th><?= _DATE ?></th>
				<th><?= _IDENTIFICATION ?></th>
				<th><?= _NAME ?></th>
				<th><?= _ENERGY_LOT ?> [MWh]</th>
				<th><?= _PURCHASED_QUANTITY ?> [MWh]</th>
				<th><?= _SOLD_QUANTITY ?> [MWh]</th>
				<th><?= _BID_PRICE ?> [EUR/MWh]</th>
			</tr>
		</thead>
	</table>
</div>

<script>
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
"date-sr-pre": function ( a ) {
    var ukDatea = a.split('.');
    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
},

"date-sr-asc": function ( a, b ) {
    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
},

"date-sr-desc": function ( a, b ) {
    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
}
} );


var table;
	
table = $('#results').dataTable({
	"processing": true,
	"autoWidth": false,
	"lengthMenu": [ 10, 25, 50 ],
    "sAjaxSource": "../../sap_sourcing/getdata_compensation.php",
    "aoColumns": [
        { mData: 'BID_DATE', className: 'dt-left sText', sWidth: '80px', sType: 'date-sr'},
        { mData: 'UNIQUE_DOC_NAME', className: 'dt-left sText'},
        { mData: 'DISPLAY_NAME', className: 'dt-left sText' },
        { mData: 'ENERGY_LOT', className: 'dt-right sText', sWidth: '60px'},
        { mData: 'PURCHASED_QUANTITY', className: 'dt-right sText', sWidth: '80px'},
        { mData: 'SOLD_QUANTITY', className: 'dt-right sText', sWidth: '80px'},
        { mData: 'BID_PRICE', className: 'dt-right sText', sWidth: '50px' }
    ]
<?php 
	if ($lng!="eng") {
?>		
		,"language": {
            "lengthMenu": "<?= _LENGHT_MENU ?>",
            "zeroRecords": "<?= _ZERO_RECORDS ?>",
            "info": "<?= _INFO ?>",
            "infoEmpty": "<?= _INFO_EMPTY ?>",
			"search": "<?= _SEARCH ?>",
			"infoFiltered": "<?= _INFO_FILTERED ?>",
			"processing": "<?= _PROCESSING ?>",
			"paginate": {
				"first": "<?= _FIRST ?>",
				"last": "<?= _LAST ?>",
				"next": "<?= _NEXT ?>",
				"previous": "<?= _PREVIOUS ?>"
			}
        }
<?php 
	}
?>		
});  

</script>	

</body>
</html>