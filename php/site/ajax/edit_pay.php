<?php
$database = new SyncDatabase();
$payBankdate = '';
$payBankid = '';
if($_REQUEST['edit']=='view') {
	$payBank = $database->Query("SELECT * FROM bank_pay WHERE ticket_id=$_REQUEST[id] LIMIT 1;");
	$payBankid = $payBank['bank_id'];
	$payBankdate = $payBank['date'];
	echo json_encode(array('date'=>$payBankdate, 'bank'=>$payBankid));
} elseif($_REQUEST['update']) {
	$database->Query("UPDATE bank_pay SET bank_id=$_REQUEST[bank_id], date='$_REQUEST[date_pay]' WHERE ticket_id=$_REQUEST[id];");
	echo json_encode(array());
} elseif(!$_REQUEST['update']) {
	$database->Query("INSERT INTO bank_pay (bank_id, ticket_id, date) VALUES ($_REQUEST[bank_id], $_REQUEST[id], '$_REQUEST[date_pay]');");
	echo json_encode(array());
}
?>
