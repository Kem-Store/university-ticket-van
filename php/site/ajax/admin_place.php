<script>
$(document).ready(function(){
	$('#ticket_form').popupBox(350, 190);
	$('#save_path').click(function(){
		$.ajax({ url: 'index.php?ajax=plance_edit',
			data: ({ place_id:$('#place_id').val(), province_id:$('#province_list').val(), place:$('#place').val() }),
			error: function() {	alert("Error: edit_place"); },
			success: function() {
				$('#ticket_form').popupClose();
				adminEdit('admin_place', '#edit_place');
			},
		});
	});	
});

function delPlace(pid) 
{
	$.ajax({ url: 'index.php?ajax=plance_edit&p=del',
		data: ({ plance_id:pid }),
		error: function() {	alert("Error: plance_edit"); },
		success: function() {
			$('#ticket_form').popupClose();
			adminEdit('admin_place', '#edit_place');
		},
	});
}
function addPlace() 
{
	$.ajax({ url: 'index.php?ajax=place_view',
		dataType: "html",
		error: function() {	alert("Error: place_view"); },
		success: function(data) {
			$('#head_add').html('เพิ่มข้อมูลสถานที่');
			$('#place_id').val(0);
			$('#place').val('');
			$('#ticket_form').popupClose();
			$('#ticket_form').popupOpen();
			$('#place_detail').html(data);
		},
	});
}

function editPlace(pid, place, province_id) 
{
	$.ajax({ url: 'index.php?ajax=place_view',
		data: ({ pid:pid, place:place, province_id:province_id }),
		dataType: "html",
		error: function() {	alert("Error: place_view"); },
		success: function(data) {
			$('#head_add').html('แก้ไขข้อมูลสถานที่');
			$('#ticket_form').popupClose();
			$('#ticket_form').popupOpen();
			$('#place_detail').html(data);
		},
	});
}
</script>
<?php
$database = new SyncDatabase();?>

<table width="500" align="center" border="0" cellspacing="0" cellpadding="3" style="background-color:#E6E6E6;margin-top:5px;">
  <tr>
    <td width="200"><strong>สถานที่</strong></td>
    <td width="200"><strong>จังหวัด</strong></td>
    <td width="100" align="center">&nbsp;</td>
  </tr>
</table>
<?php
foreach($database->Query("SELECT * FROM place ORDER BY province_id;") as $place):
$province = $database->Query("SELECT * FROM province WHERE province_id=$place[province_id] LIMIT 1;");
?>
<table width="500" align="center" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="200"><?php echo $place['place']; ?></td>
    <td width="200"><?php echo $province['province']; ?></td>
    <td width="100" align="center"><strong>
    <a style="color:#06C" onclick="editPlace(<?php echo $place['place_id'].', \''.$place['place'].'\', '.$place['province_id']; ?>)">แก้ไข</a> |
    <a style="color:#900" onclick="delPlace(<?php echo $place['place_id']; ?>)">ลบ</a></strong></td>
  </tr>
</table><?php
endforeach; ?>
<table width="500" align="center" border="0" cellspacing="0" cellpadding="10" style="border-top:#E6E6E6 solid 1px;">
  <tr>
    <td align="center"><strong><a style="color:#060" onclick="addPlace()">เพิ่มข้อมูลสถานที่</a></strong></td>
  </tr>
</table>
<div id="ticket_form">
  <div class="login_body">
    <h3 id="head_add">เพิ่มข้อมูลสถานที่</h3>
    <div id="place_detail"></div>
  </div>
  <div class="loginbg_btn">
    <input type="button" class="btn_save" id="save_path" />
  </div>
</div>
