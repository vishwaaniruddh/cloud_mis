<?php 

include($_SERVER['DOCUMENT_ROOT'].'/css/dash/esir/api/functions.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$userid = $_POST['user_id'];
$activity = $_POST['activity'];

$sqlapp = "select * from mis_newvisit_app_test where activity_type='".$activity."' AND created_by='".$userid."' ";
                                                        
    if(isset($_POST['atmid']) && $_POST['atmid']!='')
    {
        $sqlapp .= " and atmid = '".$_POST['atmid']."'";
    }
    if(isset($_POST['fromdt']) && $_POST['fromdt']!='' && isset($_POST['todt']) && $_POST['todt']!='')
    {
        $date1 = $_POST['fromdt'] ; 
        $date2 = $_POST['todt'] ;
        $sqlapp .=" and CAST(created_at AS DATE) >= '".$date1."' and CAST(created_at AS DATE) <= '".$date2."'";
    }
    
    $sqlapp .=" order by id desc";
    $_mysql = $sqlapp;
    
    $sql_app = mysqli_query($con,$sqlapp);


//$usersql = mysqli_query($con,"select id,atmid,bank,customer from mis_newvisit_app where engineer_user_id ='".$userid."'");
$dataarray = array();
$total_site = mysqli_num_rows($sql_app);
$dvr_online_count = 0;
$dvr_offline_count = 0;
if($total_site>0){
   while($userdata = mysqli_fetch_assoc($sql_app)){
       $_newdata = array();
       $atmid = $userdata['atmid'];
       $_newdata['atmid'] = $atmid;
       $newsite = mysqli_query($con,"select bm_name,city,state from mis_newsite where atmid = '".$atmid."'");
       $newsite_res = mysqli_fetch_assoc($newsite);
       
       $_newdata['city'] = $newsite_res['city'];
       $_newdata['state'] = $newsite_res['state'];
       $_newdata['bm_name'] = $newsite_res['bm_name'];
       $_newdata['list']= $userdata['checklist_json'];
     //  $_newdata['customer'] = $userdata['customer'];
     //  $_newdata['bank'] = $userdata['bank'];
       array_push($dataarray,$_newdata);
   }
  
   array_push($dataarray,$_newdata);
    
}

$array = array(['code'=>200,'visit_list'=>$dataarray,'activity'=>$activity,'sql'=>$_mysql]);
echo json_encode($array);