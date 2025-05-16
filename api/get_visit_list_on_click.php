<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$start_dt = date('Y-m-01');
$today_dt = date('Y-m-d');
$this_month = date('m');
$this_month = (int)$this_month;
$month_array = ['January','February','March','April','May','June','July','August','September','October','November','December'];
$datetime = $created_at;

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
	
//$activity = $_POST['activity'];
$statement = "select * from mis_newsite where engineer_user_id='".$userid."' AND activity IN ('RMS','Cloud') order by id desc";
//$statement = "select * from mis_newsite where activity = '".$activity."' and branch IN (".$_bank_name.") and engineer_user_id='".$userid."' order by id desc";
//$statement = "select a.id as ID,a.created_at as Created_AT,a.* from mis_newvisit a inner join mis_newsite b on a.atmid=b.atmid where b.activity='".$activity."' AND engineer='".$userid."' ";
//$statement.= " order by a.id desc" ; 

$dataArray = array();
$sql = mysqli_query($con,$statement);
if(mysqli_num_rows($sql)>0){
    while($sql_result = mysqli_fetch_assoc($sql)){
        $is_done = 0;
        $_atm_id = $sql_result['atmid'];
        $check_statement = "select id,created_at from mis_newvisit_app_test where atmid = '".$_atm_id."' order by id desc limit 1";
        $check_sql = mysqli_query($con,$check_statement);
        $pending_text = "";
        if(mysqli_num_rows($check_sql)>0){
            $is_hdd_hide = 1;
            $fetch_data = mysqli_fetch_assoc($check_sql);
            $created_date_arr = explode(" ",$fetch_data['created_at']); 
            $created_date = $created_date_arr[0];
            $created_month_arr = explode("-",$created_date);
            $last_created_month = $created_month_arr[1];
            $last_created_month = (int)$last_created_month;
            if($this_month>$last_created_month){
                $pending_text = "Still Pending From ".$month_array[$last_created_month - 1];
            }
            if($created_date>=$start_dt && $created_date<=$today_dt){
                 $is_done = 1;
            }else{
                 $is_done = 0;
            }
        }else{
            $is_hdd_hide = 0;
        }
        
       /* $visit_statement = "select id from mis_newvisit_app where CAST(created_at AS DATE) >= '".$start_dt."' AND CAST(created_at AS DATE) <= '".$today_dt."' AND atmid = '".$_atm_id."'";
        $visit_sql = mysqli_query($con,$visit_statement);
         if(mysqli_num_rows($visit_sql)>0){
            $is_done = 1;
        }else{
            $is_done = 0;
        }
        */
        
        //echo $is_done;die;
        $_newdata = array();
        $_newdata['activity'] = $sql_result['activity'];
        $_newdata['site_id'] = $sql_result['id'];
        $_newdata['atmid'] = $sql_result['atmid'];
        $_newdata['bank'] = $sql_result['bank'];
        $_newdata['customer'] = $sql_result['customer'];
        $_newdata['zone'] = $sql_result['zone'];
        $_newdata['city'] = $sql_result['city'];
        $_newdata['state'] = $sql_result['state'];
        $_newdata['location'] = htmlspecialchars($sql_result['address']);
        $_newdata['status'] = $sql_result['status'];
        $_newdata['is_hdd_hide'] = $is_hdd_hide;
        $_newdata['is_done'] = $is_done;
        $_newdata['pending_text'] = $pending_text;
        array_push($dataArray,$_newdata); 
        
    }
}
 
if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray]);
}else{
	$array = array(['Code'=>201]);
}

echo json_encode($array);	

?>
							 
   