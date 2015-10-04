<script>
var isUpdate = 0;
$(document).ready(function(){
	$('#travel_form').popupBox(600, 500);
	listviewChange($('#listpay').val());
	if($('#listpay').val()==0) $('#is_pay').hide(); 
	$('#is_pay').click(function() {
		if($('#date_pay').val()!='') {
			$.ajax({ url: 'index.php?ajax=edit_pay',
				data: ({ id:$('#listpay').val(), update:isUpdate, bank_id:$('#bank').val(), date_pay:$('#date_pay').val() }),
				error: function() {	alert("Error: Upadet PayBank " + isUpdate); },
				success: function(epay) {
					alert("ยืนยันการชำระเงินเรีบร้อย"); 
					listviewChange($('#listpay').val());
				},
			});	
		}
	});
});
function listviewChange(tid) {
	$.ajax({ url: 'index.php?ajax=edit_pay',
		data: ({ edit:'view', id:tid }),
		error: function() {	alert("Error: edit_pay"); },
		success: function(data) {
			$('#bank option:selected').removeAttr('selected');
    		$('#bank option[value='+data.bank+']').attr('selected','selected');
			$('#date_pay').val(data.date);
			if(data.date!=null) { $('#is_pay').val('แก้ไขยืนยันการชำระเงิน'); isUpdate = 1; } else { $('#is_pay').val('ยืนยันการชำระเงิน'); isUpdate = 0; }
			
			$.ajax({ url: 'index.php?ajax=list_travel',
				data: ({ id:tid }),
				dataType: "html",
				error: function() {	$('#time_travel').html("Error: Ajax User Login"); },
				success: function(data) {
					$('#list_ticket').html(data);
				},
			});	
			
		},
	});	
}
</script><?php
$session = new Session();
$database = new SyncDatabase();
?>
<h3>ยืนยันการชำระเงิน</h3>
<div style="margin:5px 20px 10px 20px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td><strong>บัญชีธนาคารที่ชำระ</strong></td>
      <td> 
       <select name="bank" id="bank"><?php
        foreach($database->Query("SELECT * FROM bank_account;") as $bank): ?>
         <option value="<?php echo $bank['bank_id']; ?>"><?php echo $bank['name'].' เลขบัญชี '.$bank['account']; ?></option><?php
		endforeach; ?>
       </select>
       <input type="button" id="how_pay" value="วิธีชำระงิน" onclick="$('#travel_form').popupClose();$('#travel_form').popupOpen()" /></td>
    </tr>
    <tr>
      <td><strong>วันที่และเวลาที่ชำระเงิน</strong></td>
      <td><input type="text" id="date_pay" value="" maxlength="50" size="30" /> <span style="font-size:9px; color:#999"> ตัวอย่าง <u>30/12/2550 20.40</u></span></td>
    </tr>
    <tr>
      <td style="padding:10px 0 0 2px;"><strong>รายการที่ต้องชำระเงิน</strong></td>
      <td rowspan="2" valign="top"><div id="list_ticket"></div></td>
    </tr>
    <tr>
      <td width="150" valign="top" style="padding:5px 0 0 3px;"><?php
		if($database->Query("SELECT * FROM ticket WHERE user_id=$_COOKIE[USER] AND pay!=1 ORDER BY date DESC;")): ?>
        <select name="listpay" id="listpay" onchange="listviewChange($(this).val())"><?php
        foreach($database->Query("SELECT * FROM ticket WHERE user_id=$_COOKIE[USER] AND pay=0 ORDER BY date DESC;") as $ticket): ?>
         <option value="<?php echo $ticket['ticket_id']; ?>">รหัสรายการที่ <?php echo $ticket['ticket_id']; ?></option><?php
		endforeach; ?>
       </select><?php
	   else: ?>
        <select name="listpay" id="listpay" disabled="disabled">
		 <option value="0">ชำระเงินเรียบร้อยแล้ว</option>
		</select><?php
	   endif; ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="button" id="is_pay" value="" onclick="" /></td>
    </tr>
  </table>
