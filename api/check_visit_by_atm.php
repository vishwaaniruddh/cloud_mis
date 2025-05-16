<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');

    function lastcommunicationdiff($datetime2){
	    date_default_timezone_set('Asia/Kolkata');
		$datetime1 = new DateTime();
	    $datetime2 = new DateTime($datetime2);
		$interval = $datetime1->diff($datetime2);
		
		$elapsedyear = $interval->format('%y');
		$elapsedmon = $interval->format('%m');
		$elapsed_day = $interval->format('%a');
		$elapsedhr = $interval->format('%h');
		$elapsedmin = $interval->format('%i');
		$not = 0;
		if($elapsedyear>0){$not=$not+1;}
		if($elapsedmon>0){$not=$not+1;}
		if($elapsed_day>0){$not=$not+1;}
		//if($elapsedhr>0){$not=$not+1;}
		$min = $elapsedmin;
		$hour = $elapsedhr;
		if($not>0){
			$return = 1;
		}else{
			if($hour>=2){
				$return = 1;
			}else{
				$return = 0;
			}
		}
				
		return $return;	   
    }

    $userid = $_POST['user_id'];
    $activity = $_POST['activity'];
    $atm =  $_POST['atmid'];
    
    $_checksql = "select created_at from mis_newvisit_app where activity_type = '".$activity."' and created_by='".$userid."' and atmid='".$atm."' and status='1' order by id desc limit 1"; 
    $sql_detail = mysqli_query($con,$_checksql);
    $is_add = 0;
    if(mysqli_num_rows($sql_detail)>0){
        $check_sql_result = mysqli_fetch_assoc($sql_detail);
        $last_created = $check_sql_result['created_at'];
        $last_status = lastcommunicationdiff($last_created);
        
      //  $array = array(['Code'=>200,'res_data'=>$last_status,'last_create'=>$last_created]);
    
       // echo json_encode($array);
        
    }else{
        $last_status = 1;
    }
    
    $array = array(['Code'=>200,'res_data'=>$last_status]);
    
    echo json_encode($array);