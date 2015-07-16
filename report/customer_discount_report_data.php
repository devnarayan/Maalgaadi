<?php
include '../includes/define.php';
verifyLogin();
?>
<style>
    .allhisde{display:none;}
    .newback{background:#F5F5F5 !important;}
    pre {
  display: block;
  padding: 5px;
  margin: 0 0 10px;
  font-size: 13px;
  line-height: 1.428571429;
  color: #333;
  word-break: break-all;
  word-wrap: break-word;
  background-color: #f5f5f5;
  border: 1px solid #ccc;
  border-radius: 4px;
}
em{
  font-style: italic;color: #333;text-align: right;
}
</style>
<!-- Coding for Get Opening Balance-->
<?php
            $search1="";
             if((isset($_POST['customer_id']))&&(!empty($_POST['customer_id']))){
                $search1= " and customer.id like '".$_POST['customer_id']."'";
            }
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
        
            $total_amount=0;$total_estimate=0;$total_payment=0;$total_balance=0;$discount_amt = 0;$cahreceive_amt = 0;
            $total_discount = 0;$total_cahreceive = 0;
            // get opening balance
            $openingDateStart= "and pickup_date >= '2015-01-01 00:00:00'";
            $ne = changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);
            $openingDateEnd = "and pickup_date <= '".$date1."'";
            
            $getOpening = "select DISTINCT CASE WHEN cashreceive_date IN (DATE(pickup_date)) THEN cash_amount ELSE '0.00' END AS cash_amount,DATE(pickup_date) as pickDate,CASE WHEN discount_date IN (DATE(pickup_date)) THEN discount_amount ELSE '0.00' END AS discount_amount,booking.pickup_date from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id left join discount on discount.customer_id=customer.id and DATE(discount.discount_date) = DATE(booking.pickup_date) left join cashreceive on cashreceive.customer_id=customer.id and DATE(cashreceive.cashreceive_date) = DATE(booking.pickup_date) where 1 $search1 $openingDateStart $openingDateEnd group by pickDate";
            $getOpeningResult=$objConnect->execute($getOpening);
            while($getOpeningData=  mysql_fetch_array($getOpeningResult)){
            $date11= $getOpeningData['pickDate']." 00:00:00";
            $date12= $getOpeningData['pickDate']." 23:59:59";
            $searchNewStart= " and pickup_date >= '".$date11."'";
            $searchEndStart= " and pickup_date <= '".$date12."'";
            $discount_amt = $getOpeningData['discount_amount'];
            $cahreceive_amt = $getOpeningData['cash_amount'];
            
           $sql = "select booking.*,vehicle.registration_no, vehicle.name as vname,booking_short.trip_time,booking_short.trip_distance,booking_short.payment_type,booking_short.payment,booking_short.total_payment_amount,booking_short.balance,booking_short.booking_type from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id left join discount on discount.customer_id=customer.id  where 1 $search1 $searchNewStart $searchEndStart group by booking_id";
            $result=$objConnect->execute($sql);
            $num=  mysql_num_rows($result);
            while($row=$objConnect->fetch_assoc())
                {
                    if($row['total_payment_amount']=="")
                    {
                    $total_estimate=$total_estimate+$row['total_fare'];}
                    else{
                    $total_amount=$total_amount+$row['total_payment_amount'];
                    }
					if($row['payment'] == "")
					{$row['payment'] = "0.00";}
                    $total_payment=$total_payment+$row['payment'];
                   
                    $total_balance = $total_balance + $row['balance'];
                }
            }
            
          //  echo 'Total Amount - '.$total_amount.'<br/>';
          //  echo 'Payment - '.$total_payment.'<br/>';
          //  echo 'Balance - '.$total_balance.'<br/>';
           // echo 'Discount - '.$total_discount.'<br/>';
           // echo 'Cash receive - '.$total_cahreceive.'<br/>';
            
            $total_amount-$total_discount+$total_cahreceive;
            $pay = $total_payment + $total_cahreceive;
            $bal = $total_balance-$total_discount;
            $openingBalance = $bal;
