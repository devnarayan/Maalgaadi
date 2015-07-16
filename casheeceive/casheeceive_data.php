<?php

// DB table to use
$table = 'cashreceive';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$i = 0;
$columns = array(
    
    array('db' => 'customer_name', 'dt' => $i++),
    array('db' => 'cashreceive_date', 'dt' => $i++),
    array('db' => 'cash_amount', 'dt' => $i++),
    array('db' => 'narration', 'dt' => $i++),
    array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return "<a href='add_casheeceive.php?id=$d' class='edit_btn' ><i class='fa fa-edit'></i></a>";
        }
    )
);
// SQL server connection information
$host = $_SERVER['HTTP_HOST'];
if ($host == 'servo') {
    $hostname = 'localhost';
    $database = 'maalgaad_maalgaadinew';
    $username = 'root';
    $password = '';
} elseif ($host == 'localhost') {
    $hostname = 'localhost';
    $database = 'maalgaad_maalgaadinew';
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
