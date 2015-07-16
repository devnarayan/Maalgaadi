<?php
include '../includes/define.php';
$mode = $_POST['mode'];
unset($_POST['mode']);
switch ($mode) {
    case "payment":
        $vehicle_id = $_POST['vehicle_id'];
        $payable = $_POST['payable'];
        unset($_POST['payable']);
        $_POST['payment_from'] = changeFormat("d/m/Y", "Y-m-d", $_POST['payment_from']);
        $_POST['payment_to'] = changeFormat("d/m/Y", "Y-m-d", $_POST['payment_to']);
        $today = date("Y-m-d H:i:s");
        $_POST['payment_date'] = $today;
        $_POST['added_by'] = $_SESSION['executive_id'];
        $_POST['status'] = 1;
        $result1 = $objConnect->insert('driver_payment', $_POST);
        $arr['status']=1;
        $result2=$objConnect->update('settlement',$arr,"vehicle_id=$vehicle_id");
        if(($payable-$_POST['payment'])!=0){
            $brr['date']=date("Y-m-d");
            $brr['vehicle_id']=$vehicle_id;
            $brr['amount_payable']=($payable-$_POST['payment']);
            $brr['addedon']=$today;
            $brr['status']=0;
            $result2 = $objConnect->insert('settlement', $_POST);
        }
        if ($result1) {

            echo "Paymewnt Successfull <a href='driver_payment.php'>View Payment List</a>";
        } 
        break;
}
?>