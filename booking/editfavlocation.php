<?php
include '../includes/define.php';
$id=$_GET['id'];
$result=$objConnect->selectWhere("favorite_location","id=$id");
$row=$objConnect->fetch_assoc();
?>
<form id="edit_fav_location" class="form">
    <div class="new_booking_field">
        <span class="fl mt5">pick_up_name</span> <input type="text" title="Enter the Pickup Person Name" class="required fl" name="pick_up_name"  value="<?php echo $row['pick_up_name'];?>"  autocomplete="off"  placeholder="Enter the Pickup name" />
    </div>
    <div class="new_booking_field mt10">
        <input type="number" minlength="10" title="Enter the Pickup Person Mobile No" class="required fl " name="pick_up_no"  value="<?php echo $row['pick_up_no'];?>"  autocomplete="off"  placeholder="Enter the Pickup Number" />
    </div>
    <div class="new_booking_field mt10">
        <input type="text" title="Enter the Pickup organization"  name="pick_up_organization"  value="<?php echo $row['pick_up_organization'];?>"  autocomplete="off"  placeholder="Enter the Pickup organization" />
    </div>
    <div class="new_booking_field mt10">
        <input type="text" title="Enter the Pickup Address" name="current_location"  value="<?php echo $row['current_location'];?>"  autocomplete="off"  placeholder="Enter the Pickup Address" />
    </div>
    <div class="new_booking_field mt10">
        <input type="text" title="Enter the Pickup Landmark" class="required " name="pick_up_landmark" id="fav_pick_up_landmark" value="<?php echo $row['pick_up_landmark'];?>"   placeholder="Enter the Pickup Landmark" onChange=""/>
        <input type="hidden" name="pickup_lat" id="fav_pickup_lat" value="<?php echo $row['fav_pickup_lat'];?>">
        <input type="hidden" name="pickup_lng" id="fav_pickup_lng" value="<?php echo $row['fav_pickup_lng'];?>">
        <input type="hidden" name="mode" value="editFav">
        <input type="hidden" name="id" value="<?php echo $id;?>">
    </div>
</form>
<div id="edit_fav_location_result"></div>
