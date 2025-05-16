<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


$userid = $_POST['user_id'];
$status = $_POST['status'];
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
	
	$sql = mysqli_query($con,"select id,atmid,bank,customer,zone,city,state,address,status,css_bm,format,recording_date from footage_bulk_request where atmid IN (SELECT atmid FROM `mis_newsite` WHERE engineer_user_id='".$userid."')  AND status='".$status."'");

	  $dataArray = array();
	  if(mysqli_num_rows($sql)>0){
		  while($sql_result = mysqli_fetch_assoc($sql)){
		      $mis_id = $sql_result['id'];
		      $mis_sql = mysqli_query($con,"select * from eng_footage_request_history where footage_id='".$mis_id."' order by id desc limit 1");
              $current_status = $sql_result['status'];
              if(mysqli_num_rows($mis_sql)>0){
                  $mis_data = mysqli_fetch_assoc($mis_sql);
                  $current_status = $mis_data['update_status'];
              }
              $_schedule_check = 1;
		      if($_schedule_check == 1){
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
				  $_newdata['current_status'] = $current_status;
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