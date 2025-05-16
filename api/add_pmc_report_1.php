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
// var_dump($_POST);

    $testarray = array();
    
    foreach($data as $key=>$value)
    {
        if($key!='images_name'){
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
    
	}       
    else
    {
        $visit_id = 0;
        
    }
    
    if($visit_id>0){
      
        
        $err = 0;
        $noerr = 0;
        
        $errv = 0;
        $noerrv = 0;
        
        $totalfiles = 0;
        $totalfilesv = 0;
        $cnt = count($_FILES["image"]["name"]);
        
        
        $array = array(['Code'=>200]);
    }else{
        $array = array(['Code'=>202]);
        
    }
    
}else{

    $array = array(['Code'=>203]);
}
    
echo json_encode($array);

?>