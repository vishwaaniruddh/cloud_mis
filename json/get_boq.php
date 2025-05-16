<?php 
$table = '( SELECT id,atmid,atmid2,atmid3,serial_number,bank,customer,address,city,state,pincode,engineer,engineer_number,bm_name,selection_type,created_at from boq_raise 
) tbl';


$primaryKey = 'id';

$columns = array(
array( 'db' => 'id', 'dt' => 1 ), 
array( 'db' => 'atmid', 'dt' => 2 ),
array( 'db' => 'atmid2', 'dt' => 3 ),
array( 'db' => 'atmid3', 'dt' => 4 ),
array( 'db' => 'serial_number', 'dt' => 5 ),
array( 'db' => 'bank', 'dt' => 6 ),
array( 'db' => 'customer', 'dt' => 7 ),
array( 'db' => 'address', 'dt' => 8 ),
array( 'db' => 'city', 'dt' => 9 ),
array( 'db' => 'state', 'dt' => 10 ),
array( 'db' => 'pincode', 'dt' => 11 ),
array( 'db' => 'engineer', 'dt' => 12 ),
array( 'db' => 'engineer_number', 'dt' => 13 ),
array( 'db' => 'bm_name', 'dt' => 14 ),
array( 'db' => 'selection_type', 'dt' => 15 ),
array( 'db' => 'created_at', 'dt' => 16 ),
);

include('config.php');
require( 'ssp.class.php' );



$where = " status=1";
echo json_encode(SSP::complex( $_GET, $sql_details, $table, $primaryKey,$columns));

?>