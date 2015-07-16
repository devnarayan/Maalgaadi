<?php include '../includes/define.php'; ?>
<html>
    <head>
        <?php include '../includes/head.php'; ?>
        <style>
            #footer{
                bottom:0 !important;  
            }
        </style>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>

        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li>
                    <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>		                </li>
                <li class="active"><a title="">Booking List</a></li>
            </ul>
        </div>

        <div class="content_middle mt15">    
            <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Vehicle Name</th>
                        <th>Vehicle Registration no</th>
                        <th>Payment</th>
                        <th>Payment Date</th>
                        <th>Payment from</th>
                        <th>Payment to</th>
                        <!--<th>Action</th>-->
                    </tr>
                </thead>
                <tbody>
                <?php 
                $sql="select driver_payment.*, vehicle.name, vehicle.registration_no  from driver_payment,vehicle where vehicle.id=driver_payment.vehicle_id";
                $result=mysql_query($sql) or die(mysql_error());
                while($row=  mysql_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['registration_no'];?></td>
                        <td><?php echo $row['payment'];?></td>
                        <td><?php echo $row['payment_date'];?></td>
                        <td><?php echo $row['payment_from'];?></td>
                        <td><?php echo $row['payment_to'];?></td>
                        <!--<td><a href='employee.php?id=$d'  class='edit_btn' ><i class='fa fa-edit'></i></a> <button type='button' class='del_btn' ><i class='fa fa-trash'></i></button></td>-->
                    </tr>
                <?php
                }
                ?>
</tbody>

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