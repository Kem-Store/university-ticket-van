<?php
$database = new SyncDatabase();
if($_REQUEST['p']=='del') {
	$database->Query("DELETE FROM place WHERE place_id=$_REQUEST[plance_id];");
} else {
	if($_REQUEST['place_id']==0) {
		$database->Query("INSERT INTO place (province_id, place) VALUES ($_REQUEST[province_id], '$_REQUEST[place]');");
	} else {
		$database->Query("UPDATE place SET province_id=$_REQUEST[province_id], place='$_REQUEST[place]' WHERE place_id=$_REQUEST[place_id];");
	}
}
echo json_encode(array());
?>
