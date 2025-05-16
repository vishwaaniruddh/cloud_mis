<?php
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    date_default_timezone_set("Asia/Calcutta");  
    $date = date('Y-m-d H:i:s');
    $today = date('Y-m-d');
    $date1 = $today;
    $date1=date_create($date1);
    
    $userid = $_POST['user_id'];

    $usersql = mysqli_query($con,"select * from daily_report_app where created_by='".$userid."' AND report_date='".$today."'");
	if(mysqli_num_rows($usersql)>0){
	    $array = array(['Code'=>200]);
	}else{
		$array = array(['Code'=>201]);
    }
   echo json_encode($array);	