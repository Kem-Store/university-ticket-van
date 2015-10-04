<?php
$database = new SyncDatabase();
if($_REQUEST['path']=='delete') {
	$database->Query("DELETE FROM travel WHERE travel_id=$_REQUEST[tid];");
} else {
	if($_REQUEST['pid']==0) {
		$path_id = $database->Query("INSERT INTO path (begin_id, finish_id) VALUES ($_REQUEST[b_id], $_REQUEST[e_id]);");
		$database->Query("INSERT INTO travel (path_id, car_id, fare) VALUES ($path_id, $_REQUEST[car_id], $_REQUEST[fare]);");
	} else {
		$database->Query("UPDATE path SET begin_id=$_REQUEST[b_id], finish_id=$_REQUEST[e_id] WHERE path_id=$_REQUEST[pid];");
		$database->Query("UPDATE  travel SET car_id=$_REQUEST[car_id], fare=$_REQUEST[fare] WHERE path_id=$_REQUEST[pid];");
	}
}
echo json_encode(array());
?>
