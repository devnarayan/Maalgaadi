<?php 
include '../includes/define.php';
verifyLogin();
?>
<table class="table table-bordered table-striped table-condensed ">
                <tr>
                    <th>Booking Id</th>
                    <th>Customer name </th>
                    <th>Phone </th>
                    <th>Organization</th>
                    <th>Start</th>
                    <th>Destination</th>
                    <th>Pickup date</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                    <th>Payment</th>
                    <th>Balance</th>
                    <th>Pay</th>
                </tr>
                <?php
                $search1 = "";
                if ((isset($_POST['customer_organization'])) && (!empty($_POST['customer_organization']))) {
                    $search1 = " and customer.customer_organization like '" . $_POST['customer_organization'] . "'";
                }
                $search2 = "";
                if ((isset($_POST['startDate'])) && (!empty($_POST['startDate']))) {
                    $date1 = changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);
                    $search2 = " and pickup_date >= '" . $date1 . "'";
                }
                $search3 = "";
                if ((isset($_POST['endDate'])) && (!empty($_POST['endDate']))) {
                    $date2 = changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['endDate']);
                    $search3 = " and pickup_date <= '" . $date2 . "'";
                }
                $search4 = "";
                if ((isset($_POST['status'])) && (!empty($_POST['status']))) {
                    if ($_POST['status'] == "Completed") {
                        $search4 = " and booking.status=7";
                    } elseif ($_POST['status'] == "Pending") {
                        $search4 = " and booking.status>=-3 and booking.status<2";
                    } elseif ($_POST['status'] == "Canceled") {
                        $search4 = " and booking.status=99 ";
                    } elseif ($_POST['status'] == "In Transit") {
                        $search4 = " and booking.status>=2 and booking.status<7";
                    }
                }
                $total_amount = 0;
                $total_estimate = 0;
                $total_payment = 0;
                $total_balance = 0;

                 $sql = "select booking.*, booking_short.distance_to_customer as to_customer,customer.customer_name,customer.customer_organization, booking_short.trip_time,booking_short.trip_distance,booking_short.payment_type,booking_short.payment,booking_short.total_payment_amount,booking_short.balance,booking_short.booking_type from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id where booking.status=7 and booking_short.balance!=0 $search1";
                $result = $objConnect->execute($sql);
                $num = mysql_num_rows($result);
                while ($row = $objConnect->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo sprintf("%07d", $row['id']); ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['pick_up_no']; ?></td>
                        <td><?php echo $row['customer_organization']; ?></td>
                        <td><?php echo $row['current_location']; ?></td>
                        <td><?php echo $row['drop_location']; ?></td>
                        <td><?php echo date("d M Y h:i a", strtotime($row['pickup_date'])); ?></td>
                        <td><?php if ($row['total_payment_amount'] == "") {
                    echo $row['total_fare'] . " Estimated";
                    $total_estimate = $total_estimate + $row['total_fare'];
                } else {
                    echo $row['total_payment_amount'];
                    $total_amount = $total_amount + $row['total_payment_amount'];
                } ?></td>
                        <td><?php echo $row['payment_type']; ?></td>
                        <td><?php echo $row['payment'];
                $total_payment = $total_payment + $row['payment']; ?></td>
                        <td><?php echo $row['balance'];
                $total_balance = $total_balance + $row['balance']; ?></td>
                        <td><a href="payment.php?booking=<?php echo $row['id']; ?>" class="btn btn-success">Pay</a></td>
                    </tr>
    <?php
}
?>
                <th colspan="2">Total- <?php echo $num; ?> Bookings</th>

                <th colspan="4">Pending And transit booking total: <?php echo $total_estimate; ?></th>
                <th colspan="4"> Completed Booking Total: <?php echo $total_amount; ?></th>


                <th colspan="2">Payments: <?php echo $total_payment; ?><br/>
                    Balance: <?php echo $total_balance; ?></th>

            </table>