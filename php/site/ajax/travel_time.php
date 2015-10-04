<select name="path_time" id="path_time" onchange="seatChange()"><?php
  for($tloop=6;$tloop<19;$tloop++):
    $nowTime = mktime($tloop,0,0, $_REQUEST['mon'], $_REQUEST['day'], ($_REQUEST['year']-543));?>  
    <option value="<?php echo $nowTime; ?>"><?php echo $tloop; ?>.00</option><?php
  endfor; ?>
</select> น. 