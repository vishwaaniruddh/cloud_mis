<?php 
    
    include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
    header('Access-Control-Allow-Origin: *');
    //header('Content-Type: application/json');
    
    date_default_timezone_set('Asia/Kolkata');
    $datetime = date('Y-m-d H:i:s');
    $date = date('Y-m-d');
    
    $data = $_POST;
// var_dump($_POST);

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
    $visit_id = 0;
    if(mysqli_query($con,$sql)){ 
        $visit_id = $con->insert_id;
    }  	
    
 }else{
    $visit_id = 0; 
 }
//echo '<pre>';print_r($data);echo '</pre>';

    
if($visit_id>0){
   
    $hddcnt = count($_FILES["HDD_Status"]["name"]);
    //$filename = strtotime("now").".jpg";
    $totalhddfiles = 0;$hdderr = 0;$hddnoerr = 0;
    if($hddcnt>0){
        $key_name = 'HDD_Status';
        for($k=0;$k<$hddcnt;$k++){
        // foreach($_FILES as $k => $v){
            $totalhddfiles = $totalhddfiles + 1;
            $name = $k ;
            $target_filedir =  "../visituploadapp/".$visit_id.'/'.$key_name.'/'; 
            $target_dir = "visituploadapp/".$visit_id.'/'.$key_name.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["HDD_Status"]["name"][$name];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            $source_file = $_FILES["HDD_Status"]["tmp_name"][$name];
           // if(compress_image($source_file, $target_file,20)){
            if (move_uploaded_file($_FILES["HDD_Status"]["tmp_name"][$name], $target_file)) {
                $hddnoerr = $hddnoerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
                $sql = "insert into misvisit_images_app(misvisitid, key_name,name,link,status,created_at) values('".$visit_id."','".$key_name."','".$name."','".$link."','1','".$datetime."')" ; 
                mysqli_query($con,$sql);
            } else {
                $hdderr = $hdderr + 1;
        
            }
        }
    }      
    if($hddnoerr>0){
        if($totalhddfiles==$hddnoerr){
            $msg = $hddnoerr." Files uploaded successfully."; 
        }else{
           $msg = $hddnoerr." Files uploaded successfully and ".$err." Files not uploaded" ;  
        }
        $array = array(['Code'=>200,'new_visit_id'=>$visit_id]);
       // $array = array(['Code'=>200,'msg'=>$msg,'files'=>$cnt]);
    }else{
        if($hddcnt==0){
            $array = array(['Code'=>200,'new_visit_id'=>$visit_id]);
        }else{
            $msg = "Sorry, there was an error uploading ".$hdderr." file."; 
            $array = array(['Code'=>202,'msg'=>$msg,'files'=>$cnt]);
        }
    }
}else{
    $array = array(['Code'=>201]);
}
            
    echo json_encode($array);		
    
    ?>