<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$userid = $_POST['user_id'];
$site_status = $_POST['type'];

if($site_status=='all'){
$usersql = mysqli_query($con,"select id,atmid,status,address from mis_newsite where engineer_user_id ='".$userid."'");
}
if($site_status=='online'){
$usersql = mysqli_query($con,"select id,atmid,status,address from mis_newsite where engineer_user_id ='".$userid."' and status=1");
}
if($site_status=='offline'){
$usersql = mysqli_query($con,"select id,atmid,status,address from mis_newsite where engineer_user_id ='".$userid."' and status=0");
}
$dataarray = array();
$total_site = mysqli_num_rows($usersql);
$dvr_online_count = 0;
$dvr_offline_count = 0;
if($total_site>0){
   while($userdata = mysqli_fetch_assoc($usersql)){
       $_newdata = array();
       $_newdata['atmid'] = $userdata['atmid'];
       $_newdata['siteaddress'] = $userdata['address'];
       $_newdata['is_online'] = $userdata['status'];
       array_push($dataarray,$_newdata);
   }
   $array = array(['code'=>200,'site_list'=>$dataarray]);
    
}else{
    $array = array(['code'=>201]);
}


echo json_encode($array);