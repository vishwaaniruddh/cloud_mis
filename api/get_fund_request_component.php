<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//$userid = $_POST['user_id'];

//$usersql = mysqli_query($con,"select customer from mis_newsite where engineer_user_id ='".$userid."' AND customer!='' group by customer");
$usersql = mysqli_query($con,"select * from eng_fund_component_master where is_active=1");
$dataarray = array();
$total_site = mysqli_num_rows($usersql);
$dvr_online_count = 0;
$dvr_offline_count = 0;
if($total_site>0){
   while($userdata = mysqli_fetch_assoc($usersql)){
       $_newdata = array();
       $_newdata['label'] = $userdata['fund_component'];
       $_newdata['value'] = $userdata['fund_component'];
       array_push($dataarray,$_newdata);
   }
   //array_push($dataarray,$_newdata);
    
}

$array = array(['code'=>200,'fund_component'=>$dataarray]);
echo json_encode($array);