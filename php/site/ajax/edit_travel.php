<?php
$database = new SyncDatabase();
$pay = 0;
if($_REQUEST['pay']==0) $pay = 1;
$text = '<strong><a style="color:#06F" onclick="payChange('.$_REQUEST['id'].','.$pay.')">จ่ายแล้ว</a></strong>';
if($pay==0) $text = '<strong><a style="color:#900" onclick="payChange('.$_REQUEST['id'].','.$pay.')">รอตวจสอบ</a></strong>';

$database->Query("UPDATE ticket SET pay=$pay WHERE ticket_id=$_REQUEST[id];");
echo json_encode(array('text'=>$text));
?>
