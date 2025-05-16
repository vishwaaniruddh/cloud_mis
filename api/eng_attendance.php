<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

$att_date = date('Y-m-d');
$userid = $_POST['user_id'];
$atmid = $_POST['atm_id'];
$att_type = $_POST['att_type'];

$mac_id = $_POST['mac_id'];
$location = $_POST['location'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

$is_valid = 1;
if($att_type==1){
    $time = date('H');
    if($time>=9 && $time<=11){
        $is_valid = 1;
    }else{
        $is_valid = 0;
    }
}
$created_at = date('Y-m-d H:i:s');

$sql = "insert into eng_attendance_app (atmid,eng_user_id,att_date,att_type,created_at,is_valid,mac_id,location,latitude,longitude) values('".$atmid."','".$userid."','".$att_date."','".$att_type."','".$created_at."','".$is_valid."','".$mac_id."','".$location."','".$latitude."','".$longitude."')";
mysqli_query($con,$sql);

if($att_type==1){
    $msg = "Punch In Successfully";
}else{
    $msg = "Punch Out Successfully";
}

$array = array(['code'=>200,'msg'=>$msg]);
echo json_encode($array);