<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

$usersql = mysqli_query($con,"SELECT * FROM `daily_report_app` where created_by='216'");
$total = mysqli_fetch_assoc($usersql);
//$version = $total[0];
$array = array(['code'=>200,'version'=>$total]);
echo json_encode($array);