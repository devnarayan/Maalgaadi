<?php

include '../includes/define.php';

verifyLogin();

?>

<!-- Coding for Get Opening Balance-->

<?php

$ne = changeFormat("d/m/Y", "Y-m-d", $_POST['startDate']);

$days_ago = date('Y-m-d', strtotime('-1 days', strtotime($ne)));

$search1 = "";

$search2 = "";

$search3 = "";
$organizationsearch = '';

if ((isset($_POST['customer_id'])) && (!empty($_POST['customer_id']))) {

    $search1 = " and customer.id like '" . $_POST['customer_id'] . "'";

}
if ((isset($_POST['customer_organization'])) && (!empty($_POST['customer_organization']))) {
    $organizationsearch = " and customer_organization like '" . $_POST['customer_organization'] . "'";
}
if ((isset($_POST['startDate'])) && (!empty($_POST['startDate']))) {

    $date1 = changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);

    $search2 = " and pickup_date >= '" . $date1 . "'";

}

if ((isset($_POST['endDate'])) && (!empty($_POST['endDate']))) {

    $date2 = changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['endDate']);

    $search3 = " and pickup_date <= '" . $date2 . "'";

}



$customerFilter = "";

if ((isset($_POST['customer_id'])) && (!empty($_POST['customer_id']))) {

    $customerFilter = " and customer_id = '" . $_POST['customer_id'] . "'";

}
$organizationFilter = "";
if ((isset($_POST['customer_organization'])) && (!empty($_POST['customer_organization']))) {
    $organizationFilter = " and customer_organization = '" . $_POST['customer_organization'] . "'";
}
$organizationFilterCus = "";
if ((isset($_POST['customer_organization'])) && (!empty($_POST['customer_organization']))) {
    $organizationFilterCus = " and customer.customer_organization = '" . $_POST['customer_organization'] . "'";
}
// cash receive filter

$cashFilter1 = "";

if ((isset($_POST['startDate'])) && (!empty($_POST['startDate']))) {

    //$date1=  changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);

    $cashFilter1 = " and cashreceive_date >= '2015-01-01 00:00:00'";

}

$cashFilter2 = "";

if ((isset($_POST['endDate'])) && (!empty($_POST['startDate']))) {

    $date2 = changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['startDate']);

    $cashFilter2 = " and cashreceive_date <= '" . $days_ago . "  23:59:59'";

}

// discount filter

$disountFilter1 = "";

if ((isset($_POST['startDate'])) && (!empty($_POST['startDate']))) {

    //$date1=  changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);

    $disountFilter1 = " and discount_date >= '2015-01-01 00:00:00'";

}

$disountFilter2 = "";

if ((isset($_POST['endDate'])) && (!empty($_POST['startDate']))) {

    $date2 = changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['startDate']);

    $disountFilter2 = " and discount_date <= '" . $days_ago . "  23:59:59'";

}



$total_amount = 0;

$total_estimate = 0;

$total_payment = 0;

$total_balance = 0;

$discount_amt = 0;

$cahreceive_amt = 0;

$total_discount = 0;

$total_cahreceive = 0;

$da = 0;

$ca = 0;



// get opening balance

$openingDateStart = "and pickup_date >= '2015-01-01 00:00:00'";

// $ne = changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);

$openingDateEnd = "and pickup_date <= '" . $days_ago . " 23:59:59'";



//$getOpening = "select DISTINCT CASE WHEN cashreceive_date IN (DATE(pickup_date)) THEN cash_amount ELSE '0.00' END AS cash_amount,DATE(pickup_date) as pickDate,CASE WHEN discount_date IN (DATE(pickup_date)) THEN discount_amount ELSE '0.00' END AS discount_amount,booking.pickup_date from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id left join discount on discount.customer_id=customer.id and DATE(discount.discount_date) = DATE(booking.pickup_date) left join cashreceive on cashreceive.customer_id=customer.id and DATE(cashreceive.cashreceive_date) = DATE(booking.pickup_date) where 1 $search1 $openingDateStart $openingDateEnd group by pickDate";



