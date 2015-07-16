<?php 
include './includes/define1.php';
$today=date("Y-m-d");
echo $sql3="select min(date(addedon)) as mindat  from location where date(addedon)!='$today'";
$result3=  mysql_query($sql3) or die(mysql_error());
$row3=  mysql_fetch_assoc($result3);
echo $start=$row3['mindat'];
$begin = new DateTime($start);
$end = new DateTime();

$end->modify('-1 day');
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ( $period as $dt ){
   $table= $dt->format( "FY");
  $date=$dt->format("Y-m-d");
$table=strtolower($table);
 $sql="CREATE TABLE IF NOT EXISTS `$table` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `latitute` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `driver_id` int(255) NOT NULL,
  `vehicle_id` int(255) NOT NULL,
  `booking_id` int(255) NOT NULL,
  `batterystatus` float NOT NULL,
  `speed` float NOT NULL,
  `gps` varchar(100) NOT NULL,
  `addedon` datetime NOT NULL,
  `addedon_to` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ";
$result=mysql_query($sql) or die(mysql_error());

 $sql1="INSERT INTO `$table` 
  (SELECT * FROM `location` where date(`addedon`)='$date')";
$result1=mysql_query($sql1) or die(mysql_error());
$sql2="delete from location where date(`addedon`)='$date'";
$result2=mysql_query($sql2) or die(mysql_error());
}
?>