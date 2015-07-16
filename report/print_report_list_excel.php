<?php include '../includes/define.php'; ?>
<?php
 $file = 'DailyReportSheet-'.date("Y-M-D")."-".time().'.xls';
 ob_start();
?>

<table class="table table-bordered table-striped table-condensed ">
                <tr  style="border:1px solid #ccc">
                    <th>Trip Id </th>
                    <th>Organization Name </th>
                    <th>Address </th>
                    <th>Contact No. </th>
                    <th>Received </th>
                    <th>Delivered</th>
                    
                </tr>
            <?php
                       
            $search2="";
            if((isset($_REQUEST['startDat']))&&(!empty($_REQUEST['startDat']))){
                $date1=  changeFormat("d/m/Y", "Y-m-d 00:00:00", $_REQUEST['startDat']);
                $search2= " and pickup_date >= '".$date1."'";
            }
            $search3="";
            if((isset($_REQUEST['endDat']))&&(!empty($_REQUEST['endDat']))){
                 $date2=  changeFormat("d/m/Y", "Y-m-d 23:59:59", $_REQUEST['endDat']);
                $search3= " and pickup_date <= '".$date2."'";
            }           
           
            
            $sql = "select booking.customer_address,booking.phone,booking.id, customer.customer_name,customer.customer_organization as customer_organize from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id where 1 and booking.status != '99' $search2 $search3 group by booking_id";
            $result=$objConnect->execute($sql);
            $num=  mysql_num_rows($result);
            while($row=$objConnect->fetch_assoc()){
                ?>
                <tr  style="border:1px solid #ccc">
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
<?php

 $content = ob_get_contents();
 ob_end_clean();
 header("Expires: 0");
 header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 header("Cache-Control: no-store, no-cache, must-revalidate");
 header("Cache-Control: post-check=0, pre-check=0", false);
 header("Pragma: no-cache");  header("Content-type: application/vnd.ms-excel;charset:UTF-8");
 header('Content-length: '.strlen($content));
 header('Content-disposition: attachment; filename='.basename($file));
 echo $content;
 exit;

?>