<script>
function delTicketlist(ticket_id, list_id) {
	if(confirm("ต้องหารลบรายการนี้ใช่หรือไม่")) {
		$.ajax({ url: 'index.php?ajax=list_ticket',
			data: ({ ticket_id:ticket_id, list_id:list_id }),
			error: function() {	alert("Error: Ajax User Login"); },
			success: function(data) {
				chkTicketList();
			},
		});
	}
}
</script>
<?php
$database = new SyncDatabase();
$isTicket = array();
foreach($database->Query("SELECT * FROM ticket WHERE user_id=$_COOKIE[USER];") as $ticket) {
	foreach($database->Query("SELECT * FROM ticket_list WHERE ticket_id=$ticket[ticket_id] AND traveldate=$_REQUEST[time] ORDER BY seat;") as $list) {
		$foundTicket = array();
		$payBank = $database->Query("SELECT * FROM bank_pay WHERE ticket_id=$ticket[ticket_id];");
		$foundTicket['pay'] = '<span style="color:#06F">ได้รับเงินแล้ว</span>';
		if($ticket['pay']==0 && $payBank) $foundTicket['pay'] = '<span style="color:#900">กำลังตรวจสอบ</span>';
		if(!$payBank) $foundTicket['pay'] = 'ยังไม่ได้ยืนยัน';
		$travel = $database->Query("SELECT * FROM travel WHERE travel_id=$list[travel_id] LIMIT 1;");
		$path = $database->Query("SELECT * FROM path WHERE path_id=$travel[path_id] LIMIT 1;");
		$begin = $database->Query("SELECT * FROM place WHERE place_id=$path[begin_id] LIMIT 1;");
		$begin_p = $database->Query("SELECT * FROM province WHERE province_id=$begin[province_id] LIMIT 1;");
		$finish = $database->Query("SELECT * FROM place WHERE place_id=$path[finish_id] LIMIT 1;");
		$finish_p = $database->Query("SELECT * FROM province WHERE province_id=$finish[province_id] LIMIT 1;");
		$foundTicket['begin_place'] = $begin['place'];
		$foundTicket['begin_province'] = $begin_p['province'];
		$foundTicket['finish_place'] = $finish['place'];
		$foundTicket['finish_province'] = $finish_p['province'];
		$foundTicket['seat'] = $list['seat'];
		
		$car = $database->Query("SELECT * FROM car WHERE car_id=$travel[car_id] LIMIT 1;");
		$foundTicket['car'] = $car['regis'];
		$foundTicket['fare'] = (float)$travel['fare'];
		$foundTicket['mark'] = $car['mark'];
		
		if($ticket['pay']==0) $foundTicket['cancel'] = '';
		if(!$payBank || $car['mark']) $foundTicket['cancel'] = '<a onclick="delTicketlist('.$list['ticket_id'].','.$list['list_id'].')" style="color:#E50">ยกเลิก</a>';
		$isTicket[] = $foundTicket;
	}
} ?>
<table align="center" width="750" border="0" cellspacing="0" cellpadding="2" style="background-color:#E6E6E6;">
  <tr>
    <td width="160"><strong>ต้นทาง</strong></td>
    <td width="160"><strong>ปลายทาง</strong></td>
    <td width="45" align="center"><strong>เลขที่นั่ง</strong></td>
    <td width="60" align="center"><strong>เลขรถ</strong></td>
    <td width="110" align="center"><strong>สถานะ</strong></td>
    <td width="40" align="center">&nbsp;</td>
    <td width="60" align="center">&nbsp;</td>
  </tr>
</table><?php
if($isTicket):
foreach($isTicket as $ticket): ?>
<table align="center" width="750" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="160"><?php echo $ticket['begin_place'].' '.$ticket['begin_province'];?></td>
    <td width="160"><?php echo $ticket['finish_place'].' '.$ticket['finish_province'];?></td>
    <td width="45" align="center"><?php echo $ticket['seat']; ?></td>
    <td width="60" align="center"><strong><?php echo $ticket['car']; ?></strong></td>
    <td width="110" align="center"><strong><?php echo $ticket['pay']; ?></strong></td>
    <td width="40" align="center"><strong><?php echo $ticket['cancel']; ?></strong></td>
    <td width="60" align="center"><?php
    if($ticket['mark']!='') { 
		echo '<img src="images/warning_16.png" width="16" height="16" title="'.$ticket['mark'].'" />'; 
	} else {
		echo '<strong>ปกติ</strong>'; 
	} ?>
    </td>
  </tr>
</table><?php
endforeach;
else: ?>
<table align="center" width="510" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="3" align="center" style="color:#900"><strong>ไม่มีรายการจองในวันและเวลาดังกล่าว</strong></td>
  </tr>
</table><?php
endif; ?>