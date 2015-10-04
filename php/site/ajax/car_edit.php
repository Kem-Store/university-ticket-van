<?php
$database = new SyncDatabase();
if($_REQUEST['car']=='del') {
	$database->Query("DELETE FROM car WHERE car_id=$_REQUEST[car_id];");
} else {
	if($_REQUEST['car_id']==0) {
		$database->Query("INSERT INTO car (regis, seat_limit, mark) VALUES ('$_REQUEST[regis]', $_REQUEST[limit], '$_REQUEST[mark]');");
	} else {
		$database->Query("UPDATE car SET regis='$_REQUEST[regis]', seat_limit=$_REQUEST[limit], mark='$_REQUEST[mark]' WHERE car_id=$_REQUEST[car_id];");
	}
}
echo json_encode(array());
?>
