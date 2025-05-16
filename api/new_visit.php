<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$datetime = date('Y-m-d H:i:s');
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json,true);
// var_dump($data);


$call_type = $data['call_type'];
$activity_type = $data['activity_type'];

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
//echo '<pre>';print_r($data);echo '</pre>';
$checklist_json = array();
foreach($data as $key=>$value){
    if($key!='activity_type' && $key!='site_id' && $key!='remark' && $key!='created_by'){
        $_newdata = array();
        $_newdata['k'] = $key;
        $_newdata['v'] = $value;
        array_push($checklist_json,$_newdata);
    }
    
}
$checklist_json = json_encode($checklist_json);
$sql = "insert into mis_newvisit_app(call_type,activity_type,site_id,atmid,bank,customer,zone,city,state,location,engineer,eng_contact,checklist_json,remark,status,created_at,created_by) values('".$call_type."','".$activity_type."','".$site_id."','".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$engineer."','".$eng_contact."','".$checklist_json."','".$remark."','0','".$datetime."','".$userid."')";

if(mysqli_query($con,$sql)){ 
    $insert_id = $con->insert_id;
   	$array = array(['Code'=>200,'new_visit_id'=>$insert_id]);
}else{
    	$array = array(['Code'=>201]);
    }   	
/*
if(mysqli_query($con,$sql)){ 
    $insert_id = $con->insert_id;
    mysqli_query($con,"insert into visitsite_details(visit_id,type,status,cam1,cam2,cam3,cam4,hdd_status,router_name,routerid,other_status,visitstatus,created_at,ip_cam,sd_card_status) values('".$insert_id."','".$tabselect."','".$status."','".$cam1."','".$cam2."','".$cam3."','".$cam4."','".$hdd_status."','".$routername."','".$routerid."','".$other_status."','1','".$datetime."','".$ip_cam."','".$sd_card_status."')");


foreach($_FILES as $k => $v){
    $name = $k ;
    $target_dir = "visitupload/".$insert_id.'/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    $target_file = $target_dir . basename($_FILES[$name]["name"]);    
    $imageTmp = $_FILES[$name]["tmp_name"];
    $compressedImage = compressImage($imageTmp,$target_file,60);
    if($compressedImage){
        $compressedImageSize = filesize($compressedImage);
    //} 
   //  if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
    if ($compressedImageSize) {
    echo "The file  has been uploaded.";
    $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. htmlspecialchars( basename( $_FILES[$name]["name"])) ; 
    $sql = "insert into misvisit_images(misvisitid, name,link,status,created_at) values('".$insert_id."','".$name."','".$link."','1','".$date."')" ; 
    mysqli_query($con,$sql);
    } else {
    echo "Sorry, there was an error uploading your file.";
    }
    echo '<br>';
    }
}
*/

    
    echo json_encode($array);		