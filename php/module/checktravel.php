<?php
$session = new Session();
$database = new SyncDatabase(); ?>
<h3>เส้นทางและผู้ให้บริการ</h3>
<table width="400" border="0" align="center" cellpadding="3" cellspacing="0" style="margin:5px 20px 10px 20px;"><?php
  foreach($database->Query("SELECT * FROM travel;") as $travel): 
  $car = $database->Query("SELECT * FROM car WHERE car_id=$travel[car_id] LIMIT 1;");
  $beginplace = $database->Query("SELECT * FROM place WHERE place_id=(SELECT begin_id FROM path WHERE path_id=$travel[path_id] LIMIT 1) LIMIT 1;");
  $finishplace = $database->Query("SELECT * FROM place WHERE place_id=(SELECT finish_id FROM path WHERE path_id=$travel[path_id] LIMIT 1) LIMIT 1;"); ?>
  <tr>
    <td><strong><a onclick="navChangeModule(<?php echo $travel['travel_id']; ?>, 'ticketing')" style="color:#390"><?php echo $car['regis']; ?></a></strong></td>
    <td><?php echo $beginplace['place']; ?> - <?php echo $finishplace['place']; ?></td>
    <td>ราคา <?php echo $travel['fare']; ?> บาท</td>
  </tr><?php
  endforeach; ?>
</table>
