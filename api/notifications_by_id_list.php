<?php 
 //$pending_pmc_count = mysqli_num_rows($sitesql);
 
include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');
$date = date('Y-m-d');
$date1 = date_create($date);

$three_month_ago_date =  date("Y-m-d",strtotime("-3 Months"));
$two_month_ago_date =  date("Y-m-d",strtotime("-2 Months -20 days"));

    $userid = $_POST['created_by'];

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
	
$activity = $_POST['activity'];
$statement = "select * from mis_newsite where activity = '".$activity."' and engineer_user_id='".$userid."' order by id desc";

$dataArray = array();
$total = 0;$total_done = 0;$total_notdone = 0;
$sql = mysqli_query($con,$statement);
if(mysqli_num_rows($sql)>0){
    while($sql_result = mysqli_fetch_assoc($sql)){
            $atm_id = $sql_result['atmid'];
            $_is_done = 0;$id=0;
            $_pmc_sql = "select * from pmc_report where atmid = '".$atm_id."' and created_by='".$userid."' order by id desc limit 1";
            $_sql_data = mysqli_query($con,$_pmc_sql);
            if(mysqli_num_rows($_sql_data)>0){
                $_is_done = 1;
                $total_done = $total_done + 1;
                $sql_pmc_result = mysqli_fetch_assoc($_sql_data);
                $id = $sql_pmc_result['id'];
                $date2=date_create($sql_pmc_result['created_at']);
                $diff=date_diff($date1,$date2);
                $last_report_days = $diff->format("%a");
                if($last_report_days>='80'){
                    $_is_done = 0;
                    $last_reported_days = $last_report_days. " days";
                }
            }else{
                $_is_done = 0;
                $total_notdone = $total_notdone + 1;
                $last_reported_days = "Not yet Fill PMC Report";
            }
            $total = $total + 1;
            if($_is_done==0){
                $_newdata = array();
                $_newdata['atmid'] = $atm_id;
                $_newdata['last_reported_days'] = $last_reported_days;
                array_push($dataArray,$_newdata);  
            }
            
            
        
     }
}
 
if(count($dataArray)>0){
	$array = array(['Code'=>200,'res_data'=>$dataArray,'tot'=>$total,'tot_done'=>$total_done,'tot_notdone'=>$total_notdone]);
}else{
	$array = array(['Code'=>201]);
}


//$array = array(['Code'=>200,'tot'=>$total,'tot_done'=>$total_done,'tot_notdone'=>$total_notdone,'3_month'=>$three_month_ago_date,'2_month_20_days'=>$two_month_ago_date]);
echo json_encode($array);	

    ?>