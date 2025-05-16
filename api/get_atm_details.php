<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$atm_id = $_POST['atmid'];
//$atm_id = "P3ENSK04";
$dataArray = array();
$city_sql = mysqli_query($con,"SELECT * FROM `mis_newsite` where atmid='".$atm_id."'");
while($city_sql_result = mysqli_fetch_assoc($city_sql)){
    $_newdata = array();
    $_newdata['bank'] = $city_sql_result['bank']; 
    $_newdata['address'] = $city_sql_result['address'];
    array_push($dataArray,$_newdata); 
}

if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>201]);
}

echo json_encode($array);	

?>
							 
   