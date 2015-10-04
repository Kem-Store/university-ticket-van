<script>
$(document).ready(function(){
	$('#ticket_form').popupBox(350, 300);
	$('#save_path').click(function(){
		//$('#debug').html(' ID_PB:'+$('#province_begin').val()+' ID_B:'+$('#place_begin').val()+' ID_PE:'+$('#province_end').val()+' ID_E:'+$('#place_end').val());
		$.ajax({ url: 'index.php?ajax=path_edit',
			data: ({ pid:$('#path_id').val(), tid:$('#travel_id').val(), b_id:$('#place_begin').val(), e_id:$('#place_end').val(), car_id:$('#car').val(), fare:$('#fare').val() }),
			error: function() {	alert("Error: path_edit"); },
			success: function() {
				$('#ticket_form').popupClose();
				$('#path_id').val('0');
				$('#travel_id').val('0');
				$('#edit_listpath').html('');
				adminEdit('admin_path', '#edit_path');
			},
		});
		
	});
});
function editPath(travel_id, path_id, begin_id, pbegin_id, end_id, pend_id, car_id, fare) {
	$('#ticket_form').popupClose();
	$('#ticket_form').popupOpen();
	$('#head_add').html('แก้ไขเส้นทาง');
	$.ajax({ url: 'index.php?ajax=path_view',
		data: ({ begin_id:begin_id, begin_pid:pbegin_id, end_id:end_id, end_pid:pend_id, car_id:car_id, fare:fare }),
		dataType: "html",
		error: function() {	alert("Error: path_path_editview"); },
		success: function(data) {
			$('#path_id').val(path_id);
			$('#travel_id').val(travel_id);
			$('#edit_listpath').html(data);
		},
	});
}
function delPath(tid) {
	$.ajax({ url: 'index.php?ajax=path_edit&path=delete',
		data: ({ tid:tid }),
		error: function() {	alert("Error: path_edit delete"); },
		success: function() {
			adminEdit('admin_path', '#edit_path');
		},
	});
}
function addPath() {
	$('#ticket_form').popupClose();
	$('#ticket_form').popupOpen();
	$('#head_add').html('เพิ่มเส้นทาง');
	$.ajax({ url: 'index.php?ajax=path_view',
		data: ({ }),
		dataType: "html",
		error: function() {	alert("Error: path_path_editview"); },
		success: function(data) {
			$('#edit_listpath').html(data);
			$('#path_id').val('0');
			$('#travel_id').val('0');
		},
	});
}
</script>

<?php
$database = new SyncDatabase();?>
<table width="550" border="0" cellspacing="0" cellpadding="3" style="background-color:#E6E6E6;margin:5px 0 2px 0;">
  <tr>
    <td width="80" align="center"><strong>เลขทะเบียนรถ</strong></td>
    <td width="150"><strong>ต้นทาง</strong></td>
    <td width="150"><strong>ปลายทาง</strong></td>
    <td width="100" align="center"><strong>ราคา</strong></td>
    <td width="70" align="center">&nbsp;</td>
  </tr>
</table><?php
foreach($database->Query("SELECT * FROM travel;") as $travel):
$path = $database->Query("SELECT * FROM path WHERE path_id=$travel[path_id] LIMIT 1");
$beginPath = $database->Query("SELECT * FROM place WHERE place_id=$path[begin_id] LIMIT 1");
$endPath = $database->Query("SELECT * FROM place WHERE place_id=$path[finish_id] LIMIT 1"); 
$car = $database->Query("SELECT * FROM car WHERE car_id=$travel[car_id] LIMIT 1"); ?>
<table width="550" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="80" align="center"><?php echo $car['regis']; ?></td>
    <td width="150"><?php echo $beginPath['place']; ?></td>
    <td width="150"><?php echo $endPath['place']; ?></td>
    <td width="100" align="center"><?php echo $travel['fare']; ?></td>
    <td width="70" align="center"><strong><a style="color:#06F"
    onclick="editPath(<?php echo $travel['travel_id'].', '.$path['path_id'].', '.$path['begin_id'].', '.$beginPath['province_id'].', '.$path['finish_id'].', '.$endPath['province_id'].', '.$car['car_id'].', '.$travel['fare']; ?>)">แก้ไข</a>
    | <a style="color:#900" onclick="delPath(<?php echo $travel['travel_id']; ?>)">ลบ</a></strong></td>
  </tr>
</table><?php
endforeach; ?>
<table width="550" border="0" cellspacing="0" cellpadding="7" style="border-top:#E6E6E6 solid 1px;">
  <tr>
    <td align="center"><strong><a style="color:#060" onclick="addPath()">เพิ่มเส้นทาง</a></strong></td>
  </tr>
</table>
<div id="ticket_form">
  <div class="login_body">
    <h3 id="head_add">แก้ไขเส้นทาง</h3>
    <div id="edit_listpath">&nbsp;</div>
    <input type="hidden" id="path_id" value="0" />
    <input type="hidden" id="travel_id" value="0" />
  </div>
  <div class="loginbg_btn">
    <input type="button" class="btn_save" id="save_path" />
  </div>
</div>