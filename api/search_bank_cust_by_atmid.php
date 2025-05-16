<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$atmid = $_POST['atmid'];

$usersql = mysqli_query($con,"select id,atmid,bank,customer from mis_newsite where atmid ='".$atmid."'");
$dataarray = array();
$total_site = mysqli_num_rows($usersql);
$dvr_online_count = 0;
$dvr_offline_count = 0;
if($total_site>0){
   while($userdata = mysqli_fetch_assoc($usersql)){
       $_newdata = array();
       $_newdata['label'] = $userdata['atmid'];
       $_newdata['value'] = $userdata['atmid'];
       $_newdata['customer'] = $userdata['customer'];
       $_newdata['bank'] = $userdata['bank'];
       array_push($dataarray,$_newdata);
   }
  
   array_push($dataarray,$_newdata);
    
}

$array = array(['code'=>200,'atmid_list'=>$dataarray]);
echo json_encode($array);