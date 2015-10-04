<script>
$(document).ready(function(){
	$('#ticket_form').popupBox(350, 190);
	$('#save_path').click(function(){
		$.ajax({ url: 'index.php?ajax=car_edit',
			data: ({ car_id:$('#car_id').val(), regis:$('#regis').val(), limit:$('#limit').val(), mark:$('#mark').val() }),
			error: function() {	alert("Error: path_edit"); },
			success: function() {
				$('#ticket_form').popupClose();
				adminEdit('admin_car', '#edit_car');
			},
		});
	});
	
});
function delCar(cid) 
{
	$.ajax({ url: 'index.php?ajax=car_edit&car=del',
		data: ({ car_id:cid }),
		error: function() {	alert("Error: car=del"); },
		success: function() {
			$('#ticket_form').popupClose();
			adminEdit('admin_car', '#edit_car');
		},
	});
}
function addCar() 
{
	$('#head_add').html('เพิ่มข้อมูลรถ');
	$('#car_id').val(0);
	$('#regis').val('');
	$('#limit').val(0);
	$('#ticket_form').popupClose();
	$('#ticket_form').popupOpen();
}

function editCar(id, regis, limit,mark) 
{
	$('#head_add').html('แก้ไขข้อมูลรถ');
	$('#car_id').val(id);
	$('#regis').val(regis);
	$('#limit').val(limit);
	$('#mark').val(mark);
	$('#ticket_form').popupClose();
	$('#ticket_form').popupOpen();
	
}
</script>
<?php
$database = new SyncDatabase();?>
<table width="390" align="center" border="0" cellspacing="0" cellpadding="3" style="background-color:#E6E6E6;margin-top:5px;">
  <tr>
    <td width="60" align="center"><strong>ลำดับ</strong></td>
    <td width="150"><strong>เลขทะเบียนรถ</strong></td>
    <td width="50" align="center"><strong>ที่นั่ง</strong></td>
    <td width="30">&nbsp;</td>
    <td width="100">&nbsp;</td>
  </tr>
</table><?php
foreach($database->Query("SELECT * FROM car;") as $car): ?>
<table width="390" align="center" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="60" align="center"><?php echo $car['car_id']; ?></td>
    <td width="150"><?php echo $car['regis']; ?></td>
    <td width="50" align="center"><?php echo $car['seat_limit']; ?></td>
    <td width="30" align="center"><?php	if($car['mark']!='') echo '<img src="images/warning_16.png" width="16" height="16" title="'.$car['mark'].'" />'; ?></td>
    <td width="100" align="center"><strong><a style="color:#06C" onclick="editCar(<?php echo $car['car_id'].', \''.$car['regis'].'\', '.$car['seat_limit'].', \''.$car['mark'].'\''; ?>)">แก้ไข</a>
    | <a style="color:#900" onclick="delCar(<?php echo $car['car_id']; ?>)">ลบ</a></strong></td>
  </tr>
</table><?php
endforeach; ?>
<table width="360" align="center" border="0" cellspacing="0" cellpadding="10" style="border-top:#E6E6E6 solid 1px;">
  <tr>
    <td align="center"><strong><a style="color:#060" onclick="addCar()">เพิ่มข้อมูลรถ</a></strong></td>
  </tr>
</table>
<div id="ticket_form">
  <div class="login_body">
    <h3 id="head_add">เพิ่มข้อมูลรถ</h3>
    <input type="hidden" id="car_id" value="0" />
      <table width="100%" cellpadding="0" cellspacing="0" style="margin:10px;">
        <tr>
          <td><strong>ทะเบียนรถ:</strong></td>
        </tr>
        <tr>
          <td style="padding:3px 3px 3px 5px;"><div id="end">
             <input type="text" id="regis" value="" size="30" />
          </div></td>
        </tr>
        <tr>
          <td><strong>ทั้งหมด:</strong>
            <input type="text" id="limit" value="0" size="5" />
            ที่นั่ง</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>หมายเหตุ: <span style="font-size:9px;color:#AAA">(จะมีหรือไม่มีก็ได้)</span></strong></td>
        </tr>
        <tr>
          <td style="padding:3px 3px 3px 5px;"><div id="end2">
            <textarea cols="30" id="mark"></textarea>
          </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
  </div>
  <div class="loginbg_btn">
    <input type="button" class="btn_save" id="save_path" />
  </div>
</div>