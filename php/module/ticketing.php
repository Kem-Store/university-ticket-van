<script>
$(document).ready(function(){
	$('#travel_form').popupBox(300, 200);
	$('#addtravel').click(function(){
		$.ajax({ url: '?ajax=travel_add',
			data: ({ time:$('#path_time').val(), travel:$('#id_travel').val(), seat:$('#seat_select').val() }),
			error: function() {	alert("ไม่สามารถสั่งจองได้"); },
			success: function(data) {
				if(!Boolean(data.date)) {
					alert('ไม่สามารถสั่งจองในช่วงเวลานี้ได้');
				} else {
					$('#travel_form').popupClose();
					$.ajax({ url: '?ajax=travel_view',
						dataType: "html",
						error: function() {	alert("Error: Ajax View List"); },
						success: function(data) {
							$('#tk_view').html(data);
							$('#verify_order').html('');
							seatChange();
						},
					});	
				}
			},
		});		
	});
	$('#add_ticket').click(function(){
		$.ajax({ url: '?ajax=ticket_add',
			dataType: "html",
			error: function() {	alert("Error: Ajax View List"); },
			success: function(data) {
				$('#verify_order').html(data);
			},
		});	
	});
});	
timeChange();
function timeChange() {
	$.ajax({ url: 'index.php?ajax=travel_time',
		data: ({ idtravel:$('#id_travel').val(), day:$('#day').val(), mon:$('#mon').val(), year:$('#year').val() }),
		dataType: "html",
		error: function() {	$('#time_travel').html("Error: Ajax User Login"); },
		success: function(data) {
			$('#time_travel').html(data);
			fareChange();
			seatChange();			
		},
	});
}
function fareChange() {
	$.ajax({ url: 'index.php?ajax=travel_fare',
		data: ({ idtravel:$('#id_travel').val(), }),
		error: function() {	$('#time_travel').html("Error: Ajax User Login"); },
		success: function(data) {
			$('#txt_fare').html(data.fare);
		},
	});
}
function seatChange() {
	$.ajax({ url: 'index.php?ajax=travel_seat',
		data: ({ idtravel:$('#id_travel').val(), day:$('#day').val(), mon:$('#mon').val(), year:$('#year').val(), time:$('#path_time').val() }),
		dataType: "html",
		error: function() {	$('#time_travel').html("Error: Ajax User Login"); },
		success: function(data) {
			$('#seat_travel').html(data);
		},
	});			
}
function delOldList(id) {
	$.ajax({ url: '?ajax=oldlist',
		data: ({ old_id:id }),
		error: function() {	alert("Error: Ajax View List"); },
		success: function(data) {
			$.ajax({ url: '?ajax=travel_view',
				dataType: "html",
				error: function() {	alert("Error: Ajax View List"); },
				success: function(data) {
					$('#tk_view').html(data);
					$('#verify_order').html('');
					seatChange();
				},
			});	
		},
	});	
}

</script>
<?php
$session = new Session();
$database = new SyncDatabase();
$nowDate = getdate((time()-3600)+86400);
$fullMonth = array(0,_January, _February, _March, _April, _Mays, _June, _July, _August, _September, _October, _November, _December);

?>
<h3>รายการจองตั๋ว</h3>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:10px 0 10px 0;">
 <tr>
  <td style="border-right:#D2D2D2 solid 1px;" valign="top">
    <table align="center" width="550" border="0" cellspacing="0" cellpadding="2">
      <tr bgcolor="#E7E7E7">
        <td width="300"><strong>วันที่ออกเดินทาง</strong></td>
        <td align="center" width="170"><strong>เที่ยวรถ</strong></td>
        <td align="center" width="80"><strong>ทะเบียนรถ</strong></td>
      </tr></table><div id="tk_view"><?php
	  if(!$database->Query("SELECT * FROM old_list WHERE user_id=$_COOKIE[USER] AND view=1;")): ?>
      <table align="center" width="510" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="3" align="center"><strong>ไม่มีข้อมูลการจอง</strong></td>
      </tr>
      </table><?php
	  else: 
	  foreach($database->Query("SELECT * FROM old_list WHERE user_id=$_COOKIE[USER] AND view=1;") as $list): ?>
      <table align="center" width="550" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td align="left" width="300"><a style="color:#900;" onclick="delOldList(<?php echo $list['old_id']; ?>)"><strong>x</strong></a> <?php echo ThaiDate::Mid($list['time']); ?></td>
        <td align="center" width="170"><?php
		 $path = $database->Query("SELECT * FROM path WHERE path_id=(SELECT path_id FROM travel WHERE travel_id=$list[travel_id]) LIMIT 1");
		 $beginPath = $database->Query("SELECT * FROM place WHERE place_id=$path[begin_id] LIMIT 1");
		 $endPath = $database->Query("SELECT * FROM place WHERE place_id=$path[finish_id] LIMIT 1");

		 $car = $database->Query("SELECT * FROM car WHERE car_id=(SELECT car_id FROM travel WHERE travel_id=$list[travel_id]) LIMIT 1");
         echo $beginPath['place'].'-'.$endPath['place'];?>
        </td>
        <td align="center" width="80"><?php echo $car['regis']; ?></td>
      </tr></table><?php
      endforeach; ?>
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="10" style="border-top:#E6E6E6 solid 1px;">
      <tr>
        <td align="center"><div id="verify_order"></div></td>
      </tr>
    </table>      </div><?php
	  endif; ?>
  </td>
  <td style="border-left:#FFFFFF solid 1px; width:200px;" valign="top"><div id="line_menu"></div>
   <div id="add_travel" onclick="$('#travel_form').popupOpen()" title="1.กรุณาเลือกเที่ยวก่อน">1.เลือกเที่ยวรถ</div>
   <div id="add_ticket" title="2.ตรวจสอบรายการให้เรียบร้อยก่อนสั่งจอง">2.สั่งจองตั๋ว</div>
  </td>
 </tr>
