<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$userid = $_POST['userid'];

$sql = mysqli_query($con,"select * from profile_details where user_id = '".$userid."' ");
$sql_data = mysqli_fetch_assoc($sql);

$dataArray = array();

$data['name']   = $sql_data['name'];
$data['mobile']   = $sql_data['contact'];
$data['dob']   = $sql_data['dob'];
$data['email']   = $sql_data['email'];
$data['qualification']   = $sql_data['qualification'];

array_push($dataArray,$data); 


if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>500,'res_data' => "Something Wrong"]);
}

echo json_encode($array);	

?>