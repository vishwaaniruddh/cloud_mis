<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set("Asia/Calcutta");  
$date = date('Y-m-d H:i:s');
$date1 = date('Y-m-d');
$date1=date_create($date1);


$id = $_POST['id'];

    
	$sql = mysqli_query($con,"select * from checkquality where id='".$id."'");
	$dataArray = array();
      if(mysqli_num_rows($sql)>0){
    	  $sql_result = mysqli_fetch_assoc($sql);
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
						  
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201]);
    }
    
    
    
    echo json_encode($array);					  