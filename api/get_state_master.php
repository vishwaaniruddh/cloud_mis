<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$dataArray = array();
$state_sql = mysqli_query($con,"SELECT * FROM `state`");
while($state_sql_result = mysqli_fetch_assoc($state_sql)){
    $_newdata = array();
    $_newdata['value'] = $state_sql_result['state_id']; 
    $_newdata['label'] = $state_sql_result['state'];
    array_push($dataArray,$_newdata); 
}

if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>201]);
}

echo json_encode($array);	

?>
							 
   