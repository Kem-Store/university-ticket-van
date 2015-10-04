<?php
$database = new SyncDatabase();
$list_id = $database->Query("INSERT INTO province (province) VALUES ('$_REQUEST[province]');");
echo json_encode(array('id'=>$list_id));
?>
