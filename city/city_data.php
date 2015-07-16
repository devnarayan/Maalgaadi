<?php

// DB table to use
$table = 'city';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$i=0;
$columns = array(
    array('db' => 'city',
          'dt' => $i++,
          
          ),
   array(
        'db' => 'id',
        'dt' => $i++,
        'formatter' => function( $d, $row ) {
            return "<a href='city.php?id=$d'  class='edit_btn' ><i class='fa fa-edit'></i></a><button type='button' onClick='delete_menu($d)' class='del_btn delete' ><i class='fa fa-trash'></i></button>";
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
            $database = 'maalgaadi_db_tes';
            $username = 'maalgaadi_db_tes';
            $password = 'maalgaadi_db_test';
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
