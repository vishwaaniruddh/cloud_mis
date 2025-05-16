<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

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
$sql = "insert into mis_newvisit_app(call_type,activity_type,site_id,atmid,bank,customer,zone,city,state,location,engineer,eng_contact,checklist_json,remark,status,created_at,created_by) values('".$call_type."','".$activity_type."','".$site_id."','".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$engineer."','".$eng_contact."','".$checklist_json."','".$remark."','1','".$datetime."','".$userid."')";

if(mysqli_query($con,$sql)){ 
    $visit_id = $con->insert_id;
    $err = 0;
    $noerr = 0;
    $totalfiles = 0;
    $cnt = count($_FILES["image"]["name"]);
    //$filename = strtotime("now").".jpg";
   // if(is_int($visit_id)){
    
        for($k=0;$k<$cnt;$k++){
        //foreach($_FILES as $k => $v){
            $totalfiles = $totalfiles + 1;
            $name = $k ;
            $target_filedir =  "../visituploadapp/".$visit_id.'/'; 
            $target_dir = "visituploadapp/".$visit_id.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["image"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["image"]["tmp_name"][$name], $target_file)) {
                $noerr = $noerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "insert into misvisit_images_app(misvisitid, name,link,status,created_at) values('".$visit_id."','".$name."','".$link."','1','".$date."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err = $err + 1;
            
            }
            
        }
        
        if($noerr>0){
            if($totalfiles==$noerr){
              $msg = $noerr." Files uploaded successfully."; 
            }else{
               $msg = $noerr." Files uploaded successfully and ".$err." Files not uploaded" ;  
            }
            $array = array(['Code'=>200,'msg'=>$msg,'files'=>$cnt]);
        }else{
            $msg = "Sorry, there was an error uploading ".$err." file."; 
            $array = array(['Code'=>201,'msg'=>$msg,'files'=>$cnt]);
        }
        
}else{
    	$array = array(['Code'=>201]);
    } 