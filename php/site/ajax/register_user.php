<?php
$database = new SyncDatabase();
$error = 0;
$valid = "^[^\.\$_\'\"<>].+[^\.\$_\'\"|[:space:]<>]@[^\.\$_\'\"|[:space:]<>].+\..+[^\.\$_\'\"<>]$";
if(eregi($valid, $_REQUEST['email']) && $_REQUEST['telephone']!=0) {
	if(isset($_REQUEST['update'])) {
		$database->Query("UPDATE user SET fullname='$_REQUEST[fullname]', sex='$_REQUEST[sex]', address='$_REQUEST[address]', telephone=$_REQUEST[telephone], email='$_REQUEST[email]' WHERE user_id=$_COOKIE[USER];");
		$level = $database->Query("SELECT * FROM user_level WHERE level_id=(SELECT level_id FROM user WHERE user_id=$_COOKIE[USER]) LIMIT 1;");
		$text = _LOGIN_TITLE.$_REQUEST['fullname'].'<br/>'._LOGIN_LEVEL.$level['level'];
	} else {
		$database->Query("INSERT INTO user (username, password, fullname, sex, address, telephone, email) VALUES ('$_REQUEST[username]', '$_REQUEST[password]', '$_REQUEST[fullname]', '$_REQUEST[sex]', '$_REQUEST[address]', '$_REQUEST[telephone]', '$_REQUEST[email]');");
	}
} else {
	$error = 1;
}
echo json_encode(array('error'=>$error,'text'=>$text));
?>