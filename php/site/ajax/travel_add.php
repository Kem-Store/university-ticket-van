<?php
$database = new SyncDatabase();
if($_REQUEST['time']<=(time()-3600)) {
	$date = false;
} else {
	$database->Query("INSERT INTO old_list (time, user_id, travel_id, seat) VALUES ($_REQUEST[time], $_COOKIE[USER], $_REQUEST[travel], $_REQUEST[seat]);");
	$date = true;
}
echo json_encode(array('date'=>$date));
?>