$getOpening = "SELECT distinct date(pickup_date) as pickup_date FROM booking where 1 $search99 $openingDateStart $openingDateEnd and booking.status!='99' group by pickup_date UNION SELECT distinct date(cashreceive_date) FROM cashreceive where 1 $organizationFilter $customerFilter $cashFilter1 $cashFilter2 UNION SELECT distinct date(discount_date) FROM discount where 1 $organizationFilter $customerFilter $disountFilter1 $disountFilter2";

$getOpeningResult = $objConnect->execute($getOpening);

while ($getOpeningData = mysql_fetch_array($getOpeningResult)) {



    $date11 = $getOpeningData['pickup_date'] . " 00:00:00";

    $date12 = $getOpeningData['pickup_date'] . " 23:59:59";

    $searchNewStart = " and pickup_date >= '" . $date11 . "'";

    $searchEndStart = " and pickup_date <= '" . $date12 . "'";



    //echo $total_balance.'----'.$getOpeningData['discount_amount'].'<br/>';

    // $total_balance = $total_balance - $getOpeningData['discount_amount'];

    // echo $total_balance.'Cas<br/>';

    // echo $total_balance.'----'.$getOpeningData['cash_amount'].'<br/>';

    // $total_balance = $total_balance - $getOpeningData['cash_amount'];

    //  echo $total_balance.'D<br/>';

    //get discount

    $sql112 = "select DISTINCT CASE WHEN discount_date IN (DATE(discount_date)) THEN discount_amount ELSE '0.00' END AS discount_amount,discount.discount_date,discount.narration as dn from discount Left join customer on discount.customer_id=customer.id where 1 $organizationFilterCus $search1 and discount_date >= '" . $date11 . "' and discount_date <= '" . $date12 . "' group by discount_date";

    $result112 = $objConnect->execute($sql112);

    $rowNUMMM = mysql_num_rows($result112);



    if ($rowNUMMM > 0) {

        $row112 = mysql_fetch_array($result112);

        if ($row112['discount_date'] != '' || $row112['discount_date'] != null) {

            $da = $row112['discount_amount'];

            $total_balance = $total_balance - ($da);

            // echo $total_balance.'---->T'.$total_balance.'--->D'.$da.'<br/>';

        }

    }

    //get cashreceive

    $sql1 = "select DISTINCT CASE WHEN cashreceive_date IN (DATE(cashreceive_date)) THEN cash_amount ELSE '0.00' END AS cash_amount,cashreceive.cashreceive_date,cashreceive.narration as cn from cashreceive Left join customer on cashreceive.customer_id=customer.id where 1 $organizationFilterCus $search1 and cashreceive_date >= '" . $date11 . "' and cashreceive_date <= '" . $date12 . "' group by cashreceive_date";

    $result1 = $objConnect->execute($sql1);

    $rowNUww = mysql_num_rows($result1);



    if ($rowNUww > 0) {

        $row1 = mysql_fetch_array($result1);

        if ($row1['cashreceive_date'] != '' || $row1['cashreceive_date'] != null) {

            $ca = $row1['cash_amount'];

            $total_balance = $total_balance - ($ca);

            // echo $total_balance.'---->T'.$total_balance.'--->C'.$ca.'<br/>';

        }

    }

    //get booking

//		   $da = $da + $getOpeningData['discount_amount'];

    //   $ca = $ca + $getOpeningData['cash_amount'];



    $da = 0;

    $ca = 0;

    $sql = "select booking.*,booking_short.payment,booking_short.total_payment_amount,booking_short.balance from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id left join discount on discount.customer_id=customer.id  where 1 $organizationFilterCus $search1 $searchNewStart $searchEndStart  and booking.status!='99' group by booking_id";

    $result = $objConnect->execute($sql);

    $num = mysql_num_rows($result);



    //echo "<br />";

    //print_r($getOpeningData);



    while ($row = $objConnect->fetch_assoc()) {



        if ($row['total_payment_amount'] == "") {

            $total_amount = $row['total_fare'];

        } else {

            $total_amount = $row['total_payment_amount'];

        }



        //$toatl_fare = $total_amount;

        // $total_payment=$total_payment+$row['payment'];

        $total_balance = $total_balance + ($total_amount - $row['payment']);

        // $total_balance = $total_balance + $row['balance'];

        //	echo "<br />";

        //	echo $total_balance."**Fare=".$total_amount."**Payment=".$row['payment'];

        //echo "<br />";

        //print_r($row);

        //	echo "<hr />";

    }

}

