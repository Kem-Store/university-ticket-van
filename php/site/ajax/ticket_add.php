<script>
$(document).ready(function(){
	$('#yes_order').click(function(){
		$.ajax({ url: '?ajax=ticket_verify',
			dataType: "html",
			error: function() {	alert("Error: Yes ticket_verify"); },
			success: function(data) {
				$('#verify_order').html(data);
			},
		});
	});
	$('#no_order').click(function(){
		$('#verify_order').html('');
	});
});	
</script>
<?php
$database = new SyncDatabase();
if($database->Query("SELECT * FROM old_list WHERE user_id=$_COOKIE[USER] AND view=1;")):
	$nowTime = time();
	$isFare = 0;
	foreach($database->Query("SELECT * FROM old_list WHERE user_id=$_COOKIE[USER] AND view=1;") as $list) {
		$travel = $database->Query("SELECT * FROM travel WHERE travel_id=$list[travel_id] LIMIT 1;");
		$isFare += $travel['fare'];
	} ?>
<table align="center" width="510" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="255" align="center">&nbsp;</td>
    <td width="255" align="left"><strong>ยอดเงินที่คุณต้องชำระเงินทั้งสิ้น <?php echo $isFare; ?> บาท</strong></td>
  </tr>
</table>
<table align="center" width="510" border="0" cellspacing="0" cellpadding="2" style="margin-top:20px;">
  <tr>
    <td colspan="3" align="center"><strong>คุณต้องการสั่งจองตั๋วตามรายการดังกล่าวใช่หรือไม่</strong></td>
  </tr>
  <tr>
    <td width="200" align="right"><input type="button" id="yes_order" value="Yes" /></td>
    <td width="110" align="right">&nbsp;</td>
    <td width="200" align="left"><input type="button" id="no_order" value="No" /></td>
  </tr>
</table><?php
else: ?>
<table align="center" width="510" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="3" align="center"><strong>ไม่สามารถจองได้ เนื่องจากยังไม่มีรายการจอง</strong></td>
  </tr>
</table>
<?php endif; ?>