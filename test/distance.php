 <?php  include '../includes/define.php';
 $result = $objConnect->selectWhere("location", "booking_id=626 and id > 14360 and status like 'start to customer' order by addedon");
        $distance = 0;
        $i = 0;
        while ($row = $objConnect->fetch_assoc()) {
            if ($i == 0) {
                $start_lati = $row['latitute'];
                $start_longi = $row['longitude'];
            } else {
                $last_lati = $row['latitute'];
                $last_longi = $row['longitude'];
                $dLat = deg2rad($last_lati - $start_lati);
                $dLon = deg2rad($last_longi - $start_longi);
                $dLat1 = deg2rad($start_lati);
                $dLat2 = deg2rad($last_longi);
                $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $d = 6378 * $c;
                
//                echo $distance = $distance + $d;
//                echo '<br>';
//                
                $start_lati = $last_lati;
                $start_longi = $last_longi;
            }
            $i++;
        }
       echo  $arr['trip_distance'] = $distance;
        ?>