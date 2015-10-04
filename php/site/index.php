<script>
$(document).ready(function(){
	$('#login_form').popupBox(450, 200);
	$('#register_form').popupBox(640, 400);	
	
	$('#login').click(function() { loginProcess(); });
	$("#username, #password").keypress(function(event) { if(event.which==13) loginProcess(); });

	$('#logout').click(function() {
		$.ajax({ url: 'index.php?ajax=user_employee',
			data: ({ user:'logout' }),
			error: function() {	$('#login_welcome').html("Error: Ajax User Login"); },
			success: function(data) {
				$('#nav_ticketing').attr('disabled', 'disabled');
				$('#nav_checkticket').attr('disabled', 'disabled');
				$('#nav_pay').attr('disabled', 'disabled');
				$('#login_register').show();
				$('#login_user').hide();
			},
		});
	});	
	
	var isRegister=0;
	var isUsername=0;
	
	$('#vailduser').click(function(){
		if($('#txt_username').val().length>3) {
			$.ajax({ url: 'index.php?ajax=user_employee',
				data: ({ user:'vaild', username: $('#txt_username').val() }),
				error: function() {	$('#register_error').html("Error: Ajax User Regiser"); },
				success: function(data) {
					if(data.vaild) {
						isUsername = 0;
						$('#vaild_error').html('<?php echo _REGISTER_OVERUSER; ?>');
					} else {
						isUsername = 1;
						$('#vaild_error').html('<?php echo _REGISTER_VAILDUSER; ?>');
					}
				},
			});
		} else {
			$('#vaild_error').html('<?php echo _REGISTER_OVERUSER; ?>');
			isUsername = 0;
		}
	});
	
	$('#txt_email, #txt_telephone, #txt_address, #txt_fullname, #txt_repassword, #txt_password, #txt_username').bind('change keyup', function() {
		if($(this).val()=='') {
			$(this).css('outline','#900 solid 1px');
		} else {
			$(this).css('outline','none');
		}
		
		if($('#txt_email').val()!=''&&$('#txt_telephone').val().length>9&&$('#txt_address').val()!=''&&$('#txt_fullname').val()!=''&&$('#txt_repassword').val()!=''&&$('#txt_password').val()!=''&&$('#txt_username').val()!='') {
			if($('#txt_repassword').val()==$('#txt_password').val()) {
				isRegister = 1;
			} else {
			 isRegister = 0;
			}
		} else {
			isRegister = 0;
		}
	});
	
	$('#register').click(function(){
		if(!isUsername) {
			$('#register_error').html('<?php echo _REGISTER_USERCHECK; ?>');
		} else if(isRegister && isUsername) {
			$.ajax({ url: 'index.php?ajax=register_user',
				data: ({
					username: $('#txt_username').val(),
					password: $('#txt_password').val(),
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
						alert('สมัครสมาชิกเรียบร้อยแล้ว');
						isRegister = 0;
						isUsername = 0;
						$('#register_error').empty();
						$('#register_form').popupClose();
						$('#txt_email, #txt_telephone, #txt_address, #txt_fullname, #txt_repassword, #txt_password, #txt_username').val('');
					}
				},
			});			
		} else {
			$('#register_error').html('<?php echo _REGISTER_ERROR; ?>');
		}
	});
	
	navChangeModule(null, 'frontpage');
});

function loginProcess()
{
	$('#preload_view').show();
	$.ajax({ 
		url: 'index.php?ajax=user_employee',
		data: ({ user:'login', username: $('#username').val(), password: $('#password').val() }),
		error: function() {	$('#login_error').html("Error: Ajax User Login"); },
		success: function(data) {
			$('#preload_view').hide();
			if(!data.error) {
				$('#login_error').empty();
				$('#password, #username').val('');
				$('#nav_ticketing').removeAttr('disabled');
				$('#nav_checkticket').removeAttr('disabled');
				$('#nav_pay').removeAttr('disabled');
				$('#login_form').popupClose()
				$('#login_register').hide();
				$('#login_user').show();
				$('#login_welcome').html(data.text);
				if(data.level==4) {
					$('#manager_admin').show();
				} else {
					$('#manager_admin').hide();
				}
			} else {
				$('#login_error').html(data.error);					
			}
		},
	});
}

