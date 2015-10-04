<script>
timeChange();
function timeChange() {
	$.ajax({ url: 'index.php?ajax=travel_time',
		data: ({day:$('#day').val(), mon:$('#mon').val(), year:$('#year').val() }),
		dataType: "html",
		error: function() {	$('#time_travel').html("Error: Ajax User Login"); },
		success: function(data) {
			$('#time_travel').html(data);
		},
	});
}

function chkTicketList() {
	$.ajax({ url: 'index.php?ajax=ticket_check',
		data: ({ time:$('#path_time').val() }),
		dataType: "html",
		error: function() {	alert("Error: ticket_check"); },
		success: function(data) {
			$('#list_ticket').html(data);
		},
	});
}
</script>
<?php
$session = new Session();
$database = new SyncDatabase();
$nowDate = getdate(time()-3600);
$fullMonth = array(0,_January, _February, _March, _April, _Mays, _June, _July, _August, _September, _October, _November, _December);
?>
<h3>ตรวจสอบการจอง</h3>
<table width="100%" cellpadding="0" cellspacing="0" style="margin:10px;">
  <tr>
    <td width="100" align="right"><strong>วันที่เดินทาง:</strong></td>
    <td width="250" style="padding:3px 3px 3px 5px;">
      <select name="day" id="day" onchange="timeChange()">
        <?php
        for($dloop=1;$dloop<=31;$dloop++): ?>
        <option value="<?php echo $dloop; ?>" <?php if($nowDate['mday']==$dloop) echo 'selected="selected"'; ?>><?php echo $dloop; ?></option>
        <?php
		endfor; ?>
      </select>
      เดือน
      <select name="month" id="mon" onchange="timeChange()">
        <?php
        for($mloop=1;$mloop<=12;$mloop++): ?>
        <option value="<?php echo $mloop; ?>" <?php if($nowDate['mon']==$mloop) echo 'selected="selected"'; ?>><?php echo $fullMonth[$mloop]; ?></option>
        <?php
		endfor; ?>
      </select>
       ปี <select name="year" id="year" onchange="timeChange()"><?php
        for($yloop=($nowDate['year']+543);$yloop<($nowDate['year']+546);$yloop++): ?>
         <option value="<?php echo $yloop; ?>"><?php echo $yloop; ?></option><?php
		endfor; ?>
       </select>
      <td width="90" style="padding-right:10px;" align="right"><strong>เลือกช่วงเวลา:</strong>&nbsp;</td>
      <td width="140"><div id="time_travel">&nbsp;</div></td>
      <td><input type="button" value="ตรวจสอบ" id="chk_ticket" onclick="chkTicketList()" /></td>
   </tr>
</table><hr width="90%" />
<div id="list_ticket">
<table align="center" width="510" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="3" align="center"><strong>ระบุข้อมูลวันที่เดินทางตามต้องการ, กดตรวจสอบ</strong></td>
  </tr>
</table>
</div>