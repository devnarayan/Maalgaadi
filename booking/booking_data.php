<?php
include '../includes/define1.php';
// DB table to use
$table = 'booking';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$i = 0;
$columns = array(
    array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return sprintf("%07d", $d);
        }
    ),
    array('db' => 'customer_organization', 'dt' => $i++),
            
    array('db' => 'phone', 'dt' => $i++),
    array('db' => 'current_location', 'dt' => $i++),
    array('db' => 'drop_location', 'dt' => $i++),
    array(
        'db' => 'pickup_date',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return date('d/m/Y H:i:s', strtotime($d));
        }
    ),
    array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
$sql2="select * from booking where id=$d";
$result2=mysql_query($sql2) or die(mysql_error());
$row2=mysql_fetch_assoc($result2);
if($row2['status']==7){
$sql="select * from `booking_short` where `booking_id`='$d'";
$result=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_assoc($result);
$loading=0;
if($row2['loading']=="true"){
$loading+=$row2['loading_charge'];
}
if($row2['unloading']=="true"){
$loading+=$row2['loading_charge'];
}
return '<i class="fa fa-rupee"></i> ' . ($row['total_payment_amount']-$loading);
}
else{
            return '<i class="fa fa-rupee"></i> ' . ($row2['trip_fare']);
}

        }
    ),
    array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
        $sql6 = "select * from booking where id=$d";
            $result6 = mysql_query($sql6);
            $row6 = mysql_fetch_assoc($result6);
            if($row6['loading']=="true"){
                
                return '<i class="fa fa-rupee"></i>'.$row6['loading_charge'];
            }
            return 0;
        }
    ),
            array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            $sql6 = "select * from booking where id=$d";
            $result6 = mysql_query($sql6);
            $row6 = mysql_fetch_assoc($result6);
            if($row6['unloading']=="true"){
                
                return '<i class="fa fa-rupee"></i>'.$row6['loading_charge'];
            }
           return 0;
        }
    ),
    array(
        'db' => 'vehicle_id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            $sql3 = "select * from vehicle where id=$d";
            $result3 = mysql_query($sql3);
            $row3 = mysql_fetch_assoc($result3);
            return $row3['mobile_no'] ;
        }
    ),
   array(
        'db' => 'vehicle_id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            $sql3 = "select * from vehicle where id=$d";
            $result3 = mysql_query($sql3);
            $row3 = mysql_fetch_assoc($result3);
            return $row3['name'] ;
        }
    ),
   array(
        'db' => 'employee_booking_id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            $sql3 = "select * from employee where id=$d";
            $result3 = mysql_query($sql3);
            $row3 = mysql_fetch_assoc($result3);
            return $row3['name'] ;
        }
    ),
    array('db' => 'id', 'dt' => $i++,
        'formatter' => function( $d, $row ) {

            $sql6 = "select * from booking where id=$d";
            $result6 = mysql_query($sql6);
            $row6 = mysql_fetch_assoc($result6);

            $d1=$row6['status'];
            $edit_status=$row6['edit_status'];

            if ($d1 < 0  && $edit_status=="") {
                return "<span class='btn btn-danger'>Pending</span>";
            } elseif ($d1 == 0 && $edit_status=="") {
                return "<span class='btn btn-danger'>To Admin</span>";
            } else
            if ($d1 == 1) {
                return "<span class='btn btn-danger'>To Employee</span>";
            } elseif ($d1 == 2 && $edit_status=="") {
                return "<span class='btn btn-warning'>Driver Allotted</span>";
            } elseif ($d1 == 7 && $edit_status=="completed") {
                return "<span class='btn btn-success'>Completed</span>";
            } 
            elseif (($d1 == 33)||($d1==34) && $edit_status=="") {
                return "<span class='btn btn-danger'>Breakdown</span>";
            }
            elseif ($d1 == 99 && $edit_status=="") {
                return "<span class='btn btn-danger'>Canceled</span>";
            } elseif ($edit_status=="start_trip") {
                return "<span class='btn btn-success'>Trip Start</span>";
            } elseif ($edit_status=="reach_to_customer") {
                return "<span class='btn btn-success'>Reach to Pickup point</span>";
            }elseif ($edit_status=="stop_trip") {
                return "<span class='btn btn-success'>Reach to Destination Point</span>";
            }else {
                return "<span class='btn btn-warning'>In Transit</span>";
            }
            
        }),
    array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            $return='<div class="btn-group">';
            $return.='<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    Action
    <span class="caret"></span>
  </a>';
            $return.='<ul class="dropdown-menu">';
            $return .= "<li><a href='booking_details.php?booking=$d'  title='view Details' >View Details</a><li>";
            $sql3 = "select * from booking where id=$d";
            $result3 = mysql_query($sql3);
            $row3 = mysql_fetch_assoc($result3);
            if ($row3['status'] < 2 && $row3['edit_status']=="") {
                $return.="<li> <a href='" . BASE_PATH . "assign/to_employee.php?booking=$d'  title='view Details' >Assign Employee</a></li>";
            }
            if($row3['status'] < 7){
                $return.="<li><a href='".BASE_PATH."booking/cancelbooking.php?booking=$d' >Cancel</a></li>";
            }
            if(($row3['status'] < 7)||($row3['status'] == 33)){
                $return.="<li> <a type='button' data-id='$d' data-table='booking' class=' delete' >Delete</a></li>";
            }
            if($row3['edit_status']=="start_trip" || $row3['edit_status']=="reach_to_customer" || $row3['edit_status']==""){
                $return.="<li><a href='".BASE_PATH."booking/edit_booking.php?booking=$d' >Edit</a></li>";
            }
            $return.="</ul>";
            return $return;
        }
    )
);

// SQL server connection information
$host = $_SERVER['HTTP_HOST'];

if ($host == 'servo') 
{
    $hostname = 'localhost';
    $database = 'mmfsol_maalgaadi';
    $username = 'root';
    $password = '';

} 
elseif ($host == 'localhost') 
{
    $hostname = 'localhost';
    $database = 'maalgaadi_db';
    $username = 'root';
    $password = 'root';
} 
else 
{
    /*$hostname = 'localhost';
    $database = 'maalgaad_maalgaadinew';
    $username = 'maalgaad_vipul';
    $password = 'newtest@123';*/
            $hostname = 'localhost';
            $database = 'maalgaadi_db';
            $username = 'maalgaadi_db';
            $password = 'maalgaadi_db';
}

$sql_details = array(
    'user' => $username,
    'pass' => $password,
    'db' => $database,
    'host' => $hostname
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( '../plugins/ssp.class.php' );

echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
