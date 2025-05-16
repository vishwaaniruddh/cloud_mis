<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$state_id = $_POST['id'];
$dataArray = array();
$city_sql = mysqli_query($con,"SELECT * FROM `mis_city` where state_id='".$state_id."'");
while($city_sql_result = mysqli_fetch_assoc($city_sql)){
    $_newdata = array();
    $_newdata['value'] = $city_sql_result['id']; 
    $_newdata['label'] = $city_sql_result['city'];
    array_push($dataArray,$_newdata); 
}

if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>201]);
}

echo json_encode($array);	

?>
							 
   