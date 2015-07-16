<?php
include '../includes/define.php';
$mode = $_REQUEST['mode'];
unset($_POST['mode']);
unset($_GET['mode']);
switch ($mode) {
    case "payment":
        $_POST['addedon'] = date("Y-m-d H:i:s");
        $objConnect->insert('payment', $_POST);
        $booking_id = $_POST['booking_id'];
        $payment = $_POST['payment'];
        $sql = "update booking_short set payment=`payment`+$payment, balance=`total_payment_amount`-`payment` where booking_id=$booking_id";
        $objConnect->execute($sql);
        echo "redirectPayment doneURLpending_payments.php";
        break;
}?>