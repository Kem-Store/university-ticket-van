<script>
$(document).ready(function(){
	$('#update_user').click(function(){
		$.ajax({ url: 'index.php?ajax=register_user&update',
			data: ({
				fullname: $('#txt_fullname').val(),
				sex: $("input[name='txt_sex']:checked").val(),
				address: $('#txt_address').val(),
				telephone: $('#txt_telephone').val(),
				email: $('#txt_email').val(),
			}),
			error: function() {	$('#register_error').html("Error: Ajax User Regiser"); },
			success: function(data) {
				if(data.error==1) {
					$('#register_error').html('<?php echo _REGISTER_ERROR; ?>');
				} else {
					isRegister = 0;
					isUsername = 0;
					$('#login_welcome').html(data.text);
					$('#register_error').empty();
					navChangeModule(null, 'frontpage');
				}
			},
		});			
	});
});
</script>
<?php
$session = new Session();
$database = new SyncDatabase();
$user = $database->Query("SELECT * FROM user WHERE user_id=$_COOKIE[USER] LIMIT 1;");
?>
<h3>แก้ไขข้อมูลผู้ใช้</h3>
<div style="margin:5px 20px 10px 20px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td align="left" width="25%">&nbsp;</td>
      <td align="left" width="40%">&nbsp;</td>
      <td align="left" width="35%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_USERNAME; ?>:</td>
      <td align="left"><input type="text" disabled id="txt_username" value="<?php echo $user['username']; ?>" size="20" maxlength="20" readonly="readonly" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_FULLNAME; ?>:</td>
      <td align="left"><input type="text" id="txt_fullname" value="<?php echo $user['fullname']; ?>" size="30" maxlength="50" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_SEX; ?>:</td>
      <td align="left"><label>
          <input type="radio" name="txt_sex" value="M" <?php if($user['sex']=='M') echo 'checked="checked"'; ?>/>
          <?php echo _REGISTER_SEX_M; ?></label>
        <label>
          <input type="radio" name="txt_sex" value="F"<?php if($user['sex']=='F') echo 'checked="checked"'; ?> />
          <?php echo _REGISTER_SEX_F; ?></label></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="top"><?php echo _REGISTER_ADDRESS; ?>:</td>
      <td align="left"><textarea name="txt_address" cols="30" rows="4" id="txt_address"><?php echo $user['address']; ?></textarea></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_TELEPHONE; ?>:</td>
      <td align="left"><input type="text" id="txt_telephone" value="<?php echo $user['telephone']; ?>" size="15" maxlength="10" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_EMAIL; ?>:</td>
      <td align="left"><input type="text" id="txt_email" value="<?php echo $user['email']; ?>" size="35" maxlength="30" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><div id="register_error"></div></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="center"><input type="button" id="update_user" value="แก้ไขข้อมูล" /></td>
      <td align="left">&nbsp;</td>
    </tr>
  </table>
</div>
