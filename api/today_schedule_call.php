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
	
	$callsql = mysqli_query($con,"select md.id,md.mis_id from mis_details m,mis_history md where m.id = md.mis_id AND m.status='schedule' and m.status=md.type AND md.engineer='".$userid."' and md.schedule_date='".$today."'");
    $total_call = mysqli_num_rows($callsql);
    $dataArray = array();
	if($total_call>0){
	    //$sql = mysqli_query($con,"select m.id,m.atmid,m.bank,m.customer,m.zone,m.city,m.state,m.location,md.status from mis_1_test m,mis_details_1_test md where m.id = md.mis_id AND md.status='schedule' AND md.engineer='".$userid."' AND m.city IN (".$_bank_name.")");
        //	$sql = mysqli_query($con,"select * from mis_1_test where city IN (".$_bank_name.")");
	    while($call_sql_result = mysqli_fetch_assoc($callsql)){
	        $mis_detail_id = $call_sql_result['mis_id'];
	        $sql = mysqli_query($con,"select md.id,m.atmid,m.bank,m.customer,m.zone,m.city,m.state,m.location,md.status,md.subcomponent from mis m,mis_details md where m.id = md.mis_id AND md.status='schedule' AND md.engineer='".$userid."' and md.id='".$mis_detail_id."'");
			  if(mysqli_num_rows($sql)>0){
				  $sql_result = mysqli_fetch_assoc($sql);
				  $mis_id = $sql_result['id'];
				    
			      $_newdata = array();
			      $_newdata['mis_detail_id'] = $sql_result['id'];
				  $_newdata['atmid'] = $sql_result['atmid'];
				  $_newdata['bank'] = $sql_result['bank'];
				  $_newdata['customer'] = $sql_result['customer'];
				  $_newdata['zone'] = $sql_result['zone'];
				  $_newdata['city'] = $sql_result['city'];
				  $_newdata['state'] = $sql_result['state'];
				  $_newdata['location'] = htmlspecialchars($sql_result['location']);
				  $_newdata['status'] = $sql_result['status'];
				  $_newdata['subcomponent'] = $sql_result['subcomponent'];
				  array_push($dataArray,$_newdata); 
				  
			}
     	}	
	}
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201,'bn'=>$_bank_name]);
    }
    
    
    
    echo json_encode($array);					  