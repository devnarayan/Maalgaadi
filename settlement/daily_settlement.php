<?php include '../includes/define.php'; ?>
<html><head>
        <?php include '../includes/head.php'; ?>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>
        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li>
                    <a href="<?php echo BASE_URL; ?>" title="<?php echo BASE_URL; ?>">Home</a>		                
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>/settlement/driver_remaining.php" title="">DRiver Remaining</a>		                
                </li>
                <li class="active"><a title=""> Daily Settlement </a></li>
            </ul>
        </div>
       
        <div class="content_middle mt15">    
            <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Vehicle Name</th>
                        <th>Vehicle Registration no</th>
                        <th>Date</th> 
                        <th>Free Distance</th>
                        <th>Booking Distance</th>
                        <th>Time</th>
                        <th>Base Amount</th>
                        <th>Extra hour</th>
                        <th>Extra Km</th>
                        <th>Amount Payable</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php    $sql = "select vehicle.*, settlement.date, settlement.free_distance,settlement.booking_distance,settlement.time,settlement.base_amount,settlement.extra_hour,settlement.extra_km,settlement.amount_payable from vehicle inner join settlement on settlement.vehicle_id=vehicle.id";
                     $result=mysql_query($sql) or die(mysql_error());
                while($row=  mysql_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['registration_no'];?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo round($row['free_distance'],2);?></td>
                        <td><?php echo round($row['booking_distance'],2);?></td>
                        <td><?php echo round($row['time'],2);?> hrs</td>
                        <td><i class="fa fa-rupee"></i> <?php echo round($row['base_amount'],2);?></td>
                        <td><?php if($row['extra_hour']<0){echo "Less ";} echo abs(round($row['extra_hour'],2));?> Hrs </td>
                        <td><?php if($row['extra_km']<0){echo "Less ";} echo abs(round($row['extra_km'],2));?> Km</td>
                        <td><i class="fa fa-rupee"></i> <?php echo round($row['amount_payable'],2);?></td>
                        <td><a href='pay_to_driver.php?id=<?php echo $row['id']?>'  class='edit_btn' ><i class='fa fa-edit'></i></a> </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </table>

        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
    </div>

    <script src="<?php echo BASE_PATH; ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>css/jquery.dataTables.css">
<!--dtat tabl-->
<style>
    tfoot {
        display: table-header-group;
    }
</style>
<script>
$("#example").DataTable();

</script>
<?php include '../includes/footer.php'; ?>
</body>
</html> 