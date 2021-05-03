<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'history';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names



$columns = array(
    array( 'db' => 'h_fname', 'dt' => 'h_fname' ),
    array( 'db' => 'h_telephone',  'dt' => 'h_telephone' ),
    array( 'db' => 'h_email',   'dt' => 'h_email' ),
    array( 'db' => 'h_address',     'dt' => 'h_address' ),
    //array( 'db' => 'h_codequeue',     'dt' => 'h_codequeue' ),
    array( 'db' => 'h_type',            'dt' => 'h_type' ),
    array( 'db' => 'h_prymitka',            'dt' => 'h_prymitka' ),
    array( 'db' => 'h_services_type',     'dt' => 'h_services_type' ),
    array( 'db' => 'h_workplace',     'dt' => 'h_workplace' ),
    array( 'db' => 'h_timequeue',     'dt' => 'h_timequeue' ),
    array( 'db' => 'h_dataqueue',     'dt' => 'h_dataqueue' ),
    array( 'db' => 'h_datetimereg',     'dt' => 'h_datetimereg' )
   
    /*array(
        'db'        => 'start_date',
        'dt'        => 'start_date',
        'formatter' => function( $d, $row ) {
            return date( 'jS M y', strtotime($d));
        }
    ),
    array(
        'db'        => 'salary',
        'dt'        => 'salary',
        'formatter' => function( $d, $row ) {
            return '$'.number_format($d);
        }
    )*/
);
// SQL server connection information
$sql_details = array(
    'user' => '',
    'pass' => '',
    'db'   => '',
    'host' => ''
);
 //$sql_details->set_charset("utf8");
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'libs/ssp.class.php' );

 
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
);