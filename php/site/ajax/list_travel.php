<table width="550" border="0" cellspacing="0" cellpadding="3" style="background-color:#E6E6E6;margin:5px 0 2px 0;">
  <tr>
    <td width="20" align="right">&nbsp;</td>
    <td width="250"><strong>เส้นทาง</strong></td>
    <td width="80" align="center"><strong>หมายเลขที่นั่ง</strong></td>
    <td width="200" align="center"><strong>วันที่เดินทาง</strong></td>
  </tr>
</table><?php
$database = new SyncDatabase();
$price = 0;
foreach($database->Query("SELECT * FROM ticket_list WHERE ticket_id=$_REQUEST[id] ORDER BY traveldate,seat ASC;") as $list):
$path = $database->Query("SELECT * FROM path WHERE path_id=(SELECT path_id FROM travel WHERE travel_id=$list[travel_id]) LIMIT 1");
$beginPath = $database->Query("SELECT * FROM place WHERE place_id=$path[begin_id] LIMIT 1");
$endPath = $database->Query("SELECT * FROM place WHERE place_id=$path[finish_id] LIMIT 1");
?>
<table width="550" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="20" align="right">&nbsp;</td>
    <td width="250"><?php echo $beginPath['place'].'-'.$endPath['place']; ?></td>
    <td width="80" align="center">ที่นั่ง <?php echo $list['seat']; ?></td>
    <td width="200"><?php echo ThaiDate::Mid($list['traveldate']); ?></td>
  </tr>
</table><?php
$travel = $database->Query("SELECT * FROM travel WHERE travel_id=$list[travel_id] LIMIT 1;");
$price += $travel['fare'];
endforeach; ?>
<hr width="550" align="left" />
<table width="550" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="400" align="right"><strong>ราคารวม : </strong></td>
    <td width="50" align="right"><?php echo number_format($price,2); ?></td>
    <td width="90" align="left"> บาท</td>
  </tr>
</table>