// end query 
?>
<pre style="margin-top: 10px;"><em>Opening Balance:-   <b><?php echo $openingBalance;?> Rs/-</b></em></pre>
<table class="table table-bordered table-striped table-condensed ">
                <tr>
                     <th>#</th>
                    <th>Customer name </th>
                    <th>Phone </th>
                    <th>Organization</th>
                    <th>Start</th>
                    <th>Destination</th>
                    <th>Pickup date</th>
                     <th>Discount Amount</th>
                     <th>Cash Receive</th>
                </tr>
            <?php
            
            $htmlTable = '<tr><th  class="newback">Booking Id</th>'
                    . '<th  class="newback">Vehicle No</th>'
                    . '<th  class="newback">Start Time</th>'
                    . '<th  class="newback">Stop Time</th>'
                    . '<th  class="newback">Distance</th>'
                    . '<th  class="newback">Total Fair</th>'
                    . '<th  class="newback">Payment Type</th>'
                    . '<th  class="newback">Payment</th>'
                    . '<th  class="newback">Balance</th>'
                    . '<th  class="newback">Status</th>'
                    
                    
                    . '</tr>';
            $total_amount=0;
            $total_estimate=0;
            $total_payment=0;
            $total_balance=0;
            $discount_amt = 0;
            $cahreceive_amt = 0;
            $total_discount = 0;
            $total_cahreceive = 0;
     
            $sql1 = "select DISTINCT CASE WHEN cashreceive_date IN (DATE(pickup_date)) THEN cash_amount ELSE '0.00' END AS cash_amount,DATE(pickup_date) as pickDate,CASE WHEN discount_date IN (DATE(pickup_date)) THEN discount_amount ELSE '0.00' END AS discount_amount,discount.discount_date,booking.*,customer.customer_name,customer.customer_organization as customer_organize from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id left join discount on discount.customer_id=customer.id and DATE(discount.discount_date) = DATE(booking.pickup_date) left join cashreceive on cashreceive.customer_id=customer.id and DATE(cashreceive.cashreceive_date) = DATE(booking.pickup_date) where 1 $search1 $search2 $search3 group by pickDate";
            $result1=$objConnect->execute($sql1);
            $num1=  mysql_num_rows($result1);
            $i = 0;
            while($row1=  mysql_fetch_array($result1)){
            $i++;
            $date11= $row1['pickDate']." 00:00:00";
            $date12= $row1['pickDate']." 23:59:59";
            $search22= " and pickup_date >= '".$date11."'";
            $search33= " and pickup_date <= '".$date12."'";
            ?>
                <tr>
                <td id="showhisde"><img id="showhie1 showhie_<?php echo $i;?>" src="details_open.png" onclick="return onshowHide('<?php echo $i;?>');"></td>
                <td><?php echo $row1['customer_name'];?></td>
                    <td><?php echo $row1['pick_up_no'];?></td>
                    <td><?php echo $row1['customer_organization'];?></td>
                    <td><?php echo $row1['current_location'];?></td>
                    <td><?php echo $row1['drop_location'];?></td>
                    <td><?php echo date("d M Y ",strtotime($row1['pickDate']));?></td>
                    <td><?php echo $row1['discount_amount'];$total_discount=$total_discount+$row1['discount_amount'];?></td>
                    <td><?php echo $row1['cash_amount'];$total_cahreceive=$total_cahreceive+$row1['cash_amount'];?></td>
                </tr>
            <?php
            $discount_amt = $row1['discount_amount'];
            $cahreceive_amt = $row1['cash_amount'];
            $sql325 = "select booking.*,vehicle.registration_no, vehicle.name as vname,booking_short.trip_time,booking_short.trip_distance,booking_short.payment_type,booking_short.payment,booking_short.total_payment_amount,booking_short.balance,booking_short.booking_type from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id left join discount on discount.customer_id=customer.id  where 1 $search1 $search22 $search33 group by booking_id";
            $result325=$objConnect->execute($sql325);
            $num=  mysql_num_rows($result325);
            $j = 0;
            ?>
                <tr class="allhisde" id="hidShow_<?php echo $i;?>">
                    <td colspan="9" style="background:#eee;">
                        <pre><table class="table table-bordered table-hover table-striped table-condensed ">
            <?php
            echo $htmlTable;
            while($row325=mysql_fetch_array($result325)){
              
                $j++;
            $idBooking = $row325['id'];
                
            $result122 = $objConnect->selectWhere("booking_short", "booking_id=$idBooking");
            $row111 = $objConnect->fetch_assoc();
            $result2 = $objConnect->selectWhere("booking_logs", "booking_id=$idBooking and status like 'reached to customer'");
            $row2 = $objConnect->fetch_assoc();
            $pickup_date = date("H:i:s", strtotime($row2['datetime']));
           // $result3 = $objConnect->selectWhere("booking_logs", "booking_id=$id and status like 'stop trip'");
            $result3 = $objConnect->selectWhere("booking_logs", "booking_id=$idBooking and status like 'stop unloading'");
            $row3 = $objConnect->fetch_assoc();
            $drop_date = date("H:i:s", strtotime($row3['datetime']));
            ?>
                
                <tr>
                    <td><?php echo "<a href='../booking/booking_details.php?booking=" . $row325['id'] . "' target='_blank'>" .sprintf("%07d",$row325['id'])."</a>";?></td>
                <td><?php echo $row325['vname']." - ".$row325['registration_no'];?></td>
<td><?php echo $pickup_date;?></td>
<td><?php echo $drop_date;?></td>    
<td><?php echo $row111['trip_distance'] / 1000; ?> Km</td>    
<td>
                <?php if($row325['total_payment_amount']=="")
                    {echo $row325['total_fare']." Estimated";
                $total_estimate=$total_estimate+$row325['total_fare'];}
                else{
                echo $row325['total_payment_amount'];
                $total_amount=$total_amount+$row325['total_payment_amount'];
                }
                ?></td>
                <td><?php echo $row325['payment_type']?></td>
                <td><?php echo $row325['payment'];
				if($row325['payment'] == "")
					{$row325['payment'] = "0.00";}
					
				$total_payment=$total_payment+$row325['payment'];?></td>
                <td> <?php echo $row325['balance'];$total_balance=$total_balance+$row325['balance'];?></td>
                <td><?php if($row325['status']==7){echo "Completed";}
                    elseif($row325['status']==99){echo "Canceled";}
                    elseif($row325['status']>=2){echo "In Transit";}
                    elseif($row325['status']>=-3){echo "Pending";}?></td>   
                </td>
                
                </tr>
            <?php 
             } // end second loop
                  echo '</table></pre></td></tr> ';
           }
            ?>
                <th colspan="2">Total- <?php echo $num;?> Bookings</th>
                <th colspan="2">Pending And transit booking total: <?php echo $total_estimate;?></th>
                <th colspan="2">
                <div>Opening Balance : <?php echo $openingBalance;?></div>
                <div>Completed Booking Total: <?php echo $total_amount;?></div>
                <div>Completed Discount Total: <?php echo $total_discount;?></div>    
                <div>Completed Cash Receive Total: <?php echo $total_cahreceive;?></div>    
                <div>Note :- <b>(New Total: Opening Balance + Total - Discount + Cash Receive )</b></div> 
                </th>
                <!-- th colspan="3">Payments: <?php echo $total_payment;?><br/>
                     Balance: <?php echo $total_balance;?></th -->
                <th colspan="3">
                    
                    Completed Booking Total : <?php echo $openingBalance+$total_amount-$total_discount+$total_cahreceive;?><br/>
                    Payments: <?php echo $total_payment+$total_cahreceive;?><br/>
                     Balance: <?php echo $total_balance-$total_discount+$openingBalance;?>  
                    <br/>( Note :  Opening Balance + Discount )
               </th>
            </table>
