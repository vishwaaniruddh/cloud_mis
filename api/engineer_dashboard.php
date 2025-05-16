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


$three_month_ago_date =  date("Y-m-d",strtotime("-3 Months"));

$userid = $_POST['user_id'];

//$usersql = mysqli_query($con,"select id,atmid from mis_newsite where engineer_user_id ='".$userid."' AND activity='RMS'");
$usersql = mysqli_query($con,"select id,atmid,status from mis_newsite where engineer_user_id ='".$userid."'");
$dataarray = array();
$total_site = mysqli_num_rows($usersql);
$dvr_online_count = 0;
$dvr_offline_count = 0;
$total_pmcdone = 0;$total_pmcnotdone = 0;$total_pmc_site=0;
if($total_site>0){
   while($userdata = mysqli_fetch_assoc($usersql)){
      // $_newdata = array();
      // $_newdata['id'] = $userdata['id'];
       $site_status = $userdata['status'];
       if($site_status==1){
           $dvr_online_count = $dvr_online_count + 1;
       }else{
           $dvr_offline_count = $dvr_offline_count + 1;
       }
       
       $atmid = $userdata['atmid'];
       array_push($dataarray,$atmid);
       
       
       $pmc_reportsql = mysqli_query($con,"select * from pmc_report_test where atmid = '".$atmid."' and created_by='".$userid."' AND CAST(created_at AS DATE)>='".$start_date."' AND CAST(created_at AS DATE)<='".$end_date."'  order by id desc limit 1");
       
        //$pmc_reportsql = mysqli_query($con,"select * from pmc_report_test where atmid = '".$atmid."' and created_by='".$userid."' AND CAST(created_at AS DATE)>='".$three_month_ago_date."' order by id desc limit 1");
        $total_pmc_report = mysqli_num_rows($pmc_reportsql);
        if($total_pmc_report>0){
            $total_pmcdone = $total_pmcdone + 1;
        }else{
            $total_pmcnotdone = $total_pmcnotdone + 1;
        }
    }
    $total_pmc_site = $total_pmcdone + $total_pmcnotdone;
}

    $_atm_ids=json_encode($dataarray);
	$_atm_ids=str_replace( array('[',']','"') , ''  , $_atm_ids);
	$_atm_id_arr=explode(',',$_atm_ids);
	$_atm_ids = "'" . implode ( "', '", $_atm_id_arr )."'";
	

$visit_sql = mysqli_query($con,"select id from mis_newvisit_app_test where created_by ='".$userid."'");
$total_valid_visit = 0; $total_invalid_visit = 0;
$total_visit = mysqli_num_rows($visit_sql);
if($total_visit>0){
     while($visitdata = mysqli_fetch_assoc($visit_sql)){
         if($visitdata['status']==0){
             $total_valid_visit = $total_valid_visit + 1;
         }else{
             $total_invalid_visit = $total_invalid_visit + 1;
         }
         
     }
}

$footagesql = mysqli_query($con,"select id from eng_footage_request_history where created_by ='".$userid."' and update_details='".$today."'");
$total_footage = mysqli_num_rows($footagesql);

$checkqualitysql = mysqli_query($con,"select * from newcheckquality where created_by ='".$userid."' ");
$total_cq_approved = 0;$total_cq_notapproved = 0;$total_cq_incomplete = 0;
$total_checkquality = mysqli_num_rows($checkqualitysql);
if($total_checkquality>0){
     while($cqdata = mysqli_fetch_assoc($checkqualitysql)){
         if($cqdata['status']==0){
             $total_cq_notapproved = $total_cq_notapproved + 1;
         }else{
             $total_cq_approved = $total_cq_approved + 1;
         }
         if($cqdata['wizard_number']<7){
             $total_cq_incomplete = $total_cq_incomplete + 1;
         }
     }
}

//$callsql = mysqli_query($con,"select id from mis_history where engineer ='".$userid."' and type='schedule' and schedule_date='".$today."'");
$callsql = mysqli_query($con,"select md.id,md.mis_id from mis_details m,mis_history md where m.id = md.mis_id AND m.status='schedule' and m.status=md.type AND md.engineer='".$userid."' and md.schedule_date='".$today."'");
$total_call = mysqli_num_rows($callsql);

