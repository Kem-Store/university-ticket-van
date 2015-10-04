<script>
$(document).ready(function(){
	$('#check_next').click(function(){
		navChangeModule(null, 'checkticket');
	});
});
</script>
<?php
$database = new SyncDatabase();
$nowTime = time();
$ticket = $database->Query("INSERT INTO ticket (user_id, date) VALUES ($_COOKIE[USER], $nowTime);");
foreach($database->Query("SELECT * FROM old_list WHERE user_id=$_COOKIE[USER] AND view=1;") as $list) {
	$database->Query("INSERT INTO ticket_list (ticket_id, travel_id, seat, traveldate) VALUES ($ticket, $list[travel_id], $list[seat], $list[time]);");
	$database->Query("UPDATE old_list SET view=0 WHERE old_id=$list[old_id];");
}
?>
<table align="center" width="510" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="3" align="center"><strong>การจองตั๋วเรียบร้อยแล้ว<br /> สามารถตรวจสอบหมายเลขรถได้อีกครั้งที่ <u id="check_next"><a>ตรวจสอบการจอง</a></u></strong></td>
  </tr>
</table>