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

$fund_requested_by = $data['user_id'];

$atmid = "";
if(isset($data['atmid'])){
  $atmid = $data['atmid'];
}
$fund_type = "";
if(isset($data['fund_type'])){
  $fund_type = $data['fund_type'];
}
$fund_component = "";
if(isset($data['fund_component'])){
  $fund_component = $data['fund_component'];
}
$requested_amt = 0; $approved_amt = 0;
if(isset($data['requested_amt'])){
  $requested_amt = $data['requested_amt'];
}


$array = array();

if($atmid!=''){
$sql = "insert into eng_fund_request(atmid,fund_type,fund_component,requested_amount,approved_amount,fund_requested_by,created_at) values('".$atmid."','".$fund_type."','".$fund_component."','".$requested_amt."','".$approved_amt."','".$fund_requested_by."','".$datetime."')";
    $fundreq_id = 0;
    if(mysqli_query($con,$sql)){ 
        $fundreq_id = $con->insert_id;
        
        if($fundreq_id>0){
            $fundsql = "insert into eng_fund_request_history(fundreq_id, requested_amount,approved_amount,action_by,status,created_at,updated_at) values('".$fundreq_id."','".$requested_amt."','".$approved_amt."','".$fund_requested_by."',1,'".$datetime."','".$datetime."')" ; 
            mysqli_query($con,$fundsql);
            $msg = "Fund Request Created Successfully";
            $array = array(['Code'=>200,'msg'=>$msg]);
            
        }else{
            $array = array(['Code'=>202]);
        }
    }else{
        $array = array(['Code'=>201]);
    }  	
}else{
    $array = array(['Code'=>203]);
}

            
    echo json_encode($array);		
  