</table>
<div id="travel_form">
  <div class="login_body">
    <h3>เพิ่มรายการจองตั๋ว</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="margin:10px;">
     <tr>
      <td colspan="2"><strong>วันที่เดินทาง:</strong></td>
     </tr>
     <tr>
      <td colspan="2" style="padding:3px 3px 3px 5px;">
       วัน <select name="day" id="day" onchange="timeChange()"><?php
        for($dloop=1;$dloop<=31;$dloop++): ?>
         <option value="<?php echo $dloop; ?>" <?php if($nowDate['mday']==$dloop) echo 'selected="selected"'; ?>><?php echo $dloop; ?></option><?php
		endfor; ?>
       </select>
       เดือน <select name="month" id="mon" onchange="timeChange()"><?php
        for($mloop=1;$mloop<=12;$mloop++): ?>
         <option value="<?php echo $mloop; ?>" <?php if($nowDate['mon']==$mloop) echo 'selected="selected"'; ?>><?php echo $fullMonth[$mloop]; ?></option><?php
		endfor; ?>
       </select>
       ปี <select name="year" id="year" onchange="timeChange()"><?php
        for($yloop=($nowDate['year']+543);$yloop<($nowDate['year']+546);$yloop++): ?>
         <option value="<?php echo $yloop; ?>"><?php echo $yloop; ?></option><?php
		endfor; ?>
       </select>
      </td>
     </tr>
     <tr>
      <td colspan="2">&nbsp;</td>
     </tr>
     <tr>
      <td colspan="2"><strong>เลือกเที่ยวรถ:</strong></td>
     </tr>
     <tr>
      <td colspan="2" style="padding:3px 3px 3px 5px;">
       <select name="id_travel" id="id_travel" onchange="timeChange()"><?php
        foreach($database->Query("SELECT * FROM travel;") as $travel): 
		 $beginplace = $database->Query("SELECT * FROM place WHERE place_id=(SELECT begin_id FROM path WHERE path_id=$travel[path_id] LIMIT 1) LIMIT 1;");
		 $finishplace = $database->Query("SELECT * FROM place WHERE place_id=(SELECT finish_id FROM path WHERE path_id=$travel[path_id] LIMIT 1) LIMIT 1;"); ?>
         <option value="<?php echo $travel['travel_id']; ?>" lang="<?php echo $travel['fare']; ?>"><?php echo $beginplace['place']; ?> - <?php echo $finishplace['place']; ?></option><?php
		endforeach; ?>
       </select>
      </td>
     </tr>
     <tr>
      <td colspan="2">&nbsp;</td>
     </tr>
     <tr>
      <td width="90" style="padding-right:10px;" align="right"><strong>เลือกช่วงเวลา:</strong>&nbsp;</td>
      <td><div id="time_travel">&nbsp;</div></td>
     </tr>
     <tr>
      <td style="padding-right:10px;" align="right"><strong>หมายเลขที่นั่ง:</strong>&nbsp;</td>
      <td><div id="seat_travel">&nbsp;</div></td>
     </tr>
     <tr>
      <td style="padding-right:10px;" align="right"><strong>ราคา:</strong>&nbsp;</td>
      <td><span id="txt_fare">0</span> บาท</td>
     </tr>
    </table>
  </div>
  <div class="loginbg_btn"><input type="button" class="btn_addtravel" id="addtravel" /></div>
</div>