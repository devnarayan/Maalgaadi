<?php
include '../includes/define1.php';
$result = $objConnect->select("vehicle");
while ($row = mysql_fetch_assoc($result)) {
    $arr = array();
    $date = date("Y-m-d", strtotime("-1 day"));
    $fulldistance = 0;
    $arr['booking_distance'] = 0;
    $arr['free_distance'] = 0;

    $sql1 = "select * from `location` where vehicle_id=" . $row['id'] . " and Date(addedon)='$date' order by addedon asc ";
    $result1 = mysql_query($sql1) or die("1" . mysql_error());
    $i = 0;
    $status = "";
    $distance = 0;
    $num1 = mysql_num_rows($result1);

    if ($num1 != 0) {
//free distance calculation
        while ($row1 = mysql_fetch_assoc($result1)) {
            $sql10 = "update `vehicle` set status=0 where id=" . $row['id'];
            $result10 = mysql_query($sql10) or die(mysql_error());
            $stat = $row1['status'];
            if ($stat != "free") {
                $i = 0;
            }
            if ($i == 0) {
                $start_lati = $row1['latitute'];
                $start_longi = $row1['longitude'];
            } else {
                $last_lati = $row1['latitute'];
                $last_longi = $row1['longitude'];
                $dLat = deg2rad($last_lati - $start_lati);
                $dLon = deg2rad($last_longi - $start_longi);
                $dLat1 = deg2rad($start_lati);
                $dLat2 = deg2rad($last_longi);
                $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $d = round((6371 * $c), 2); //in km
                $distance = $distance + round($d, 2);

                $start_lati = $last_lati;
                $start_longi = $last_longi;
            }

            $i++;
            if ($stat != "free") {
                $fulldistance = $distance + $fulldistance;
                $distance = 0;
                $i = 0;
            }
        }
    }
    $fulldistance = $distance + $fulldistance;
    $arr['vehicle_id'] = $row['id'];
    $arr['date'] = $date;
//    Booking distance calculation
    $sql5 = "select sum(distance_to_customer) as cust_dist,sum(trip_distance) as trip from booking_short,booking where booking.id=booking_id and date(pickup_date)='$date' and booking.vehicle_id=" . $row['id'];
    $result5 = mysql_query($sql5) or die(mysql_error());
    $row5 = mysql_fetch_assoc($result5);
    $arr['booking_distance'] = ($row5['cust_dist'] / 1000) + ($row5['trip'] / 1000);
    $arr['free_distance'] = $fulldistance;
    $arr['time'] = 0;
//    select login time
    $sql6 = "select * from `login` where  date(login_time)='$date' and vehicle_id=" . $row['id'];
    $result6 = mysql_query($sql6) or die(mysql_error());
    while ($row6 = mysql_fetch_assoc($result6)) {
        $logintime = $row6['login_time'];
        $logouttime = $row6['logout_time'];
        if ($logintime != "0000-00-00 00:00:00") {
            if ($logouttime == "0000-00-00 00:00:00") {
                $logouttime = date("Y-m-d 21:00:00", strtotime($logintime));
                $sql7 = "update login set logout_time='$logouttime', status=0 where id=" . $row6['id'];
                $result7 = mysql_query($sql7) or die(mysql_error());
            }

            $time = round(((abs(strtotime($logouttime) - strtotime($logintime))) / 60), 2);
            $arr['time'] = $time + $arr['time'];
        }
    }
    $sql8 = "select * from vehicle_category where `name` like '" . $row['category'] . "'";
    $result8 = mysql_query($sql8) or die(mysql_error());
    $row8 = mysql_fetch_assoc($result8);
    $day = date("t", strtotime($date));

    $contractkm = $row8['contract_km'] / $day;
    $contract_hour = $row8['contract_hour'] / $day;

    $extra_km_rate = $row8['extra_km_rate'];
    $extra_time_rate = $row8['extra_time_rate'] / 60;
    $arr['base_amount'] = $row['fare'] / $day;
    $arr['extra_km'] = (($arr['booking_distance']) + $arr['free_distance']) - $contractkm;
    $arr['extra_hour'] = $arr['time'] - ($contract_hour * 60);

    if ($arr['extra_km'] >= 0) {
        $arr['amount_payable'] = $arr['base_amount'];
    } elseif ($arr['extra_hour'] >= 0) {
        $arr['amount_payable'] = $arr['base_amount'];
    }
//    exta km
    if ($arr['extra_km'] > 0) {
        $arr['amount_payable'] = $arr['amount_payable'] + ($arr['extra_km'] * $extra_km_rate);
    }
//    extra hour
    if ($arr['extra_hour'] > 0) {
        $arr['amount_payable'] = $arr['amount_payable'] + ($arr['extra_hour'] * $extra_time_rate);
    }
    $arr['extra_hour'] = $arr['extra_hour'] / 60;
    $arr['time'] = $arr['time'] / 60;
    $arr['addedon'] = date("Y-m-d H:i:s");
    $insert = $objConnect->insert("settlement", $arr);
}
$message=date("Y-m-d H:i:s");
mail("mmfinfotech335@gmail.com","dailysatelment ".$date,$message);
?>