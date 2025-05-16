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
	
//	$ch = "select m.atmid,m.bank,m.customer,m.zone,m.city,m.state,m.location,md.status from mis_1_test m,mis_details_1_test md where m.id = md.mis_id AND md.status='open' AND md.engineer='".$userid."' AND m.city IN (".$_bank_name.")";
	$sql = mysqli_query($con,"select m.atmid,m.bank,m.customer,m.zone,m.city,m.state,m.location,md.status,md.id,md.subcomponent,md.created_at,m.created_by,m.call_receive_from from mis m,mis_details md where m.id = md.mis_id AND md.engineer='".$userid."'");
	$dataArray = array();
      if(mysqli_num_rows($sql)>0){
    	  while($sql_result = mysqli_fetch_assoc($sql)){
    	        $call_city = $sql_result['city'];
    	        $call_branch_id = "";
    	        $call_citysql = mysqli_query($con,"select id from mis_city where city='".$call_city."'");
    	        if(mysqli_num_rows($call_citysql)>0){
            	   $call_citydata = mysqli_fetch_assoc($call_citysql);
            	   $call_branch_id = $call_citydata['id'];
    	        }
    	   /*   $mis_id = $sql_result['id'];
    	      $mis_sql = mysqli_query($con,"select id,mis_id from mis_details where mis_id='".$mis_id."' order by id desc limit 1");
             $_schedule_check = 0;
             if(mysqli_num_rows($mis_sql)>0){
              $mis_data = mysqli_fetch_assoc($mis_sql);
              
              if($mis_data['status']=='close'){
                  $_schedule_check = 1;
              }
             } */
    	   //   if($_schedule_check == 0){
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
    			         $_newdata['branch_id'] = $call_branch_id;
    			         $_newdata['subcomponent'] = $sql_result['subcomponent'];
    			         
    			         $date2=date_create($sql_result['created_at']);
                         $diff=date_diff($date1,$date2);
                         $_newdata['down_time'] = $diff->format("%a days");
                         $_newdata['aging'] = $diff->format("%a");
                         $_id = $sql_result['created_by'];
                         $user_sql = mysqli_query($con,"select * from mis_loginusers where id ='".$_id."'");
                         $created_by_name = "";
                         if(mysqli_num_rows($user_sql)>0){
                           $user_sql_result = mysqli_fetch_assoc($user_sql);
                           $created_by_name = $user_sql_result['name'];
                         }
                         $_newdata['created_by'] = $created_by_name;
                         $_newdata['call_receive_from'] = $sql_result['call_receive_from'];
    			         array_push($dataArray,$_newdata);  
    	   //   }
    	  }
      }
						  
	if(count($dataArray)>0){
    	$array = array(['Code'=>200,'count_data'=>$_bank_name,'res_data'=>$dataArray]);
    }else{
    	$array = array(['Code'=>201,'bn'=>$_bank_name]);
    }
    
    
    
    echo json_encode($array);					  