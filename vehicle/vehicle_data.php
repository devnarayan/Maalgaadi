<?php
include '../includes/define1.php';
// DB table to use
$table = 'vehicle';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$i=0;
$columns = array(
    array('db' => 'name', 'dt' => $i++),
    array('db' => 'category', 'dt' => $i++),
    array('db' => 'city_id', 'dt' => $i++,
          'formatter' => function( $d, $row ) {
            $sql3 = "select * from `city` where `id`='$d'";
            $result3=mysql_query($sql3);
            $row3 = mysql_fetch_array($result3);
            return $row3['city'] ;
        }

        ),

    array('db' => 'registration_no', 'dt' => $i++),
    
    array('db' => 'capacity', 'dt' => $i++),
    
    array('db' => 'addedby', 'dt' => $i++),
    array('db' => 'email', 'dt' => $i++),
    array('db' => 'mobile_no', 'dt' => $i++),
    array(
        'db' => 'addedon',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return date('jS M y', strtotime($d));
        }
    ),
    array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return "<a href='vehicle.php?id=$d' class='edit_btn' ><i class='fa fa-edit'></i></a> <button type='button' data-id='$d' data-table='vehicle' class='delete del_btn' ><i class='fa fa-trash'></i></button>";
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
