<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$created_at = date('Y-m-d H:i:s');
$datetime = $created_at;

$count_visit_query = mysqli_query($con,"select id from pmc_report order by id DESC LIMIT 1");
$count_visit = mysqli_fetch_assoc($count_visit_query);
if($count_visit['id']){
    $_next_visit_id = $count_visit['id'] + 1;
}else{
    $_next_visit_id = 1;
}

$atmid = $_POST['atm_id'];
$visit_id = $_next_visit_id;

$eng_id = $_POST['eng_id'];
$form_start_time = $_POST['form_start_time'];

$form_end_time = $created_at;

$mac_id = "";
if(isset($_POST['mac_id'])){
  $mac_id = $_POST['mac_id'];
}
$location = "";
if(isset($_POST['location'])){
  $location = $_POST['location'];
}
$latitude = "";
if(isset($_POST['latitude'])){
  $latitude = $_POST['latitude'];
}
$longitude = "";
if(isset($_POST['longitude'])){
  $longitude = $_POST['longitude'];
}


$files = '';
$array = array();
$status = 0;

if($atmid!='' && $eng_id!=''){

    $data = $_POST;
    $_imagefilename = $data['images_name'];
     $_videofilename = $data['videos_name'];
// var_dump($_POST);

    $testarray = array();
    
    foreach($data as $key=>$value)
    {
       if($key!='images_name' && $key!='videos_name') {
        
        $_newdata = array();
        $_newdata['key'] = $key;
        $_newdata['value'] = trim($value);
        array_push($testarray,$_newdata);
        
       }
    }

    $testarray = json_encode($testarray);

    $query_result = mysqli_query($con,"insert into pmc_report (`atmid`, `visit_id`,  `question_list`, `status`, `created_at`, `created_by`, `form_start_time`, `form_end_time`, `mac_id`, `location`, `latitude`, `longitude`) values ('".$atmid."','".$visit_id."','".$testarray."','".$status."','".$created_at."','".$eng_id."','".$form_start_time."','".$form_end_time."','".$mac_id."','".$location."','".$latitude."','".$longitude."') ");

    if($query_result)
	{
	    $visit_id = $con->insert_id;
	    $update_visit_id = mysqli_query($con,"update pmc_report SET  `visit_id`='".$visit_id."' where id='".$visit_id."'");
   	   // $array = array('Code'=>200,'res_data'=>$testarray,'new_visit_id'=>$insert_id);
	
	}       
    else
    {
        $visit_id = 0;
    }
    
    if($visit_id>0){
       // $_videofilename = $_POST['videos_name'];
       // $_imagefilename = $_POST['images_name'];
        $err = 0;
        $noerr = 0;
        
        $errv = 0;
        $noerrv = 0;
        
        $totalfiles = 0;
        $totalfilesv = 0;
        $cnt = count($_FILES["image"]["name"]);
        
        
        //$filename = strtotime("now").".jpg";
        
        for($k=0;$k<$cnt;$k++){
        // foreach($_FILES as $k => $v){
            $totalfiles = $totalfiles + 1;
            $name = $k ;
            $target_filedir =  "../pmcreportapp/".$visit_id.'/'; 
            $target_dir = "pmcreportapp/".$visit_id.'/';
                if (!file_exists($target_filedir)) {
                    mkdir($target_filedir, 0777, true);
                }
            $path = $_FILES["image"]["name"][$name];
            $image_name = $_imagefilename[$k];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time()."_".$name.".".$ext; 
            //$target_file = $target_filedir . basename($_FILES[$name]["name"]);    
            $target_file = $target_filedir . $filename;
            if (move_uploaded_file($_FILES["image"]["tmp_name"][$name], $target_file)) {
                $noerr = $noerr + 1;
                $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/'.$target_dir. $filename ; 
               if($image_name=='FSR Copy'){
                    $_get_detail = "SELECT bank,atmid FROM mis_newsite WHERE atmid = (SELECT atmid FROM `pmc_report` WHERE visit_id='".$visit_id."')";
                    $_getsql = mysqli_query($con,$_get_detail);
                    if(mysqli_num_rows($_getsql)>0){
                       $getsql_result = mysqli_fetch_assoc($_getsql);
                       $_atmid = $getsql_result['atmid'];
                       $_bank = $getsql_result['bank'];
                       $_ins_sql = "insert into view_pmc_report_fsr_image(atmid, visit_id,bank,link,created_at) values('".$_atmid."','".$visit_id."','".$_bank."','".$link."','".$datetime."')" ; 
                       mysqli_query($con,$_ins_sql);
                    }
                    
                }  
                $sql = "insert into pmcreport_images_app(visitid, name,filename,link,status,created_at) values('".$visit_id."','".$name."','".$image_name."','".$link."','1','".$datetime."')" ; 
                mysqli_query($con,$sql);
            } else {
                $err = $err + 1;
        
            }
        
        }
        
        // $_filename = $_FILES["videos"]["name"];
        // var_dump($_filename);
        
        
        $cntv = count($_FILES["videos"]["name"]);
        // echo $cntv;
        $maxsize = 15728640; // 15MB
        
        for ($k = 0; $k < $cntv; $k++) {
            $totalfilesv = $totalfilesv + 1;
            $name = $k;
            $target_filedir =  "../pmcreportapp/" . $visit_id . '/';
            $target_dir = "pmcreportapp/" . $visit_id . '/';
            if (!file_exists($target_filedir)) {
                mkdir($target_filedir, 0777, true);
            }
            $path = $_FILES["videos"]["name"][$name];
          //  var_dump($path);
            $video_name = $_videofilename[$k];
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
            // Valid file extensions
            $extensions_arr = array("mp4", "mpeg");
        
            $filename = time() . "_" . $name . "." . $ext;
        
            $target_file = $target_filedir . $filename;
        
            if (in_array($ext, $extensions_arr)) {
        
                $size = $_FILES['videos']['size'][$name];
                // var_dump($size);
        
                 
                if(move_uploaded_file($_FILES["videos"]["tmp_name"][$name], $target_file)) {
                    $noerrv = $noerrv + 1;
                    $link = 'https://cssmumbai.sarmicrosystems.com/css/dash/esir/' . $target_dir . $filename;
                    $sql = "insert into pmcreport_videos_app(visitid, name,filename,link,status,created_at) values('" . $visit_id . "','" . $name . "','".$video_name."','" . $link . "','1','" . $datetime . "')";
                    mysqli_query($con, $sql);
                }  else if (($size >= $maxsize) || ($size == 0)) {
                    $errmsg = "File too large. File must be less than 15MB.";
                    $errv = $errv + 1;
                }
            }
        
            
            
        }
        
        if($noerr>0){
            if($totalfiles==$noerr){
                $update = mysqli_query($con,"update pmc_report SET  `status`='1', `updated_at`='".$datetime."' where visit_id='".$visit_id."'");
    
                $msg = $noerr." Files uploaded successfully."; 
            }else{
               $msg = $noerr." Files uploaded successfully and ".$err." Files not uploaded" ;  
            }
            $array = array(['Code'=>200]);
        }else{
            $msg = "Sorry, there was an error uploading ".$err." file."; 
            $array = array(['Code'=>201]);
        }
        
      /*  
        if ($totalfiles == $noerr && $totalfilesv == $noerrv) {
            $query_result = mysqli_query($con,"update pmc_report SET  `status`='1', `updated_at`='".$datetime."' where visit_id='".$visit_id."'");
            $msg = " Form uploaded successfully.";
            $array = array(['Code' => 200, 'image' => $noerr,'video'=> $noerrv]);
            
            
        }  else {
            $msg = "Sorry, there was an error uploading form";
            $array = array(['Code' => 201, 'image' => $noerr,'video'=> $noerrv]);
            
        }
         */ 
         
    }else{
        $array = array(['Code'=>202]);
        
    }
    
    
}else{
    $array = array(['Code'=>203]);
    
}

    
echo json_encode($array);

?>