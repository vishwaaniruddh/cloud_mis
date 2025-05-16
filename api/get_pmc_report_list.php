<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');
$current_month = date('m');
$int_month = intval($current_month);
if($int_month>=1 && $int_month<=3){
    $start_date = date('Y-01-01');
    $end_date = date('Y-03-31');
}
if($int_month>=4 && $int_month<=6){
    $start_date = date('Y-04-01');
    $end_date = date('Y-06-30');
}
if($int_month>=7 && $int_month<=9){
    $start_date = date('Y-07-01');
    $end_date = date('Y-09-30');
}
if($int_month>=10 && $int_month<=12){
    $start_date = date('Y-10-01');
    $end_date = date('Y-12-31');
}

//echo $start_date.'_'.$end_date;die;


$three_month_ago_date =  date("Y-m-d",strtotime("-3 Months"));

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
$statement = "select * from mis_newsite where engineer_user_id='".$userid."' order by id desc";
//$statement = "select * from mis_newsite where activity = '".$activity."' and engineer_user_id='".$userid."' order by id desc";
//$statement = "select * from mis_newsite where activity = '".$activity."' and branch IN (".$_bank_name.") and engineer_user_id='".$userid."' order by id desc";
//$statement = "select a.id as ID,a.created_at as Created_AT,a.* from mis_newvisit a inner join mis_newsite b on a.atmid=b.atmid where b.activity='".$activity."' AND engineer='".$userid."' ";
//$statement.= " order by a.id desc" ; 

$dataArray = array();
$total = 0;$total_done = 0;$total_notdone = 0;
$sql = mysqli_query($con,$statement);
if(mysqli_num_rows($sql)>0){
    while($sql_result = mysqli_fetch_assoc($sql)){
            $atm_id = $sql_result['atmid'];
            $activity = $sql_result['activity'];
            $_is_done = 0;$id=0;
            /*
            $_pmc_sql = "select * from pmc_report_test where atmid = '".$atm_id."' and created_by='".$userid."' AND CAST(created_at AS DATE)>='".$three_month_ago_date."' order by id desc limit 1";
            */
            $_pmc_sql = "select * from pmc_report_test where atmid = '".$atm_id."' and created_by='".$userid."' AND CAST(created_at AS DATE)>='".$start_date."' AND CAST(created_at AS DATE)<='".$end_date."' order by id desc limit 1";
            $_sql_data = mysqli_query($con,$_pmc_sql);
            if(mysqli_num_rows($_sql_data)>0){
                $_is_done = 1;
                $total_done = $total_done + 1;
                $sql_pmc_result = mysqli_fetch_assoc($_sql_data);
                $id = $sql_pmc_result['id'];
            }else{
                $_is_done = 0;
                $total_notdone = $total_notdone + 1;
            }
            $total = $total + 1;
            $_newdata = array();
            $_newdata['site_id'] = $id;
            $_newdata['atmid'] = $atm_id;
            $_newdata['bank'] = $sql_result['bank'];
            $_newdata['customer'] = $sql_result['customer'];
            $_newdata['zone'] = $sql_result['zone'];
            $_newdata['city'] = $sql_result['city'];
            $_newdata['state'] = $sql_result['state'];
            $_newdata['location'] = htmlspecialchars($sql_result['address']);
            $_newdata['status'] = $sql_result['status'];
            $_newdata['is_done'] = $_is_done;
            $_newdata['activity'] = $activity;
            array_push($dataArray,$_newdata); 
        
     }
}
 
if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray,'tot'=>$total,'tot_done'=>$total_done,'tot_notdone'=>$total_notdone]);
}else{
	$array = array(['Code'=>201,'bn'=>$_bank_name]);
}

echo json_encode($array);	

?>
							 
   