<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

$today = date('Y-m-d');

$userid = $_POST['user_id'];

    $usersql = mysqli_query($con,"select branch,zone from mis_loginusers where id='".$userid."'");
	$userdata = mysqli_fetch_assoc($usersql);
	$_bank_ids = $userdata['branch'];
    $banks = explode(",",$_bank_ids);
	$_bank_name = [];
	for($i=0;$i<count($banks);$i++){
	    $branch_city = $banks[$i];
    	$citysql = mysqli_query($con,"select city from mis_city where id='".$branch_city."'");
    	$citydata = mysqli_fetch_assoc($citysql);
	    array_push($_bank_name,$citydata['city']);
	} 
	   
    $_bank_name=json_encode($_bank_name);
	$_bank_name=str_replace( array('[',']','"') , ''  , $_bank_name);
	$bankarr=explode(',',$_bank_name);
	$_bank_name = "'" . implode ( "', '", $bankarr )."'";
	
	$footagesql = mysqli_query($con,"select footage_id from eng_footage_request_history where created_by ='".$userid."' and update_details='".$today."'");
    $total_footage = mysqli_num_rows($footagesql);
    $dataArray = array();
    if($total_footage>0){
        while($footage_data=mysqli_fetch_assoc($footagesql)){
          $footage_id = $footage_data['footage_id'];   
          $sql = mysqli_query($con,"select id,atmid,bank,customer,zone,city,state,address,status,css_bm,format,recording_date from footage_bulk_request where id='".$footage_id."'");

	
    	  if(mysqli_num_rows($sql)>0){
    		 
    		      $sql_result = mysqli_fetch_assoc($sql);
		          $_newdata = array();
			      $_newdata['id'] = $sql_result['id'];
				  $_newdata['atmid'] = $sql_result['atmid'];
				  $_newdata['bank'] = $sql_result['bank'];
				  $_newdata['customer'] = $sql_result['customer'];
				  $_newdata['zone'] = $sql_result['zone'];
				  $_newdata['city'] = $sql_result['city'];
				  $_newdata['state'] = $sql_result['state'];
				  $_newdata['location'] = htmlspecialchars($sql_result['address']);
				  $_newdata['status'] = $sql_result['status'];
				  $_newdata['current_status'] = 'Schedule';
				  $_newdata['css_bm'] = $sql_result['css_bm'];
				  $_newdata['format'] = $sql_result['format'];
				  $_newdata['recording_date'] = $sql_result['recording_date'];
				  array_push($dataArray,$_newdata); 
    		   
    	  }
       }
    }
	
	
						  
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);					  