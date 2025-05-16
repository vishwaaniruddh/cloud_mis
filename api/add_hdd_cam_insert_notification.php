<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$datetime = date('Y-m-d H:i:s');

$eng_user_id = $data['created_by'];

$site_id = $data['site_id'];
$remark = $data['remark'];
$userid = $data['created_by'];

 $sitesql = mysqli_query($con,"select s.*,u.contact,u.name from mis_newsite s,mis_loginusers u where u.id=s.engineer_user_id and s.id='".$site_id."'");
 if(mysqli_num_rows($sitesql)>0){
    $sitedata = mysqli_fetch_assoc($sitesql);
    $atmid = $sitedata['atmid'];
    $bank = $sitedata['bank'];
    $customer = $sitedata['customer'];
    $zone = $sitedata['zone'];
    $city = $sitedata['city'];
    $state = $sitedata['state'];
    $location = $sitedata['address'];
    $engineer = $sitedata['name'];
    $eng_contact = $sitedata['contact'];
 }

$checklist_json = json_encode($checklist_json);
$sql = "insert into mis_newvisit_app(call_type,activity_type,site_id,atmid,bank,customer,zone,city,state,location,engineer,eng_contact,checklist_json,remark,status,created_at,created_by) values('".$call_type."','".$activity_type."','".$site_id."','".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$engineer."','".$eng_contact."','".$checklist_json."','".$remark."','0','".$datetime."','".$userid."')";

if(mysqli_query($con,$sql)){ 
    $insert_id = $con->insert_id;
   	$array = array(['Code'=>200,'new_visit_id'=>$insert_id]);
}else{
    	$array = array(['Code'=>201]);
    }   	


    
    echo json_encode($array);		