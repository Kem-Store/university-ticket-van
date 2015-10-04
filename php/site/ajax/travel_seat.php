<?php
$database = new SyncDatabase();
$car = $database->Query("SELECT * FROM car WHERE car_id=(SELECT car_id FROM travel WHERE travel_id=$_REQUEST[idtravel]) LIMIT 1");
$listDisabled = array();
foreach($database->Query("SELECT * FROM old_list;") as $list) {
	for($tloop=1;$tloop<=$car['seat_limit'];$tloop++) {
		if($list['time']==$_REQUEST['time'] && $list['travel_id']==$_REQUEST['idtravel'] && $list['seat']==$tloop) {
			$listDisabled[$tloop] = true;
		}
	}
}
?>
<select name="seat_select" id="seat_select"><?php
  for($tloop=1;$tloop<=$car['seat_limit'];$tloop++):
	  if(!isset($listDisabled[$tloop])): ?>
        <option value="<?php echo $tloop; ?>"><?php echo $tloop; ?></option><?php
	  endif;
  endfor; ?>
</select>