</div>
<div id="travel_form">
  <div class="login_body">
    <h3>วิธีสั่งจองและชำระเงิน</h3>
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:5px 20px 10px 20px;">
      <tbody>
        <tr>
          <td width="85%"> ชำระผ่านตู้เอทีเอ็มธนาคาร (ไทยพาณิชย์, กสิกรไทย, กรุงไทย)</td>
        </tr>
        <tr>
          <td>1. ทำการจอง ที่เว็บไซต์นี้ <br />
            2. รับรหัสการจอง <br />
            3. นำรหัสการจองและจำนวนเงินไปชำระผ่านตู้เอทีเอ็ม ธนาคารดังต่อไปนี้ <br />
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tbody>
                <tr>
                  <td width="25"> </td>
                  <td width="404">&nbsp;</td>
                </tr>
                <tr>
                  <td> </td>
                  <td><div id="atm_node"><strong>ธนาคารไทยพาณิชย์</strong> (ชำระภายในเที่ยงคืนของวันที่ทำรายการ )<br />
                      1. เลือก &ldquo;อื่นๆ/OTHERS&rdquo; <br />
                      2. เลือก &ldquo;ชำระสินค้า/บริการ&rdquo;<br />
                      3. เลือก &ldquo;ชำระเงินเข้าบริษัทอื่นๆ&rdquo;<br />
                      4. เลือกจากบัญชี (เดินสะพัด/บัตรของขวัญ, ออมทรัพย์, บัตรเครดิต/SPEEDY CASH, ประจำ) <br />
                      5. ใส่หมายเลข COMP CODE &ldquo;7002&rdquo;<br />
                      6. ใส่ จำนวนเงิน<br />
                      7. ใส่หมายเลขอ้างอิง โดย<br />
                      CUSTOMER NO ใส่ รหัสการจอง <br />
                      REFERENCE NO กด ต้องการ โดยไม่ต้องใส่ข้อมูลใดๆ<br />
                      8. รับใบบันทึกรายการ<br />
                    </div></td>
                </tr>
              </tbody>
            </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tbody>
                <tr>
                  <td width="25"> </td>
                  <td width="404">&nbsp;</td>
                </tr>
                <tr>
                  <td> </td>
                  <td><div id="atm_node2"><strong>ธนาคารกสิกรไทย</strong> (ชำระเงินก่อนเวลา 22.00 น. ของวันที่ทำรายการ )<br />
                      1. เลือก &quot;ชำระเงิน / เติมเงินมือถือ / กองทุนรวม&quot;<br />
                      2. เลือก &ldquo;อื่นๆ/ระบุรหัสบริษัท&rdquo; <br />
                      3. เลือกหักจากบัญชี (ออมทรัพย์, กระแสรายวัน)<br />
                      4. ใส่รหัสบริษัท &ldquo;70003&rdquo;<br />
                      5. หมายเลขสมาชิก/บัญชี ให้ท่านใส่ รหัสการจอง<br />
                      6. ใส่ จำนวนเงิน<br />
                      7. รับใบบันทึกรายการ<br />
                    </div></td>
                </tr>
              </tbody>
            </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tbody>
                <tr>
                  <td width="25"> </td>
                  <td width="404">&nbsp;</td>
                </tr>
                <tr>
                  <td> </td>
                  <td><div id="atm_node3"><strong>ธนาคารกรุงไทย</strong> (ชำระเงินก่อนเวลา 23.00 น. ของวันที่ทำรายการ )<br />
                      1. เลือก &ldquo;บริการอื่นๆ&rdquo;<br />
                      2. เลือก &ldquo;ชำระค่าบริการ&rdquo;<br />
                      3. เลือก &ldquo;ระบุรหัสบริษัท&rdquo;<br />
                      4. เลือกประเภทบัญชี (ออมทรัพย์, กระแสรายวัน)<br />
                      5. ใส่รหัสบริษัท &ldquo;2009&rdquo;<br />
                      6. ใส่หมายเลขอ้างอิงที่ต้องการชำระ ให้ท่านใส่ รหัสการจอง<br />
                      7. ใส่ จำนวนเงิน<br />
                      8. รับใบบันทึกรายการ<br />
                    </div></td>
                </tr>
              </tbody>
            </table>
            <br />
            4. ไปขึ้นรถ โดยใช้ใบบันทึกรายการ (สลิปเอทีเอ็ม)<br />
            <br />
            *หมายเหตุ : <br />
            - ต้องชำระเงินภายในเวลา 24.00 น. (ก่อนเที่ยงคืน) ของวันที่ทำการจอง <br />
            - ยกเว้นธนาคารกรุงไทย ต้องชำระเงินภายในเวลา 23.00 น. ของวันที่ทำการจอง<br />
            - และ ธนาคารกสิกรไทย ต้องชำระเงินภายในเวลา 22.00 น. ของวันที่ทำการจอง<br />
            - เสียค่าธรรมเนียมการบริการ 15 บาทต่อรายการ ทุกธนาคาร</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
