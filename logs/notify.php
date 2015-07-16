<?php
include '../includes/define.php';
include_once '../api/GCM.php';
$id = $_POST['id'];
$result3 = $objConnect->selectWhere("vehicle", "id = '$id'");
$num3=$objConnect->total_rows();
if($num3){
$row3 = $objConnect->fetch_assoc();
$unicode = 1;
$mobileno = $row3["mobile_no"];
$message = "आप इन्टरनेट क्षेत्र से बहार हैं, कृपया जांचे एवं इन्टरनेट क्षेत्र में आए |";
$senderid = "101010";
sendsms($mobileno, $message, $senderid, $unicode);

echo " Notification Sent ";

}
else{
    echo "NO driver with email";
}
?>
