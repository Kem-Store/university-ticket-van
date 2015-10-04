<script>
$(document).ready(function(){
	$('#ticket_form').popupBox(480, 500);
});
function genListTicket(tid) {
	$('#ticket_form').popupClose();
	$('#ticket_form').popupOpen();
	$.ajax({ url: 'index.php?ajax=list_travel',
		data: ({ id:tid }),
		dataType: "html",
		error: function() {	$('#time_travel').html("Error: Ajax User Login"); },
		success: function(data) {
			$('#list_ticket').html(data);
		},
	});
}
function payChange(tid, pay) {
	$.ajax({ url: '?ajax=edit_travel',
		data: ({ id:tid, pay:pay }),
		error: function() {	alert("Error: edit_travel"); },
		success: function(data) {
			$('#pay_' + tid).html(data.text);
		},
	});
}
</script>
<table width="550" border="0" cellspacing="0" cellpadding="3" style="background-color:#E6E6E6;margin:5px 0 2px 0;">
  <tr>
    <td width="20" align="right">&nbsp;</td>
    <td width="170"><strong>ผู้จอง</strong></td>
    <td width="120" align="center"><strong>ธนาคารที่ชำระเงิน</strong></td>
    <td width="120" align="center"><strong>ข้อมูลการยืนยัน</strong></td>
    <td width="100" align="center"><strong>แก้ไขสถานะ</strong></td>
  </tr>
</table><?php
$database = new SyncDatabase();
foreach($database->Query("SELECT * FROM ticket ORDER BY pay,date ASC;") as $ticket):
$payBank = $database->Query("SELECT * FROM bank_pay WHERE ticket_id=$ticket[ticket_id] LIMIT 1;");
if($payBank) $accountBank = $database->Query("SELECT * FROM bank_account WHERE bank_id=$payBank[bank_id] LIMIT 1;"); ?>
<table width="550" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="20" align="right"><strong><a onclick="genListTicket(<?php echo $ticket['ticket_id']; ?>);" style="color:#060">รายการ</a></strong></td>
    <td width="150"><strong><?php $user = $database->Query("SELECT * FROM user WHERE user_id=$ticket[user_id] LIMIT 1;"); echo $user['fullname']; ?></strong></td>
    <td width="130" align="center"><?php if($payBank) echo $accountBank['name']; else echo '-'; ?></td>
    <td width="130" align="center"><?php if($payBank) echo $payBank['date']; else echo '-'; ?></td>
    <td width="100" align="center"><div id="pay_<?php echo $ticket['ticket_id']; ?>"><?php
	$payBank = $database->Query("SELECT * FROM bank_pay WHERE ticket_id=$ticket[ticket_id] LIMIT 1;");
	if($payBank) {
		if($ticket['pay']==0) {
			echo '<strong><a style="color:#900" onclick="payChange('.$ticket['ticket_id'].','.$ticket['pay'].')">รอตวจสอบ</a></strong>';
		} else {
			echo '<strong><a style="color:#06F" onclick="payChange('.$ticket['ticket_id'].','.$ticket['pay'].')">จ่ายแล้ว</a></strong>';
		}
	} else {
		echo '<strong>ยังไม่ได้ยืนยัน</strong>';
	}?></div>
    </td>
  </tr>
</table><?php
endforeach;
if(!$database->Query("SELECT * FROM ticket;")): ?>
<table width="550" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td align="center"><strong>ไม่มีข้อมูลการจองตั๋ว</strong></td>
  </tr>
</table><?php
endif;
?>
<div id="ticket_form">
  <div class="login_body" style="height:450px;">
    <h3>รายการจองตั๋ว</h3>
    <div id="list_ticket"></div>
  </div>
  <div class="loginbg_btn">&nbsp;</div>
</div>