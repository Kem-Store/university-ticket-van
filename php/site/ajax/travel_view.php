<?php
$database = new SyncDatabase();

foreach($database->Query("SELECT * FROM old_list WHERE user_id=$_COOKIE[USER] AND view=1;") as $list): ?>
<table align="center" width="550" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="left" width="300"><a style="color:#900;" onclick="delOldList(<?php echo $list['old_id']; ?>)"><strong>x</strong></a> <?php echo ThaiDate::Mid($list['time']); ?></td>
    <td align="center" width="170"><?php
		 $path = $database->Query("SELECT * FROM path WHERE path_id=(SELECT path_id FROM travel WHERE travel_id=$list[travel_id]) LIMIT 1");
		 $beginPath = $database->Query("SELECT * FROM place WHERE place_id=$path[begin_id] LIMIT 1");
		 $endPath = $database->Query("SELECT * FROM place WHERE place_id=$path[finish_id] LIMIT 1");
		 $car = $database->Query("SELECT * FROM car WHERE car_id=(SELECT car_id FROM travel WHERE travel_id=$list[travel_id]) LIMIT 1");
         echo $beginPath['place'].'-'.$endPath['place'];?>
        </td>
     <td align="center" width="80"><?php echo $car['regis']; ?></td>
  </tr>
</table><?php
endforeach; ?>
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="10" style="border-top:#E6E6E6 solid 1px;">
      <tr>
        <td align="center"><div id="verify_order"></div></td>
      </tr>
    </table>