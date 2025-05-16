<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$userid = $_POST['user_id'];

$usersql = mysqli_query($con,"select id,atmid from mis_newsite where engineer_user_id ='".$userid."'");
$dataarray = array();
$total_site = mysqli_num_rows($usersql);
$dvr_online_count = 0;
$dvr_offline_count = 0;
if($total_site>0){
   while($userdata = mysqli_fetch_assoc($usersql)){
       $_newdata = array();
       $_newdata['label'] = $userdata['atmid'];
       $_newdata['value'] = $userdata['atmid'];
       array_push($dataarray,$_newdata);
   }
   $_newdata = array();
   $_newdata['label'] = 'Other';
   $_newdata['value'] = 'Other';
   array_push($dataarray,$_newdata);
    
}

$array = array(['code'=>200,'atmid_list'=>$dataarray]);
echo json_encode($array);