//  $total_amount-$total_discount+$total_cahreceive;

// $pay = $total_payment + $total_cahreceive;

//  $bal = $total_balance-$total_discount;



$openingBalance = $total_balance;

$tripAmt = '';

$completeTotal = '';

//die();

?>



<table class="table table-bordered table-striped table-condensed ">

    <tr>

        <th>Date </th>

        <th>Trip Id</th>

        <th>Source </th>

        <th>Destination</th>

        <th>Trip Amount </th>

        <th>Payment</th>

        <th>Balance</th>

    </tr>

    <tr>

        <td><?php echo date("d M Y", strtotime(changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['startDate']))); ?></td>

        <td colspan="5"><b>Opening Balance</b></td>

        <td><b><?php echo $openingBalance; ?></b></td>

    </tr>

    <?php
$organizationFilter11 = "";
	if ((isset($_POST['customer_organization'])) && (!empty($_POST['customer_organization']))) {
		$organizationFilter11 = " and customer_organization = '" . $_POST['customer_organization'] . "'";
	}
    $search99 = "";

    if ((isset($_POST['customer_id'])) && (!empty($_POST['customer_id']))) {

        $search99 = " and customer_id = '" . $_POST['customer_id'] . "'";

    }



    $search1 = "";

    if ((isset($_POST['customer_id'])) && (!empty($_POST['customer_id']))) {

        $search1 = " and customer.id = '" . $_POST['customer_id'] . "'";

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



    // cash receive filter

    $searchC = "";

    if ((isset($_POST['startDate'])) && (!empty($_POST['startDate']))) {

        $date1 = changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);

        $searchC = " and cashreceive_date >= '" . $date1 . "'";

    }

    $searchD = "";

    if ((isset($_POST['endDate'])) && (!empty($_POST['endDate']))) {

        $date2 = changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['endDate']);

        $searchD = " and cashreceive_date <= '" . $date2 . "'";

    }

    // discount filter

    $searchC1 = "";

    if ((isset($_POST['startDate'])) && (!empty($_POST['startDate']))) {

        $date1 = changeFormat("d/m/Y", "Y-m-d 00:00:00", $_POST['startDate']);

        $searchC1 = " and discount_date >= '" . $date1 . "'";

    }

    $searchD1 = "";

    if ((isset($_POST['endDate'])) && (!empty($_POST['endDate']))) {

        $date2 = changeFormat("d/m/Y", "Y-m-d 23:59:59", $_POST['endDate']);

        $searchD1 = " and discount_date <= '" . $date2 . "'";

    }



    $total_amount = 0;

    $total_estimate = 0;

    $total_payment = 0;

    $total_balance = 0;



    //get date from discount,cashreceive and booking

    $newGetDate = "SELECT distinct date(pickup_date) as pickup_date FROM booking where 1 $search99 $search2 $search3 and booking.status!='99' group by pickup_date UNION SELECT distinct date(cashreceive_date) FROM cashreceive where 1 $search99 $searchC $searchD UNION SELECT distinct date(discount_date) FROM discount where 1 $organizationFilter11 $search99 $searchC1 $searchD1 ORDER BY  `pickup_date` ASC ";

    $reDAte = mysql_query($newGetDate);

    $i = 0;

    $completeTotal = $openingBalance;

    while ($dataDate = mysql_fetch_array($reDAte)) {



        $i++;

        $date11 = $dataDate['pickup_date'] . " 00:00:00";

        $date12 = $dataDate['pickup_date'] . " 23:59:59";

        $search22 = " and pickup_date >= '" . $date11 . "'";

        $search33 = " and pickup_date <= '" . $date12 . "'";





        //get discount

        $sql112 = "select DISTINCT CASE WHEN discount_date IN (DATE(discount_date)) THEN discount_amount ELSE '0.00' END AS discount_amount,discount.discount_date,discount.narration as dn from discount Left join customer on discount.customer_id=customer.id where 1 $organizationFilterCus $search1 and discount_date >= '" . $date11 . "' and discount_date <= '" . $date12 . "' group by discount_date";

        $result112 = $objConnect->execute($sql112);

        $rowNUMMM = mysql_num_rows($result112);



        if ($rowNUMMM > 0) {

            $row112 = mysql_fetch_array($result112);

            if ($row112['discount_date'] != '' || $row112['discount_date'] != null) {

                ?>

                <tr>

                    <td><?php echo date("d M Y", strtotime($row112['discount_date'])); ?></td>

                    <td colspan="4"><b>( <?php echo $row112['dn']; ?> ) </b></td>

                    <td><?php echo $row112['discount_amount']; ?></td>

                    <td><?php echo $completeTotal = $completeTotal - $row112['discount_amount']; ?></td>

                </tr>

                <?php

            }

        }

        //get cashreceive

        $sql1 = "select DISTINCT CASE WHEN cashreceive_date IN (DATE(cashreceive_date)) THEN cash_amount ELSE '0.00' END AS cash_amount,cashreceive.cashreceive_date,cashreceive.narration as cn from cashreceive Left join customer on cashreceive.customer_id=customer.id where 1 $organizationFilterCus $search1 and cashreceive_date >= '" . $date11 . "' and cashreceive_date <= '" . $date12 . "' group by cashreceive_date";

        $result1 = $objConnect->execute($sql1);

        $rowNUww = mysql_num_rows($result1);



        if ($rowNUww > 0) {

            $row1 = mysql_fetch_array($result1);

            if ($row1['cashreceive_date'] != '' || $row1['cashreceive_date'] != null) {

                ?>

                <tr>

                    <td><?php echo date("d M Y", strtotime($row1['cashreceive_date'])); ?></td>

                    <td colspan="4"><b>( <?php echo $row1['cn']; ?> )</b></td>

                    <td><?php echo $row1['cash_amount']; ?></td>

                    <td><?php echo $completeTotal = $completeTotal - $row1['cash_amount']; ?></td>

                </tr>

                <?php

            }

        }

        //get booking

        $sql325 = "select booking.*,vehicle.registration_no, vehicle.name as vname,booking_short.trip_time,booking_short.trip_distance,booking_short.payment_type,booking_short.payment,booking_short.total_payment_amount,booking_short.balance,booking_short.booking_type from booking inner join customer on customer.id=booking.customer_id left join booking_short on booking.id=booking_short.booking_id left join vehicle on vehicle.id=booking.vehicle_id left join discount on discount.customer_id=customer.id  where 1 $organizationFilterCus $search1 $search22 $search33  and booking.status!='99' group by booking_id";

        $result325 = $objConnect->execute($sql325);

        while ($row325 = mysql_fetch_array($result325)) {

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



            //---------

            if ($row325['total_payment_amount'] == "") {

                $tripAmt = $row325['total_fare'];

            } else {

                $tripAmt = $row325['total_payment_amount'];

            }

            if ($row325['payment'] == '' || $row325['payment'] == null || $row325['payment'] == 0) {

                $row325['payment'] = 0;

            }

            //echo $tot = $completeTotal.'<br/>';

            //$completeTotal = $tot.' + '.($tripAmt .'  -  '. $row325['payment']).'<br/>';

            ?>

            <tr> 

                <!-- td><?php $completeTotal . '---->' . $tripAmt . '--' . $row325['payment']; ?>

                  </td -->

                <td><?php echo date("d M Y h:i a", strtotime($row325['pickup_date'])); ?></td>

                <td><?php echo "<a href='../booking/booking_details.php?booking=" . $row325['id'] . "' target='_blank'>" . sprintf("%07d", $row325['id']) . "</a>"; ?></td>

                <td><?php echo $row325['current_location']; ?></td>

                <td><?php echo $row325['drop_location']; ?></td>

                <td><?php

                    if ($row325['total_payment_amount'] == "") {

                        echo $row325['total_fare'] . " Estimated";

                    } else {

                        echo $row325['total_payment_amount'];

                    }

                    ?></td>

                <td><?php echo $row325['payment']; ?></td>

                <td><?php echo $completeTotal = $completeTotal + ($tripAmt - $row325['payment']);

                    ?></td>

            </tr>

            <?php

        }



        $completeTotal;

    }

    $completeTotal;

    ?>

</table>