$totalservice_call = 0;
$totalmd_call = 0;
$totalmip_call = 0;
$totalmr_call = 0;
$totalopen_call = 0;
$totalschedule_call = 0;
$totalclose_call = 0;

//$service_callsql = mysqli_query($con,"select status from mis_details where status IN ('material_dispatch','material_in_process','material_requirement','Open','schedule','close') AND atmid IN (select atmid from mis_newsite where engineer_user_id ='".$userid."')");       

//$service_callsql = mysqli_query($con,"SELECT COUNT(id) AS count,status FROM `mis_details` WHERE status IN ('material_dispatch','material_in_process','material_requirement','open','schedule','close') AND atmid IN (select atmid FROM mis_newsite WHERE engineer_user_id='".$userid."') GROUP BY status");

$service_callsql = mysqli_query($con,"SELECT COUNT(md.id) AS count,md.status FROM mis m,mis_details md where m.id = md.mis_id AND md.status IN ('material_dispatch','material_in_process','material_requirement','open','schedule','close') AND md.atmid IN (select atmid FROM mis_newsite WHERE engineer_user_id='".$userid."') GROUP BY md.status");

//$service_callsql = mysqli_query($con,"select md.id,md.mis_id,m.status from mis_details m,mis_history md where m.id = md.mis_id AND m.atmid IN (".$_atm_ids.") AND m.status IN ('material_dispatch','material_in_process','material_requirement','Open','schedule') AND m.status=md.type AND md.engineer='".$userid."'");
$totalservice_call = mysqli_num_rows($service_callsql);
if($totalservice_call>0){
    while($servicecalldata = mysqli_fetch_assoc($service_callsql)){
        if($servicecalldata['status']=='material_dispatch'){
           // $totalmd_call = $totalmd_call + 1;
           $totalmd_call = $servicecalldata['count'];
        }
        if($servicecalldata['status']=='material_in_process'){
           // $totalmip_call = $totalmip_call + 1;
            $totalmip_call = $servicecalldata['count'];
        }
        if($servicecalldata['status']=='material_requirement'){
          //  $totalmr_call = $totalmr_call + 1;
            $totalmr_call = $servicecalldata['count'];
        }
        if($servicecalldata['status']=='open'){
           // $totalopen_call = $totalopen_call + 1;
            $totalopen_call = $servicecalldata['count'];
        }
        if($servicecalldata['status']=='schedule'){
           // $totalschedule_call = $totalschedule_call + 1;
           $totalschedule_call = $servicecalldata['count'];
        }
        if($servicecalldata['status']=='close'){
          // $totalclose_call = $totalclose_call + 1;
          $totalclose_call = $servicecalldata['count'];
        }
    }
}

$total_service_call = $totalmd_call + $totalmip_call + $totalmr_call + $totalopen_call + $totalschedule_call;

$array = array(['code'=>200,'total_site'=>$total_site,'atmid_list'=>$dataarray,'total_visit'=>$total_visit,'today_footage'=>$total_footage,'online_count'=>$dvr_online_count,'offline_count'=>$dvr_offline_count,'total_call'=>$total_call,'total_pmc_site'=>$total_pmc_site,'total_pmc_report_done'=>$total_pmcdone,'total_pmc_report_notdone'=>$total_pmcnotdone,
                'totalservice_call'=>$total_service_call,'totalmd_call'=>$totalmd_call,'totalmip_call'=>$totalmip_call,'totalmr_call'=>$totalmr_call,
                'totalopen_call'=>$totalopen_call,'totalschedule_call'=>$totalschedule_call,'totalclose_call'=>$totalclose_call,
                'total_checkquality'=>$total_checkquality,'total_cq_approved'=>$total_cq_approved,'total_cq_notapproved'=>$total_cq_notapproved,'total_cq_incomplete'=>$total_cq_incomplete,
                'total_valid_visit'=>$total_valid_visit,'total_invalid_visit'=>$total_invalid_visit]);     
echo json_encode($array);

