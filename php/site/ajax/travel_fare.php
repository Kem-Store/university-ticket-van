<?php
$database = new SyncDatabase();
$fare = $database->Query("SELECT * FROM travel WHERE travel_id=$_REQUEST[idtravel] LIMIT 1");

echo json_encode(array('fare'=>$fare['fare']));
?>