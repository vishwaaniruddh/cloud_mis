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
	
	$sql = mysqli_query($con,"select * from checkquality where created_by='".$userid."' order by created_at desc");
	$dataArray = array();
      if(mysqli_num_rows($sql)>0){
    	  while($sql_result = mysqli_fetch_assoc($sql)){
    	      $_newdata = array();
    	      $_newdata['id'] = $sql_result['id'];
    	      $_newdata['customer'] = $sql_result['customer'];
    	      $_newdata['atmid'] = $sql_result['atmid'];
    		  $_newdata['bank'] = $sql_result['bank'];
    		  $_newdata['question_list'] = $sql_result['question_list'];
    		  $_newdata['status'] = $sql_result['status'];
    		  $_newdata['created_at'] = $sql_result['created_at'];
    		  array_push($dataArray,$_newdata);  
    	   
    	  }
      }
						  
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201,'bn'=>$_bank_name]);
    }
    
    
    
    echo json_encode($array);					  