var beforeChange = null;
function navChangeModule(menu, name)
{
	$.ajax({ url: 'index.php?mod=' + name,
		dataType: "html",
		error: function() {	$('.frame_footer').html("Error: Module " + name); },
		success: function(data) {
			$('.frame_body').html(data);
			if(menu>0) {
				$('#travel_form').popupClose();
				$('#travel_form').popupOpen();
				$('#id_travel option:selected').removeAttr('selected');
    			$('#id_travel option[value='+menu+']').attr('selected','selected');
			}
			beforeChange = menu;
		},
	});
}
</script>
<div style="background-color:#000; height:40px;"><?php
$session = new Session();
$database = new SyncDatabase();
?>
</div>
<table align="center" width="786" border="0" cellspacing="0" cellpadding="0" class="main_frame">
  <tr><td colspan="3" background="images/border_top.png" class="frame_border"></td></tr><tr><td class="frame_lr"></td>
    <td>
      <div class="frame_header">
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td width="50%" valign="bottom"><img src="images/logoHeader.jpg" border="0" width="330" height="52" hspace="20" style="margin-bottom:10px;" /></td>
          <td width="50%" valign="top" align="right">
            <div id="login_frame">
             <div id="login_register" <?php if($session->Value('USER')) echo 'style="display:none;"'; ?>>
               <span class="login_menu"><a onclick="$('#login_form').popupOpen();$('#username').focus()"><?php echo _LOGIN_LOGIN; ?></a></span>
               <span class="login_menu"><a onclick="$('#register_form').popupOpen()" style="color:#00a0e9;"><?php echo _LOGIN_REGISTER; ?></a></span>
               <span style="border-left:#D3D3D3 solid 1px;"></span>
             </div>
             <div id="login_user" <?php if(!$session->Value('USER')) echo 'style="display:none;"'; ?>>
               <span class="login_menu" id="manager_admin" <?php if($session->Value('LEVEL')!=4) echo 'style="display:none;"'; ?>>
               <a onclick="navChangeModule(this,'admin_manage')" style="color:#00a0e9;"><?php echo _ADMIN_MANAGER; ?></a></span>
               <span class="login_menu" id="user_edit"><a onclick="navChangeModule(this, 'useredit')" style="color:#00a0e9;"><?php echo _LOGIN_EDITUSER; ?></a></span>
               <span class="login_menu"><a id="logout" style="color:#9c1e00;"><?php echo _LOGIN_LOGOUT; ?></a></span>
               <span style="border-left:#D3D3D3 solid 1px;"></span>
               <div id="login_welcome"><?php
				if($session->Value('USER')) {
					$user_id = $session->Value('USER');
					$user = $database->Query("SELECT * FROM user WHERE user_id=$user_id LIMIT 1;");
					$level = $database->Query("SELECT * FROM user_level WHERE level_id='$user[level_id]' LIMIT 1;");
					echo _LOGIN_TITLE.$user['fullname'].'<br/>'._LOGIN_LEVEL.$level['level'];
				} ?>               
               </div>
             </div>
            </div>
          </td>
        </tr>
      </table>
      </div> 
      <div class="frame_nav"><?php
		$navigator = array('Frontpage'=>_NAV_FRONTPAGE, 'Ticketing'=>_NAV_TICKET, 'CheckTicket'=>_NAV_CHECKTICKET, 'CheckTravel'=>_NAV_CHECKTRAVEL, 'Pay'=>_NAV_PAY, 'Contract'=>_NAV_CONTRACT);
		foreach($navigator as $text=>$title) {			
			echo '<input type="button" class="nav_menu" id="nav_'.strtolower($text).'" onclick="navChangeModule(this, \''.strtolower($text).'\')" alt="'.$text.'" title="'.$title.'"';
			if(($text==='Ticketing' || $text==='CheckTicket' || $text==='Pay') && !$session->Value('USER')) echo 'disabled="disabled"';
			echo '/>';			
		} ?>
      </div> 
      <div class="frame_body">
        body

      </div>
      <div class="frame_footer">&nbsp;</div>
    </td>
  <td class="frame_lr"></td></tr><tr><td colspan="3" background="images/border_bottom.png" class="frame_border"></td></tr>
</table>
<div id="register_form">
<div class="register_body">
 <h3><?php echo _REGISTER_HEAD; ?></h3>
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td align="left" width="25%">&nbsp;</td>
      <td align="left" width="40%">&nbsp;</td>
      <td align="left" width="35%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_USERNAME; ?>:</td>
      <td align="left"><input type="text" id="txt_username" value="" size="20" maxlength="20" /> <input id="vailduser" type="button" value="ตรวจสอบ" />
        </td>
      <td align="left"><span id="vaild_error"></span></td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_PASSWORD; ?>:</td>
      <td align="left"><input type="password" id="txt_password" value="" size="10" maxlength="20" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_REPASSWORD; ?>:</td>
      <td align="left"><input type="password" id="txt_repassword" value="" size="10" maxlength="20" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_FULLNAME; ?>:</td>
      <td align="left"><input type="text" id="txt_fullname" value="" size="30" maxlength="50" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_SEX; ?>:</td>
      <td align="left">
       <label><input type="radio" name="txt_sex" value="M" checked="checked"/><?php echo _REGISTER_SEX_M; ?></label>
       <label><input type="radio" name="txt_sex" value="F" /><?php echo _REGISTER_SEX_F; ?></label>
      </td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="top"><?php echo _REGISTER_ADDRESS; ?>:</td>
      <td align="left"><textarea cols="30" rows="4" id="txt_address"></textarea></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_TELEPHONE; ?>:</td>
      <td align="left"><input type="text" id="txt_telephone" value="" size="15" maxlength="10" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><?php echo _REGISTER_EMAIL; ?>:</td>
      <td align="left"><input type="text" id="txt_email" value="" size="35" maxlength="30" /></td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="left"><div id="register_error"></div></td>
    </tr>
  </table></div>
 <div class="loginbg_btn"><input type="button" class="btn_register" id="register" /></div>
</div>
<div id="login_form">
  <div class="login_body">
    <div id="login_error">&nbsp;</div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px 5px 10px 5px;height:80px;">
      <tr>
        <td width="60%" style="border-right:#F7F7F7 solid 1px;">
         <div class="box_username"><input type="text" id="username" value="" maxlength="19"/></div>
         <div class="box_password"><input type="password" id="password" value="" maxlength="19" /></div>
        </td>
        <td width="40%" align="center" valign="top">
        <div id="login_preload"><span id="preload_view"><img src="images/ajax-loader.gif" width="16" height="16" border="0" /></span></div>
         <?php echo _LOGIN_NOREGISTER; ?><br />
         <strong><a onclick="$('#register_form').popupOpen()" style="font-size:12px;"><?php echo _LOGIN_REGISTER; ?></a></strong>
        </td>
      </tr>
    </table>
  </div>
  <div class="loginbg_btn"><input type="button" class="btn_login" id="login" /></div>
</div>
