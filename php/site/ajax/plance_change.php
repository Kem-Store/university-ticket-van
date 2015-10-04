<?php
$database = new SyncDatabase();
switch($_REQUEST['mod']) {
	case 'pchange': ?>
        <select name="province_list" id="province_list">
          <?php
        	foreach($database->Query("SELECT * FROM province;") as $place): ?>
          <option value="<?php echo $place['province_id']; ?>" <?php if($place['province_id']==$_REQUEST['province_id']) echo 'selected="selected"'; ?>><?php echo $place['province']; ?></option>
          <?php
			endforeach; ?>
        </select>
        <?php
		break;	
	case 'pbegin': ?>
        <select name="province_begin" id="province_begin" onchange="changeProvinceBegin('pbegin', $(this).val())">
          <?php
          foreach($database->Query("SELECT * FROM province;") as $place): ?>
          <option value="<?php echo $place['province_id']; ?>" <?php if($place['province_id']==$_REQUEST['id']) echo 'selected="selected"'; ?>><?php echo $place['province']; ?></option>
          <?php
          endforeach; ?>
        </select>
    	<?php
		break;	
	case 'begin': ?>
        <select name="place_begin" id="place_begin">
          <?php
          foreach($database->Query("SELECT * FROM place WHERE province_id=$_REQUEST[id];") as $place): ?>
          <option value="<?php echo $place['place_id']; ?>" <?php if($place['place_id']==$_REQUEST['id']) echo 'selected="selected"'; ?>><?php echo $place['place']; ?></option>
          <?php
          endforeach; ?>
        </select>
        <?php
		break;	
	case 'pend': ?>
		 <select name="province_end" id="province_end" onchange="changeProvinceEnd($(this).val())">
		  <?php
          foreach($database->Query("SELECT * FROM province WHERE province_id!=$_REQUEST[id];") as $place): ?>
          <option value="<?php echo $place['province_id']; ?>" <?php if($place['province_id']==$_REQUEST['id']) echo 'selected="selected"'; ?>><?php echo $place['province']; ?></option>
          <?php
          endforeach; ?>
        </select>
		<?php
		break;	
	case 'end': ?>
		<select name="place_end" id="place_end">
		  <?php
          foreach($database->Query("SELECT * FROM place WHERE province_id=$_REQUEST[id];") as $place): ?>
          <option value="<?php echo $place['place_id']; ?>" <?php if($place['place_id']==$_REQUEST['id']) echo 'selected="selected"'; ?>><?php echo $place['place']; ?></option>
          <?php
          endforeach; ?>
        </select>
		<?php
		break;	
	
} ?> 