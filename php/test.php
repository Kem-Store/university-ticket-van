<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
require("cgi-bin/SyncMySQL.php");
require("cgi-bin/ConfigSite.php");
?>
<body>
<?php
$database = new SyncDatabase();

foreach($database->Query("SELECT * FROM ticket;") as $ticket) {
	echo 'User:'.$ticket['user_id'];
	echo '<br/>';
	foreach($database->Query("SELECT * FROM ticket_list WHERE ticket_id=$ticket[ticket_id];") as $list) {
		$date = ThaiDate::Full($list['traveldate']);
		echo '-'.$date;
	echo '<br/>';
	}
}
?>
</body>
</html>
