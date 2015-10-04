<script>
$(document).ready(function(){
	$('#add_province').click(function(){
		if($('#province').val()!='') {
			$.ajax({ url: 'index.php?ajax=add_province',
				data: ({ province:$('#province').val() }),
				error: function() {	alert("Error: province Add"); },
				success: function(data) {
					$.ajax({ url: 'index.php?ajax=plance_change&mod=pchange',
						data: ({ province_id:data.id }),
						dataType: "html",
						error: function() {	alert("Error: plance_change"); },
						success: function(data) {
							$('#province').val('');	
							$('#pchange').html(data);	
						},
					});
				},
			});
		}
	});	
});
</script>
<?php
$database = new SyncDatabase();
?>
<input type="hidden" id="place_id" value="<?php echo $_REQUEST['pid']; ?>" />
<table width="100%" cellpadding="0" cellspacing="0" style="margin:10px;">
  <tr>
    <td style="padding:3px 3px 3px 5px;"> จังหวัด
      <input type="text" size="15" name="province" id="province" value="" />
      <input type="button" id="add_province" value="เพิ่ม" /></td>
  </tr>
</table>
<hr/>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:10px;">
  <tr>
    <td style="padding:3px 3px 3px 5px;"> สถานที่
      <div id="begin">
        <input type="text" size="15" name="place" id="place" value="<?php echo $_REQUEST['place']; ?>" />
      </div>
      จังหวัด
      <div id="pchange">
        <select name="province_list" id="province_list">
          <?php
        	foreach($database->Query("SELECT * FROM province;") as $place): ?>
          <option value="<?php echo $place['province_id']; ?>" <?php if($place['province_id']==$_REQUEST['province_id']) echo 'selected="selected"'; ?>><?php echo $place['province']; ?></option>
          <?php
			endforeach; ?>
        </select>
      </div></td>
  </tr>
</table>
