<?php
$database = new SyncDatabase();
$database->Query("DELETE FROM old_list WHERE old_id=$_REQUEST[old_id];");
?>