<?php 
    
    include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
    header('Access-Control-Allow-Origin: *');
    //header('Content-Type: application/json');
    
    function delfolder($path) {
       $files = array_diff(scandir($path), array('.','..'));
        foreach ($files as $file) {
          (is_dir("$path/$file")) ? delfolder("$path/$file") : unlink("$path/$file");
        }
        return rmdir($path);
    } 
    
    date_default_timezone_set('Asia/Kolkata');
    $datetime = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    
    $data = $_POST;
// var_dump($_POST);

$mac_id = "";
if(isset($data['mac_id'])){
  $mac_id = $data['mac_id'];
}
$exact_location = "";
if(isset($data['location'])){
  $exact_location = $data['location'];
}
$latitude = "";
if(isset($data['latitude'])){
  $latitude = $data['latitude'];
}
$longitude = "";
if(isset($data['longitude'])){
  $longitude = $data['longitude'];
}


$call_type = $data['call_type'];
$activity_type = $data['activity_type'];
$is_hdd_hide = $data['is_hdd_hide'];
$site_id = $data['site_id'];
$remark = $data['remark'];
$userid = $data['created_by'];
$array = array();
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
    $sql = "insert into mis_newvisit_app_test(call_type,activity_type,site_id,atmid,bank,customer,zone,city,state,location,engineer,eng_contact,checklist_json,remark,status,created_at,created_by,mac_id,exact_location,latitude,longitude) values('".$call_type."','".$activity_type."','".$site_id."','".$atmid."','".$bank."','".$customer."','".$zone."','".$city."','".$state."','".$location."','".$engineer."','".$eng_contact."','".$checklist_json."','".$remark."','0','".$datetime."','".$userid."','".$mac_id."','".$exact_location."','".$latitude."','".$longitude."')";
    $visit_id = 0;
    if(mysqli_query($con,$sql)){ 
        $visit_id = $con->insert_id;
    }  	
    
 }else{
    $visit_id = 0; 
 }

if($visit_id>0){
        $err = 0;$noerr = 0;
        $errv = 0;$noerrv = 0;
        
        $totalfiles = 0;$totalfilesv = 0;
       // $cnt = count($_FILES["image"]["name"]);
        
        $target_filedir =  "../addvisitappchecknow/".$visit_id.'/'; 
        $target_dir = "addvisitappchecknow/".$visit_id.'/';
        if (!file_exists($target_filedir)) {
            mkdir($target_filedir, 0777, true);
        }
        
        $count_visit_image_query = mysqli_query($con,"select * from addvisit_upload_images_app WHERE atmid='".$atmid."'");
        $file_cpy = 0;
        $_name = 0;
        $file_cnt = mysqli_num_rows($count_visit_image_query);
        while($count_visit_image = mysqli_fetch_assoc($count_visit_image_query)) {
        
            $image_name = $count_visit_image['img_name']; 
            $key_name = '';
            if($image_name=='HDD_Status'){
                $key_name = $image_name;
                $name = 0;
            }else{
                $name = $image_name;
            }
            $img_file = $count_visit_image['img']; 
            $explode_img_url = explode("esir",$img_file);
            
            $filename_explode = explode("/",$explode_img_url[1]);
            
            $filename = $filename_explode[count($filename_explode) - 1];
            
           // $filename = "_Lobby_Temperature_0.jpg";
            $source_file = "..".$explode_img_url[1];
            $destination_file = $target_filedir . $filename;
            if (copy($source_file, $destination_file)) {
                $noerr = $noerr + 1;
                $file_cpy = $file_cpy + 1;
                
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                
                $sql = "insert into misvisit_images_app_new_test(misvisitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$datetime."')" ; 
                mysqli_query($con,$sql);
                $_name = $_name + 1;
            } else {
                $err = $err + 1;
            }
        
        }
        
        if($file_cpy==$file_cnt){
           $path = "../addvisituploadimageapp/".$atmid;
           delfolder($path);
        }
         
  
    if($noerr>0){
        if($totalfiles==$noerr){
            $update = mysqli_query($con,"update mis_newvisit_app_test set status='1' where id = '".$visit_id."' ");

            $msg = $noerr." Files uploaded successfully."; 
        }else{
           $msg = $noerr." Files uploaded successfully and ".$err." Files not uploaded" ;  
        }
        $array = array(['Code'=>200,'msg'=>$msg,'files'=>$cnt,'hdd_msg'=>$hddmsg]);
    }else{
        $msg = "Sorry, there was an error uploading ".$err." file."; 
       $array = array(['Code'=>201,'msg'=>$msg,'files'=>$cnt,'hdd_msg'=>$hddmsg]);
    }
    
    
}else{
    $array = array(['Code'=>202]);
}
            
    echo json_encode($array);		
  