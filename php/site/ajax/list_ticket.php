<?php
$database = new SyncDatabase();
$database->Query("DELETE FROM ticket_list WHERE list_id=$_REQUEST[list_id];");
if(!$database->Query("SELECT COUNT(*) FROM ticket_list WHERE ticket_id=$_REQUEST[ticket_id];")) $database->Query("DELETE FROM ticket WHERE ticket_id=$_REQUEST[ticket_id];");
echo json_encode(array());
?>
