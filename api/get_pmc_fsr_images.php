<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');

$statement = "select pia.link,pia.visitid,pr.atmid from pmcreport_images_app pia,pmc_report pr where pia.visitid = pr.visit_id AND pia.filename='FSR Copy'";

$dataArray = array();
$total = 0;$total_done = 0;$total_notdone = 0;
$sql = mysqli_query($con,$statement);
if(mysqli_num_rows($sql)>0){
    while($sql_result = mysqli_fetch_assoc($sql)){
        $_newdata = array();
         $_newdata['atmid'] = $sql_result['atmid'];
         $_newdata['link'] = $sql_result['link'];
         $_newdata['visitid'] = $sql_result['visitid'];
         array_push($dataArray,$_newdata); 
    }
}

if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);