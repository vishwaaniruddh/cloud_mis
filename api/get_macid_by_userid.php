<?php
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$userid = $_POST['user_id'];

 $sql = mysqli_query($con,"select mac_id from mis_loginusers where id = '".$userid."'");
 $sql_result = mysqli_num_rows($sql);

if($sql_result>0){
    $get_sql_result = mysqli_fetch_assoc($sql);
	$mac_id = $get_sql_result['mac_id'];
	
    $data=['Code'=> 200,'mac_id'=>$mac_id];
    echo json_encode($data);
        
}
else{

	$data=['Code'=> 201];
    echo json_encode($data);
}
?>