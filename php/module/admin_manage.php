<script>
adminEdit('admin_ticket', '#edit_ticket');
function adminEdit(file, menu) {
	$('#head_admin').html($('#head_admin').attr('lang') + $(menu).html());
	$.ajax({ url: 'index.php?ajax=' + file,
		dataType: "html",
		error: function() {	$('#admin_html').html("Error: Ajax User Login"); },
		success: function(data) {
			$('#admin_html').html(data);
		},
	});			
}
</script>
<h3 lang="จัดการระบบ" id="head_admin">จัดการระบบ</h3>
  <table width="100%" cellpadding="0" cellspacing="0" style="margin:10px 0 10px 0;">
    <tr>
      <td style="border-right:#D2D2D2 solid 1px;" valign="top">
        <div id="admin_html">&nbsp;</div>
      </td>
      <td style="border-left:#FFFFFF solid 1px; width:200px;" valign="top">
        <div id="line_menu"></div>
        <div id="edit_ticket" onclick="adminEdit('admin_ticket', this)">ตรวจสอบข้อมูลตั๋ว</div>
        <div id="edit_path" onclick="adminEdit('admin_path', this)">ข้อมูลเส้นทาง</div>
        <div id="edit_place" onclick="adminEdit('admin_place', this)">ข้อมูลสถานที่</div>
        <div id="edit_car" onclick="adminEdit('admin_car', this)">ข้อมูลรถ</div>
      </td>
    </tr>
  </table>
