<?php

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');

$statement = "select pia.link,pia.visitid,pr.atmid,pia.created_at from pmcreport_images_app pia,pmc_report pr where pia.visitid = pr.visit_id AND pia.filename='FSR Copy'";

$dataArray = array();
$total = 0;$total_done = 0;$total_notdone = 0;
$sql = mysqli_query($con,$statement);
if(mysqli_num_rows($sql)>0){
    while($sql_result = mysqli_fetch_assoc($sql)){
       // $_newdata = array();
       $total = $total + 1;
         $_atmid = $sql_result['atmid'];
         $link = $sql_result['link'];
         $visit_id = $sql_result['visitid'];
         $datetime = $sql_result['created_at'];
         $_get_detail = "SELECT bank,atmid FROM mis_newsite WHERE atmid = (SELECT atmid FROM `pmc_report` WHERE visit_id='".$visit_id."')";
        $_getsql = mysqli_query($con,$_get_detail);
        if(mysqli_num_rows($_getsql)>0){
           $getsql_result = mysqli_fetch_assoc($_getsql);
           $_atmid = $getsql_result['atmid'];
           $_bank = $getsql_result['bank'];
           $_ins_sql = "insert into view_pmc_report_fsr_image(atmid, visit_id,bank,link,created_at) values('".$_atmid."','".$visit_id."','".$_bank."','".$link."','".$datetime."')" ; 
           mysqli_query($con,$_ins_sql);
        }
        
    }
}
echo $total;die;