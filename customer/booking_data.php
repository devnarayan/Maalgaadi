<?php

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
            return sprintf("%07d",$d);
        }
    ),
    array('db' => 'firstname', 'dt' => $i++),
    array('db' => 'email', 'dt' => $i++),
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
        'db' => 'total_fare',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return '$' . number_format($d);
        }
    ),
    array('db' => 'customer_category', 'dt' => $i++),
    array('db' => 'status', 'dt' => $i++,
        'formatter' => function( $d, $row ) {
        if($d<0){
            return "<span class='btn btn-danger'>Pending</span>";
        }
        elseif($d==0){
            return "<span class='btn btn-danger'>To Admin</span>";
        }
        else
            if($d<=0){
            return "<span class='btn btn-danger'>To Emloyee</span>";
        
        }
        elseif($d==2){
            return "<span class='btn btn-warning'>Driver Allotted</span>";
        }
        elseif($d==7){
            return "<span class='btn btn-success'>Completed</span>";
        }
        elseif($d==99){
            return "<span class='btn btn-danger'>Canceled</span>";
        }
        else{
            return "<span class='btn btn-warning'>In Transit</span>";
        }
        }),
    array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return "<a href='../booking/booking_details.php?booking=$d' class='edit_btn ' title='view Details' ><i class='fa fa-list'></i></a>";
        }
    )
);

// SQL server connection information
$host = $_SERVER['HTTP_HOST'];
if ($host == 'servo') {
    $hostname = 'localhost';
    $database = 'mmfsol_maalgaadi';
    $username = 'root';
    $password = '';
} elseif ($host == 'localhost') {
    $hostname = 'localhost';
    $database = 'mmfsol_maalgaadi';
    $username = 'root';
    $password = '';
} else {
    $hostname = 'localhost';
            $database = 'maalgaad_maalgaadinew';
            $username = 'maalgaad_vipul';
            $password = 'newtest@123';
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
$where1=" 1 AND customer_id=".$_GET['customer_id'];
require( '../plugins/ssp.class.php' );

echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
?>