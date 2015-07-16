<?php 
include '../includes/define.php';
$sql="select * FROM booking";
$i=1;
$result=  mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
    $sql1="update booking set id=$i where customer_id=".$row['customer_id'];
    $result1=  mysql_query($sql1);
    $i++;
}
?>