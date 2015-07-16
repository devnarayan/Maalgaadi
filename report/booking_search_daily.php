<?php
include '../includes/define.php';
verifyLogin();
?>

            <table class="table table-bordered table-striped table-condensed ">
                <tr>
                    <th>Trip Id </th>
                    <th>Organization Name </th>
                    <th>Address </th>
                    <th>Contact No. </th>
                    <th>Received </th>
                    <th>Delivered</th>
                    
                </tr>
            <?php
            
            
            $search2="";
            if((isset($_POST['startDate']))&&(!empty($_POST['startDate']))){
                $date1=  changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);
                $search2= " and pickup_date >= '".$date1."'";
            }
            $search3="";
            if((isset($_POST['endDate']))&&(!empty($_POST['endDate']))){
                 $date2=  changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['endDate']);
                $search3= " and pickup_date <= '".$date2."'";
            }
            
           
            
            $sql = "select booking.customer_address,booking.phone,booking.id, customer.customer_name,customer.customer_organization as customer_organize from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id where 1 and booking.status != '99' $search1 $search2 $search3 $search4 group by booking_id";
            $result=$objConnect->execute($sql);
            $num=  mysql_num_rows($result);
            while($row=$objConnect->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo "<a href='../booking/booking_details.php?booking=" . $row['id'] . "' target='_blank'>" .sprintf("%07d",$row['id'])."</a>";?></td>
                    <td><?php echo $row['customer_organize'];?></td>
                    <td><?php echo $row['customer_address'];?></td>
                    <td><?php echo $row['phone'];?></td>
                    <td></td>
                    <td></td>
                   
                </tr>
            <?php 
            }
            ?>         
                        
            </table>
           