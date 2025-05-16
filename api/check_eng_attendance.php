<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');
$userid = $_POST['user_id'];
$atmid = $_POST['atm_id'];
$att_date = date('Y-m-d');

//$usersql = mysqli_query($con,"select id,created_at,att_type from eng_attendance_app where eng_user_id ='".$userid."' AND atmid='".$atmid."' AND att_date='".$att_date."'");
$usersql = mysqli_query($con,"select id,created_at,att_type from eng_attendance_app where eng_user_id ='".$userid."' AND att_date='".$att_date."'");
$total = mysqli_num_rows($usersql);
$att_type = "";
$msg = "";
if($total==0){
    $att_type = "IN";
    $msg = "You have not logged in";
}else{
    if($total==1){
      $att_type = "OUT";  
    }
}
$array = array(['code'=>200,'att_type'=>$att_type,'atmid'=>$atmid]);
echo json_encode($array);