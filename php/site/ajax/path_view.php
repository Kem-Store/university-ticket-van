<script>
function changeProvinceBegin(id) {
	$.ajax({ url: 'index.php?ajax=plance_change&mod=begin',
		data: ({ id:id }),
		dataType: "html",
		error: function() {	alert("Error: plance_change begin"); },
		success: function(data) {
			$('#begin').html(data);	
			$.ajax({ url: 'index.php?ajax=plance_change&mod=pend',
				data: ({ id:id }),
				dataType: "html",
				error: function() {	alert("Error: plance_change pend"); },
				success: function(data) {
					$('#pend').html(data);	
					$.ajax({ url: 'index.php?ajax=plance_change&mod=end',
						data: ({ id:$('#province_end').val() }),
						dataType: "html",
						error: function() {	alert("Error: plance_change end"); },
						success: function(data) {
							$('#end').html(data);			
						},
					});							
				},
			});
		},
	});
}
function changeProvinceEnd(id) {
	$.ajax({ url: 'index.php?ajax=plance_change&mod=end',
		data: ({ id:id }),
		dataType: "html",
		error: function() {	alert("Error: plance_change end"); },
		success: function(data) {
			$('#end').html(data);	
		},
	});
}
</script><?php
$database = new SyncDatabase();
if(!isset($_REQUEST['begin_pid']) && !isset($_REQUEST['end_id'])) {
	$id_province = $database->Query("SELECT * FROM province LIMIT 1;");
	$_REQUEST['begin_pid'] = $id_province['province_id'];
	
	$id_endp = $database->Query("SELECT * FROM province WHERE province_id!=$_REQUEST[begin_pid] LIMIT 1;");
	$_REQUEST['end_pid'] = $id_endp['province_id'];
	
	$id_end = $database->Query("SELECT * FROM place WHERE province_id=$_REQUEST[begin_pid] LIMIT 1;");
	$_REQUEST['end_id'] = $id_end['place_id'];
}
?>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:10px;">
  <tr>
    <td width="90"><strong>ต้นทาง:</strong></td>
  </tr>
  <tr>
    <td style="padding:3px 3px 3px 5px;"> จังหวัด <div id="pbegin">
      <select name="province_begin" id="province_begin" onchange="changeProvinceBegin($(this).val())">
        <?php
        foreach($database->Query("SELECT * FROM province;") as $place): ?>
        <option value="<?php echo $place['province_id']; ?>" <?php if($place['province_id']==$_REQUEST['begin_pid']) echo 'selected="selected"'; ?>><?php echo $place['province']; ?></option>
        <?php
		endforeach; ?>
      </select></div>
      สถานที่ <div id="begin">
      <select name="place_begin" id="place_begin">
        <?php
        foreach($database->Query("SELECT * FROM place WHERE province_id=$_REQUEST[begin_pid];") as $place): ?>
        <option value="<?php echo $place['place_id']; ?>" <?php if($place['place_id']==$_REQUEST['begin_id']) echo 'selected="selected"'; ?>><?php echo $place['place']; ?></option>
        <?php
		endforeach; ?>
      </select></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>ปลายทาง:</strong></td>
  </tr>
  <tr>
    <td style="padding:3px 3px 3px 5px;"> จังหวัด <div id="pend">
      <select name="province_end" id="province_end" onchange="changeProvinceEnd($(this).val())">
        <?php
        foreach($database->Query("SELECT * FROM province WHERE province_id!=$_REQUEST[begin_pid];") as $place): ?>
        <option value="<?php echo $place['province_id']; ?>" <?php if($place['province_id']==$_REQUEST['end_pid']) echo 'selected="selected"'; ?>><?php echo $place['province']; ?></option>
        <?php
		endforeach; ?>
      </select></div>
      สถานที่ <div id="end">
      <select name="place_end" id="place_end">
        <?php
        foreach($database->Query("SELECT * FROM place WHERE province_id=$_REQUEST[end_pid];") as $place): ?>
        <option value="<?php echo $place['place_id']; ?>" <?php if($place['place_id']==$_REQUEST['end_id']) echo 'selected="selected"'; ?>><?php echo $place['place']; ?></option>
        <?php
		endforeach; ?>
      </select></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>เลือกรถ:</strong></td>
  </tr>
  <tr>
    <td style="padding:3px 3px 3px 5px;">
      <div id="end">
      <select name="car" id="car">
        <?php
        foreach($database->Query("SELECT * FROM car;") as $car): ?>
        <option value="<?php echo $car['car_id']; ?>" <?php if($car['car_id']==$_REQUEST['car_id']) echo 'selected="selected"'; ?>>คันที่ <?php echo $car['car_id']; ?> เลข <?php echo $car['regis']; ?></option>
        <?php
		endforeach; ?>
      </select></div>
    </td>
  </tr>
  <tr>
    <td><strong>ราคา:</strong> <input type="text" id="fare" value="<?php echo (int)$_REQUEST['fare']; ?>" size="5" /> บาท</td>
  </tr>
</table>
