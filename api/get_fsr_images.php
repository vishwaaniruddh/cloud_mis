<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');

$statement = "select atmid,bank,link,created_at from view_pmc_report_fsr_image where bank='PNB'";

$dataArray = array();
$total = 0;$total_done = 0;$total_notdone = 0;
$sql = mysqli_query($con,$statement);
if(mysqli_num_rows($sql)>0){
    while($sql_result = mysqli_fetch_assoc($sql)){
        $_newdata = array();
         $_newdata['atmid'] = $sql_result['atmid'];
         $_newdata['link'] = $sql_result['link'];
         $_newdata['created_at'] = $sql_result['created_at'];
         array_push($dataArray,$_newdata); 
    }
}

if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);