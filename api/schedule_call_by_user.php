<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set("Asia/Calcutta");  
$date = date('Y-m-d H:i:s');
$date1 = date('Y-m-d');
$date1=date_create($date1);


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
	
	//$sql = mysqli_query($con,"select m.id,m.atmid,m.bank,m.customer,m.zone,m.city,m.state,m.location,md.status from mis_1_test m,mis_details_1_test md where m.id = md.mis_id AND md.status='schedule' AND md.engineer='".$userid."' AND m.city IN (".$_bank_name.")");
	$sql = mysqli_query($con,"select m.id,m.atmid,m.bank,m.customer,m.zone,m.city,m.state,m.location,md.status,md.subcomponent,md.created_at,m.created_at as call_date,md.id as md_id from mis m,mis_details md where m.id = md.mis_id AND md.status='schedule' AND md.engineer='".$userid."'");
//	$sql = mysqli_query($con,"select * from mis_1_test where city IN (".$_bank_name.")");
	$dataArray = array();
						  if(mysqli_num_rows($sql)>0){
							  while($sql_result = mysqli_fetch_assoc($sql)){
							      $mis_id = $sql_result['id'];
							      $md_id = $sql_result['md_id'];
							      $mis_his_query = mysqli_query($con,"SELECT schedule_date FROM `mis_history` WHERE mis_id='".$md_id."'");
							      $schedule_date = "";
							      if(mysqli_num_rows($mis_his_query)>0){
							      $mis_his_data = mysqli_fetch_assoc($mis_his_query);
							      $schedule_date = $mis_his_data['schedule_date'];
							      }
							    /*  $mis_sql = mysqli_query($con,"select id,type,engineer,mis_id from mis_history_test where mis_id='".$mis_id."' order by id desc limit 1");
    	                          $mis_data = mysqli_fetch_assoc($mis_sql);
    	                          $_schedule_check = 0;
    	                          if($mis_data['type']=='schedule'){
    	                              if($mis_data['engineer']==$userid){
    	                                  $_schedule_check = 1;
    	                              }
    	                          } */
    	                          
    	                          $_misdetailid = $md_id;
							        $fund_req_id = 0;
							        $fund_reqsql = mysqli_query($con,"select id from eng_fund_request where mis_id='".$_misdetailid."'");
							        if(mysqli_num_rows($fund_reqsql)>0){
                                	   $fund_reqdata = mysqli_fetch_assoc($fund_reqsql);
                                	   $fund_req_id = $fund_reqdata['id'];
							        }
    	                          
    	                          $_schedule_check = 1;
							      if($_schedule_check == 1){
    							      $_newdata = array();
    								  $_newdata['atmid'] = $sql_result['atmid'];
    								  $_newdata['bank'] = $sql_result['bank'];
    								  $_newdata['customer'] = $sql_result['customer'];
    								  $_newdata['zone'] = $sql_result['zone'];
    								  $_newdata['city'] = $sql_result['city'];
    								  $_newdata['state'] = $sql_result['state'];
    								  $_newdata['location'] = htmlspecialchars($sql_result['location']);
    								  $_newdata['status'] = $sql_result['status'];
    								  $_newdata['subcomponent'] = $sql_result['subcomponent'];
    								  $_newdata['schedule_date'] = $schedule_date;
    								  $date2=date_create($sql_result['created_at']);
                                             $diff=date_diff($date1,$date2);
                                             $_newdata['down_time'] = $diff->format("%a days");
                                             $_newdata['aging'] = $diff->format("%a");
                                    $_newdata['call_date'] = $sql_result['call_date']; 
                                    
                                    $_newdata['fund_req_id'] = $fund_req_id;
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